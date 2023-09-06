<?php
$return_value = ['success'=>1,'data'=>$data];

try{
    $month = $data['month'];
    $year = $data['year'];
    // print_r($data);

    $sql1 = "select * from {$account_db}.bills WHERE month = {$month} and year = :year";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'year'=>$year,
    ]);
    $records1 = $record_sth1->fetch();
    
    
    $return_value = ['success'=>1,'billing_data'=>$records1];
    
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);