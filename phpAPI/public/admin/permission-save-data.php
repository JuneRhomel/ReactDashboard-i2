<?php
$return_value = ['success'=>1,'data'=>$data];
$sql_test = '';
try{
	$role_id = $data['id'];
	unset($data['id']);
	//delete all rights based on role_id
	$sth = $db->prepare("DELETE from {$account_db}._role_rights WHERE role_id=$role_id");
	$sth->execute();

	foreach(array_keys($data) as $field) {
		$table_name = $field;
	
		$data_array = $data["$table_name"];
		foreach(array_keys($data_array) as $field) {
			$insert_data = [
				'role_id'=>$role_id,
				'right_name' => $field,
				'table_name' => $table_name,
				'is_active' => 1,
				'created_by' => $user_token['user_id'],
				'created_on' => time()
			];

			$sth = $db->prepare("insert into {$account_db}._role_rights (" . implode(",",array_keys($insert_data)) . ") values(?" . str_repeat(",?",count(array_keys($insert_data))-1) .")");
			$sth->execute(array_values($insert_data));
		}
	}

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);