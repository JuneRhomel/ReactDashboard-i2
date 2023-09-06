<?php 
$return_value = [
    'success' => 1,
    'data' => $data
];
try{
    $month = $data['month'];
    if(!in_array($data['utility_type'], ['Electricity','Water'])){
        throw new Exception('Please use \'Electricity\' or \'Water\'only for utility_type');
    }
    $utility_type = $data['utility_type'] ?? 'Electricity';
    $year = $data['year'] ?? date('Y');
    $sql1 = "select *  from {$account_db}.billing_and_rates WHERE months = {$month} and year = :year AND utility_type = :utility_type and deleted_on=0";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'year'=> $year,
        'utility_type' => $utility_type
    ]);
    $records_current = $record_sth1->fetch();

    $sql1 = "select *  from {$account_db}.billing_and_rates WHERE months = {$month} and year = :year and deleted_on=0";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'year'=> ($year -1)
    ]);
    $records_previous = $record_sth1->fetch();

    // 23-0623 ATR: ERROR WITH INVALID INDEX, ADD FIX
    $records_previous['consumption'] = isset($records_previous['consumption']) ?? 0;
    $records_previous['bill_amount'] = isset($records_previous['bill_amount']) ?? 0;    
    $records_current['consumption'] = isset($records_current['consumption']) ?? 0;
    $records_current['bill_amount'] = isset($records_current['bill_amount']) ?? 0;

    $return_value['kwhr_consumption'] = [
        ($year-1)=>$records_previous['consumption'],
        $year => $records_current['consumption'],
        
    ];
    $return_value['kwhr_consumption_variance'] = [
        ($year - 1) . "_vs_" . $year => 0,
        '%' => 0
    ];

    $return_value['electric_billing'] = [
        ($year-1)=>$records_previous['bill_amount'],
        $year => isset($records_current['bill_amount']) ?? 0,
        
    ];

    $return_value['electric_billing_variance'] = [
        ($year - 1) . "_vs_" . $year => 0,
        '%' => 0
    ];

    $return_value['meralco_rate'] = [
        ($year-1)=>($records_previous['bill_amount'] / (($records_previous['consumption'] == 0) ? 1 : $records_previous['consumption'])),
        $year => ($records_current['bill_amount'] / (($records_current['consumption'] == 0) ? 1 : $records_current['consumption'])),
    ];
    
    $return_value['meralco_rate_variance'] = [
        ($year - 1) . "_vs_" . $year => 0,
        '%' => 0
    ];

    $return_value['current'] = $records_current;
    $return_value['previous'] = $records_previous;
}
catch(Exception $e){
    $return_value = [
        'success' => 0,
        'data' => $e->getMessage()
    ];
}

echo json_encode($return_value);