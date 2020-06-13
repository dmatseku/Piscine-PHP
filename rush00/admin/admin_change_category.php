<?php

require "../auth.php";
require "../sql/sql_products.php";

if ($_SESSION['logged'] && get_user_privileges($_SESSION['login'])) {
    $action = "change_category";
    $error = false;

    if (!empty($_POST['old_category']) && !empty($_POST['new_category'])) {
        if (!update_category_name($_POST['old_category'], $_POST['new_category'])) {
            $error = "Category does not exist";
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