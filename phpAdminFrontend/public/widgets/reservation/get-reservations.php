<?php
header('Content-Type: application/json; charset=utf-8');
$locations = $ots->execute('reservation','get-reservations',$_POST);
echo $locations;