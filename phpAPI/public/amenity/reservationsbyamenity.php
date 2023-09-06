<?php
$return_value = [];
try{
	$amenity_id = $data['amenity_id'] ?? 0;
	$records = $db->prepare("select amenity_id,amenity_name,from_unixtime(reserved_from) reserved_from,from_unixtime(reserved_to) reserved_to,description,status,amenity_reservations.created_on from {$account_db}.amenity_reservations,{$account_db}.amenities where amenity_id=? and amenity_reservations.reserved_to > unix_timestamp()");

	$records->execute([$amenity_id]);
	
	$return_value = $records->fetchAll();
}catch(Exception $e){
	$return_value[$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);