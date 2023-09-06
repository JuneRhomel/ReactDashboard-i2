<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$data['tenant_id'] = $user_id;
	$data['created_on'] = time();
	$data['created_by'] = $user_id;
	
	if(is_array($data['file']) && $data['file']['filename'] && $data['file']['data'])
	{
		//write to file
		$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/form";
		if(!is_dir($upload_dir))
		{
			mkdir($upload_dir,0777,true);
		}
		$content = base64_decode($data['file']['data']);
		$diskname = uniqueFilename($data['file']['filename']);
		file_put_contents($upload_dir . "/" . $diskname, $content);
		$data['file_url'] = WEB_ROOT . "/uploads/{$accountcode}/form/{$diskname}"; 
	}

	unset($data['file']);
	$data['form_id'] = decryptData($data['form_id']);
	$sth = $db->prepare("insert into {$account_db}.form_uploads (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);