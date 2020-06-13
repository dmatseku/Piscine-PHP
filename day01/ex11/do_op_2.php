#!/usr/bin/php
<?php

if ($argc == 2)
{
    $matches = array();
    $str = preg_replace("/ +/", "", $argv[1]);
    $match_result = preg_match("/^(\d+)(\+|-|\*|\/|%)(\d+)$/", $str, $matches);
    if (!$match_result || $match_result == false)
        echo "Syntax Error\n";

    $first = (int)($matches[1]);
    $operator = ord($matches[2]);
    $second = (int)($matches[3]);
    
    switch ($operator)
    {
        case 43:
            echo ($first + $second)."\n";
            break;
        case 45:
            echo ($first - $second)."\n";
            break;
        case 42:
            echo ($first * $second)."\n";
            break;
        case 47:
            echo ($first / $second)."\n";
            break;
        case 37:
            echo ($first % $second)."\n";
            break;
    }
}
else
    echo "Invalid number of arguments\n";

?>