<?php
$return_value = ['success'=>1,'data'=>[]];
$sql_test = '';
try{
    $update_data = $data;
    
    $update_data['created_by'] = $user_token['user_id'];
    $update_data['rec_id'] = decryptData($data['reference_id']);
    $update_data['created_on'] = time();
    $update_data['type'] = 'stage';
    unset($update_data['reference_id']);
    
    $id = decryptData($data['reference_id']);
    
    //get rank
    $table = "{$account_db}.{$view}"; 
    $filter_data = [
        'stage_type'=>'cm'
    ];
    
    $and_rank_condition = "AND rank= '{$data['rank']}'";
    $sql = "select * from {$account_db}.stages WHERE stage_type=:stage_type {$and_rank_condition} ORDER by created_on DESC";
    $records_sth = $db->prepare($sql);
    $records_sth->execute($filter_data);
    $records = $records_sth->fetchAll();

    $update_data['stage'] = $records[0]['stage_name'];

    // print_r($update_data);
    $fields = array_keys($update_data);
    
    $sql = "insert {$account_db}.cm_updates (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    
    $sth = $db->prepare($sql);
    $sth->execute($update_data);

    //update main cm table
    $sth = $db->prepare("update {$account_db}.cm set stage=?,rank=? where id=?");
    $sth->execute([$update_data['stage'],$update_data['rank'],$id]);

    echo "update {$account_db}.cm set stage='{$update_data['stage']}',rank='{$update_data['rank']}' where id={$id}";
    if($data['rank']==3){
        
        $checking = $db->prepare("SELECT * FROM {$account_db}.cm_updates WHERE stage='work-started' AND rec_id={$id}");
        $checking->execute();

        if($checking){
            $datetime = date("Y-m-d");

            $sth = $db->prepare("UPDATE {$account_db}.cm SET stage='{$update_data['stage']}',rank='{$data['rank']}'  WHERE id={$id}");
            $sth->execute();

            $sth = $db->prepare("UPDATE {$account_db}.view_cm SET stage='{$update_data['stage']}',rank='{$data['rank']}'   WHERE id={$id}");
            $sth->execute();

        }else{
            $datetime = date("Y-m-d");

            $sth = $db->prepare("UPDATE {$account_db}.cm SET cm_start_date='{$datetime}',stage='{$update_data['stage']}',rank='{$data['rank']}'  WHERE id={$id}");
            $sth->execute();

            $sth = $db->prepare("UPDATE {$account_db}.view_cm SET cm_start_date='{$datetime}',stage='{$update_data['stage']}' ,rank='{$data['rank']}'  WHERE id={$id}");
            $sth->execute();
        }
    }

    if($data['rank']==6){
        $datetime = date("Y-m-d");
        $id = decryptData($data['reference_id']);

        $sth = $db->prepare("UPDATE {$account_db}.cm SET cm_end_date='{$datetime}',stage='{$update_data['stage']}',rank='{$data['rank']}' WHERE id={$id}");
        $sth->execute();

        $sth = $db->prepare("UPDATE {$account_db}.view_cm SET cm_end_date='{$datetime}',stage='{$update_data['stage']}',rank='{$data['rank']}'  WHERE id={$id}");
        $sth->execute();
    }

	$return_value = ['success'=>1,'description'=>'Record saved.', 'id' => encryptData($id)];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(), 'sql_test' => $sql_test];
}
echo json_encode($return_value);