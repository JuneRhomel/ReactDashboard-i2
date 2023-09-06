<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$sr_id = decryptData($data['srid']);
	$sth = $db->prepare("select servicerequest_updates.*,_users.first_name,_users.last_name from {$account_db}.servicerequest_updates left join {$account_db}._users on _users.id=servicerequest_updates.created_by where sr_id=? order by servicerequest_updates.id desc");
	$sth->execute([$sr_id]);
	$return_value =  $sth->fetchAll();

	//get 
	$sth = $db->prepare("select * from {$account_db}.servicerequests where id=?");
	$sth->execute([$sr_id]);
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