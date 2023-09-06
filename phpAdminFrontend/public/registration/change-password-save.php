<?php
include('../../../apii2-sandbox.inventiproptech.com/config.php');
include('../../../apii2-sandbox.inventiproptech.com/db.php');
include('../../../apii2-sandbox.inventiproptech.com/shared.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$acctid = $_POST['acctid'];
$email = $_POST['email'];
$password = md5($_POST['password']);
$acctdb = "otsi2_{$acctid}";

$sth = $db->prepare("update {$acctdb}._users set password=? where email=?");
$sth->execute([ $password,$email ]);
$return = ['success'=>true];

echo json_encode($return);