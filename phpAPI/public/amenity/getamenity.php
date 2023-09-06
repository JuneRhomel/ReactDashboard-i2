<?php
$return_value = [];
try{
	$amenity_id = $data['amenity_id'];
	$records = $db->prepare("select amenities.*,locations.location_name from {$account_db}.amenities,{$account_db}.locations where amenities.location_id=locations.id and amenities.id=?");
	
	$records->execute([$amenity_id]);
	
	$return_value = $records->fetch();
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);