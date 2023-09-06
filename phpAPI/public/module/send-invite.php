<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$email = $data['email'];

	// CHECK IF EMAIL EXIST IN OCCUPANT TABLE
	$sth = $db->prepare("select * from {$account_db}.resident where email=? and deleted_on=0");
	$sth->execute([ $email ]);
	$record = $sth->fetch();

	if ($record) {
		$return_value = ['success'=>0,'description'=>'Email already exist.'];
	} else {
		// GET BUILDING INFO
		$sth = $db->prepare("select * from {$account_db}.location where id=1");
		$sth->execute();
		$building = $sth->fetch();

		// INIT BODY CONTENT
		$body = "<p>We're sending an invite for you to register as occupant in {$building['location_name']}.</p>
			<p>Please fill out the registration form with your details and give us some time to review your registration. You will receive an email within 24 hours for the next steps.</p>
			<p>For questions, please don't hesitate to contact us.</p>
			<p><a href='http://portali2.sandbox.inventiproptech.com/register.php?acctcode=".encryptData($accountcode)."&email={$email}'>View Link<p>";

		// SEND EMAIL
		$mailer = new Mailer([ 'debug'=>0 ]);
		$sent = $mailer->send([
			'subject' => 'Registration Invite From Inventi',
			'body'=> $body,
			'recipients' => [$email]
		]);	

		$return_value = ['success'=>1,'description'=>"Invite sent to $email"];
	}
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);