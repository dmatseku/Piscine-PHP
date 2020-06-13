#!/usr/bin/php
<?php

if ($argc != 2)
    exit("Invalid number of arguments\n");

$days_of_week = array(
    "Lundi" => "Monday",
    "Mardi" => "Tuesday",
    "Mercredi" => "Wednesday",
    "Jeudi" => "Thursday",
    "Vendredi" => "Friday",
    "Samedi" => "Saturday",
    "Dimanche" => "Sunday"
);

$months = array(
    "Janvier" => "01",
    "Fevrier" => "02",
    "Mars" => "03",
    "Avril" => "04",
    "Mai" => "05",
    "Juin" => "06",
    "Juillet" => "07",
    "Aout" => "08",
    "Septembre" => "09",
    "Octobre" => "10",
    "Novembre" => "11",
    "Decembre" => "12"
);

$matches = array();
$match_result = preg_match("/(Lundi|Mardi|Mercredi|Jeudi|Vendredi|Samedi|Dimanche) (\d{1,2}) ".
    "(Janvier|Fevrier|Mars|Avril|Mai|Juin|Juillet|Aout|Septembre|Octobre|Novembre|Decembre) (\d{4}) ".
    "((\d{2}):(\d{2}):(\d{2}))/", $argv[1], $matches);

if ($match_result == 0 || $match_result == false)
    exit("Wrong Format\n");

$matches[1] = $days_of_week[$matches[1]];
$matches[3] = $months[$matches[3]];

if ($matches[4] < 1970)
    exit("Too low number of year\n");
if ($matches[1] > cal_days_in_month(CAL_GREGORIAN, $matches[3], $matches[4]))
    exit("Incorrect day of month\n");
if (jddayofweek(cal_to_jd(CAL_GREGORIAN, $matches[3], $matches[2], $matches[4]), 1) != $matches[1])
    exit("Incorrect day of the week\n");
if ($matches[6] > 23 || $matches[7] > 59 || $matches[8] > 59)
    exit("Incorrect time\n");

echo (strtotime($matches[4].'-'.$matches[3].'-'.$matches[2].' '.$matches[5]) - strtotime('1970-01-01 01:00:00'));
echo "\n";
?>