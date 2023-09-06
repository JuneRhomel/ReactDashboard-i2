<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$post = $_POST;
//vdump($post);

$api = apiSend('reservation','create',$post);
//vdump($api);

/*$api = apiSend('amenity','myreservations',ARR_BLANK);
$api_json = json_decode($api,true);
vdump($api_json);*/

header("location: home.php");
?>