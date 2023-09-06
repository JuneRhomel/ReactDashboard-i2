<?php 
$return_value = [
    'success' => 1,
    'data' => $data
];
try{
    $sql = "select *, sum(bill_amount) as amount,sum(consumption) as khwr,sum(consumption) as khwr from {$account_db}.billing_and_rates where deleted_on=0 group by months, year,utility_type";
        
    $records_sth = $db->prepare($sql);
    $records_sth->execute();
    $records = $records_sth->fetchAll();

    $return_value['utility_reports'] = $records;
    $return_value['record_count'] = count($records);
    
}
catch(Exception $e){
    $return_value = [
        'success' => 0,
        'description' => $e->getMessage()
    ];
}

echo json_encode($return_value);

