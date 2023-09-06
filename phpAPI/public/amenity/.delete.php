<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$id = decryptData($data[0]);
	$sth = $db->prepare("update {$account_db}.amenities set deleted_by=:deleted_by,deleted_on=:deleted_on where id=:id");
	$sth->execute([ 'deleted_by'=>$user_token['user_id'],'deleted_on'=>time(),'id'=>$id ]);

	$return_value = ['success'=>1,'description'=>'Record deleted.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);