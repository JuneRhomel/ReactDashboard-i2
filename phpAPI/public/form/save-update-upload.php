<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$data['created_by'] = $user_id;
	$data['created_on'] = time();

	$data['form_upload_id'] = decryptData($data['form_upload_id']);

	$fields = array_keys($data);
	$sth = $db->prepare("insert {$account_db}.form_uploads_updates (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
	$sth->execute($data);

	//update ticket
	$sth = $db->prepare("update {$account_db}.form_uploads set status=? where id=?");
	$sth->execute([$data['status'],$data['form_upload_id']]);


	//form_uploads
	// $sth = $db->prepare("select * from {$account_db}.form_uploads where id=?");
	// $sth->execute([$data['form_upload_id']]);
	// $form_uploads = $sth->fetch();

	// //notify tenant
	// $sth = $db->prepare("insert into {$account_db}.notifications set created_on=?,title=?,content=?,tenant_id=?");
	// $sth->execute([
	// 	time(),
	// 	"Sumo - {$data['status']}",
	// 	"Your gate pass has been {$data['status']}.",
	// 	$form_uploads['tenant_id']
	// ]);

	$return_value = ['success'=>1,'description'=>'Update saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);