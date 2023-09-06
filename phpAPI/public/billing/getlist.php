<?php
$return_value = [];
try{
	$records = $db->prepare("select bills.*,soa.remaining_balance,soa.amount_due,soa.due_date,soa.due_month from {$account_db}.bills 
						LEFT JOIN {$account_db}.soa ON soa.bill_id=bills.id
						where bills.billed='billed' and bills.tenant_id=? order by bills.created_on desc");
	$records->execute([$user_id]);
	$return_value = $records->fetchAll();

	foreach($return_value as $index=>$record)
	{
		$return_value[$index]['id'] = encryptData($record['id']);
	}
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);