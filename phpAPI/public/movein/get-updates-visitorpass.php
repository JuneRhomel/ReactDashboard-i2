<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$res_id = decryptData($data['gatepass_id'] ?? $data['gatepassid']);

	$sth = $db->prepare("select gatepass_updates.*,_users.first_name,_users.last_name from {$account_db}.gatepass_updates left join {$account_db}._users on _users.id=gatepass_updates.created_by where gatepass_id=?  order by gatepass_updates.id desc");
	$sth->execute([$res_id]);
	$return_value =  $sth->fetchAll();

	$sth = $db->prepare("select * from {$account_db}.gatepasses where id=?");
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