<?php
$return_value = ['success'=>1,'description'=>'Amenity reservation updated!'];
try{
	$reservation_id = decryptData($data['reservation_id']);
	$status = $data['status'];

	$sth = $db->prepare("update {$account_db}.amenity_reservations set status=? where id=?");
	$sth->execute([$status,$reservation_id]);
	
	$return_value = ['success'=>1,'description'=>"Amenity reservation updated as {$status}"];

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);