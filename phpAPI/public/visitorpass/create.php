<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$data['name'] = $user_id;
	$data['created_by'] = $user_id;
	$data['created_on'] = time();
	$data['sr_type']='visitor-pass';
	$guest_name=$data['guest_name'];
	$guest_num=$data['guest_num'];
	$guest_add=$data['guest_add'];
	unset($data['guest_name']);
	unset($data['guest_num']);
	unset($data['guest_add']);
	
	// if(is_array($data['receipt']) && $data['receipt']['filename'] && $data['receipt']['data'])
	// {
	// 	//write to file
	// 	$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/gatepass/";
	// 	if(!is_dir($upload_dir))
	// 	{
	// 		mkdir($upload_dir,0777,true);
	// 	}
	// 	$content = base64_decode($data['receipt']['data']);
	// 	$diskname = uniqueFilename($data['receipt']['filename']);
	// 	file_put_contents($upload_dir . "/" . $diskname, $content);
	// 	$data['receipt_url'] = WEB_ROOT . "/uploads/{$accountcode}/gatepass/{$diskname}"; 
	// }

	// unset($data['receipt']);
		
	$sth = $db->prepare("insert into {$account_db}.visitor_pass (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
	$id = $db->lastInsertId(); 

	foreach ($guest_name as $i=>$row) {
		$item['vp_id'] = $id;
		$item['created_by'] = $user_id;
		$item['created_on'] = time();
		$item['guest_name'] = $guest_name[$i];
		$item['guest_num'] = $guest_num[$i];
		$item['guest_add'] = $guest_add[$i];

		$fields = array_keys($item);
		$sth = $db->prepare("insert {$account_db}.vp_guest (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
		$sth->execute($item);
	}
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'query'=>"insert into {$account_db}.visitor_pass (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")"];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);