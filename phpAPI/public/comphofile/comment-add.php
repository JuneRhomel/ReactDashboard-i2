<?php
$result = ['success'=>0,'description'=>''];

try{
	$data['reference_id'] = decryptData($data['reference_id']);
	$data['created_by'] = $user_token['user_id'];

	$sth = $db->prepare("insert into {$account_db}.comments set " . implode("=?," , array_keys($data)) . "=?");
	$sth->execute(array_values($data));

	$result = ['success'=>1,'description'=>'Saved','data'=>$data];
}catch(Exception $e){
	$code = $e->getCode();
	switch($code)
	{
		case 23000:
			$message = "Duplicate entry!";
			break;
		default:
			$message = "Error saving record!";
	}

	$result['description'] = $message;
	$result['values']= $data;
}

echo json_encode($result);