<?php
$return_value = ['success'=>1,'description'=>''];
try{

	$data['created_by'] = $user_token['user_id'];
	$data['created_on'] = time();

	$fields = array_keys($data);
	$sql_test =  $sql = "insert {$account_db}.recently_access (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
	$sth = $db->prepare($sql);
	$sth->execute($data);

	$return_value = ['success'=>1,'description'=>'Record saved.', 'id' =>  encryptData($id), 'data'=>$data];
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);