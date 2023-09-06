<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$data['name'] = $user_id;
	$data['created_by'] = $user_id;
	$data['created_on'] = time();
	$data['sr_type']='work-permit';
	//worker
	$worker_name=$data['workers_name'];
	$worker_desc=$data['workers_desc'];
	unset($data['workers_name']);
	unset($data['workers_desc']);
	//materials
	$material_qty=$data['material_qty'];
	$material_desc=$data['material_desc'];	
	unset($data['material_qty']);
	unset($data['material_desc']);
	//tools
	$tools_qty=$data['tools_qty'];
	$tools_desc=$data['tools_desc'];
	unset($data['tools_qty']);
	unset($data['tools_desc']);
	
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
		
	$sth = $db->prepare("insert into {$account_db}.work_permit (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	$sth->execute(array_values($data));
	$id = $db->lastInsertId(); 

	foreach ($worker_name as $i=>$row) {
		$w_item['created_by'] = $user_id;
		$w_item['created_on'] = time();
		$w_item['rec_id'] = $id;
		$w_item['ref_table'] = 'work_permit';
		$w_item['name'] = $worker_name[$i];
		$w_item['description'] = $worker_desc[$i];

		$fields = array_keys($w_item);
		$sth = $db->prepare("insert {$account_db}.workers (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
		$sth->execute($w_item);
	}

	//materials
	foreach ($material_qty as $i=>$row) {
		$m_item['created_by'] = $user_id;
		$m_item['created_on'] = time();
		$m_item['rec_id'] = $id;
		$m_item['ref_table'] = 'work_permit';
		$m_item['qty'] = $material_qty[$i];
		$m_item['description'] = $material_desc[$i];

		$fields = array_keys($m_item);
		$sth = $db->prepare("insert {$account_db}.materials (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
		$sth->execute($m_item);
	}

	//tools
	foreach ($tools_qty as $i=>$row) {
		$item['created_by'] = $user_id;
		$item['created_on'] = time();
		$item['rec_id'] = $id;
		$item['ref_table'] = 'work_permit';
		$item['qty'] = $tools_qty[$i];
		$item['description'] = $tools_desc[$i];

		$fields = array_keys($item);
		$sth = $db->prepare("insert {$account_db}.tools (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
		$sth->execute($item);
	}
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'query'=>"insert into {$account_db}.work_permit (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")"];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);