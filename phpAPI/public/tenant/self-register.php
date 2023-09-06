<?php
$return_value = ['success'=>1,'description'=>''];
try{
	//$data['owner_id'] = $user_id;

	// if(is_array($data['photo_id']) && $data['photo_id']['filename'] && $data['photo_id']['data'])
	// {
	// 	//write to file
	// 	$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/tenant/";
	// 	if(!is_dir($upload_dir))
	// 	{
	// 		mkdir($upload_dir,0777,true);
	// 	}
	// 	$content = base64_decode($data['photo_id']['data']);
	// 	$diskname = uniqueFilename($data['photo_id']['filename']);
	// 	file_put_contents($upload_dir . "/" . $diskname, $content);
	// 	$data['id_url'] = WEB_ROOT . "/uploads/{$accountcode}/tenant/{$diskname}"; 
	// }

	// unset($data['photo_id']);
	$data['created_on'] = time();
	$data['status'] = 'registered';

	if($data['password'] != $data['password2'])
		throw new Exception("Password does not matched!");
	unset($data['password2']);
	$data['password'] = md5($data['password']);

	$sth = $db->prepare("insert into {$account_db}.tenant (".implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);	