<?php
$return_value = ['success'=>1,'data'=>[]];
try{
    
    // print_r($data);
    $table =  $data['table'];
    $view_table =  $data['view_table'] ?? null;
	$update_table =  $data['update_table'] ?? null;
	$id = null ?? decryptData($data['id']);
    $id = decryptData($data['id']);
    unset($data['table']);
	unset($data['update_table']);
    unset($data['view_table']);
    unset($data['id']);
    unset($data['file']);
    // print_r($data);
    //exit();
	if($id) {
		$fields = [];
		foreach( array_keys($data) as $field) {
			$fields[] = "{$field}=:{$field}";
		}
		$sth = $db->prepare("update {$account_db}.{$table} set " . implode(",",$fields). " where id={$id}");
		$sth->execute($data);

        if($view_table != null){
            
            $fields = [];
            foreach( array_keys($data) as $field) {
                $fields[] = "{$field}=:{$field}";
            }
            $sth = $db->prepare("update {$account_db}.view_{$table} set " . implode(",",$fields). " where rec_id={$id}");
            $sth->execute($data);
        }

		if($update_table != null){

			// $update_data['rec_id'] = $id;
			$update_data = [];
            $update_data['created_by'] = $user_token['user_id'];
            $update_data['created_on'] = time();
			$update_data['status'] = 'edited';

			if($table == 'contracts'){
				$update_data['contract_number'] = $data['contract_number'];
				$update_data['effectivity_date'] = $data['effectivity_date'];
				$update_data['expiration_date'] = $data['expiration_date'];
				$update_data['contract_id'] = $id;
				$update_data['description'] = 'edited';

			}
			else if($table == 'permits'){
				$update_data['permit_number'] = $data['permit_number'];
				$update_data['date_issued'] = $data['date_issued'];
				$update_data['expiration_date'] = $data['expiration_date'];
				$update_data['permit_id'] = $id;
				$update_data['description'] = 'edited';
			}

			$fields = array_keys($update_data);
            
			$sql = "insert {$account_db}.{$update_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
			$sth = $db->prepare($sql);
			$sth->execute($update_data);
		}
	}else{
		$data['created_by'] = $user_token['user_id'];
		$data['created_on'] = time();

		$fields = array_keys($data);
		$sth = $db->prepare("insert {$account_db}.{$table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
		$sth->execute($data);
		$id = $db->lastInsertId(); 

        if($view_table != null){
            $data['rec_id'] = $id;
            $data['created_by'] = $user_token['user_id'];
            $data['created_on'] = time();

            $fields = array_keys($data);
            $sth = $db->prepare("insert {$account_db}.{$view_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
            $sth->execute($data);
            
        }

		if($update_table != null){

			
            $update_data = [];
            $update_data['created_by'] = $user_token['user_id'];
            $update_data['created_on'] = time();
			$update_data['status'] = 'new';

			if($table == 'contracts'){
				$update_data['contract_number'] = $data['contract_number'];
				$update_data['effectivity_date'] = $data['effectivity_date'];
				$update_data['expiration_date'] = $data['expiration_date'];
				$update_data['contract_id'] = $id;
				$update_data['description'] = 'new';

			}
			else if($table == 'permits'){
				$update_data['permit_number'] = $data['permit_number'];
				$update_data['date_issued'] = $data['date_issued'];
				$update_data['expiration_date'] = $data['expiration_date'];
				$update_data['permit_id'] = $id;
				$update_data['description'] = 'new';
			}

			$fields = array_keys($update_data);
            
			$sql = "insert {$account_db}.{$update_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
			$sth = $db->prepare($sql);
			$sth->execute($update_data);
		}

	}
    

	// if ($module=="stage") {
	// 	// REARRANGE SORTING ORDER
	// 	$sth = $db->prepare("select * from {$account_db}.stages where deleted_on=0 and stage_type=:stage_type and id<>:id and rank>=:rank order by rank");
	// 	$sth->execute([ 'stage_type'=>$data['stage_type'],'rank'=>$data['rank'],'id'=>$id ]);
	// 	$records = $sth->fetchAll();
	// 	if ($records) {
	// 		$ct = $data['rank']+1;
	// 		foreach ($records as $record) {
	// 			$sth = $db->prepare("update {$account_db}.stages set rank=:rank where id=:id");
	// 			$sth->execute([ 'rank'=>$ct,'id'=>$record['id'] ]);
	// 			$ct++;
	// 		}
	// 	}
	// }

	$return_value = ['success'=>1,'description'=>'Record saved.', 'id' => encryptData($id)];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);