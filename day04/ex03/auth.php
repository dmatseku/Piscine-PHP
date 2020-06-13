<?php

function auth($login, $passwd)
{
    if ($login && $passwd)
    {
        $accounts_info = unserialize(file_get_contents('../private/passwd'));
        $h_pw = hash("whirlpool", $passwd);

        if ($accounts_info)
            foreach ($accounts_info as $k => $v)
                if ($v['login'] === $login && $v['passwd'] === $h_pw)
                    return true;
    }
    return false;
}

?>