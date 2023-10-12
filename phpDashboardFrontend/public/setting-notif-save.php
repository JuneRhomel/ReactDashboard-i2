<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$post['notify_email'] = (initObj('notify_email')=="") ? "No" : "Yes";
$post['notify_viber'] = (initObj('notify_viber')=="") ? "No" : "Yes";
$post['allow_push'] = (initObj('allow_push')=="") ? "No" : "Yes";

$api = apiSend('tenant','update-me',$post);

header("location: setting.php");
?>