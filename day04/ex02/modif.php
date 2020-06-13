<?php

if ($_POST['login'] && $_POST['oldpw'] && $_POST['newpw'] && $_POST['submit'] === "OK")
{
    $accounts_info = unserialize(file_get_contents('../private/passwd'));
    $h_old = hash("whirlpool", $_POST['oldpw']);
    $h_new = hash("whirlpool", $_POST['newpw']);
    
    if ($accounts_info)
        foreach ($accounts_info as $k => $v)
            if ($v['login'] === $_POST['login'] && $v['passwd'] === $h_old)
            {
                $accounts_info[$k]['passwd'] = $h_new;
                file_put_contents('../private/passwd', serialize($accounts_info));
                exit("OK\n");
            }
}

echo "ERROR\n";

?>