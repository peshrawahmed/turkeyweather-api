<?php
include('turkeyweather.php');

$weather = new TurkeyWeather();
$weather->province('burdur');

echo $weather->temperatureK();

?>


