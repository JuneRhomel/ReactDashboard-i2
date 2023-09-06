<?php
$return_value = ['success'=>1,'data'=>$data];

try{
    $meter_id = $data['meter_id'];
    $month = $data['month'];
    $year = $data['year'];

    $month = $month-1;
    if($month == 0){
        $month = 12;
        $year = $year - 1;
    }

    $sql1 = "select *  from {$account_db}.meter_readings WHERE meter_id = :meter_id and month = :month and year = :year;";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'meter_id'=>$meter_id,
        'month'=>$month,
        'year'=>$year
    ]);
    $records1 = $record_sth1->fetch();
    $return_value = $records1;
    // $return_value['data'] = $data;
    
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);