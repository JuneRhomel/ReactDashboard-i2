<?php
$return_value = ['success'=>1,'description'=>'Payment saved.'];
try{
	$data['billing_id'] = decryptData($data['billing_id']);

	$data['created_on'] = time();
	$data['created_by'] = $user_id;
	$sth = $db->prepare("insert into {$account_db}.billing_payments (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));

	//update billing details
	$sth = $db->prepare("update {$account_db}.billings set payment=payment + ? where id=?");
	$sth->execute([
		$data['amount'],
		$data['billing_id']
	]);

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);