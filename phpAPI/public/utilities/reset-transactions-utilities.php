<?php 
$return_value = [
    'success' => 1,
    'data'=>$data
];
try{
    //Reset for Utilities
    $sql1 = "
    
    truncate {$account_db}.meter_readings;
    truncate {$account_db}.view_meter_readings;

    truncate {$account_db}.bills;
    truncate {$account_db}.view_bills;
    truncate {$account_db}.bills_update;

    truncate {$account_db}.billing_and_rates;
    truncate {$account_db}.billing_and_rate_updates;
    truncate {$account_db}.view_billing_and_rates;

    truncate {$account_db}.soa;
    truncate {$account_db}.soa_items; 
    truncate {$account_db}.view_soa;
    
    truncate {$account_db}.soa_updates;

    
    truncate {$account_db}.payments;        
          
    
    ";
    
        $record_sth1 = $db->prepare($sql1);
        $record_sth1->execute([]);
    $result = $record_sth1->fetchAll();
}   
catch(Exception $e){
    $return_value=[
        'sucess'=> 0,
        'description'=> $e->getMessage()
    ];
}
echo json_encode($return_value);
/**
 * truncate meter_readings; truncate view_meter_readings; truncate bills; truncate view_bills, truncate bills_update; truncate soa; truncate view_soa; truncate soa_updates; truncate payments;
 */
?>