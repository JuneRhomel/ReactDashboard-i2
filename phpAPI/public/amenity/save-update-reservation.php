<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$data['created_by'] = $user_id;
	$data['created_on'] = time();

	$data['amenity_reservation_id'] = decryptData($data['reservation_id']);
	unset($data['reservation_id']);

	$fields = array_keys($data);
	$sth = $db->prepare("insert {$account_db}.amenity_reservations_updates (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
	$sth->execute($data);

	//update ticket
	$sth = $db->prepare("update  {$account_db}.amenity_reservations set status=? where id=?");
	$sth->execute([$data['status'],$data['amenity_reservation_id']]);

	$sth = $db->prepare("select * from {$account_db}.amenity_reservations where id=?");
	$sth->execute([$data['amenity_reservation_id']]);
	$reservation = $sth->fetch();

	//notify tenant
	$sth = $db->prepare("insert into {$account_db}.notifications set created_on=?,title=?,content=?,tenant_id=?");
	$sth->execute([
		time(),
		"Amenity Reservation Request - {$data['status']}",
		"{$data['description']}",
		$reservation['tenant_id']
	]);



	$return_value = ['success'=>1,'description'=>'Update saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);