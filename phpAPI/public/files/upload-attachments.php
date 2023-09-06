<?php 
$return_value = ['success'=>1,'data'=>[]];
try{
    $data['created_by'] = $user_id = $user_token['user_id'];
    $data['created_on'] = time();
    $module = $data['reference_table'];
    $refeence_id = decryptData($data['reference_id']);
    $attachments = $data['attachments'];
    $description = $data['description'];
	unset($data['attachments']);

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
                'created_by' => $user_id,
                'reference_id' => $refeence_id,
                'created_on' => time(),
                'description' => $description
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