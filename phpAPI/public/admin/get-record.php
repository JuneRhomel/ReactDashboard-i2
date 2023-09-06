<?php
$return_value = ['success'=>1,'data'=>[]];
try{
    // print_r($data);
    $view = $data['view'];
    $table = "{$account_db}.{$view}"; 
    $id = ($data['_id']==null)?decryptData($data['id']):$data['_id'];

    if($view=='building_profile'){
        $sql = "select * from {$table} WHERE deleted_on=0";
    }else{
        $sql = "select * from {$table} WHERE deleted_on=0 and id={$id}";
    }

    $record_sth = $db->prepare($sql);
    $record_sth->execute([]);
    $record = $record_sth->fetch();
    $return_value = $record;
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);