<?php
require_once "sql/sql_products.php";
require_once "auth.php";

$privileges = false;
if ($_SESSION['logged']) {
    $privileges = get_user_privileges($_SESSION['login']);
}
function init_external($current_file) {
    require_once "header.php";
    global $privileges;
    if ($privileges) {
        require_once "admin/admin_panel.php";
        require_once "admin/admin_delete_button.php";
        require_once "admin/admin_edit_button.php";
    }
}

$init_info = false;
$orphan_info = false;
if (!$_GET['category'] && !$_GET['product']) {
    $init_info = get_index_content();
} else {
    $category = isset($_GET['category']) ? $_GET['category'] : "%";
    $product = isset($_GET['product']) && $_GET['product'] !== "" ? "%".$_GET['product']."%" : "%";
    $init_info = get_desired_content($category, $product);
    if ($category == "%") {
        $orphan_info = get_orphan_content($product);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Магазин фиг пойми чего"</title>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
    <?php init_external("/index.php"); ?>
        <main>
        <?php if ($init_info !== false || $orphan_info !== false): ?>
            <?php

            $i = 0;
            $count = ($init_info !== false ? count($init_info) : 0);

            while ($i < $count):
                $actual_category = $init_info[$i]['category_name'];
            ?>
                <section class="category">
                    <form class="category_header" method="GET" action="index.php">
                        <button name="category" value="<?= $actual_category ?>"><b><?= $actual_category ?></b></button>
                    </form>
                    <div class="product_list">
                    <?php while ($i < $count && $init_info[$i]['category_name'] == $actual_category): ?>
                        <section class="product part_of_three">
                            <input type="hidden" value="<?= $init_info[$i]['product_id'] ?>">
                            <input type="hidden" value="<?= $init_info[$i]['product_price'] ?>">
                            <?php

                            if ($privileges) {
                                init_content_delete_button("/index.php", $init_info[$i]['product_id'], "product");
                                init_edit_button($init_info[$i]['product_id']);
                            }
                            ?>
                            <div class="product_description">
                                <div>
                                    <h2 class="product_name"><?= $init_info[$i]['product_name'] ?></h2>
                                    <p class="product_price">$<?= $init_info[$i]['product_price'] ?></p>
                                </div>
                            </div>
                            <img class="product_image" src="<?= $init_info[$i]['product_image_link'] ?>">
                        </section>
                    <?php
                        $i++;
                    endwhile;
                    ?>
                    </div>
                </section>
            <?php endwhile; ?>
            <?php if ($orphan_info): ?>
                <section class="category">
                    <form class="category_header">
                        <button name="category" type="button"><b>Other</b></button>
                    </form>
                    <div class="product_list">
                        <?php foreach ($orphan_info as $value): ?>
                            <section class="product part_of_three">
                                <input type="hidden" value="<?= $value['product_id'] ?>">
                                <input type="hidden" value="<?= $value['product_price'] ?>">
                                <?php

                                if ($privileges) init_content_delete_button("/index.php", $value['product_id'], "product");
                                init_edit_button($value['product_id']);
                                ?>
                                <div class="product_description">
                                    <div>
                                        <h2 class="product_name"><?= $value['product_name'] ?></h2>
                                        <p class="product_price">$<?= $value['product_price'] ?></p>
                                    </div>
                                </div>
                                <img class="product_image" src="<?= $value['product_image_link'] ?>">
                            </section>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        <?php else: ?>
            <div id="empty"><b>There are no products</b></div>
        <?php endif; ?>
        </main>
        <div id="buy_product_background">
            <form id="buy_product" method="GET" action="basket_add_delete.php">
                <input type="hidden" name="basket_product_id" value="">
                <div id="buy_product_main">
                    <div id="buy_product_image">
                        <img src="">
                    </div>
                    <div id="buy_product_data">
                        <div id="buy_product_name"><h2>Product name</h2></div>
                        <div id="buy_product_count">
                            <div></div>
                            <div id="buy_product_count_panel">
                                <button type="button" id="buy_product_count_panel_decrease">-</button>
                                <input type="text" id="buy_count_text" name="basket_product_count">
                                <button type="button" id="buy_product_count_panel_increase">+</button>
                            </div>
                        </div>
                        <div id="buy_product_total">Total price:&nbsp<span id="buy_product_total_value">300</span></div>
                        <button id="buy_product_buy" type="submit" name="basket_product_add" value="OK">Buy</button>
                        <button id="buy_product_close" type="button">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script type="text/javascript" src="js/index.js"></script>
</html>