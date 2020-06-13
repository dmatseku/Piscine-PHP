<?php

require_once "../sql/sql_products.php";
require "../auth.php";

if ($_SESSION['logged'] && get_user_privileges($_SESSION['login'])) {
    $error = false;
    $action = "category_add";

    if (isset($_POST['category_add']) && $_POST['category_add'] != "") {
        if ($_POST['category_add'] === "Other" || !create_category($_POST['category_add'])) {
            $error = "Category already exists";
        }
    } else {
        $error = "Field is empty";
    }

    if ($error) {
        $_SESSION['error'] = array($action, $error);
    }
}
header("Location: ".$_POST["src_file"]);
//EOF
