<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$data['created_by'] = 0;
	$data['created_on'] = time();

	$data['punchlist_id'] = decryptData($data['sr_id']);
	unset($data['sr_id']);

	$fields = array_keys($data);
	$sth = $db->prepare("insert {$account_db}.punchlist_updates (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
	$sth->execute($data);

	//update ticket
	$sth = $db->prepare("update  {$account_db}.punchlists set status=? where id=?");
	$sth->execute([$data['status'],$data['punchlist_id']]);

	$return_value = ['success'=>1,'description'=>'Update saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);