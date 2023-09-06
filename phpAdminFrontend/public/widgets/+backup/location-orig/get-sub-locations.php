<?php
header('Content-Type: application/json; charset=utf-8');
$_POST['locationid'] = $_GET['locationid'];
$locations = $ots->execute('location','get-sub-locations',$_POST);
echo $locations;