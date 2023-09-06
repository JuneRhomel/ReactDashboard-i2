<?php
$return_value = ['success'=>1,'description'=>'Registration updated!'];
try{
	$registration_id = decryptData($data['registration_id']);
	$status = $data['status'];

	$sth = $db->prepare("update {$account_db}.tenant_registrations set status=? where id=?");
	$sth->execute([$status,$registration_id]);

	//get tenant info
	$sth =  $db->prepare("select * from {$account_db}.tenant_registrations where id=?");
	$sth->execute([$registration_id]);
	$tenant = $sth->fetch();

	if($status == 'Approved')
	{
		//save details to tenant record
		if(!$tenant['password'])
		{
			$password = randomString(10);
			$sth = $db->prepare("insert into {$account_db}.tenants(tenant_name,tenant_type,email,mobile,id_url,contract_url,password) select tenant_name,tenant_type,email,mobile,id_url,contract_url,'{$password}' from {$account_db}.tenant_registrations where id=?");
		}
		else
			$sth = $db->prepare("insert into {$account_db}.tenants(tenant_name,tenant_type,email,mobile,id_url,contract_url,password) select tenant_name,tenant_type,email,mobile,id_url,contract_url,password from {$account_db}.tenant_registrations where id=?");
		$sth->execute([$registration_id]);
		$tenant_id = $db->lastInsertId();

		//save to tenant location 
		$sth = $db->prepare("insert into {$account_db}.tenant_locations set tenant_id=?,location_id=?,is_default=1");
		$sth->execute([$tenant_id,$tenant['location_id']]);

		if(!$tenant['password'])
		{
			//send an email
			$mailer = new Mailer([]);
			$sent = $mailer->send([
				'subject' => 'Registration approved',
				'body'=> "Hi {$tenant['tenant_name']},<p>Your registration has been approved. You may now login at <a href='https://portal.ots-sandbox.intuition.ph/index.php'>https://portal.ots-sandbox.intuition.ph/index.php</a><br>Password: {$password}</p>Thank you",
				'recipients' => [$tenant['email']]
			]);

		}else{
			//send an email
			$mailer = new Mailer([]);
			$sent = $mailer->send([
				'subject' => 'Registration approved',
				'body'=> "Hi {$tenant['tenant_name']},<p>Your registration has been approved. You may now login at <a href='https://portal.ots-sandbox.intuition.ph/index.php'>https://portal.ots-sandbox.intuition.ph/index.php</a></p>Thank you",
				'recipients' => [$tenant['email']]
			]);
		}
	}
	
	//notify tenant
	$sth = $db->prepare("insert into {$account_db}.notifications set created_on=?,title=?,content=?,tenant_id=?");
	$sth->execute([
		time(),
		"Tenant Registration - {$status}",
		"Your tenant registration has been {$status}.",
		$tenant['owner_id']
	]);
	
	$return_value = ['success'=>1,'description'=>"Registration updated as {$status}"];

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);