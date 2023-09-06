<?php
header('Content-Type: application/json; charset=utf-8');
$locations = $ots->execute('location','search',$_POST);
echo $locations;