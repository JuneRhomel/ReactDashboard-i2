<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$data = $_POST;
$result = apiSend('tenant', 'change-password-save', $data);
echo $result;

?>