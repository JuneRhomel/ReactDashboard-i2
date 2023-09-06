<?php
$return_value = [];
try{
	$records = $db->prepare("select amenity_reservations.id,amenity_id,
	amenity_name,reserved_from,
	reserved_to,description,status,amenity_reservations.created_on 
	from {$account_db}.amenity_reservations,{$account_db}.amenities 
	where amenity_reservations.amenity_id=amenities.id and tenant_id=?");

	$records->execute([$user_id]);

	$return_value = $records->fetchAll();

	foreach($return_value as $index=>$record)
	{
		$return_value[$index]['schedule'] = date('M d, Y h:i a',$record['reserved_from']) . ' to ' . (date('Y-m-d',$record['reserved_from']) == date('Y-m-d',$record['reserved_to']) ?  date('h:i a',$record['reserved_to']) :  date('M d, Y h:i a',$record['reserved_to']));
		$return_value[$index]['id'] = encryptData($record['id']);
		$return_value[$index]['reservation_id'] = $record['id'];
	}
}catch(Exception $e){
	$return_value[$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);