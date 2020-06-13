<?php

require_once "../sql/sql_auth.php";
require "../auth.php";

if ($_SESSION['logged'] && get_user_privileges($_SESSION['login'])) {
    $error = false;
    $action = (isset($_POST['create_user']) ? "create_user" : "delete_user");

    if (!empty($_POST['login']) && ($action == "delete_user" || !empty($_POST['password']))) {
        $login = $_POST['login'];
        if (is_string($login) && preg_match("/^[A-Za-z]\w*$/", $login) == 1 && !empty($login)) {
            if ($action == "create_user") {
                if (!register_user($login, password_hash($_POST['password'], PASSWORD_DEFAULT))) {
                    $error = "User already exists";
                }
            } elseif ($action == "delete_user") {
                $id = get_user_id_by_login($login);
                if ($id !== false) {
                    remove_user($login);
                    clear_old_logs($id);
                } else {
                    $error = "User does not exist";
                }
            }
        } else {
            $error = "Invalid login format";
        }
    } else {
        $error = "Some fields are empty";
    }

    if ($error) {
        $_SESSION['error'] = array($action, $error);
    }
}
header("Location: ".$_POST["src_file"]);

//EOF