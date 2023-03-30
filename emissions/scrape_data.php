<?php
header('Content-type: application/json');

$lon = $_GET['lon'];
$lat = $_GET['lat'];
$PAR = $_GET['par'];


exec("gdallocationinfo -wgs84 -valonly data/$PAR.tif $lon $lat", $vals);

echo json_encode($vals);

?>