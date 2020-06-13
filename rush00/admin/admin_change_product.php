<?php
require_once "../auth.php";
require_once "../sql/sql_products.php";

function load_image(&$link) {
    if (exif_imagetype($_FILES['product_image_file']['tmp_name'])) {
        if (!is_dir("../img_product")) {
            mkdir("../img_product");
        }
        $link = "/img_product/".basename($_FILES['product_image_file']['name']);
        if (is_file("..".$link)) {
            return 0; //file already exists
        }

        if ($_FILES['product_image_file']['size'] > 2097152
        || !move_uploaded_file($_FILES['product_image_file']['tmp_name'], "..".$link)) {
            return 5; //invalid file
        }
        return 0; //file is ok
    }
    return 4; //file is not image
}

if ($_SESSION['logged'] && get_user_privileges($_SESSION['login'])) {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $image_type = $_POST['product_image_type'];
    $image_link = $_POST['product_image_link'];
    $categories = $_POST['category'];
    $action = $_POST['action'];

    if (!isset($_POST['product_name']) || !isset($_POST['product_price']) || !is_numeric($price)
    || !isset($_POST['product_image_type'])  || ($image_type === 'link' && !isset($_POST['product_image_link']))
    || ($action == "change" && !isset($_POST['change_id']))) {
        header("Location: /index.php");
        exit;
    }

    $error = 0;
    if ($image_type == "file" && !array_key_exists('product_image_file', $_FILES)) {
        $error = 2; // file is not selected
    } elseif ($_FILES['product_image_file']['error'] != 0) {
        $error = 5; //invalid file
    }

    if ($error == 0) {
        $tmp_id = get_product_id_by_name($name);
        echo $tmp_id." ".$action." ".$_POST['change_id'];
        if (!$tmp_id || ($action == "change" && $tmp_id == $_POST['change_id'])) {
            if ($image_type == "file") {
                $error = load_image($image_link);
            }
            if ($error == 0) {
                if ($action == "create") {
                    create_product($name, $price, $image_link);
                    $product_id = get_product_id_by_name($name);

                    if ($categories && $product_id) {
                        foreach ($categories as $category_id) {
                            add_dependency($product_id, $category_id);
                        }
                    }
                } elseif ($action == "change") {
                    $product_id = $_POST['change_id'];
                    update_product($product_id, $name, $price, $image_link);

                    $prev_categories = get_dependencies_for_product($product_id);
                    foreach ($categories as $category_id) { //add dependency
                        if (!in_array($category_id, $prev_categories)) {
                            add_dependency($product_id, $category_id);
                        }
                    }
                    foreach ($prev_categories as $category_id) { //delete dependency
                        if (!in_array($category_id, $categories)) {
                            delete_dependency($product_id, $category_id);
                        }
                    }
                }
            }
        } else {
            $error = 1; //name already exists
        }
    }

    if ($error) {
        $_SESSION['error'] = array($name, $price, $error, ($action == "change" ? $_POST['change_id'] : false));
//        header("Location: /admin/admin_change_product_page.php");
        exit;
    }
}
header("Location: /index.php");

//EOF