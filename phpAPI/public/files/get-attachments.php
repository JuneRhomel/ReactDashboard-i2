<?php
$return_value = ['success'=>1,'data'=>$data];

try{
    $table = "attachments"; 
    $filter = [
        'reference_table' => $data['reference_table'],
        'reference_id' => decryptData($data['reference_id'])
    ];
    $sql = "select a.*,b.full_name as created_by_fullname from {$account_db}.{$table} a left join {$account_db}.`_users` b on b.id=a.created_by 
        where reference_table=:reference_table and reference_id=:reference_id order by created_on desc";
    $sth = $db->prepare($sql);
    $sth->execute($filter);    
    $records = $sth->fetchAll();

    $return_value = $records;
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);