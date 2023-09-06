<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$data['created_by'] = $user_id;
	$data['created_on'] = time();

	$data['punchlist_id'] = decryptData($data['punchlist_id']);

	$attachments = $data['attachments'];
	unset($data['attachments']);

	$fields = array_keys($data);
	$sth = $db->prepare("insert {$account_db}.punchlist_updates (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
	$sth->execute($data);
	$update_id = $db->lastInsertId();

	//update ticket
	$sth = $db->prepare("update {$account_db}.punchlists set status=?,closed=? where id=?");
	$sth->execute([$data['status'],($data['status'] == 'Closed' ? 1 : 0),$data['punchlist_id']]);

	$module = "punchlistupdate";
	if(is_array($attachments))
	{
		foreach($attachments as $attachment)
		{
			//write to file
			$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/{$module}/";
			if(!is_dir($upload_dir))
			{
				mkdir($upload_dir,0777,true);
			}
			$content = base64_decode($attachment['data']);
			$diskname = uniqueFilename($attachment['filename']);
			file_put_contents($upload_dir . "/" . $diskname, $content);
			$attachments_data = [
				'attachment_url'=>WEB_ROOT . "/uploads/{$accountcode}/{$module}/{$diskname}",
				'filename' => $attachment['filename'],
				'diskname' => $diskname,
				'reference_table' => $module,
				'reference_id' => $update_id,
				'created_on' => time()
			]; 
		
			$sth = $db->prepare("insert into {$account_db}.attachments (" . implode(",",array_keys($attachments_data)) . ") values(?" . str_repeat(",?",count(array_keys($attachments_data))-1) .")");
			$sth->execute(array_values($attachments_data));
		}
	}

	$return_value = ['success'=>1,'description'=>'Update saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);