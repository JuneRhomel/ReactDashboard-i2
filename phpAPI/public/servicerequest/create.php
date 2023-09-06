<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$data['tenant_id'] = $user_id;
	$data['created_on'] = time();

	$attachments = $data['attachments'];
	unset($data['attachments']);

	$sth = $db->prepare("insert into {$account_db}.servicerequests (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));

	$sr_id = $db->lastInsertId();
	
	if(is_array($attachments))
	{
		foreach($attachments as $attachment)
		{
			//write to file
			$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/servicerequests/";
			if(!is_dir($upload_dir))
			{
				mkdir($upload_dir,0777,true);
			}
			$content = base64_decode($attachment['data']);
			$diskname = uniqueFilename($attachment['filename']);
			file_put_contents($upload_dir . "/" . $diskname, $content);
			$attachments_data = [
				'attachment_url'=>WEB_ROOT . "/uploads/{$accountcode}/servicerequests/{$diskname}",
				'filename' => $attachment['filename'],
				'diskname' => $diskname,
				'reference_table' => 'servicerequests',
				'reference_id' => $sr_id,
				'created_on' => time()
			]; 
		
			$sth = $db->prepare("insert into {$account_db}.attachments (" . implode(",",array_keys($attachments_data)) . ") values(?" . str_repeat(",?",count(array_keys($attachments_data))-1) .")");
			$sth->execute(array_values($attachments_data));
		}
	}


}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'query'=>"insert into {$account_db}.gatepasses (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")"];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);