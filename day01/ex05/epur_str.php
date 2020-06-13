#!/usr/bin/php
<?php

if ($argc > 1)
{
    $str = preg_replace("/ +/", " ", trim($argv[1]));
    if ($str)
        echo $str."\n";
}

?>