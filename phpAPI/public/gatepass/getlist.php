<?php
$return_value = [];
try{
	$records = $db->prepare("select * from {$account_db}.gate_pass where name=?");
	$records->execute([$user_id]);
	$return_value = $records->fetchAll();

	foreach($return_value as $index=>$record)
	{
		$return_value[$index]['id'] = encryptData($record['id']);
	}
}catch(Exception $e){
	$return_value[$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);