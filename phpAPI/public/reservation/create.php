<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$data['name'] = $user_id;
	$data['created_by'] = $user_id;
	$data['created_on'] = time();
	$data['sr_type']='reservation';
		
	$sth = $db->prepare("insert into {$account_db}.reservation (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'query'=>"insert into {$account_db}.reservation (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")"];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);