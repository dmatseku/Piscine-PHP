#!/usr/bin/php
<?php

function ft_is_sort($arr) : bool
{
    $is_sorted = true;
    $c = count($arr);
    
    for ($i = 1; $i < $c && $is_sorted == true; $i++)
        if ($arr[$i] < $arr[$i - 1])
            $is_sorted = false;
    return ($is_sorted);
}

?>