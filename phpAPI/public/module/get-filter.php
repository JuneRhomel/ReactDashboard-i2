<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	//$return_value = $db->getFilter("{$account_db}.{$data['table']}",$data['field']);
	$return_value = $db->getFilter("{$account_db}.tenants","tenant_type");
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);