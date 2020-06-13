<?php

require_once "../auth.php";
require_once "../sql/sql_products.php";

if ($_SESSION['logged'] && get_user_privileges($_SESSION['login'])):
    $categories = get_full_categories_list();
    $name = "";
    $price = "";
    $link = "";
    $selected_categories = array();
    $name_price_error = "";
    $file_error = "";
    $action = "create";
    $product_id = false;

    if (isset($_POST['edit']) || (isset($_SESSION['error']) && $_SESSION['error'][3] !== false)) {
        $action = "change";
        $product_id = (isset($_POST['edit']) ? $_POST['edit'] : $_SESSION['error'][3]);
    }

    if ($action == "change") {
        $product = get_product($product_id);
        $name = $product['product_name'];
        $price = $product['product_price'];
        $link = $product['product_image_link'];
        $selected_categories = get_dependencies_for_product($product_id);
    }
    if (isset($_SESSION['error'])) {
        $name = $_SESSION['error'][0];
        $price = $_SESSION['error'][1];
        switch ($_SESSION['error'][2]) {
            case 1:
                $name_price_error = "Product with the same name already exists";
                break;
            case 2:
                $file_error = "File is not selected";
                break;
            case 3:
                $file_error = "File already exists";
                break;
            case 4:
                $file_error = "File is not image";
                break;
            case 5:
                $file_error = "Invalid file";
                break;
        }
        unset($_SESSION['error']);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Магазин фиг пойми чего"</title>
        <link rel="stylesheet" href="/css/admin_change_product_page.css">
    </head>
    <body>
        <form id="main_form" method="POST" action="/admin/admin_change_product.php" enctype="multipart/form-data">
            <?php if ($action == "change"): ?>
            <input type="hidden" name="change_id" value="<?= $product_id ?>">
            <?php endif; ?>
            <div id="marg"></div>
            <div id="main_data">
                <div id="product_image">
                    <div id="image_by_link">
                        <label class="radio_label">
                            <input class="image_radio" id="radio_link" type="radio" name="product_image_type" value="link" checked>
                            Insert image by link
                        </label>
                        <input id="image_link" type="text" name="product_image_link" value="<?= $link ?>" placeholder="Link">
                    </div>
                    <div id="image_by_file">
                        <label class="radio_label">
                            <input class="radio" id="radio_file" type="radio" name="product_image_type" value="file">
                            Insert image from file
                        </label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                        <input id="image_file" type="file" name="product_image_file" disabled>
                        <p id="file_error"><?= $file_error ?></p>
                    </div>
                    <div id="selected_img_container">
                        <img id="selected_img" src="<?= $link ?>" alt="">
                    </div>
                </div>
                <div id="product_info">
                    <div id="name_price">
                        <p id="name_price_error"><?= $name_price_error ?></p>
                        <input type="text" name="product_name" value="<?= $name ?>" placeholder="Name" id="input_name">
                        <input type="text" name="product_price" value="<?= $price ?>" placeholder="Price" id="input_price">
                    </div>
                    <h2>Categories:</h2>
                    <div id="categories_list">
                        <ul>
                            <?php foreach ($categories as $data): ?>
                                <li class="category">
                                    <label>
                                        <input type="checkbox" name="category[]" value="<?= $data['id']?>" <?= (in_array($data['id'], $selected_categories) ? "checked" : "")?>>
                                        <?= $data['name']?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="confirm_field">
                <a id="decline" href="../index.php"><button>Decline</button></a>
                <button id="confirm" name="action" value="<?= $action ?>">Confirm</button>
            </div>
        </form>
        <script type="text/javascript" src="/js/admin_add_product_page.js"></script>
    </body>
</html>
<?php

else:
    header("Location: index.php");
endif;
?>
