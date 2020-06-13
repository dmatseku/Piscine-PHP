<?php

if ($_POST['login'] && $_POST['passwd'] && $_POST['submit'] === "OK")
{
    if (!file_exists('../private'))
        mkdir('../private');
    if (!file_exists('../private/passwd'))
        file_put_contents('../private/passwd', null);

    $accounts_info = unserialize(file_get_contents('../private/passwd'));

    if ($accounts_info)
        foreach ($accounts_info as $k => $v)
            if ($v['login'] === $_POST['login'])
                exit("ERROR\n");

    $result['login'] = $_POST['login'];
    $result['passwd'] = hash("whirlpool", $_POST['passwd']);
    $accounts_info[] = $result;
    file_put_contents('../private/passwd', serialize($accounts_info));
    echo "OK\n";
}
else
{
    echo "ERROR\n";
}

?>