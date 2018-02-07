<?php
include('src/turkeyweather.php');

$weather = new TurkeyWeather();
$weather->province('burdur');

echo $weather->temperatureK();

?>


