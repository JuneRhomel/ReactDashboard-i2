<?php
include('../../../apii2-sandbox.inventiproptech.com/config.php');
include('../../../apii2-sandbox.inventiproptech.com/db.php');
include('../../../apii2-sandbox.inventiproptech.com/shared.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$token = $_REQUEST['token'];
$acctid = $_REQUEST['acctid'];
$acctdb = "otsi2_{$acctid}";

// CHECK IF TOKEN IS VALID
$sth = $db->prepare("select * from {$acctdb}._users where fcm_token=?");
$sth->execute([ $token ]);
$result = $sth->fetch();
if ($result) {
	$sth = $db->prepare("update {$acctdb}._users set is_active=1 where id=1");
	$sth->execute();
	header("location:".WEB_ROOT."?success=1");
} else {
	header("location:".WEB_ROOT."?error=Invalid verification.<br>Please contact our administration.");
}