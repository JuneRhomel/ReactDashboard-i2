<?php
$return_value = [];
try{
	$movement_id = decryptData($data['movement_id']);
	$records = $db->prepare("select * from {$account_db}.view_tenant_movements where id=?");
	
	$records->execute([$movement_id]);
	
	$return_value = $records->fetch();
	$return_value['movement_id'] = $return_value['id'];
	$return_value['id'] = encryptData($return_value['id']);
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);