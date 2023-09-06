<?php
$return_value = ['success'=>1,'description'=>''];
try{
	// $data['created_on'] = time();
	// $data['created_by'] = $user_id;

	if(is_array($data['picture']) && $data['picture']['filename'] && $data['picture']['data'])
	{
		$attachment = $data['picture'];
		unset($data['picture']);

		//write to file
		$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/tenant/";
		if(!is_dir($upload_dir))
		{
			mkdir($upload_dir,0777,true);
		}
		$content = base64_decode($attachment['data']);
		$diskname = uniqueFilename($attachment['filename']);
		file_put_contents($upload_dir . "/" . $diskname, $content);
		$data['id_url'] = WEB_ROOT . "/uploads/{$accountcode}/tenant/{$diskname}"; 
	}

	$field_values = [];
		
	foreach($data as $key=>$value)
	{
		$field_values[] = "{$key}=:{$key}";
	}
	$sth = $db->prepare("update {$account_db}.tenants set " . implode(",",$field_values) . " where id = :id");
	$data['id'] = $user_id;
	$sth->execute($data);
	
		
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);	