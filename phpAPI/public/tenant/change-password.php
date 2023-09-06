<?php
$return_value = ['success'=>1,'description'=>''];
try{
	//get tenant record
	$sth =  $db->prepare("select * from {$account_db}.tenants where id=?");
	$sth->execute([$user_id]);
	$user_details = $sth->fetch();
	
	if(!isset($data['password_new']) || !isset($data['password_old']))
		throw new Exception("Incomplete data submitted");

	//check old password
	if($user_details['password'] != md5($data['password_old']))
		throw new Exception("Invalid old password.");

	//check current and retypr
	// if($data['password_new'] != $data['password_confirm'])
	// 	throw new Exception("Password does not matched!");

	if(trim($data['password_new']) == '')
		throw new Exception("Empty password is not allowed");

	$sth = $db->prepare("update {$account_db}.tenants set password=:password where id = :id");
	$sth->execute(['password'=>md5($data['password_new']),'id'=>$user_id]);
	
	$return_value['description'] = 'Password changed!';
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);	