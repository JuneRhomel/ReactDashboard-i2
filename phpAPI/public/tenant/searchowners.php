<?php
$return_value = [];
try{
	$term = $data['term'];
	$sth = $db->prepare("select a.id as value, a.tenant_name as label, b.location_id from {$account_db}.tenants a left join {$account_db}.tenant_locations b on b.tenant_id=a.id where a.tenant_type='Owner' and a.tenant_name like ?");
	$sth->execute(["%" . $term . "%"]);
	$return_value = $sth->fetchAll();
}catch(Exception $e){
	$return_value = [];
}

echo json_encode($return_value);