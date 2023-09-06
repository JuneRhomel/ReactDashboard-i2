<?php
$return_value = ['success'=>1,'description'=>''];
try{
	//check if there's an existing movein
	$sth = $db->prepare("select * from {$account_db}.moveinout where tenant_id=? and location_id=? and closed=0 and move_type=?");
	$sth->execute([$data['tenant_id'],$data['location_id'],$data['move_type']]);
	$check = $sth->fetch();

	if($check)
		throw new Exception("There's an existing {$data['move_type']} request.");

	$data['owner_id'] = $user_id;
	$data['created_on'] = time();

	$attachments_data = [];
	$attachments = $data['attachments'];
	unset($data['attachments']);

	$sth = $db->prepare("insert into {$account_db}.moveinout (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));

	$move_id = $db->lastInsertId();
	
	if(is_array($attachments))
	{
		foreach($data['attachments'] as $attachment)
		{
			//write to file
			$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/moveinout/";
			if(!is_dir($upload_dir))
			{
				mkdir($upload_dir,0777,true);
			}
			$content = base64_decode($attachment['data']);
			$diskname = uniqueFilename($attachment['filename']);
			file_put_contents($upload_dir . "/" . $diskname, $content);
			$attachments_data[] = [
				'attachment_url'=>WEB_ROOT . "/uploads/{$accountcode}/moveinout/{$diskname}",
				'filename' => $attachment['filename'],
				'diskname' => $diskname,
				'reference_table' => 'moveinout',
				'reference_id' => $move_id,
				'created_on' => time()
			]; 
		
			$sth = $db->prepare("insert into {$account_db}.attachments (" . implode(",",array_keys($attachments_data)) . ") values(?" . str_repeat(",?",count(array_keys($attachments_data))-1) .")");
			$sth->execute(array_values($attachments_data));
		}
	}


}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);