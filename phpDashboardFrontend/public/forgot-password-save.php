<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$post = $_POST;
$api = apiSend('tenant','reset-password',$post);
$result = json_decode($api);
header("location: index.php");