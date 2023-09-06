<?php
$return_value = ['success'=>1,'data'=>[]];
try{
    // print_r($data);
    $view = $data['view'];
    $table = "{$account_db}.{$view}"; 
    $id = (!isset($data['_id'])) ? (isset($data['id']) ? decryptData($data['id']):0) : $data['_id'];

    $cm_details_records = [];
    if($view=='view_equipments'){
        $sql = "select {$view}.*,sp.company as sp_name from {$table}
            LEFT JOIN {$account_db}.service_providers as sp ON sp.id={$view}.service_provider
            WHERE {$view}.deleted_on=0 and {$view}.id={$id}";
        //get CM
        $cm_records_sql = "
            select 
                id ,
                priority_level ,
                wo_type ,
                created_on,
                created_by
                from {$account_db}.cm
            WHERE
                equipment_id = :equipment_id
        ";
        $cm_records_st = $db->prepare($cm_records_sql);
        $cm_records_st->execute([
            'equipment_id'=>$id
        ]);

        $cm_details_records = $cm_records_st->fetchAll();
        foreach($cm_details_records as $index => $cm){
            $cm_status_sql = "
                select *
                    from {$account_db}.cm_updates
                WHERE
                    rec_id = :cm_id 
                    AND
                    type = 'stage'
                ORDER by id desc
            ";
            $cm_status_st = $db->prepare($cm_status_sql);
            $cm_status_st->execute([
                'cm_id'=>$cm['id']
            ]);
            $cm_status_records = $cm_status_st->fetch();
            $cm_details_records[$index]['status'] = $cm_status_records['stage'];   
            $cm_details_records[$index]['status_created_on'] = $cm_status_records['created_on'];   
            $cm_details_records[$index]['status_created_created_by'] = $cm_status_records['created_by'];   
        }
        //get Cm Status

    } elseif($view=="users") {
        $sql = "select * from {$account_db}._users WHERE id={$user_token['user_id']}";

    } else {
        $sql = "select * from {$table} WHERE deleted_on=0 and id={$id}";
    }

    $record_sth = $db->prepare($sql);
    $record_sth->execute([]);
    $record = $record_sth->fetch();
    $return_value = $record;
    $return_value['cm_details'] = $cm_details_records;
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);