<?php
$result = ['success'=>0,'description'=>''];

try{
	$data['reference_id'] = decryptData($data['reference_id']);
	$data['created_by'] = $user_token['user_id'];
	$table = $data['reference_table'];
	$attachments = $data['attachments'];

	if(is_array($attachments)) {
		foreach($attachments as $attachment)
		{
			$upload_dir = DIR_ROOT . "/public/uploads/$accountcode/$table/photos/";
			if(!is_dir($upload_dir))
				mkdir($upload_dir,0777,true);

			$content = base64_decode($attachment['data']);
			$diskname = uniqueFilename($attachment['filename']);
			file_put_contents($upload_dir . "/" . $diskname, $content);

			$attachments_data = [
				'attachment_url'=> WEB_ROOT . "/uploads/$accountcode/$table/photos/$diskname",
				'filename' => $attachment['filename'],
				'diskname' => $diskname,
				'reference_table' => $data['reference_table'],
				'created_by' => $data['created_by'],
				'reference_id' => $data['reference_id'],
				'description' => $data['description']
			];
			$sth = $db->prepare("insert into {$account_db}.photos set " . implode("=?," , array_keys($attachments_data)) . "=?");
			$sth->execute(array_values($attachments_data));		
		}
	}

	$result = ['success'=>1,'description'=>'Saved','data'=>$attachments_data];
}catch(Exception $e){
	$code = $e->getCode();
	switch($code)
	{
		case 23000:
			$message = "Duplicate entry!";
			break;
		default:
			$message = "Error saving record!";
	}

	$result['description'] = $message;
	$result['values']= $data;
}

echo json_encode($result);