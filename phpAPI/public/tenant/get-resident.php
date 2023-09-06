<?php
$return_value = [];
try{
	$id = decryptData($data['id']);
	$records = $db->prepare("select * from {$account_db}.tenants where id=?");
	$records->execute([$id]);
	
	$return_value = $records->fetch();
	$return_value['tenant_id'] = $return_value['id'];
	$return_value['id'] = encryptData($return_value['id']);
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);