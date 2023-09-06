<?php
$return_value = ['success'=>1,'data'=>[]];
try{
    $sql = "select * from {$account_db}.attachments WHERE description='{$data['desc']}' ORDER BY id DESC";   
    $record_sth = $db->prepare($sql);
    $record_sth->execute([]);
    $record = $record_sth->fetch();
    $return_value = $record;
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);