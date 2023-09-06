<?php
$return_value = [];
try{
	$amenity_id = decryptData($data['amenity_id']);
	$records = $db->prepare("select * from {$account_db}.view_amenities where id=?");
	
	$records->execute([$amenity_id]);
	
	$return_value = $records->fetch();
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);