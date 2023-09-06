<?php
$return_value = ['success'=>1,'data'=>[]];
try{
    // print_r($data);
    $view = $data['view'];
    $table = "{$account_db}.{$view}"; 

    $sql = "select * from {$table} WHERE deleted_on=0 and role_id={$data['role_id']} and is_active=1";

    $record_sth = $db->prepare($sql);
    $record_sth->execute([]);
    $records = $record_sth->fetchAll();
	
    $role_rights = [];
    if($records){
        foreach($records as $rec){
            $role_rights[$rec['table_name']][$rec['right_name']] = 'checked';
        }
    }

    $return_value = $role_rights;

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);