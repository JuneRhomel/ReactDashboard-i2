<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$id = ($data['id']) ? decryptData($data['id']) : 0;		unset($data['id']);
	$table = $data['table']; 								unset($data['table']);

	if($id) {
		$fields = [];
		foreach( array_keys($data) as $field) {
			$fields[] = "{$field}=:{$field}";
		}
		$sth = $db->prepare("update {$account_db}.{$table} set " . implode(",",$fields). " where id={$id}");
		$sth->execute($data);
	}else{
		$data['created_by'] = $user_token['user_id'];
		$data['created_on'] = time();

		$fields = array_keys($data);
		$sth = $db->prepare("insert {$account_db}.{$table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
		$sth->execute($data);
		$id = $db->lastInsertId(); 
	}

	$return_value = ['success'=>1,'description'=>'Record saved.','loc_id'=>$loc_id];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);