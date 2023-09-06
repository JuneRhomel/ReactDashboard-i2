<?php
$arr = explode("/",$_REQUEST["url"]);
$_POST['view'] = $arr[2];
$_POST['location_id'] = $arr[3];
header('Content-Type: application/json; charset=utf-8');
$records = $ots->execute("module","get-location-list",$_POST);
echo $records;