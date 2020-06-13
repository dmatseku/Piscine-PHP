<?php

require_once "sql/sql_auth.php";

session_start();

$_SESSION['logged'] = false;
$_SESSION['login'] = "";
if (!empty($_COOKIE['user_hash']) && !empty($_COOKIE['user_id'])
    && $login = find_log($_COOKIE['user_hash'], $_COOKIE['user_id'])) {
        $_SESSION['logged'] = true;
        $_SESSION['login'] = $login;
}

//EOF