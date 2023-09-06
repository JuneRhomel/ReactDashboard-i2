<?php
include('../../../apii2-sandbox.inventiproptech.com/config.php');
include('../../../apii2-sandbox.inventiproptech.com/db.php');
include('../../../apii2-sandbox.inventiproptech.com/shared.php');
include('../../../apii2-sandbox.inventiproptech.com/mailer/mailer.class.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$email = $_POST['email'];

$sth = $db->prepare("select a.*,b.id as acctid from i2accounts.accounts a left join otsi2.accounts b on b.account_code=a.account where a.username=?");
$sth->execute([ $email ]);
$result = $sth->fetch();
if ($result) {
	$acctid = $result['acctid'];
	//$token = md5(randomString().time());
	// EMAIL USER CHNAGE PASSWORD LINK
	$mailer = new Mailer([]);
	$sent = $mailer->send([
		'subject' => 'Change Password Link From Inventi',
		'body'=> "Hi, please click on the link to change your password <a href=\"".WEB_ROOT."/registration/change-password.php?acctid={$acctid}&email={$email}\">Click Here</a>",
		'recipients' => [ $email ]
	]);

	$return = ['success'=>true];
} else {
	$return = ['success'=>false];
}

echo json_encode($return);