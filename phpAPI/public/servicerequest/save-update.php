<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$data['created_by'] = $user_id;;
	$data['created_on'] = time();

	$data['sr_id'] = decryptData($data['sr_id']);

	$fields = array_keys($data);
	$sth = $db->prepare("insert {$account_db}.servicerequest_updates (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
	$sth->execute($data);

	//update ticket
	$sth = $db->prepare("update {$account_db}.servicerequests set status=? where id=?");
	$sth->execute([$data['status'],$data['sr_id']]);


	$sth = $db->prepare("select * from {$account_db}.servicerequests where id=?");
	$sth->execute([$data['sr_id']]);
	$sr = $sth->fetch();

	//notify tenant
	$sth = $db->prepare("insert into {$account_db}.notifications set created_on=?,title=?,content=?,tenant_id=?");
	$sth->execute([
		time(),
		"Service Request - {$data['status']}",
		"{$data['description']}",
		$sr['tenant_id']
	]);

	$return_value = ['success'=>1,'description'=>'Update saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);