<?php
session_start();
include("../library.php");

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// $post = $_POST;

// // INIT ATTACHMENT
// $attachments = array();
// if (initFile($_FILES['upload_pic'])!="")
// 	array_push($attachments,initFile($_FILES['upload_pic']));
// if (initFile($_FILES['upload_file'])!="")
// 	array_push($attachments,initFile($_FILES['upload_file']));
// if (!empty($attachments))
// 	$post['attachments'] = $attachments;
// //vdump($post);

// $api = apiSend('servicerequest','create',$post);
// //vdump($api);

$result = apiSend('servicerequest','save',$_POST);
echo $result;

// header("location: home.php");
?>