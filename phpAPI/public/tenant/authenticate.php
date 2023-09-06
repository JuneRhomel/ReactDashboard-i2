<?php
$return_value = ['success' => 1, 'description' => '', 'data' => []];
try {
	//$tmp = encryptData("adminmailinatorcom");
	//$account_db = decryptData($data['acctdb']);
	//$acctcode = decryptData($data['acctcode'])
	//$accountcode = $data['accountcode'];
	//$_SESSION['accountcode'] = $acctcode;

	$email = $data['email'];
	$otp = $data['otp'];
	$password = md5($data['password']);

	$sth = $db->prepare("select * from {$account_db}.vw_resident where email=:email and status ='Active'");
	$sth->execute(['email' => $email]);
	$tenant = $sth->fetch();
	if (!$tenant) {
		$tenant['id'] = 0;
		$return_value = ['success' => 0, 'description' => 'Account does not exist'];
	} else {

		$sth = $db->prepare("select * from {$account_db}.vw_resident where email=:email and password=:password and status ='Active'");
		$sth->execute(['email' => $email, 'password' => $password]);
		$tenant = $sth->fetch();
		if ($tenant) {
			/*if(!$tenant || $tenant['otp'] != $otp)
						throw new Exception("Invalid OTP");*/

			$token = md5(randomString() . time());

			// SAVE TO USER TOKENS
			$user_token_table = $account_db . '._tenant_tokens';
			$sth = $db->prepare("insert into {$user_token_table} (tenant_id,token) values(:tenant_id,:token)");
			$sth->execute(['tenant_id' => $tenant['id'], 'token' => $token]);

			//get locations
			// $sth = $db->prepare("select tenant_locations.location_id,locations.location_name,tenant_locations.is_default from {$account_db}.tenant_locations,{$account_db}.locations where tenant_locations.tenant_id=:tenant_id and  locations.id = tenant_locations.location_id");
			// $sth->execute(['tenant_id'=>$tenant['id']]);
			// $locations = $sth->fetchAll();

			$return_value = ['success' => 1, 'description' => '', 'data' => ['token' => $token, 'tenant_name' => $tenant['fullname'], 'tenant_id' => $tenant['id'], 'email' => $tenant['email'], 'mobile' => $tenant['contact_no'], 'db' => $account_db, 'tmp' => $tmp]];
		} else {
			$return_value = ['success' => 0, 'description' => 'Invalid login'];
		}
	}
} catch (Exception $e) {
	$return_value = ['success' => 0, 'description' => $e->getMessage(), 'data' => decryptData($data['acctdb']), 'tmp' => $tmp];
}

echo json_encode($return_value,	JSON_NUMERIC_CHECK);
