<?php

require_once "../sql/sql_products.php";
require "../auth.php";

if ($_SESSION['logged'] && get_user_privileges($_SESSION['login'])) {
    if (isset($_POST['category_delete'])) {
        delete_category($_POST['category_delete']);
    } elseif (isset($_POST['product_delete'])) {
        delete_product($_POST['product_delete']);
    }
}
header("Location: ".$_POST["src_file"]);

//EOF