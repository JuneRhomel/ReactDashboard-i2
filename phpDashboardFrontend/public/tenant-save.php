<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$post = $_POST;
if (initFile($_FILES['upload_file'])!="") // call function to init for receipt
	$post['photo_id'] = initFile($_FILES['upload_file']); 

if (initFile($_FILES['upload_file_contract'])!="") // call function to init for 
	$post['contract_file'] = initFile($_FILES['upload_file_contract']); 
//vdump($post);

$api = apiSend('tenant','register',$post);
//vdump($api);

header("location: home.php");
?>