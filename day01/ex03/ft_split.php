#!/usr/bin/php
<?php

function ft_split($str)
{
    $res = preg_split("/ +/", trim($str));
    sort($res);
    if ($res != FALSE && $res[0])
        return $res;
    return null;
}

?>