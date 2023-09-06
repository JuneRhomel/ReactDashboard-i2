<?php
$return_value = ['success'=>1,'description'=>''];
try{
	
	$id = $data['id'] ?? 0;
	unset($data['id']);

	$data['created_on'] = time();
	$data['created_by'] = $user_id;
		
	$sth = $db->prepare("insert into {$account_db}.pdcs (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);