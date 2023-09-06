<?php
header('Content-Type: application/json; charset=utf-8');
$locations = $ots->execute('location','get-locations',$_POST);
echo $locations;