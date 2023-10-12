<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$post = $_POST;
if (initFile($_FILES['upload_file'])!="") // call function to init for receipt
	$post['file'] = initFile($_FILES['upload_file']); 
//vdump($post);

$api = apiSend('form','upload',$post);
//vdump($api);

header("location: forms.php?type=upload");
?>