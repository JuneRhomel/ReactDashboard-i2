<?php
$return_value = ['success' => 1, 'data' => $data];

try {
    $utility_type = $data['utility_type'];
    $month = $data['month'];
    $year = $data['year'];
    $date = $data['date'];

    $sql1 = "SELECT *, (bill_amount / consumption) AS consumption_rate FROM {$account_db}.vw_billing_and_rates WHERE months = :months AND year = :year AND utility_type = :utility_type ORDER BY id DESC";
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->bindParam(':months', $month);
    $record_sth1->bindParam(':year', $year);
    $record_sth1->bindParam(':utility_type', $utility_type);
    $record_sth1->execute();
    $records1 = $record_sth1->fetch();
    
    $encryptedId = encryptData($records1['id']);
    $records1['enc_id'] = $encryptedId;


    // history
    $records2 = null;
    if (!empty($date)) {
        $sql2 = "SELECT * FROM {$account_db}.vw_billing_and_rates WHERE DATE_FORMAT(STR_TO_DATE(`date`, '%Y-%m'), '%Y-%m') = :date AND utility_type = :utility_type LIMIT 1";
        $previous_reading = $db->prepare($sql2);
        $previous_reading->bindParam(':utility_type', $utility_type);
        $previous_reading->bindParam(':date', $date);
        $previous_reading->execute();
        $records2 = $previous_reading->fetch();
    }
    // $records2= [
    //     'enc_id' =>  encryptData($records2['id'])
    // ];
    

    $return_value = ['success' => 1, 'billing_data' => $records1, 'previous_reading' => $records2];
} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage()];
}

echo json_encode($return_value);
