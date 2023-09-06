<?php
$return_value = ['success'=>1,'data'=>[]];
try{
    $id = decryptData($data['id']);
    $table = $data['table'];
    $vtable = $data['view_table'];
    $status = $data['status'];

	$sth = $db->prepare("update {$account_db}.{$table} set status=:status where id=:id");
	$sth->execute(['status'=>$status,'id'=>$id ]);
    if($data['view_table']){
        $sth = $db->prepare("update {$account_db}.view_{$table} set status=:status where id=:id");
        $sth->execute(['status'=>$status,'id'=>$id ]);
    }

    $return_value = ['success'=>1,'description'=>'Record saved.', 'id' => decryptData($id) , 'data'=>$data];
    
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);