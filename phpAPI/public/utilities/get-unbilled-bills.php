<?php 
$return_value = [
    'success' => 1,
    'data' => $data
];
try{
    $month = $data['month'];
    $year = $data['year'];

    $sql1 = "select * from {$account_db}.bills WHERE month ={$month} AND year ={$year} AND billed = 'unbilled'";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute();
    $records1_billing = $record_sth1->fetchAll();
    
    $return_value['record_count']['total'] = count($records1_billing);
    $return_value['record_count']['sql'] = $record_sth1;

    $zero_water_reading = 0;
    $zero_electric_reading = 0;
    $zero_assoc_dues = 0;

    foreach($records1_billing as $record){
        if($record['water'] == 0 || $record['water'] == null)
        {
            $zero_water_reading++;
        }
        if($record['electricity'] == 0 || $record['electricity'] == null)
        {
            $zero_electric_reading++;
        }
        if($record['association_dues'] == 0 || $record['association_dues'] == null)
        {
            $zero_assoc_dues++;
        }
    } 
    $return_value['record_count']['zero_water_reading'] = $zero_water_reading;
    $return_value['record_count']['zero_electric_reading'] = $zero_electric_reading;
    $return_value['record_count']['zero_assoc_dues'] = $zero_assoc_dues;
    $return_value['bills'] = $records1_billing;


    
}
catch(Exception $e){
    $return_value = [
        'success' => 0,
        'description' => $e->getMessage()
    ];
}

echo json_encode($return_value);


