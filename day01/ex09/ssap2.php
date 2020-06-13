#!/usr/bin/php
<?php

$res = array();

for ($i = 1; $i < $argc; $i++)
{
    $arg_res = preg_split("/ +/", trim($argv[$i]));
    if ($arg_res[0] != "")
        $res = array_merge($res, $arg_res);
}

function cmp($a, $b)
{
    if ($a == $b)
        return (0);

    $i = 0;
    while ($a[$i] == $b[$i])
        $i++;
    
    $char_a = $a[$i];
    $char_b = $b[$i];

    if ($char_a >= 'a' && $char_a <= 'z')
        $char_a = chr (ord ($char_a) - 32);
    if ($char_b >= 'a' && $char_b <= 'z')
        $char_b = chr (ord ($char_b) - 32);

    if (IntlChar::isalpha($char_b))
        if (IntlChar::isalpha($char_a))
            return (ord ($char_a) - ord ($char_b));
        else
            return (1);
    else if ((!IntlChar::isdigit($char_b) && IntlChar::isalnum($char_a))
          || (IntlChar::isdigit($char_b) && IntlChar::isalpha($char_a)))
        return (-1);
    else if (IntlChar::isdigit($char_a) && IntlChar::isdigit($char_b))
        return (ord ($char_a) - ord ($char_b));
    return (1);
}

usort($res, "cmp");

foreach ($res as $elem)
{
    echo $elem."\n";
}

?>