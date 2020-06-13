#!/usr/bin/php
<?php

if ($argc == 4)
{
    $first = (int)($argv[1]);
    $operator = ord(trim($argv[2])[0]);
    $second = (int)($argv[3]);
    
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
        default:
            "Invalid operand\n";
            break;
    }
}
else
    echo "Invalid number of arguments\n";

?>