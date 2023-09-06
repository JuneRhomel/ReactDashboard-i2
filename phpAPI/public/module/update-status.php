<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$table = $data['table'];
	$id = ($data['id']) ? decryptData($data['id']) : 0;
	$field = $data['field'];	
	$status = $data['status'];
	$email = $data['email'];

	// UPDATE STATUS IN TABLE WITH ACTION TAKEN
	$sql = "update {$account_db}.{$table} set {$field}=? where id=?";
	$sth = $db->prepare($sql);	
	$sth->execute([ $status,$id ]);

	// OCCUPANT REGISTRATION *********************************************************
	if ($table=="occupant_reg") {
		// INIT BODY CONTENT BASED ON ACTION
		if ($status=="Approved") {		
			// REPLICATE DATA FROM OCCUPANT REG TO RESIDENT
			$sql = "insert into {$account_db}.resident (email,company_name,first_name,last_name,type,address,contact_no,created_by,created_on) 
				select email,company_name,first_name,last_name,type,address,contact_no,".$user_token['user_id'].",".time()." from {$account_db}.occupant_reg where id=?";
			$sth = $db->prepare($sql);	
			$sth->execute([ $id ]);

			$subject = "Password Setup From Inventi";
			$body = "<p>Greeting! Your registration has been approved. Click on the link below to enter your password.</p>
				<p><a href='http://portali2.sandbox.inventiproptech.com/password-setup.php?acctcode=".encryptData($accountcode)."&email={$email}'>View Link</a><p>
				<p>To log into your account <a href='http://portali2.sandbox.inventiproptech.com/?acctcode=".encryptData($accountcode)."'><u>click here</u></a></p>";
		} else {
			$subject = "Registration Status Update from Inventi";
			$body = "<p>Sorry your registration has been denied.  Please contact our admin for assistance.</p>";
		}

		// SEND EMAIL
		$mailer = new Mailer([ 'debug'=>0 ]);
		$sent = $mailer->send([
			'subject' => $subject,
			'body'=> $body,
			'recipients' => [$email]
		]);	

	// CONTRACT **********************************************************************			
	} elseif ($table=="contract") {
		// GET RESIDENT FROM CONTRACT
		$sth = $db->prepare("select resident_id from {$account_db}.contract where id=?");
		$sth->execute([ $id ]);		
		$resident_id = $sth->fetch()['resident_id'];
		// RESET UNIT ID TO ZERO IN RESIDENT
		$sth = $db->prepare("update {$account_db}.resident set unit_id=0 where id=?");
		$sth->execute([ $resident_id ]);		

	}


	$return_value = ['success'=>1,'description'=>'Status updated.','tmp'=>$id];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);