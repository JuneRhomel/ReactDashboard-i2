<?php
$return_value = ['success'=>1,'data'=>$data];

try{
    $view = 'stages';

    $table = "{$account_db}.{$view}"; 
    $filter_data = [
        'stage_type'=>$data['stage_type']
    ];
    $and_rank_condition = '';
    if($data['rank']){
        $and_rank_condition = "AND rank= '{$data['rank']}'";
    }
    
    $sql = "select * from {$table} WHERE stage_type=:stage_type {$and_rank_condition} ORDER by created_on DESC";

    $records_sth = $db->prepare($sql);
    $records_sth->execute($filter_data);
    
    $records = $records_sth->fetchAll();
    foreach($records as $index => $record){

        if (isset($record['created_by'])){
            $sql = "select * from {$account_db}._users WHERE id={$record['created_by']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$equipment = $sth->fetch()['full_name'];
			$records[$index]['created_by_full_name'] = $equipment;
		}
    }
    $return_value = $records;
    
    // $return_value['sql'] = $sql;
    // print_r($return_value);

	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);