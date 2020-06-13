#!/usr/bin/php
<?php

if ($argc != 2)
    exit();

$curl = curl_init($argv[1]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$code = curl_exec($curl);
curl_close($curl);

if (empty($code))
    exit();

$images_info = array();
    preg_match_all("/<img[^>]+src=\"([^\s>]+)\"/i", $code, $matches);
foreach($matches as $v)
    if (!empty($v))
        array_push($images_info, $v[1]);

$folder_name = preg_replace("/^.*:\/\//", "", $argv[1]);
if (!file_exists($folder_name) || !is_dir($folder_name))
    mkdir($folder_name, 0777, true);

if (empty($image_content))
    exit();

foreach ($images_info as $image)
{
    $curl = curl_init($image);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $image_content = curl_exec($curl);
    curl_close($curl);

    preg_match("/^.*([^\/]+)$/", $image, $matches);
    $fd = fopen($folder_name."/".$matches[1], "w");
    if ($fd != false)
    {
        fwrite($fd, $image_content);
        fclose($fd);
    }
}

?>