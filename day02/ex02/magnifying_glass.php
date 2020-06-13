#!/usr/bin/php
<?php

if ($argc > 1)
{
    $content = preg_replace_callback("/(<a.*>.*<\/a>)/si",
    function($matches)
    {
        $matches[0] = preg_replace_callback("/(<.[^>]*)(title=)('|\")(.+)('|\")(.*\/?>)/i",
        function($matches)
        {
            return ($matches[1].$matches[2].$matches[3].strtoupper($matches[4]).$matches[5].$matches[6]);
        }, $matches[0]);
        
        $matches[0] = preg_replace_callback("/(>)([^><]+)(<)/si",
        function($matches)
        {
            return ($matches[1].strtoupper($matches[2]).$matches[3]);
        }, $matches[0]);

        return $matches[0];
    }, file_get_contents($argv[1]));

    echo $content;
}

?>