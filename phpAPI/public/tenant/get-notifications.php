<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$unread = $data['unread'] ?? 0;

	if($unread)
		$sth = $db->prepare("select id,created_on,title,content,if(read_on > 0,'Yes','No') as notif_read from {$account_db}.notifications where read_on=0 and tenant_id=? order by id desc");
	else
		$sth = $db->prepare("select id,created_on,title,content,if(read_on > 0,'Yes','No') as notif_read from {$account_db}.notifications where tenant_id=? order by id desc");

	$sth->execute([$user_id]);
	$return_value = $sth->fetchAll();
	
	foreach($return_value as $index=>$record)
	{
		$return_value[$index]['id'] = encryptData($record['id']);
	}

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);