#!/usr/bin/php
<?php

if ($argc > 2)
{
    $needle = $argv[1];
    $map = array();
    for ($i = 2; $i < $argc; $i++)
    {
        $split = preg_split("/:/", $argv[$i]);
        $map[$split[0]] = $split[1];
    }

    if (array_key_exists($needle, $map))
        echo $map[$needle]."\n";
}

?>