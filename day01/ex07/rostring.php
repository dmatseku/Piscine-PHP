#!/usr/bin/php
<?php

if ($argc > 1)
{
    $arr = preg_split("/ +/", trim($argv[1]));
    if ($arr != FALSE && $arr[0])
    {
        $c = count($arr);
        for ($i = 1; $i < $c; $i++)
            echo $arr[$i]." ";
        echo $arr[0]."\n";
    }
}

?>