<?php
$return_value = ['success'=>1,'description'=>'Visitor updated!'];
try{
	$visitor_id = decryptData($data['visitor_id']);
	$status = $data['status'];

	$sth = $db->prepare("select * from {$account_db}.visitors where id=?");
	$sth->execute([$visitor_id]);
	$visitor = $sth->fetch();

	$cancel_reason = $data['cancel_reason'] ?? '';

	$sth = $db->prepare("update {$account_db}.visitors set status=?,cancel_reason=? where id=?");
	$sth->execute([$status,$cancel_reason,$visitor_id]);

	//notify tenant
	$sth = $db->prepare("insert into {$account_db}.notifications set created_on=?,title=?,content=?,tenant_id=?");
	$sth->execute([
		time(),
		"Visitor Registration - {$status}",
		"Your visitor {$visitor['visitor_name']} has {$status}. {$cancel_reason}",
		$visitor['tenant_id']
	]);

	$return_value = ['success'=>1,'description'=>"Visitor updated as {$status}"];

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);