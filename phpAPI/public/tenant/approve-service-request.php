
<?php 

$return_value = ['success'=>1,'data'=>[]];
try{
    $id = $data['id'];
    $approve = $data['approve'];
    $return_value['data'] = $data;
    $table = str_replace('-','_', $data['sr_type']);

    
    $sth = $db->prepare("update {$account_db}.{$table} set approve = :approve where id= :id");
    $sth->execute([
        'approve' => $data['approve'],
        'id' => $data['id']
    ]);

    $sth = $db->prepare("update {$account_db}.view_{$table} set approve = :approve where id= :id");
    $sth->execute([
        'approve' => $data['approve'],
        'id' => $data['id']
    ]);
    $return_value['updated'] = 'TRUE';
}
catch(Exception $e){
    $return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);