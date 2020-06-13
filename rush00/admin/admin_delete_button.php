<link rel="stylesheet" href="../css/admin_delete_button.css">
<?php function init_content_delete_button($current_file, $id, $type) { ?>
    <form class="admin_delete_button admin_<?= $type ?>_delete_button" method="POST" action="/admin/admin_delete_content.php">
        <input type="hidden" name="src_file" value="<?= $current_file ?>">
        <button name="<?= $type ?>_delete" value="<?= $id ?>">
            <img src="/img/trash.png" alt="delete">
        </button>
    </form>
<?php } ?>
