#!/usr/bin/php
<?php

$res = array();

for ($i = 1; $i < $argc; $i++)
{
    $arg_res = preg_split("/ +/", trim($argv[$i]));
    if ($arg_res[0] != "")
        $res = array_merge($res, $arg_res);
}

sort($res);

foreach ($res as $elem)
{
    echo $elem."\n";
}

?>