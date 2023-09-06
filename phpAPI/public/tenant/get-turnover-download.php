<?php
$return_value = [];
try{
	$records = $db->prepare("select turnover_id,tenant_name,location_name,status,from_unixtime(created_on) as created_date from {$account_db}.view_tenant_turnovers");
	$records->execute();
	
	$return_value = $records->fetchAll();
	
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);