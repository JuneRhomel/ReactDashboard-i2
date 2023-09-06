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

        // UPDATE BILLING DETAILS
        //electrcity
        $sql1 = "select *  from {$account_db}.meters WHERE tenant= {$record['tenant_id']} and utility_type = 'Electricity'";
        $record_sth1 = $db->prepare($sql1);
        $record_sth1->execute();
        $records1 = $record_sth1->fetch();
        $electric_meter_id =  $records1['id'];
        
         // Water
        $sql1 = "select *  from {$account_db}.meters WHERE tenant={$record['tenant_id']} and utility_type = 'Water'";
        $record_sth1 = $db->prepare($sql1);
        $record_sth1->execute();
        $records1 = $record_sth1->fetch();
        $water_meter_id =  $records1['id'];

        //electricity rate
        $month = $data['month'];
        $utility_type = 'Electricity';
        $year = $data['year'];
        
        $sql1 = "select *,(bill_amount / consumption) as rates from {$account_db}.view_billing_and_rates WHERE months = {$month} and year =:year AND utility_type = :utility_type";
        
        $record_sth1 = $db->prepare($sql1);
        $record_sth1->execute([
            'year'=>$year,
            'utility_type'=>$utility_type
        ]);
        $records1 = $record_sth1->fetch();
        $electricity_rates = $records1['bill_amount'] / $records1['consumption'];

        //electricity current
        $meter_id = $electric_meter_id;
        $month = $data['month'];
        $year = $data['year'];

        $sql = "select * from {$account_db}.meter_readings WHERE meter_id= :meter_id AND month = {$month} AND year = :year";
        
        $record_sth = $db->prepare($sql);
        $record_sth->execute([
            'year'=>$year,
            'meter_id'=>$meter_id
        ]);
        $elect_current_reading = $record_sth->fetch()['reading'];
        
        //electricity previous
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
        
        $elect_last_reading = $record_sth1->fetch()['reading'];

        $electric_consumption = $elect_current_reading - $elect_last_reading;  

        //Water
        $utility_type = 'Water';
        $year = $data['year'];
        $month = $data['month'];
        $sql1 = "select *,(bill_amount / consumption) as rates from {$account_db}.view_billing_and_rates WHERE months = {$month} and year = :year AND utility_type = :utility_type";
        
        $record_sth1 = $db->prepare($sql1);
        $record_sth1->execute([
            'year'=>$year,
            'utility_type'=>$utility_type
        ]);
        $records1 = $record_sth1->fetch();
        $water_rates = $records1['bill_amount'] / $records1['consumption'];

        //water current
        
        $meter_id = $water_meter_id;
        $month = $data['month'];
        $year = $data['year'];

        $sql = "select * from {$account_db}.meter_readings WHERE meter_id= :meter_id AND month = {$month} AND year = :year";
        
        $record_sth = $db->prepare($sql);
        $record_sth->execute([
            'meter_id'=>$meter_id,
            'year'=>$year
        ]);
        $water_current_reading = $record_sth->fetch()['reading'];
        
        //water previous

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
        $water_last_reading = $record_sth1->fetch()['reading'];

        $water_consumption = $water_current_reading - $water_last_reading;  

        $item_amount_water = ($water_current_reading - $water_last_reading) * $water_rates;
        $item_amount_elec = ($elect_current_reading - $elect_last_reading) * $electricity_rates;

        $data_update_bills['electricity'] = $item_amount_elec;
        $data_update_bills['water'] = $item_amount_water;

        $fields = [];
        foreach( array_keys($data_update_bills) as $field) {
            $fields[] = "{$field}=:{$field}";
        }
        $sql = "update {$account_db}.bills set " . implode(",",$fields). " where id= {$record['id']}";
        $sth = $db->prepare($sql);
        $sth->execute($data_update_bills);
        
        $sql = "update {$account_db}.view_bills set " . implode(",",$fields). " where rec_id= {$record['id']}";
        $sth = $db->prepare($sql);
        $sth->execute($data_update_bills);

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


