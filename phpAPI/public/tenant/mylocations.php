<?php
$locations = [];
try{
	//get locations
	$sth = $db->prepare("select tenant_locations.location_id,locations.location_name,tenant_locations.is_default from {$account_db}.tenant_locations,{$account_db}.locations where tenant_locations.tenant_id=:tenant_id and  locations.id = tenant_locations.location_id");
	$sth->execute(['tenant_id'=>$user_id]);
	$locations = $sth->fetchAll();
}catch(Exception $e){
	$locations = [];
}

echo json_encode($locations,JSON_NUMERIC_CHECK);