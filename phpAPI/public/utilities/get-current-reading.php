<?php
$return_value = ['success'=>1,'data'=>[]];
$sql_test = '';
try{
    // print_r($data);
    $meter_id = $data['meter_id'];
	$month = $data['month'];
    $year = $data['year'];

    $sql = "select * from {$account_db}.meter_readings WHERE meter_id= :meter_id AND month = :month AND year = :year";

    $record_sth = $db->prepare($sql);
    $record_sth->execute([
        'meter_id'=>$meter_id,
        'month'=>$month,
        'year'=>$year
    ]);
    $records = $record_sth->fetch();
    
    $return_value = $records;
    // $return_value['data'] = $data;
	

    
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(), 'sql_test' => $sql_test];
}
echo json_encode($return_value);
