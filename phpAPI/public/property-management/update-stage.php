<?php
$return_value = ['success'=>1,'data'=>[]];
$sql_test = '';
try{
    $update_data = $data;
    
    $update_data['created_by'] = $user_token['user_id'];
    $update_data['rec_id'] = decryptData($data['reference_id']);
    $update_data['created_on'] = time();
    $update_data['type'] = 'stage';
    $stage_type = $update_data['stage_type']; //table
    $table_update = $update_data['update_table'];
    unset($update_data['stage_type']);
    unset($update_data['update_table']);
    unset($update_data['reference_id']);
    
    //get rank
    $table = "{$account_db}.{$view}"; 
    $filter_data = [
        'stage_type'=>"{$stage_type}"
    ];
    
    $and_rank_condition = "AND rank= '{$data['rank']}'";
    $sql = "select * from {$account_db}.stages WHERE stage_type=:stage_type {$and_rank_condition} ORDER by created_on DESC";
    $records_sth = $db->prepare($sql);
    $records_sth->execute($filter_data);
    $records = $records_sth->fetchAll();

    $update_data['stage'] = $records[0]['stage_name'];

    // print_r($update_data);
    $fields = array_keys($update_data);
    
    $sql = "insert {$account_db}.{$table_update} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    
    $sth = $db->prepare($sql);
    $sth->execute($update_data);

    if($data['rank']==3){
        $checking = $db->prepare("SELECT *  FROM {$account_db}.{$table_update} WHERE stage='work-started' AND rec_id={$update_data['rec_id']}");
        $checking->execute();

        if($checking){
            $id = decryptData($data['reference_id']);

            $sth = $db->prepare("UPDATE {$account_db}.{$stage_type} SET stage='{$update_data['stage']}',rank='{$data['rank']}' WHERE id={$id}");
            $sth->execute();

            $sth = $db->prepare("UPDATE {$account_db}.view_{$stage_type} SET stage='{$update_data['stage']}',rank='{$data['rank']}' WHERE id={$id}");
            $sth->execute();
        }else{
            $datetime = date("Y-m-d");
            $id = decryptData($data['reference_id']);

            $sth = $db->prepare("UPDATE {$account_db}.{$stage_type} SET {$stage_type}_start_date='{$datetime}',stage='{$update_data['stage']}',rank='{$data['rank']}'  WHERE id={$id}");
            $sth->execute();

            $sth = $db->prepare("UPDATE {$account_db}.view_{$stage_type} SET {$stage_type}_start_date='{$datetime}',stage='{$update_data['stage']}',rank='{$data['rank']}'   WHERE id={$id}");
            $sth->execute();
        }

        
    }else if($data['rank']==6){
        $datetime = date("Y-m-d");
        $id = decryptData($data['reference_id']);

        $sth = $db->prepare("UPDATE {$account_db}.{$stage_type} SET {$stage_type}_end_date='{$datetime}',stage='{$update_data['stage']}',rank='{$data['rank']}' WHERE id={$id}");
        $sth->execute();

        $sth = $db->prepare("UPDATE {$account_db}.view_{$stage_type} SET {$stage_type}_end_date='{$datetime}',stage='{$update_data['stage']}',rank='{$data['rank']}'  WHERE id={$id}");
        $sth->execute();
    }else{
        $datetime = date("Y-m-d");
        $id = decryptData($data['reference_id']);

        $sth = $db->prepare("UPDATE {$account_db}.{$stage_type} SET rank='{$data['rank']}',stage='{$update_data['stage']}' WHERE id={$id}");
        $sth->execute();

        $sth = $db->prepare("UPDATE {$account_db}.view_{$stage_type} SET rank='{$data['rank']}',stage='{$update_data['stage']}'  WHERE id={$id}");
        $sth->execute();
    }

	$return_value = ['success'=>1,'description'=>'Record saved.', 'id' => encryptData($id)];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(), 'sql_test' => $sql_test];
}
echo json_encode($return_value);