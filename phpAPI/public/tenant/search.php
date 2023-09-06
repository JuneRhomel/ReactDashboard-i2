<?php
$return_value = [];
try{
	$term = $data['term'];
	$sth = $db->prepare("select id as value,tenant_name as label from {$account_db}.tenants where tenant_name like ?");
	$sth->execute(["%" . $term . "%"]);
	$return_value = $sth->fetchAll();
}catch(Exception $e){
	$return_value = [];
}

echo json_encode($return_value);