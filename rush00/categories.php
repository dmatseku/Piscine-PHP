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
    }
}

$categories = false;
if ($_SESSION['logged'] && get_user_privileges($_SESSION['login'])) {
    $categories = get_full_categories_list();
} else {
    $categories = get_categories_list();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Магазин фиг пойми чего"</title>
        <link rel="stylesheet" href="css/categories.css">
    </head>
    <body>
        <?php init_external("/categories.php"); ?>
        <main>
            <div id="title">Categories</div>
            <?php if ($categories !== false): ?>
                <form class="category" method="GET" action="index.php">
                    <button class="category_button" name="category" value="%">All</button>
                </form>
                <?php foreach ($categories as $info): ?>
                    <section class="category">
                        <?php if ($privileges) init_content_delete_button("/categories.php", $info['id'], "category"); ?>
                        <form class="category_form" method="GET" action="index.php">
                            <button class="category_button" name="category" value="<?= $info['name'] ?>"><?= $info['name'] ?></button>
                        </form>
                    </section>
                <?php endforeach; ?>
            <?php else: ?>
                <div id="empty"><b>There are no categories</b></div>
            <?php endif; ?>
        </main>
    </body>
</html>
