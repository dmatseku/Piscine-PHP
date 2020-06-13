<?php

require_once "sql/sql_products.php";

session_start();

if (!is_array($_SESSION['basket_products'])) {
    $_SESSION['basket_products'] = array();
}

$prod_id = $_GET['basket_product_id'];
if ($prod_id && product_is_exist($prod_id)) {
    $prod_count = $_GET['basket_product_count'];
    if ($prod_count && is_numeric($prod_count) && $prod_count >= 1
        && $prod_count <= 9999 && $_GET['basket_product_add'] == 'OK') {
        if (!array_key_exists($prod_id, $_SESSION['basket_products'])) {
            $_SESSION['basket_products'][$prod_id] = $prod_count;
        } else {
            $_SESSION['basket_products'][$prod_id] += $prod_count;
        }
    } else if ($_GET['basket_product_delete'] == 'OK' && $_SESSION['basket_products']
        && array_key_exists($prod_id, $_SESSION['basket_products'])) {
        unset($_SESSION['basket_products'][$prod_id]);
    }
}

header("Location: basket.php");

//EOF