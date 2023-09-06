<?php
$return_value = [];
try{
	$sth = $db->prepare("select b.*,from_unixtime(b.created_on) as payment_date from {$account_db}.billings a right join {$account_db}.billing_payments b on b.billing_id=a.id where a.deleted_on=0 and a.tenant_id=? order by id desc limit 0,2");
	$sth->execute([ $data['tenant_id'] ]);
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