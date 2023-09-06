<?php
$return_value = ['available' => false];
try{
	$amenity_id = $data['amenity_id'] ?? 0;
	$reserved_from = strtotime($data['reserved_from']);
	$reserved_to = strtotime($data['reserved_to']);

	$records = $db->prepare("select * from {$account_db}.amenity_reservations where amenity_id=? and ((reserved_from <= ? and reserved_to >= ?) or (reserved_from <= ? and reserved_to >= ?))");

	$records->execute([
		$amenity_id,
		$reserved_from,
		$reserved_from,
		$reserved_to,
		$reserved_to
	]);
	
	if($records->fetchAll())
		$return_value = ['available'=> false];
	else {
		$return_value = ['available'=> true];
	}
	
}catch(Exception $e){
	$return_value = ['available'=> false];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);