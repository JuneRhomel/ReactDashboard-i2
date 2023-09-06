<?php
header('Content-Type: application/json; charset=utf-8');
$locations = $ots->execute('amenity','get-reservations',$_POST);
echo $locations;