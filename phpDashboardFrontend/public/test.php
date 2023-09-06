<?php 
include_once('../library.php');

$data = [
	'role_id'=>3,
	'table'=>'building_app_form',
	'view'=>'role_rights'
];
$otp = $ots->execute('form','get-role-access',$data);
// $otp = apiSend('form','get-role-access',$data);
// var_dump($role_access);

// $otp = apiSend('property-management','get-record',$data);
// $otp = apiSend('tenant','getotp',$_POST);
// echo $otp;
var_dump($otp);
?>