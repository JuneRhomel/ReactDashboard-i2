<?php
/**
 * Tenat Get One Time Password
 * @author Arnel Benitez <arnel@inventi.ph>
 * @param string $email
 */

$return_value = ['success'=>1,'description'=>'','data'=>[]];

try{
	$email = $data['email'] ?? '';
	$password = $data['password'] ?? 'none';

	if(!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) 
		throw new Exception('Invalid email.');

	//check if tenant exists
	$tenant = $db->getRecord("{$account_db}.tenant",["owner_email"=>$email]);
	$tenant2 = $db->getRecord("{$account_db}.tenant",["tenant_email"=>$email]);

	if(!$tenant && !$tenant2)
		throw new Exception('Tenant not found.');

	if($tenant['password'] != $password)
		throw new Exception('Invalid login');

	$digits = 6;
	$otp =  rand(pow(10, $digits-1), pow(10, $digits)-1);
	
	//update tenant table with token
	$sth = $db->prepare("update {$account_db}.tenant set otp=:otp where owner_email=:email or tenant_email=:email");
	$sth->execute(['otp'=>$otp,'email'=>$email]);

	$mailer = new Mailer([]);
	$sent = $mailer->send([
		'subject' => 'Inventi OTP',
		'body'=> "Your OTP is {$otp}.",
		'recipients' => [$email]
	]);
	$return_value['description'] = $sent['description'];

}catch(PDOException $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);