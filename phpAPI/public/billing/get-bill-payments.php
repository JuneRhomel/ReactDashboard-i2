<?php
$return_value = [];
try{
	$billing_id = decryptData($data['billingid']);
	$sth = $db->prepare("select b.* from {$account_db}.billings a left join {$account_db}.billing_payments b on b.billing_id=a.id where a.id=?");
	$sth->execute([$billing_id]);
	$return_value = $sth->fetchAll();

	foreach($return_value as $index=>$record)
	{
		$return_value[$index]['id'] = encryptData($record['id']);
		$return_value[$index]['billing_id'] = encryptData($record['billing_id']);
	}
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value);