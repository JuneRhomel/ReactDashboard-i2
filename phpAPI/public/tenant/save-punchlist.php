<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$id = 0;
	if($data['id'])
		$id = decryptData($data['id']);

	unset($data['id']);

	$attachments = $data['attachments'];
	unset($data['attachments']);


	if($id)
	{
		$fields = [];
		foreach( array_keys($data) as $field)
		{
			$fields[] = "{$field}=:{$field}";
		}
		$sth = $db->prepare("update {$account_db}.punchlists set " . implode(",",$fields). " where id={$id}");
	}else{
		$data['created_by'] = $user_token['user_id'];
		$data['created_on'] = time();

		$fields = array_keys($data);
		$sth = $db->prepare("insert {$account_db}.punchlists(" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
	}
	$sth->execute($data);

	if(!$id)
		$id = $db->lastInsertId();

	if(is_array($attachments))
	{
		foreach($attachments as $attachment)
		{
			//write to file
			$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/punchlist/";
			if(!is_dir($upload_dir))
			{
				mkdir($upload_dir,0777,true);
			}
			$content = base64_decode($attachment['data']);
			$diskname = uniqueFilename($attachment['filename']);
			file_put_contents($upload_dir . "/" . $diskname, $content);
			$attachments_data = [
				'attachment_url'=>WEB_ROOT . "/uploads/{$accountcode}/punchlist/{$diskname}",
				'filename' => $attachment['filename'],
				'diskname' => $diskname,
				'reference_table' => 'punchlists',
				'reference_id' => $id,
				'created_on' => time()
			]; 
		
			$sth = $db->prepare("insert into {$account_db}.attachments (" . implode(",",array_keys($attachments_data)) . ") values(?" . str_repeat(",?",count(array_keys($attachments_data))-1) .")");
			$sth->execute(array_values($attachments_data));
		}
	}

	$return_value = ['success'=>1,'description'=>'Punch List saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);
