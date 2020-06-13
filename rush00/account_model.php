<?php

require_once "sql/sql_auth.php";

session_start();

$action = $_POST['auth_action'];

function try_log_in()
{
    global $login;
    global $password;
    global $error;
    $true_password = get_user_password($login);
    $id = get_user_id_by_login($login);

    if ($id !== false && $true_password && password_verify($password, $true_password)) {
        $hash = hash("sha256", $true_password.$_SERVER['HTTP_USER_AGENT']);
        if (!find_log($hash, $id)) {
            insert_log($hash, $id, $_SERVER['HTTP_USER_AGENT']);
        }
        setcookie("user_hash", $hash, time() + 3600 * 24);
        setcookie("user_id", $id, time() + 3600 * 24);
    } else {
        $error = "Login or password is incorrect";
    }
}

if ($action === "logout") {
    if (isset($_COOKIE['user_hash'])) {
        unset($_COOKIE['user_hash']);
        setcookie("user_hash", null, -1);
    }
    if (isset($_COOKIE['user_id'])) {
        unset($_COOKIE['user_id']);
        setcookie("user_id", null, -1);
    }
    $_SESSION['logged'] = false;
    $_SESSION['login'] = "";
} else {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $error = "";
    $_SESSION["auth_error"] = false;

    if ((!is_string($login) || !strlen($login))
        || (!is_string($password) || !strlen($login))
        || ($action == 'change_passwd' && (!is_string($new_password) || !strlen($new_password)))) {
        $error = "Some fields are empty";
    } elseif (preg_match("/^[A-Za-z]\w*$/", $login) != 1) {
        $error = "login characters: \n[A-Z, a-z][A-Z, a-z, 0-9, _]";
    } elseif (strlen($login) > 25) {
        $error = "Login is too long";
    }

    if ($error === "") {
        if ($action === 'register') {
            if (register_user($login, password_hash($password, PASSWORD_DEFAULT))) {
                try_log_in();
            } else {
                $error = "User already exists";
            }
        } elseif ($action === 'login') {
            try_log_in();
        } elseif ($action === 'change_passwd') {
            $true_password = get_user_password($login);
            if ($true_password && password_verify($password, $true_password)) {
                $password = $new_password;
                update_password($login, password_hash($new_password, PASSWORD_DEFAULT));
                clear_old_logs(get_user_id_by_login($login));
                try_log_in();
            } else {
                $error = "Login or password is incorrect";
            }
        }
    }

    if ($error != "") {
        $_SESSION["auth_error"] = array("login" => $login, "error" => $error, "action" => $action);
    }
}

header("Location: ".$_POST["src_file"]);

//EOF