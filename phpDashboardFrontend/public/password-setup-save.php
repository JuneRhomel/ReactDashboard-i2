<?php
session_start();

include('../../../vhosts/apii2-sandbox.inventiproptech.com/config.php');
include('../../../vhosts/apii2-sandbox.inventiproptech.com/db.php');
include('../../../vhosts/apii2-sandbox.inventiproptech.com/shared.php');
include('../../../vhosts/apii2-sandbox.inventiproptech.com/mailer/mailer.class.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// GET OTS DB NAME
$sth = $db->prepare("select concat('otsi2_',id) as account_db from otsi2.accounts where account_code=?");
$sth->execute([ decryptData($_POST['acctcode']) ]);
$account_db = $sth->fetch()['account_db'];

$email = $_POST['email'];
$password = md5($_POST['password']);
$confirm_password = md5($_POST['confirm-password']);
if(isset($_POST['master_password'])) {
    $master_password = md5($_POST['master_password']);
} else {
    $master_password = '';
}

if ($password !== $confirm_password) {
    // Return an error since the password and confirm-password do not match
    $error_message = "Password and Confirm Password do not match.";
    $return = ['success' => false, 'error' => $error_message];
} else {
    // Passwords match, proceed with updating the password in the database
    $sth = $db->prepare("UPDATE {$account_db}.resident SET password=?,master_password=?  WHERE email=?");
    $sth->execute([$password,$master_password, $email]);
    $return = ['success' => true];
}

// Convert the response to JSON and send it back
echo json_encode($return);

