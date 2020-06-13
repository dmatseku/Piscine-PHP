<link rel="stylesheet" href="../css/admin_edit_button.css">
<?php function init_edit_button($id) { ?>
    <form class="admin_edit_button" method="POST" action="/admin/admin_change_product_page.php">
        <button name="edit" value="<?= $id ?>">
            <img src="/img/edit.png" alt="edit">
        </button>
    </form>
<?php } ?>