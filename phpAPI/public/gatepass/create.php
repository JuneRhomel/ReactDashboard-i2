<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$data['name'] = $user_id;
	$data['created_by'] = $user_id;
	$data['created_on'] = time();
	$item_num=$data['item_num'];
	$item_name=$data['item_name'];
	$item_qty=$data['item_qty'];
	$description=$data['description'];
	unset($data['item_num']);
	unset($data['item_name']);
	unset($data['item_qty']);
	unset($data['description']);
	
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
		
	$sth = $db->prepare("insert into {$account_db}.gate_pass (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
	$id = $db->lastInsertId(); 

	foreach ($item_num as $i=>$row) {
		$item['gp_id'] = $id;
		$item['created_by'] = $user_id;
		$item['created_on'] = time();
		$item['item_num'] = $item_num[$i];
		$item['item_name'] = $item_name[$i];
		$item['item_qty'] = $item_qty[$i];
		$item['description'] = $description[$i];

		$fields = array_keys($item);
		$sth = $db->prepare("insert {$account_db}.gp_items (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
		$sth->execute($item);
	}
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'query'=>"insert into {$account_db}.gatepasses (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")"];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);