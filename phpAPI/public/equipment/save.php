<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	
	$data['created_by'] = $user_token['user_id'];
	$data['created_on'] = time();

	// $sth = $db->prepare("insert {$account_db}.equipment(" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
	$sth = $db->prepare("insert into {$account_db}.equipments (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
	$sth->execute($data);

	$return_value = ['success'=>1,'description'=>'Equipment saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);