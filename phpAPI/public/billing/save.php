<?php
$return_value = ['success'=>1,'description'=>''];
try{
	$id = $data['id'] ? decryptData($data['id']) : 0;
	unset($data['id']);

	
	if($id == 0)
	{
		$data['created_on'] = time();
		$data['created_by'] = $user_id;
		$sth = $db->prepare("insert into {$account_db}.billings (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
		$sth->execute(array_values($data));
	}else{
		$field_values = [];
		foreach($data as $key=>$value)
		{
			$field_values[] = "{$key}=:{$key}";
		}
//echo "<pre>"; var_dump($field_values); echo "</pre>";
//echo "<pre>"; var_dump($data); echo "</pre>";

		$sth = $db->prepare("update {$account_db}.billings set " . implode(",",$field_values) . " where id = :id");
		$data['id'] = $id;
		$sth->execute($data);
	}
	
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);