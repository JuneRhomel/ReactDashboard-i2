<?php
$return_value = ['success'=>1,'data'=>[]];
try{
    // print_r($data);
    $view = $data['view'];
    $table = "{$account_db}.{$view}"; 
    $id = ($data['_id']==null)?decryptData($data['id']):$data['_id'];

    if($view=='view_equipments'){
        $sql = "select {$view}.*,sp.company as sp_name from {$table}
            LEFT JOIN {$account_db}.service_providers as sp ON sp.id={$view}.service_provider
            WHERE {$view}.deleted_on=0 and {$view}.id={$id}";
    }else{
        $sql = "select * from {$table} WHERE deleted_on=0 and id={$id}";
    }

    $record_sth = $db->prepare($sql);
    $record_sth->execute([]);
    $record = $record_sth->fetch();
    $return_value = $record;
	
    
    if (isset($record['requestor_name'])){
        $sql = "select * from {$account_db}.tenant WHERE id={$record['requestor_name']}";
        $sth = $db->prepare($sql);
        $sth->execute($data);
        $tenant_name = $sth->fetch()['owner_name'];
        $return_value['tenant_name'] = $tenant_name;
    }

    if (isset($record['name'])){
        $sql = "select * from {$account_db}.tenant WHERE id={$record['name']}";
        $sth = $db->prepare($sql);
        $sth->execute($data);
        $tenant_name = $sth->fetch()['owner_name'];
        $return_value['tenant_name'] = $tenant_name;
    }

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);