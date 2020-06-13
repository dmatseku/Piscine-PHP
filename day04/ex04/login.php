<?php

require_once('auth.php');

session_start();

if (auth($_POST['login'], $_POST['passwd']))
{
    $_SESSION['loggued_on_user'] = $_POST['login'];
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>ex04_Chat</title>
    </head>
    <body>
        <iframe name="chat" src="chat.php" width="100%" height="550px"></iframe>
        <iframe name="speak" src="speak.php" width="100%" height="50px"></iframe>
    </body>
    </html>
    <?php
}
else
{
    $_SESSION['loggued_on_user'] = "";
    echo "ERROR\n";
}

?>