<?php
$return_value = ['success'=>1,'data'=>[]];
$sql_test = '';
try{
    // print_r($data);
    $month = $data['month'];
    $year = $data['year'];

    $sql = "select * from {$account_db}.assoc_dues WHERE  month ={$month} AND year = :year order by id desc";

    $record_sth = $db->prepare($sql);
    $record_sth->execute([
        'year'=>$year
    ]);
    $records = $record_sth->fetch()['dues'];
    
    $return_value = ['success'=>1,'assoc_dues'=>$records];
    // $return_value['data'] = $data;
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(), 'sql_test' => $sql_test];
}
echo json_encode($return_value);
