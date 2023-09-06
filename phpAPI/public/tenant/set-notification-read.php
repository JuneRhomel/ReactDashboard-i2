<?php
$return_value = ['success'=>1,'data'=>'Notification marked as read'];
try{
	$id = decryptData($data['id'] ?? encryptData(0));

	$sth = $db->prepare("update {$account_db}.notifications set read_on=if(read_on = 0,unix_timestamp(),read_on) where id=?");
	$sth->execute([$id]);
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);