<?php

function get_error($window) {
    if (isset($_SESSION['error']) && $_SESSION['error'][0] === $window) {
        $value = $_SESSION['error'][1];
        $_SESSION['error'] = false;
        unset ($_SESSION['error']);
        return $value;
    }
    return "";
}

if ($_SESSION['logged'] && get_user_privileges($_SESSION['login'])):
?>
<link rel="stylesheet" href="/css/admin_panel.css">
<aside class="admin_panel" id="admin_panel_left">
    <div class="admin_form">
        <h2 class="admin_title">Admin</h2>
        <p class="admin_error"><?= get_error("give_take_admin") ?></p>
        <form class="admin_inputs" method="POST" action="/admin/admin_give_take_admin.php">
            <input type="hidden" name="src_file" value="<?= $current_file ?>">
            <input class="admin_input" type="text" name="login_for_action" value="" placeholder="Login">
            <button class="admin_button" name="login_action" value="give_privileges">Add</button>
            <button class="admin_button" name="login_action" value="take_privileges">Take away</button>
        </form>
    </div>
    <div class="admin_form">
        <h2 class="admin_title">Create user</h2>
        <p class="admin_error"><?= get_error("create_user") ?></p>
        <form class="admin_inputs" method="POST" action="/admin/admin_create_delete_user.php">
            <input type="hidden" name="src_file" value="<?= $current_file ?>">
            <input class="admin_input" type="text" name="login" value="" placeholder="Login">
            <input class="admin_input" type="password" name="password" value="" placeholder="Password">
            <button class="admin_button" name="create_user" value="OK">Create</button>
        </form>
    </div>
    <div class="admin_form">
        <h2 class="admin_title">Delete user</h2>
        <p class="admin_error"><?= get_error("delete_user") ?></p>
        <form class="admin_inputs" method="POST" action="/admin/admin_create_delete_user.php">
            <input type="hidden" name="src_file" value="<?= $current_file ?>">
            <input class="admin_input" type="text" name="login" value="" placeholder="Login">
            <button class="admin_button" name="delete_user" value="OK">Delete</button>
        </form>
    </div>
</aside>
<aside class="admin_panel" id="admin_panel_right">
    <div class="admin_form">
        <h2 class="admin_title">Add content</h2>
        <p class="admin_error"><?= get_error("category_add") ?></p>
        <form class="admin_inputs" method="POST" action="/admin/admin_add_category.php">
            <input type="hidden" name="src_file" value="<?= $current_file ?>">
            <input class="admin_input" type="text" name="category_add" value="" placeholder="Category name">
            <button class="admin_button">Add category</button>
            <a id="admin_link_product" href="/admin/admin_change_product_page.php">
                <button class="admin_button" id="admin_button_product" type="button">Add product</button>
            </a>
        </form>
    </div>
    <div class="admin_form">
        <h2 class="admin_title">Change category</h2>
        <p class="admin_error"><?= get_error("change_category") ?></p>
        <form class="admin_inputs" method="POST" action="/admin/admin_change_category.php">
            <input type="hidden" name="src_file" value="<?= $current_file ?>">
            <input class="admin_input" type="text" name="old_category" value="" placeholder="Old name">
            <input class="admin_input" type="text" name="new_category" value="" placeholder="New name">
            <button class="admin_button">Change</button>
        </form>
    </div>
</aside>
<?php endif; ?>