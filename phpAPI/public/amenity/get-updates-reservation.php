<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$res_id = decryptData($data['reservation_id']);
	$sth = $db->prepare("select amenity_reservations_updates.*,_users.first_name,_users.last_name from {$account_db}.amenity_reservations_updates left join {$account_db}._users on _users.id=amenity_reservations_updates.created_by where amenity_reservation_id=?  order by amenity_reservations_updates.id desc");
	$sth->execute([$res_id]);
	$return_value =  $sth->fetchAll();

	$sth = $db->prepare("select * from {$account_db}.amenity_reservations where id=?");
	$sth->execute([$res_id]);
	$request = $sth->fetch();
	foreach($return_value as $index=>$value)
	{
		if($value['first_name'] == '')
		{
			$sth = $db->prepare("select * from  {$account_db}.tenants where id=?");
			$sth->execute([$request['tenant_id']]);
			$tenant = $sth->fetch();
			$return_value[$index]['first_name'] = $tenant['tenant_name'];
		}
	}
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);