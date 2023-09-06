<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$data['tenant_id'] = $user_id;
	
	if(is_array($data['receipt']) && $data['receipt']['filename'] && $data['receipt']['data'])
	{
		//write to file
		$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/gatepass/";
		if(!is_dir($upload_dir))
		{
			mkdir($upload_dir,0664,true);
		}
		$content = base64_decode($data['receipt']['data']);
		$diskname = uniqueFilename($data['receipt']['filename']);
		file_put_contents($upload_dir . "/" . $data['receipt']['filename'], $content);
		$data['receipt_url'] = WEB_ROOT . "/uploads/{$accountcode}/gatepass/{$diskname}"; 
	}
	
	unset($data['receipt']);
		
	$sth = $db->prepare("insert into {$account_db}.gatepasses (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'query'=>"insert into {$account_db}.gatepasses (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")"];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);