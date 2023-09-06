<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$id = 0;
	if($data['id'])
		$id = decryptData($data['id']);

	unset($data['id']);

	if($id)
	{
		$fields = [];
		foreach( array_keys($data) as $field)
		{
			$fields[] = "{$field}=:{$field}";
		}
		$sth = $db->prepare("update {$account_db}.turnovers set " . implode(",",$fields). " where id={$id}");
	}else{
		$data['created_by'] = $user_token['user_id'];
		$data['created_on'] = time();

		$fields = array_keys($data);
		$sth = $db->prepare("insert {$account_db}.turnovers(" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
	}
	$sth->execute($data);
	$return_value = ['success'=>1,'description'=>'Turnover saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);