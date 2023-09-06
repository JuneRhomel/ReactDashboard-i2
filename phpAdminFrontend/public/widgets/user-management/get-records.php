<?php
$arr = explode("/",$_REQUEST["url"]);

if($arr[2]=='view_tenant_list'){
	$_POST['view'] ="tenant";
	$_POST['filter'] = "status='approved'";
}else if($arr[2]=='tenant'){
	$_POST['filter'] = "status IN ('registered', 'disapproved')";
	$_POST['view'] = $arr[2];
}else{
	$_POST['view'] = $arr[2];
}
if (isset($_REQUEST['loc_id']))
	$_POST['filter']['location_id'] = $_REQUEST['loc_id'];

header('Content-Type: application/json; charset=utf-8');

$records = $ots->execute("admin","get-records",$_POST);
echo $records;