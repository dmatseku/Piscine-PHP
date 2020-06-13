<?php

require_once "sql/sql_products.php";
require_once "auth.php";

function init_external($current_file) {
    require_once "header.php";
}

session_start();

if (!is_array($_SESSION['basket_products']) || ($_SESSION['logged'] && $_GET['buy'] === "OK")) {
    $_SESSION['basket_products'] = array();
}

$products_data = get_products_data($_SESSION['basket_products']);

$sum = 0;
foreach ($products_data as $id => $data) {
    $sum += $data['product_price'] * $_SESSION['basket_products'][$id];
}
?>

<?php if ($products_data || !$_SESSION['basket_products']): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Магазин фиг пойми чего</title>
        <link rel="stylesheet" href="css/basket.css">
    </head>
    <body>
        <?php init_external("/basket.php"); ?>
        <main>
            <div id="title">Basket</div>
            <?php if (!$_SESSION['basket_products'] || count($_SESSION['basket_products']) == 0): ?>
                <div id="empty"><b>Basket is empty</b></div>
            <?php else: ?>
                <?php foreach ($products_data as $id => $data): ?>
                    <section class="product">
                        <div class="product_image">
                            <img src="<?= $data['product_image_link'] ?>">
                        </div>
                        <div class="product_info">
                            <div><h2><?= $data['product_name'] ?></h2></div>
                            <div><?= $data['product_price']."x".$_SESSION['basket_products'][$id] ?></div>
                            <div><b>$<?= $data['product_price'] * $_SESSION['basket_products'][$id] ?></b></div>
                            <form method="GET" action="basket_add_delete.php">
                                <input type="hidden" name="basket_product_id" value="<?= $id ?>">
                                <button class="product_delete" type="submit" name="basket_product_delete" value="OK">
                                    <img src="img/trash.png">
                                </button>
                            </form>
                        </div>
                    </section>
                <?php endforeach; ?>
                <form id="buy_window" action="basket.php" method="GET">
                    <div id="buy_total">Total cost: $<?= $sum?></div>
                    <div id="buy_splitter"></div>
                    <?php if ($_SESSION['logged']): ?>
                        <button id="buy_confirm" name="buy" value="OK">Buy all</button>
                    <?php else: ?>
                        <div id="buy_not_auth">You must be authorized to purchase</div>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </main>
    </body>
    <?php if ($_GET['buy'] === "OK"): ?>
        <script type="text/javascript">
            <?php if ($_SESSION['logged']): ?>
            alert("Products successfully purchased");
            <?php else: ?>
            alert("You must be authorized to purchase");
            <?php endif; ?>
        </script>
    <?php endif; ?>
</html>
<?php

else:
    header("Location: /html/error503.html");
endif;
?>