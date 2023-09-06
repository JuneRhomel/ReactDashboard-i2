<?php
try{
    $table = $data['table'];
    $sql = "select a.*,b.full_name as created_by_fullname from {$account_db}.{$table} a left join {$account_db}.`_users` b on b.id=a.created_by 
        where a.rec_id=? and a.type='comment' order by a.created_on desc";
    $sth = $db->prepare($sql);
    $sth->execute([ decryptData($data['rec_id']) ]);
    $records = $sth->fetchAll();
    $return_value = $records;	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);