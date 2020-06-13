<?php

require_once "../sql/sql_auth.php";
require "../auth.php";

if ($_SESSION['logged'] && get_user_privileges($_SESSION['login'])) {
    $error = false;
    $action = "give_take_admin";

    if (isset($_POST['login_action'])) {
        if (isset($_POST['login_for_action']) && $_POST['login_for_action'] != "") {
            $login = $_POST['login_for_action'];
            $login_action = $_POST['login_action'];

            if ($id = get_user_id_by_login($login)) {
                if ($login_action == "give_privileges") {
                    give_privileges($id);
                } elseif ($login_action == "take_privileges") {
                    take_privileges_away($id);
                }
            } else {
                $error = "User does not exists";
            }
        } else {
            $error = "Field is empty";
        }
    }

    if ($error) {
        $_SESSION['error'] = array($action, $error);
    }
}
header("Location: ".$_POST["src_file"]);

//EOF
