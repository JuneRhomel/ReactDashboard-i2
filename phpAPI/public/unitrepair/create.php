<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$data['requestor_name'] = $user_id;
	$data['created_by'] = $user_id;
	$data['created_on'] = time();
	$data['sr_type']='unit-repair';
	$data['request_type']='New';
	//files
	$attachments = $data['receipt'];
	unset($data['receipt']);

	$sth = $db->prepare("insert into {$account_db}.unit_repair (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
	$id = $db->lastInsertId(); 


	//if has attachments
	if(is_array($attachments))
	{
		foreach($attachments as $attachment)
		{
			//write to file
			$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/unit-repair/";
			if(!is_dir($upload_dir))
			{
				mkdir($upload_dir,0777,true);
			}
			$content = base64_decode($attachment['data']);
			$diskname = uniqueFilename($attachment['filename']);
			file_put_contents($upload_dir . "/" . $diskname, $content);
			$attachments_data = [
				'attachment_url'=>WEB_ROOT . "/uploads/{$accountcode}/unit-repair/{$diskname}",
				'filename' => $attachment['filename'],
				'diskname' => $diskname,
				'reference_table' => 'unit-repair',
				'created_by' => $user_id,
				'reference_id' => $id,
				'created_on' => time()
			]; 

			$sth = $db->prepare("insert into {$account_db}.attachments (" . implode(",",array_keys($attachments_data)) . ") values(?" . str_repeat(",?",count(array_keys($attachments_data))-1) .")");
			$sth->execute(array_values($attachments_data));
		}
	}	
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'query'=>"insert into {$account_db}.unit_repair (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")"];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);