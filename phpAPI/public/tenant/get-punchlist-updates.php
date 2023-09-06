<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$punchlist_id = decryptData($data['punchlist_id']);
	$sth = $db->prepare("select punchlist_updates.*,_users.first_name,_users.last_name from {$account_db}.punchlist_updates left join {$account_db}._users on _users.id=punchlist_updates.created_by where punchlist_id=?  order by punchlist_updates.id desc");
	$sth->execute([$punchlist_id]);
	$return_value =  $sth->fetchAll();

	//get 
	$sth = $db->prepare("select * from {$account_db}.punchlists where id=?");
	$sth->execute([$punchlist_id]);
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

		// 22-0922 ATR: GET ATTACHMENTS
		$attachments = $db->prepare("select attachment_url,filename from {$account_db}.attachments where reference_table='punchlistupdate' and reference_id=:reference_id");
		$attachments->execute(['reference_id'=>$value['id']]);
		$return_value[$index]['attachments'] = $attachments->fetchAll();
	}
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);