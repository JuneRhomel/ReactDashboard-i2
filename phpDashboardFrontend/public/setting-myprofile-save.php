<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$post = $_POST;
// if (initFile($_FILES['upload_file'])!="") 
// 	$post['picture'] = initFile($_FILES['upload_file']); 
// vdump($post);

$result = apiSend('tenant', 'save-profile', $post);
echo $result;
// header("location: my-profile_new.php");
?>