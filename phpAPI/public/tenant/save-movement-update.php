<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$data['created_by'] = $user_id;
	$data['created_on'] = time();

	$data['movement_id'] = decryptData($data['movement_id']);

	$fields = array_keys($data);
	$sth = $db->prepare("insert {$account_db}.movement_updates (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
	$sth->execute($data);

	//update ticket
	$sth = $db->prepare("update  {$account_db}.moveinout set status=?,closed=? where id=?");
	$sth->execute([$data['status'],($data['status']=='Closed' ? 1 : 0),$data['movement_id']]);

	if($data['status'] == 'Closed')
	{
		//get movement request
		$sth = $db->prepare("select * from {$account_db}.moveinout where id=?");
		$sth->execute([$data['movement_id']]);
		$movement = $sth->fetch();

		if($movement['move_type'] == 'Move In')
			$location_status = 'Occupied';
		else
			$location_status = 'Vacant';

		$sth = $db->prepare("update {$account_db}.locations set location_status='{$location_status}' where id=?");
		$sth->execute([$movement['location_id']]);
	}

	$return_value = ['success'=>1,'description'=>'Update saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);