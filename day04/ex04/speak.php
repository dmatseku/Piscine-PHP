<?php

session_start();

if (!($_SESSION['loggued_on_user']))
    echo 'ERROR\n';
else
{
    if ($_POST['msg'])
    {
        if (!file_exists('../private'))
            mkdir('../private');
        if (!file_exists('../private/chat'))
            file_put_contents('../private/chat', null);

        $chat = unserialize(file_get_contents('../private/chat'));
        $fp = fopen('../private/chat', "w");
        flock($fp, LOCK_EX);
        $res['login'] = $_SESSION['loggued_on_user'];
        $res['time'] = time();
        $res['msg'] = $_POST['msg'];
        $chat[] = $res;
        file_put_contents('../private/chat', serialize($chat));
        flock($fp, LOCK_UN);
        fclose($fp);
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <script language="javascript">top.frames['chat'].location = 'chat.php';</script>
    </head>
    <body>
        <form action="speak.php" method="POST">
            <input type="text" name="msg" value=""/>
            <input type="submit" name="submit" value="Send"/>
        </form>
    </body>
    <?php
}

?>