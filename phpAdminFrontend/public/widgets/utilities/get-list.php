<?php
$arr = explode("/",$_REQUEST["url"]);
$_POST['view'] = $arr[2];

if (isset($_REQUEST['loc_id']))
	$_POST['filter']['location_id'] = $_REQUEST['loc_id'];
header('Content-Type: application/json; charset=utf-8');
$records = $ots->execute("utilities","get-list",$_POST);
echo $records;
// p_r($records);