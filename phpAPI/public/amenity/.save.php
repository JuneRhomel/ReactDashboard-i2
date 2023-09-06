<?php
$return_value = ['success'=>1,'description'=>'Amenity saved.'];
try{
	$id = isset($data['id']) ? decryptData($data['id']) : 0;
	unset($data['id']);

	if(!$id)
	{
		$data['created_on'] = time();
		$data['created_by'] = $user_id;
	}
	
	if(is_array($data['main_image']) && $data['main_image']['filename'] && $data['main_image']['data'])
	{
		//write to file
		$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/amenity";
		if(!is_dir($upload_dir))
		{
			mkdir($upload_dir,0777,true);
		}
		$content = base64_decode($data['main_image']['data']);
		$diskname = uniqueFilename($data['main_image']['filename']);
		file_put_contents($upload_dir . "/" . $diskname, $content);
		$data['picture_url'] = WEB_ROOT . "/uploads/{$accountcode}/amenity/{$diskname}"; 
	}

	unset($data['main_image']);
	
	if($id)
	{
		$update_values = [];
		foreach(array_keys($data) as $field)
			$update_values[] = "{$field}=?";

		$sth = $db->prepare("update {$account_db}.amenities set " . implode(",",$update_values) . " where id=?");
		$data['id'] = $id;
	}
	else
		$sth = $db->prepare("insert into {$account_db}.amenities (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");

	$sth->execute(array_values($data));
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);