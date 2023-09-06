<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$id = 0;
	if($data['id'])
		$id = decryptData($data['id']);

	unset($data['id']);
	$location_id = $data['location_id'];  unset($data['location_id']);

	if ($id){
		$fields = [];
		foreach( array_keys($data) as $field)
		{
			$fields[] = "{$field}=:{$field}";
		}
		$sth = $db->prepare("update {$account_db}.tenants set " . implode(",",$fields). " where id={$id}");
		$sth->execute($data);
	} else {
		$data['created_by'] = $user_token['user_id'];
		$data['created_on'] = time();

		$fields = array_keys($data);
		$sth = $db->prepare("insert {$account_db}.tenants (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
		$sth->execute($data);
		$id = $db->lastInsertId(); 
	}

	// CHECKING IF TENANT LOCATION EXIST
	$sth = $db->prepare("select id from {$account_db}.tenant_locations where tenant_id=:tenant_id and location_id=:location_id");
	$sth->execute([
		"tenant_id"=>$id,
		"location_id"=>$location_id
	]);
	$records = $sth->fetch();
	if ($records) {
		// UPDATE TENANT LOCATION
		$sth = $db->prepare("update {$account_db}.tenant_locations set location_id=:location_id where tenant_id=:tenant_id");
		$sth->execute([
			"tenant_id"=>$id,
			"location_id"=>$location_id
		]);
	} else {
		//  SAVE TENANT LOCATION
		$sth = $db->prepare("insert {$account_db}.tenant_locations set tenant_id=:tenant_id, location_id=:location_id, is_default=1");
		$sth->execute([
			"tenant_id"=>$id,
			"location_id"=>$location_id
		]);
	}

	$return_value = ['success'=>1,'description'=>'Resident saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);