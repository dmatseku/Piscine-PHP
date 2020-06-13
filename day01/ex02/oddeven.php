#!/usr/bin/php
<?php

$in = fopen("php://stdin", "r");

while ($in)
{
    echo "Enter a number: ";
    $str = str_replace("\n", "", fgets($in));
    if (!feof($in))
    {
        if (is_numeric($str))
        {
            if ($str % 2 == 0)
                echo "The number " . $str . " is even";
            else
                echo "The number " . $str . " is odd";
        }
        else
            echo "'" . $str . "' is not a number";
            echo "\n";
    }
    else
    {
        echo "\n";
        break;
    }
}

?>