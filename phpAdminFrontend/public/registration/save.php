<?php
include('../../../apii2-sandbox.inventiproptech.com/config.php');
include('../../../apii2-sandbox.inventiproptech.com/db.php');
include('../../../apii2-sandbox.inventiproptech.com/shared.php');
include('../../../apii2-sandbox.inventiproptech.com/mailer/mailer.class.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$post = $_POST;

$email = $post['email'];
$account_code = str_replace(".","",str_replace("@","",$email));

// DELETE OLD EXISTING ACCOUNT CODE
$sth = $db->prepare("delete from i2accounts.accounts where account=?");
$sth->execute([ ($account_code) ]);

// CREATE NEW ACCOUNT IN I2ACCOUNTS
$sth = $db->prepare("insert into i2accounts.accounts set __createtime=?,username=?,account=?");
$sth->execute([ time(), ($email), ($account_code) ]);

// DELETE OLD EXISTING ACCOUNT CODE
$sth = $db->prepare("delete from otsi2.accounts where account_code=?");
$sth->execute([ $account_code ]);

// CREATE NEW ACCOUNT IN OTSI2
$sth = $db->prepare("insert into otsi2.accounts set created_at=?,account_code=?");
$sth->execute([ time(), $account_code ]);

// GET LAST ID;
$sth = $db->prepare("select max(id) as lastid from otsi2.accounts");
$sth->execute();
$record = $sth->fetch();
$acctid = $record['lastid'];

$olddb = "otsi2_template";
$newdb = "otsi2_{$acctid}";
exec("mysql -u ".DB_USER." -p".DB_PWD." -h ".DB_HOST." -e 'drop database if exists `".$newdb."`; create database `".$newdb."`;'");
exec("mysqldump -u ".DB_USER." -p".DB_PWD." -h ".DB_HOST." ".$olddb." | mysql -u ".DB_USER." -p".DB_PWD." -h ".DB_HOST." ".$newdb);

// UPDATE DEFAULT 1ST USER
$token = md5(randomString().time());
$fullname = $post['firstname'].' '.$post['lastname'];
$sth = $db->prepare("update {$newdb}._users set user_name=:email,email=:email,first_name=:first_name,last_name=:last_name,password=:password,created_at=:created_at,fcm_token=:token,is_active=0,role_type=:role_type");
$sth->execute([	'email'=>$post['email'], 'first_name'=>$post['firstname'], 'last_name'=>$post['lastname'], 'password'=>md5($post['password']), 'created_at'=>time(), 'token'=>$token,'role_type'=>$post['user_role'] ]);

// ADD DETAIL INTO SYSTEM_INFO
$sth = $db->prepare("insert into {$newdb}.system_info set ownership=:ownership,subscription=:subscription,property_name=:property_name,property_address=:property_address,property_size=:property_size,property_type=:property_type,created_on=:created_on");
$sth->execute([	'ownership'=>$post['ownership'], 'subscription'=>$post['subscription'], 'property_name'=>$post['property_name'], 'property_address'=>$post['property_address'], 'property_size'=>$post['property_size'], 'property_type'=>$post['property_type'],'created_on'=>time() ]);

// CREATE BUILDING IN LOCATION
$sth = $db->prepare("insert into {$newdb}.location set location_name=:location_name,location_type=:location_type,location_use=:location_use,floor_area=:floor_area,created_on=:created_on");
$sth->execute([	'location_name'=>$post['property_name'], 'location_type'=>'Building', 'location_use'=>$post['property_type'], 'floor_area'=>$post['property_size'], 'created_on'=>time() ]);

// EMAIL REGISTRANT VERIFICATION LINK
$mailer = new Mailer([]);
$sent = $mailer->send([
	'subject' => 'Verification Link From Inventi',
	'body'=> "Hi {$fullname}, please click on the link to verify <a href=\"".WEB_ROOT."/registration/verify.php?token={$token}&acctid={$acctid}\">Click Here</a>",
	'recipients' => [ $post['email'] ]
]);

echo json_encode($post);