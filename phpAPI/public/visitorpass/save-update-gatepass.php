<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$data['created_by'] = $user_id;
	$data['created_on'] = time();

	$data['gatepass_id'] = decryptData($data['gatepass_id']);

	$fields = array_keys($data);
	$sth = $db->prepare("insert {$account_db}.gatepass_updates (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
	$sth->execute($data);

	//update ticket
	$sth = $db->prepare("update {$account_db}.gatepasses set status=? where id=?");
	$sth->execute([$data['status'],$data['gatepass_id']]);


	//gatepass
	$sth = $db->prepare("select * from {$account_db}.gatepasses where id=?");
	$sth->execute([$data['gatepass_id']]);
	$gatepass = $sth->fetch();

	//notify tenant
	$sth = $db->prepare("insert into {$account_db}.notifications set created_on=?,title=?,content=?,tenant_id=?");
	$sth->execute([
		time(),
		"Gate Pass - {$data['status']}",
		"Your gate pass has been {$data['status']}.",
		$gatepass['tenant_id']
	]);

	$return_value = ['success'=>1,'description'=>'Update saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);