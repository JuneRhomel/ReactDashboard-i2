<?php
$return_value = [];
try{
	$records = $db->prepare("select billing_payments.* from {$account_db}.billings,{$account_db}.billing_payments where tenant_id=? and billing_payments.billing_id=billings.id");
	$records->execute([$user_id]);
	$return_value = $records->fetchAll();

	foreach($return_value as $index=>$record)
	{
		$return_value[$index]['id'] = encryptData($record['id']);
		$return_value[$index]['billing_id'] = encryptData($record['billing_id']);
	}
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);