<?php
$return_value = ['success' => 1, 'data' => []];
$sql_test = '';
try {
    $meter_id = $data['meter_id'];
    $month = $data['month'];
    $month = $month - 1;
    if ($month == 0) {
        $month = 12;
    }
    $year = $data['year'];

    //get last reading
    $sql1 = "select *  from {$account_db}.meter_readings WHERE meter_id = :meter_id and month = :month and year = :year;";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'meter_id' => $meter_id,
        'month' => $month,
        'year' => $year
    ]);
    $records1 = $record_sth1->fetch();

    $last_reading = $records1['reading'];

    if ($data['reading'] < $last_reading) {
        throw new Exception('Current reading must not be lesser than previous reading');
    }
    // print_r($data);
    $meter_id = $data['meter_id'];
    $month = $data['month'] = number_format($data['month'], 0);
    $year = $data['year'];

    $sql = "select * from {$account_db}.meter_readings WHERE meter_id= :meter_id AND month = :month AND year = :year";

    $record_sth = $db->prepare($sql);
    $record_sth->execute([
        'meter_id' => $meter_id,
        'month' => $month,
        'year' => $year
    ]);
    $record = $record_sth->fetch();
    print_r($record);


    // print_r($records);
    if ($record == false) {
        $fields = [];
        $data['created_by'] = $user_token['user_id'];
        $data['created_on'] = time();

        $fields = array_keys($data);
        // print_r($fields);
        // print_r($data);
        $fields = array_keys($data);

        $sql = "insert {$account_db}.meter_readings (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";
        $sth = $db->prepare($sql);
        // print_r($sth);
        $sth->execute($data);
        $id = $db->lastInsertId();
        $data['rec_id'] = $id;
        $fields = array_keys($data);

        $fields = array_keys($data);

        $sql = "insert {$account_db}.view_meter_readings (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";
        $sth = $db->prepare($sql);
        $sth->execute($data);


        $return_value['insert_id'] = $id;
    } else {
        $data['created_by'] = $user_token['user_id'];
        $data['created_on'] = time();

        $fields = [];
        foreach (array_keys($data) as $field) {
            $fields[] = "{$field}=:{$field}";
        }
        $sql = "update {$account_db}.meter_readings set reading = ? where id={$record['id']}";
        $sth = $db->prepare($sql);
        // print_r($sth);
        $sth->execute([$data['reading']]);


        $sql = "update {$account_db}.view_meter_readings set reading = ? where rec_id={$record['id']}";
        $sth = $db->prepare($sql);
        // print_r($sth);
        $sth->execute([$data['reading']]);
    }

    //new bill records,

    $sql1 = "select *  from {$account_db}.meters as m, {$account_db}.tenant as t WHERE m.id = :meter_id and t.id= m.tenant";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute([
        'meter_id' => $meter_id,
    ]);
    $tenant = $record_sth1->fetch();

    $return_value['tenant_details'] = $tenant;
    $return_value['last_reading'] = $last_reading;
    $return_value['reading'] = $data['reading'];
    if ($last_reading > 0)
        $consumption =  $data['reading'] - $last_reading;
    $return_value['consumption'] = $consumption;
    //get rates

    $month = $data['month'];
    $utility_type = $tenant['utility_type'];
    if ($utility_type == 'Electrical')
        $utility_type = 'Electricity';

    $year = $data['year'];

    $sql1 = "select *,(bill_amount / consumption) as rates from {$account_db}.view_billing_and_rates WHERE months = :months and year = :year AND utility_type = :utility_type order by id desc";
    $bills_data = [
        'months' => $month,
        'year' => $year,
        'utility_type' => $utility_type
    ];
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute($bills_data);
    $latest_billing_rates = $record_sth1->fetch();

    $return_value['latest_billing_rates'] = $latest_billing_rates['rates'];

    $bill_amount = $consumption *  $latest_billing_rates['rates'];
    if ($bill_amount < 0) {
        $bill_amount = 0;
    }
    $return_value['bill_amount'] = $bill_amount;

    $month = $data['month'];
    $year = $data['year'];

    $sql = "select * from {$account_db}.assoc_dues WHERE  month = :month AND year = :year order by id desc";

    $record_sth = $db->prepare($sql);
    $record_sth->execute([
        'month' => $month,
        'year' => $year
    ]);
    $records = $record_sth->fetch();

    $assoc_dues_month = $return_value['assoc_dues_month'] = $records['dues'];

    $return_value['assoc_dues'] = $assoc_dues = $tenant['unit_area'] * $assoc_dues_month;

    //check if there_are Bills existing using tenant_id
    $tenant_id = $tenant['tenant'];
    $month = $data['month'];
    $year = $data['year'];

    $sql = "select * from {$account_db}.bills WHERE tenant_id= :tenant_id AND month = :month AND year = :year order by id desc";

    $record_sth = $db->prepare($sql);
    $record_sth->execute([
        'tenant_id' => $tenant_id,
        'month' => $month,
        'year' => $year
    ]);
    $records = $record_sth->fetch();

    $bill_details = $return_value['bill_details'] = $records;

    if ($bill_details) {
        $id = $bill_details['id'];
        $return_value['bills_insert'] = 'no';
        //update bills
        $table = 'bills';
        $data_insert['created_by'] = $user_token['user_id'];
        $data_insert['created_on'] = time();

        $data_insert['month'] = $data['month'];
        $data_insert['year'] = $data['year'];
        $data_insert['tenant_id'] = $tenant['tenant'];
        $data_insert['association_dues'] = $assoc_dues ?? 0;
        $data_insert['billed'] = 'unbilled';

        if ($tenant['utility_type'] == 'Electrical') {
            $data_insert['electricity'] = $bill_amount;
        } else {
            $data_insert['water'] = $bill_amount;
        }


        $fields = [];
        foreach (array_keys($data_insert) as $field) {
            $fields[] = "{$field}=:{$field}";
        }
        $sth = $db->prepare("update {$account_db}.{$table} set " . implode(",", $fields) . " where id={$id}");
        $sth->execute($data_insert);
        //update view_bills
        $view_table = 'view_bills';
        $data_insert_view['rec_id'] = $id;
        $data_insert_view['month'] = $data['month'];
        $data_insert_view['year'] = $data['year'];
        $data_insert_view['tenant_id'] = $tenant['tenant'];
        $data_insert_view['association_dues'] = $assoc_dues ?? 0;
        $data_insert_view['billed'] = 'unbilled';
        if ($tenant['utility_type'] == 'Electrical') {
            $data_insert_view['electricity'] = $bill_amount;
        } else {
            $data_insert_view['water'] = $bill_amount;
        }

        $fields = [];
        foreach (array_keys($data_insert_view) as $field) {
            $fields[] = "{$field}=:{$field}";
        }

        $sth = $db->prepare("update {$account_db}.{$view_table} set " . implode(",", $fields) . " where id={$id}");
        $sth->execute($data_insert_view);

        $update_table = 'bills_update';
        $update_data = [];
        $update_data['rec_id'] = $id;
        $update_data['created_by'] = $user_token['user_id'];
        $update_data['created_on'] = time();

        $update_data['type'] = 'comment';
        $update_data['comment'] = 'updated';
        $update_data['description'] = 'updated : ' . $tenant['utility_type'] . " = " . $bill_amount;

        $fields = array_keys($update_data);

        $sql = "insert {$account_db}.{$update_table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";
        $sth = $db->prepare($sql);
        $sth->execute($update_data);
    } else {
        //insert new bills
        $table = 'bills';
        $data_insert['created_by'] = $user_token['user_id'];
        $data_insert['created_on'] = time();

        $data_insert['month'] = $data['month'];
        $data_insert['year'] = $data['year'];
        $data_insert['tenant_id'] = $tenant['tenant'];
        $data_insert['association_dues'] = $assoc_dues ?? 0;
        $data_insert['billed'] = 'unbilled';

        if ($tenant['utility_type'] == 'Electrical') {
            $data_insert['electricity'] = $bill_amount;
        } else {
            $data_insert['water'] = $bill_amount;
        }

        $fields = array_keys($data_insert);

        $sql_test =  $sql = "insert {$account_db}.{$table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";
        $sth = $db->prepare($sql);
        $sth->execute($data_insert);
        $id = $db->lastInsertId();

        $view_table = 'view_bills';
        $data_insert_view['rec_id'] = $id;
        $data_insert_view['month'] = $data['month'];
        $data_insert_view['year'] = $data['year'];
        $data_insert_view['tenant_id'] = $tenant['tenant'];
        $data_insert_view['association_dues'] = $assoc_dues ?? 0;
        $data_insert_view['billed'] = 'unbilled';
        if ($tenant['utility_type'] == 'Electrical') {
            $data_insert_view['electricity'] = $bill_amount;
        } else {
            $data_insert_view['water'] = $bill_amount;
        }

        $fields = array_keys($data_insert_view);

        $sth = $db->prepare("insert {$account_db}.{$view_table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")");
        $sth->execute($data_insert_view);
        $return_value['bills_insert'] = 'yes';

        $update_table = 'bills_update';
        $update_data = [];
        $update_data['rec_id'] = $id;
        $update_data['created_by'] = $user_token['user_id'];
        $update_data['created_on'] = time();

        $update_data['type'] = 'comment';
        $update_data['comment'] = 'created';
        $update_data['description'] = 'created : ' . $tenant['utility_type'] . " = " . $bill_amount;

        $fields = array_keys($update_data);

        $sql = "insert {$account_db}.{$update_table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";
        $sth = $db->prepare($sql);
        $sth->execute($update_data);
    }
} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage(), 'sql_test' => $sql_test];
}
echo json_encode($return_value);
