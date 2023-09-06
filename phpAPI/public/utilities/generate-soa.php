<?php 
$return_value = [
    'success' => 1,
    'data' => $data
];
try{
    $month = $data['month'];
    $year = $data['year'];
    $bill_id = $data['bill_id'];

    $sql1 = "select bills.* from {$account_db}.bills,{$account_db}.tenant WHERE bills.id= {$bill_id} and bills.tenant_id = tenant.id";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute();
    $records1 = $record_sth1->fetch();
    
    $billing_details = $records1;
    
    $month_balance = $data['month'];
    $year_balance = $data['year'];
    $month_balance = $month -1;
    if($month == 1 || $month == 01){
        $month_balance = 12;
        $year_balance = $year_balance - 1;
    }
    $sql1 = "select *  from 
        {$account_db}.soa WHERE tenant_id = :tenant_id AND due_month = {$month_balance} and due_year = {$year_balance}";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'tenant_id'=>$billing_details['tenant_id']
    ]);
    $balance_from_previous = 0;
    $balance_from_previous= $record_sth1->fetch()['remaining_balance'];

    $total_amount = $records1['association_dues'] + $records1['water'] + $records1['electricity'];
    $records1['total'] = $total_amount;


    $total_amount_due = $total_amount + $balance_from_previous;
    $data_insert = [
        'due_month' => $month,
        'due_year' => $year,
        'due_date' => get_setting($db ,$account_db, 'soa_due_date'),
        'bill_id' => $bill_id,
        'remaining_balance'=> $total_amount_due,
        'amount_due' => $total_amount,
        'total_amount_due' => $total_amount_due,
        'charges_inc_vat' => $inc_vat =  $total_amount / (1 + (get_setting($db ,$account_db, 'vat')/100)),
        'vat_exempted' => 0,
        'total_vat' => $total_amount - $inc_vat,
        'notes'=>'Single Generation',
        'tenant_id' => $billing_details['tenant_id']
    ];

    $data_insert['created_by'] = $user_token['user_id'];
    $data_insert['created_on'] = time();

    $fields = array_keys($data_insert);

    $sql = "insert {$account_db}.soa (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    $sth = $db->prepare($sql);
    print_r($data);
    
    $sth->execute($data_insert);

    $id = $db->lastInsertId(); 

    $data_insert['rec_id'] = $id;
    $fields = array_keys($data_insert);
    $sql = "insert {$account_db}.view_soa (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    $sth = $db->prepare($sql);
    // print_r($sth);
    $sth->execute($data_insert);

    // // updates
    $update_table = 'soa_updates';
    $update_data = [];
    $update_data['rec_id'] = $id;
    $update_data['created_by'] = $user_token['user_id'];
    $update_data['created_on'] = time();

    $update_data['type'] = 'comment';
    $update_data['comment'] = 'generated';
    $update_data['description'] = 'generated'; 

    $fields = array_keys($update_data);
        
    $sql = "insert {$account_db}.{$update_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    $sth = $db->prepare($sql);
    $sth->execute($update_data);
    
    $update_table = 'soa_updates';
    $update_data = [];
    $update_data['rec_id'] = $id;
    $update_data['created_by'] = $user_token['user_id'];
    $update_data['created_on'] = time();

    $update_data['type'] = 'stage';
    $update_data['stage'] = 'billed';
    $update_data['comment'] = 'billed';
    $update_data['description'] = 'billed';
    $update_data['rank'] = '1';

    $fields = array_keys($update_data);
        
    $sql = "insert {$account_db}.{$update_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    $sth = $db->prepare($sql);
    $sth->execute($update_data);
    
    
        
    $return_value['data_insert'] = $data_insert;
    $return_value['last_insert_id'] = $id;

    $balance = 0;
    //insert to soa_items

    $tenant_id = $billing_details['tenant_id'];

    //electrcity
    
    $sql1 = "select *  from {$account_db}.meters WHERE tenant= {$tenant_id} and utility_type = 'Electricity'";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute();
    $records1 = $record_sth1->fetch();
    $return_value['elect_meter_id'] = $electric_meter_id =  $records1['id'];

    // Water
    $sql1 = "select *  from {$account_db}.meters WHERE tenant= {$tenant_id} and utility_type = 'Water'";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute();
    $records1 = $record_sth1->fetch();
    $return_value['water_meter_id'] = $water_meter_id =  $records1['id'];

    //electricity rate
    $month = $data['month'];
    
    $utility_type = 'Electricity';
    $year = $data['year'];
    
    $sql1 = "select *,(bill_amount / consumption) as rates from {$account_db}.view_billing_and_rates WHERE months = {$month} and year =:year AND utility_type = :utility_type and deleted_on=0";
    
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'year'=>$year,
        'utility_type'=>$utility_type
    ]);
    $records1 = $record_sth1->fetch();
    $electricity_rates = $records1['bill_amount'] / $records1['consumption'];
    $return_value['electricity_rates'] = $electricity_rates;

    //electricity previous
    
    $meter_id = $electric_meter_id;
	$month = $data['month'];
    $year = $data['year'];

    $sql = "select * from {$account_db}.meter_readings WHERE meter_id= :meter_id AND month = {$month} AND year = :year";
    
    $record_sth = $db->prepare($sql);
    $record_sth->execute([
        'year'=>$year,
        'meter_id'=>$meter_id
    ]);
    $records = $record_sth->fetch()['reading'];
    
    $return_value['elect_current_reading'] = $records;  

    //electricity current

    $meter_id = $electric_meter_id;
    $month = $data['month'];
    $year = $data['year'];

    $month = $month-1;
    
    if($month == 0){
        $month = 12;
        $year = $year - 1;
    }

    $sql1 = "select *  from {$account_db}.meter_readings WHERE meter_id = :meter_id and month = {$month} and year = :year";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'meter_id'=>$meter_id,
        'year'=>$year
    ]);
    
    $records1 = $record_sth1->fetch()['reading'];
    $return_value['elect_last_reading'] = $records1;  

    $return_value['electric_consumption'] = $return_value['elect_current_reading'] - $return_value['elect_last_reading'];  

    //Water
    $utility_type = 'Water';
    $year = $data['year'];
    $month = $data['month'];
    $sql1 = "select *,(bill_amount / consumption) as rates from {$account_db}.view_billing_and_rates WHERE months = {$month} and year = :year AND utility_type = :utility_type and deleted_on=0";
    
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'year'=>$year,
        'utility_type'=>$utility_type
    ]);
    $records1 = $record_sth1->fetch();
    $water_rates = $records1['bill_amount'] / $records1['consumption'];
    $return_value['water_rates'] = $water_rates;

    //electricity previous
    
    $meter_id = $water_meter_id;
	$month = $data['month'];
    $year = $data['year'];

    $sql = "select * from {$account_db}.meter_readings WHERE meter_id= :meter_id AND month = {$month} AND year = :year";
    
    $record_sth = $db->prepare($sql);
    $record_sth->execute([
        'meter_id'=>$meter_id,
        'year'=>$year
    ]);
    $records = $record_sth->fetch()['reading'];
    
    $return_value['water_current_reading'] = $records;  

    //electricity current

    $meter_id = $water_meter_id;
    $month = $data['month'];
    $year = $data['year'];

    $month = $month-1;
    
    if($month == 0){
        $month = 12;
        $year = $year - 1;
    }

    $sql1 = "select *  from {$account_db}.meter_readings WHERE meter_id = :meter_id and month = {$month} and year = :year";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'meter_id'=>$meter_id,
        'year'=>$year
    ]);
    
    //insert balance
    $records1 = $record_sth1->fetch()['reading'];
    $return_value['water_last_reading'] = $records1;  

    $return_value['water_consumption'] = $return_value['water_current_reading'] - $return_value['water_last_reading'];  

    $item_table = 'soa_items';

    // Upaid Balance

    $month = $data['month'];
    $year = $data['year'];
    $month = $month -1;
    if($month == 0){
        $month = 12;
        $year = $year - 1;
    }
    $sql1 = "select *  from 
        {$account_db}.soa WHERE tenant_id = :tenant_id AND due_month = {$month} and due_year = :year";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'tenant_id'=>$billing_details['tenant_id'],
        'year'=>$year
    ]);
    $balance= $record_sth1->fetch()['remaining_balance'];
    print_r($balance);

    $data_insert_balance = [
        
        'item_type' => 'balance',
        'item_name' => 'unpaid_balance',
        'item_amount' => $balance,
        'soa_id'=>$id
    ];

    $data_insert_balance['created_by'] = $user_token['user_id'];
    $data_insert_balance['created_on'] = time();

    $fields = array_keys($data_insert_balance);

    $sql = "insert {$account_db}.{$item_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    $sth = $db->prepare($sql);
    $sth->execute($data_insert_balance);
    
    //insert Assoc Dues,
    //getAssoc
    $sql = "select * from {$account_db}.tenant; WHERE id = :id";

    $record_sth = $db->prepare($sql);
    $record_sth->execute([
        'id'=> $billing_details['tenant_id']
    ]);
    $tenants = $record_sth->fetch();

    $unit_area = $tenants['unit_area'];
    
    $month = $data['month'];
    $year = $data['year'];

    $sql = "select * from {$account_db}.assoc_dues WHERE  month = {$month} AND year = :year order by id desc";

    $record_sth = $db->prepare($sql);
    $record_sth->execute([
        'year'=>$year
    ]);
    $records = $record_sth->fetch();
    $assoc_dues = $records['dues'];    

    $data_insert_assoc = [
        
        'item_type' => 'assoc_dues',
        'item_name' => 'current_charges',
        'rate'=> $assoc_dues,
        'consumption' => $unit_area,
        'item_amount' => $billing_details['association_dues'],
        'soa_id'=>$id
    ];
    // print_r($data_insert_assoc);
    $data_insert_assoc['created_by'] = $user_token['user_id'];
    $data_insert_assoc['created_on'] = time();

    $fields = array_keys($data_insert_assoc);

    $sql = "insert {$account_db}.{$item_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    $sth = $db->prepare($sql);
    $sth->execute($data_insert_assoc);


    //insert electricl
    $item_amount = ($return_value['elect_current_reading'] - $return_value['elect_last_reading']) * $return_value['electricity_rates'];
    if($item_amount < 0){
        $item_amount = 0;
    }
    $data_insert_electric = [
        
        'item_type' => 'reading',
        'item_name' => 'electricity_charges',
        'previous' => $return_value['elect_last_reading'],
        'current' => $return_value['elect_current_reading'],
        'consumption' => $return_value['elect_current_reading'] - $return_value['elect_last_reading'],
        'rate' => $return_value['electricity_rates'],
        'item_amount' => $item_amount,
        'soa_id'=>$id
    ];
    // print_r($data_insert_electric);
    $data_insert_electric['created_by'] = $user_token['user_id'];
    $data_insert_electric['created_on'] = time();
    
    $fields = array_keys($data_insert_electric);
    
    $sql = "insert {$account_db}.{$item_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    $sth = $db->prepare($sql);
    $sth->execute($data_insert_electric);
    
    $item_amount = ($return_value['water_current_reading'] - $return_value['water_last_reading']) * $return_value['water_rates'];

    if($item_amount < 0){
        $item_amount = 0;
    }
    $data_insert_water = [
        
        'item_type' => 'reading',
        'item_name' => 'water_charges',
        'previous' => $return_value['water_last_reading'],
        'current' => $return_value['water_current_reading'],
        'consumption' => $return_value['water_current_reading'] - $return_value['water_last_reading'],
        'rate' => $return_value['water_rates'],
        'item_amount' => $item_amount,
        'soa_id'=>$id
    ];
    // print_r($data_insert_electric);
    $data_insert_water['created_by'] = $user_token['user_id'];
    $data_insert_water['created_on'] = time();
    
    $fields = array_keys($data_insert_water);

    $sql = "insert {$account_db}.{$item_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    $sth = $db->prepare($sql);
    $sth->execute($data_insert_water);

    // $data_update_bills = [];
    $data_update_bills['billed'] = 'billed';
    $data_update_bills['created_by'] = $user_token['user_id'];
    $data_update_bills['created_on'] = time();
    $fields = [];
    foreach( array_keys($data_update_bills) as $field) {
        $fields[] = "{$field}=:{$field}";
    }
    $sql = "update {$account_db}.bills set " . implode(",",$fields). " where id= {$data['bill_id']}";
    $sth = $db->prepare($sql);
    $sth->execute($data_update_bills);
    
    $sql = "update {$account_db}.view_bills set " . implode(",",$fields). " where rec_id= {$data['bill_id']}";
    $sth = $db->prepare($sql);
    $sth->execute($data_update_bills);

}
catch(Exception $e){
    $return_value = [
        'success' => 0,
        'description' => $e->getMessage()
    ];
}

echo json_encode($return_value);
/**
 * Reset mo kapag maguulit ka ng generate billing
 */

//truncate soa; truncate view_soa; truncate soa_updates; truncate soa_items; update bills set billed='unbilled';
// update view_bills set billed='unbilled';