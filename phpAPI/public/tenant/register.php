<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$data['owner_id'] = $user_id;

	if(is_array($data['photo_id']) && $data['photo_id']['filename'] && $data['photo_id']['data'])
	{
		//write to file
		$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/tenant/";
		if(!is_dir($upload_dir))
		{
			mkdir($upload_dir,0777,true);
		}
		$content = base64_decode($data['photo_id']['data']);
		$diskname = uniqueFilename($data['photo_id']['filename']);
		file_put_contents($upload_dir . "/" . $diskname, $content);
		$data['id_url'] = WEB_ROOT . "/uploads/{$accountcode}/tenant/{$diskname}"; 
	}

	if(is_array($data['contract_file']) && $data['contract_file']['filename'] && $data['contract_file']['data'])
	{
		//write to file
		$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/tenant/";
		if(!is_dir($upload_dir))
		{
			mkdir($upload_dir,0777,true);
		}
		$content = base64_decode($data['contract_file']['data']);
		$diskname = uniqueFilename($data['contract_file']['filename']);
		file_put_contents($upload_dir . "/" . $diskname, $content);
		$data['contract_url'] = WEB_ROOT . "/uploads/{$accountcode}/tenant/{$diskname}"; 
	}

	unset($data['photo_id']);
	unset($data['contract_file']);
	$data['created_on'] = time();

	$sth = $db->prepare("insert into {$account_db}.tenant_registrations (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'query'=>"insert into {$account_db}.gatepasses (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")"];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);