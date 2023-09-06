<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$post = $_POST;
$api = apiSend('tenant','change-password',$post);
$api_json = json_decode($api,true);
if ($api_json['description']=="Invalid old password.")
	echo "false";
else 
	echo "true";
//echo $api_json['description'];
?>