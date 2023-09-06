<?php
$return_value = ['success'=>1,'data'=>$data];

try{
    $month = $data['month'];
    $utility_type = $data['utility_type'];
    
    $year = $data['year'];
    // print_r($data);
    $sql1 = "select *,(bill_amount / consumption) as rates from {$account_db}.view_billing_and_rates WHERE months = :months and year = :year AND utility_type = :utility_type";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'months'=>$month,
        'year'=>$year,
        'utility_type'=>$utility_type
    ]);
    $records1 = $record_sth1->fetch();
    $return_value = $records1;
    // $return_value['data'] = $data;
    
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);