<?php 
$return_value = [
    'success' => 1,
    'data' => $data
];
try{
    $soa_id = ($data['_soa_id']==null)?decryptData($data['soa_id']):$data['_soa_id'];

    $remaining_balance = 0;
    
    
    $sql1 = " select 
            *
        from 
            {$account_db}.soa ,
            {$account_db}.bills,
            {$account_db}.tenant
        WHERE 
            soa.bill_id = bills.id AND
            tenant.id = bills.tenant_id AND
            soa.id = :id;";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'id'=>$soa_id
        
    ]);

    $soa_detials = $record_sth1->fetch();
    
    $return_value['soa_details']= $soa_detials;

    //unpaid_balance 
    $sql1 = "Select * from {$account_db}.soa_items WHERE soa_id = :id and item_type = 'balance' order by id desc";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'id'=>$soa_id
    ]);
    $unpaid_balances = $record_sth1->fetch();
    $return_value['soa_items']['unpaid_balances']['amount'] = $unpaid_balances['item_amount'];

    //assoc_dues
    $sql1 = "Select * from {$account_db}.soa_items WHERE soa_id = :id and item_type = 'assoc_dues'";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'id'=>$soa_id
    ]);
    $assoc_dues = $record_sth1->fetch();
    $return_value['soa_items']['current_charges']['unit_area'] = $assoc_dues['consumption'];
    $return_value['soa_items']['current_charges']['common_area_charges_month'] = $assoc_dues['rate'];
    $return_value['soa_items']['current_charges']['amount'] = $assoc_dues['item_amount'];

    //electricity
    $sql1 = "Select * from {$account_db}.soa_items WHERE soa_id = :id and item_type = 'reading'  AND item_name ='electricity_charges'";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'id'=>$soa_id
    ]);
    $electricity = $record_sth1->fetch();
    $return_value['soa_items']['electricity_charges'] = $electricity;

    //water
    $sql1 = "Select * from {$account_db}.soa_items WHERE soa_id = :id and item_type = 'reading'  AND item_name ='water_charges'";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'id'=>$soa_id
    ]);
    $water = $record_sth1->fetch();
    $return_value['soa_items']['water_charges'] = $water;
    
    // $return_value['soa_details'] = [
    //     'tenant_details'
    // ];
    // Payments
    $sql1 = "Select * from {$account_db}.payments WHERE soa_id = :id";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'id'=>$soa_id
    ]);
    $payments = $record_sth1->fetchAll();
    $return_value['payment_details'] = $payments;

}
catch(Exception $e){
    $return_value = [
        'success' => 0,
        'description' => $e->getMessage()
    ];
}

echo json_encode($return_value);

