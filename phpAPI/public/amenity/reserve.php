<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$reservation = [
		'tenant_id' => $user_id,
		'description' => $data['description'],
		'created_on' => time(),
		'status' => 'Pending',
		'amenity_id' => $data['amenity_id'],
		'reserved_from' => strtotime($data['reserved_from']),
		'reserved_to' => strtotime($data['reserved_to']),
		'email' => $data['email'],
		'mobile' => $data['mobile']
	];

	$sth = $db->prepare("insert into {$account_db}.amenity_reservations (" . implode(",",array_keys($reservation)) . ") values(?" . str_repeat(",?",count(array_keys($reservation))-1) .")");
	$sth->execute(array_values($reservation));
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);