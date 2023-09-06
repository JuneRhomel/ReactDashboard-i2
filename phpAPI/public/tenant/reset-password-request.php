<?php
$return_value = ['success'=>1,'description'=>'Password reset link sent to email.'];
try{
	$email = trim($data['email'] ?? '');
	$reseturl = $data['reseturl'];

	if(!$email)if(!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) 
		throw new Exception('Invalid email.');

	
	$sth = $db->prepare("select * from {$account_db}.tenants where email=?");
	$sth->execute([$email]);
	$check = $sth->fetch();
	
	if(!$check)
		throw new Exception("Unregistered email.");

	$digits = 6;
	$otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
	
	//update tenant table with otp
	$sth = $db->prepare("update {$account_db}.tenants set otp=:otp where email=:email");
	$sth->execute(['otp'=>$otp,'email'=>$email]);



	$otp_encrypted = encryptData($otp);
	$email_encrypted = encryptData($email);

	$mailer = new Mailer([]);
	$sent = $mailer->send([
		'subject' => 'Inventi Reset Password Request',
		'body'=> "Hi {$check['tenant_name']},<p>There was a request to reset your password!</p><p>If you did not make this request then please ignore this email.</p><p>Otherwise, please click this link to reset your password: {$reseturl}?resettoken={$otp_encrypted}&email={$email_encrypted}</p>",
		'recipients' => [$email]
	]);
	$return_value['description'] = $sent['description'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);