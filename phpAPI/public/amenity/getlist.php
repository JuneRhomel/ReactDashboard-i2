<?php
$return_value = [];
try{
	$location_id = $data['location_id'] ?? 0;
	if($location_id)
		$records = $db->prepare("select amenities.*,locations.location_name from {$account_db}.amenities,{$account_db}.locations where location_id=? and amenities.location_id=locations.id");
	else
		$records = $db->prepare("select amenities.*,locations.location_name from {$account_db}.amenities,{$account_db}.locations where amenities.location_id=locations.id");
	
	$records->execute([$location_id]);
	
	$return_value = $records->fetchAll();
}catch(Exception $e){
	$return_value[$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);