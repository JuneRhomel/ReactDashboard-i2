<?php
$return_value = ['success'=>1,'data'=>[]];
try{
    $ids = $data['ids'];
    $table = $data['table'];
    $vtable = $data['view_table'];

    foreach($ids as $id){
        $id = decryptData($id);

        $sth = $db->prepare("update {$account_db}.{$table} set deleted_by=:deleted_by,deleted_on=:deleted_on where id=:id");
        
        $sth->execute([ 'deleted_by'=>$user_token['user_id'],'deleted_on'=>time(),'id'=>$id ]);
        if($data['view_table']){
            if($table=="pm" || $table=="building_personnel" || $table="service_providers"){
                $sth = $db->prepare("update {$account_db}.{$vtable} set deleted_by=:deleted_by,deleted_on=:deleted_on where id=:id");
                $sth->execute([ 'deleted_by'=>$user_token['user_id'],'deleted_on'=>time(),'id'=>$id ]);
            }else{
                $sth = $db->prepare("update {$account_db}.view_{$table} set deleted_by=:deleted_by,deleted_on=:deleted_on where id=:id");
                $sth->execute([ 'deleted_by'=>$user_token['user_id'],'deleted_on'=>time(),'id'=>$id ]);
            }
        }
    }

    $return_value = ['success'=>1,'description'=>'Record saved.', 'data'=>$data];
    
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);