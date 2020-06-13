<?php
require_once "sql/sql_auth.php";

session_start();
?>
    <link rel="stylesheet" href="/css/header.css">
    <script type="text/javascript" src="/js/show_hide_modal.js"></script>
    <header id="main_header">
        <div id="home">
            <a href="index.php"><img src="/img/shop.png" alt="Home" title="Home"></a>
        </div>
        <div id="main_panel">
            <form id="search_panel" method="GET" action="/index.php">
                <input type="hidden" name="category" value="<?= (isset($_GET['category']) ? $_GET['category'] : "%") ?>">
                <input id="search_field" type="text" name="product" value="<?= (isset($_GET['product']) ? htmlspecialchars($_GET['product'], ENT_QUOTES) : "") ?>" placeholder="Search">
                <button id="search_button">
                    <img id="search_image" src="/img/loupe.png" alt="Search">
                </button>
            </form>
            <form class="menu_link" action="/categories.php">
                <button class="menu_button">
                    <img class="menu_image" src="/img/list.png" alt="Categories" title="Categories">
                </button>
            </form>
            <form class="menu_link" action="/basket.php">
                <button class="menu_button">
                    <img class="menu_image" src="/img/basket.png" alt="Your basket" title="Your basket">
                </button>
            </form>
        </div>
        <?php if (!$_SESSION['logged']): ?>
            <div id="non_profile">
                <div>
                    <button class="profile_button" type="button">Log In</button>
                    <button class="profile_button" type="button">Register</button>
                </div>
            </div>
        <?php else: ?>
            <div id="profile">
                <h2 id="profile_login"><?= $_SESSION['login'] ?></h2>
                <form id="profile_actions" method="post" action="/account_model.php">
                    <button class="profile_button" id="profile_change" type="button">Change password</button>
                    <button class="profile_button" name="auth_action" value="logout">Log out</button>
                    <input type="hidden" name="src_file" value="<?= $current_file ?>">
                </form>
            </div>
        <?php endif; ?>
    </header>
    <div class="auth_background">
        <form method="POST" action="/account_model.php" class="auth_window" id="register">
            <h2 class="auth_header">Register</h2>
            <p class="auth_state_info"></p>
            <div class="auth_fields">
                <input type="text" name="login" class="auth_login" placeholder="Enter login">
                <input type="password" name="password" id="auth_reg_password" placeholder="Enter password">
                <input type="password" id="auth_confirm" placeholder="Confirm password">
            </div>
            <div class="auth_buttons">
                <button name="auth_action" value="register">Register</button>
                <button type="button" class="auth_button_close">Close</button>
            </div>
            <input type="hidden" name="src_file" value="<?= $current_file ?>">
        </form>
    </div>
    <div class="auth_background">
        <form method="POST" action="/account_model.php" class="auth_window" id="change_passwd">
            <h2 class="auth_header">Change password</h2>
            <p class="auth_state_info"></p>
            <div class="auth_fields">
                <input type="text" name="login" class="auth_login" placeholder="Enter login">
                <input type="password" name="password" placeholder="Old password">
                <input type="password" name="new_password" placeholder="New password">
            </div>
            <div class="auth_buttons">
                <button name="auth_action" value="change_passwd">Change</button>
                <button type="button" class="auth_button_close">Close</button>
            </div>
            <input type="hidden" name="src_file" value="<?= $current_file ?>">
        </form>
    </div>
    <div class="auth_background">
        <form method="POST" action="/account_model.php" class="auth_window" id="login">
            <h2 class="auth_header">Log in</h2>
            <p class="auth_state_info"></p>
            <div class="auth_fields">
                <input type="text" name="login" class="auth_login" placeholder="Enter login">
                <input type="password" name="password" placeholder="Enter password">
            </div>
            <div class="auth_buttons">
                <button name="auth_action" value="login">Log in</button>
                <button type="button" class="auth_button_close">Close</button>
            </div>
            <input type="hidden" name="src_file" value="<?= $current_file ?>">
        </form>
    </div>
    <script type="text/javascript" src="/js/header.js"></script>
        <?php

            if ($_SESSION["auth_error"]):
                $err_login = $_SESSION["auth_error"]["login"];
                $error = $_SESSION["auth_error"]["error"];
                $err_action = $_SESSION["auth_error"]["action"];
                $_SESSION["auth_error"] = false;
                unset($_SESSION["auth_error"]);
                if ($err_action == "register" || $err_action == "login" || $err_action == "change_passwd"):
        ?>
    <script type="text/javascript">
        document.getElementById("<?= $err_action ?>").getElementsByClassName("auth_login")[0].value = "<?= $err_login ?>";
        document.getElementById("<?= $err_action ?>").getElementsByClassName("auth_state_info")[0].textContent = "<?= $error ?>";
        show_window(document.getElementById("<?= $err_action ?>").parentElement)
    </script>
        <?php

    endif;
endif;
?>