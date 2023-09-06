<?php
$return_value = ['success' => 1, 'data' => $data];

try {
    $month = $data['date']; // Assuming this is the correct key for the month value
    $months = $data['months'];
    $year = $data['year'];
    $mother_meter = $data['mother_meter'];
    $latest_reading = $data['latest_reading'];
    $bill_amount = $data['bill_amount'];
    $rate_ = $data['rate_'];

    $sql = "INSERT INTO {$account_db}.view_billing_and_rates (month, months, year, mother_meter, latest_reading, bill_amount, rate) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $db->prepare($sql); 
    $stmt->execute([$month, $months, $year, $mother_meter, $latest_reading, $bill_amount, $rate_]);

} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage(), 'sql' => $sql];
}

header('Content-Type: application/json');
echo json_encode($return_value);



