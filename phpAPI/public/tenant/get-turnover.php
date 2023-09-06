<?php
$return_value = [];
try{
	$turnover_id = decryptData($data['turnover_id']);
	$records = $db->prepare("select turnover_id,tenant_name,location_name,status,from_unixtime(created_on) as created_date from {$account_db}.view_tenant_turnovers where id=?");
	$records->execute([$turnover_id]);
	
	$return_value = $records->fetch();
	$return_value['turnover_id'] = $return_value['id'];
	$return_value['id'] = encryptData($return_value['id']);
	$return_value['enc_tenant_id'] = encryptData($return_value['tenant_id']);
	$return_value['enc_loc_id'] = encryptData($return_value['location_id']);
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);