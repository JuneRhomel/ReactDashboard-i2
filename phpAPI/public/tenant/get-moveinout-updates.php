<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$movement_id = decryptData($data['movement_id']);
	$sth = $db->prepare("select movement_updates.*,_users.first_name,_users.last_name from {$account_db}.movement_updates left join {$account_db}._users on _users.id=movement_updates.created_by  where movement_id=? order by movement_updates.id desc");
	$sth->execute([$movement_id]);
	$return_value =  $sth->fetchAll();

	//get 
	$sth = $db->prepare("select * from {$account_db}.moveinout where id=?");
	$sth->execute([$movement_id]);
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