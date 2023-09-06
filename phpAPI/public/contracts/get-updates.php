<?php
$return_value = ['success'=>1,'data'=>[]];
try{

	$id = decryptData($data['id']);
	$sql = "select " . $data['table'] . ".*,_users.first_name,_users.last_name from {$account_db}." . $data['table'] . " left join {$account_db}._users on _users.id=" . $data['table'] . ".created_by where " . $data['identifier'] . "=? order by " . $data['table'] . ".id desc";
	$sth = $db->prepare($sql);
	$sth->execute([$id]);
	$return_value =  $sth->fetchAll();

	
	//get 
	// $sth = $db->prepare("select * from {$account_db}." . $data['table'] . " where id=?");
	// $sth->execute([$id]);
	// $request = $sth->fetch();
	// foreach($return_value as $index=>$value)
	// {
	// 	if($value['first_name'] == '')
	// 	{
	// 		$sth = $db->prepare("select * from  {$account_db}.tenants where id=?");
	// 		$sth->execute([$request['tenant_id']]);
	// 		$tenant = $sth->fetch();
	// 		$return_value[$index]['first_name'] = $tenant['tenant_name'];
	// 	}
	// }
    
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);