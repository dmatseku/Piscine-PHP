#!/usr/bin/php
<?php

require_once "sql/sql_main.php";
require_once "sql/sql_auth.php";

$admin_name = "";
$admin_password = "";

$sql_link = connect();

if (!$sql_link) {
    echo "Connection: Error (".mysqli_connect_error().")\n";
    exit;
}
echo "Connection: Success\n";

if (!file_exists("sql/create.sql") || !is_file("sql/create.sql")) {
    echo "File ./sql/create.sql not found\n";
    exit;
}
$sql_creation = file_get_contents("sql/create.sql");

if (!mysqli_multi_query($sql_link, $sql_creation)) {
    echo "Database creation: Error (".mysqli_error($sql_link).")\n";
    exit;
}
echo "Database creation: Success\n";

register_user($admin_name, password_hash($admin_password, PASSWORD_DEFAULT));
give_privileges(get_user_id_by_login($admin_name));
echo "Admin with name: \"".$admin_name."\" and password: \"".$admin_password."\" has created successfully\n";

mysqli_close($sql_link);

//EOF
