<?php
$return_value = [];
try{
	$reservation_id = decryptData($data['reservation_id']);
	$records = $db->prepare("select * from {$account_db}.view_amenity_reservations where id=?");
	
	$records->execute([$reservation_id]);
	
	$return_value = $records->fetch();
	$return_value['reservation_id'] = $return_value['id'];
	$return_value['id'] = encryptData($return_value['id']);
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);