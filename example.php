<?php
include('src/turkeyweather.php');

$weather = new TurkeyWeather();
$weather->province('Ankara');
$weather->district('Çankaya');

echo $weather->province() . ' ' . $weather->district() . '\'da şu an Sıcaklık ' . $weather->temperature() . ' derecedir';

?>


