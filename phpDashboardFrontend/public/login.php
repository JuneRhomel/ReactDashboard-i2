<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include_once('../library.php');
$authenticate = apiSend('tenant','authenticate',$_POST);
$authenticate_json = json_decode($authenticate,true);

if($authenticate_json['success'] == 1) {
	$_SESSION['tenant'] = $authenticate_json['data'];
	header("location:home.php");
}
echo $authenticate_json;