<?php
$return_value = ['success'=>1,'description'=>'Password changed.'];
try{
	$email = decryptData(trim($data['email'] ?? ''));
	$resettoken = $data['resettoken'];
	$password = $data['password'];

	if(!$email)if(!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) 
		throw new Exception('Invalid email.');
	
	$sth = $db->prepare("select * from {$account_db}.tenants where email=?");
	$sth->execute([$email]);
	$check = $sth->fetch();
	
	if(!$check)
		throw new Exception("Unregistered email.");

	if($check['otp'] != decryptData($resettoken))
		throw new Exception("Invalid reset token.");
	
	//update tenant table with new password
	$sth = $db->prepare("update {$account_db}.tenants set password=:password where email=:email");
	$sth->execute(['password'=>md5($password),'email'=>$email]);

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);