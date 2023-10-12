<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$post = $_POST;
// if (initFile($_FILES['upload_file'])!="") // call function to init for receipt
// 	$post['photo_id'] = initFile($_FILES['upload_file']); 
// vdump($post);

$api = apiSend('workpermit','create',$post);
//vdump($api);

header("location: home.php");
?>