<?php
$return_value = ['success'=>1,'description'=>[]];
try{
	$id = decryptData($data['billingid']);
	$amount = $data['amount'];
	
	$sth = $db->prepare("update {$account_db}.billings set payment=? where id=?");
	$sth->execute([$amount,$id]);

	$sth = $db->prepare("insert into {$account_db}.billing_payments set amount=?,billing_id=?,created_on=?");
	$sth->execute([$amount,$id,time()]);
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);