<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $months = $_POST['months'];
    $year = $_POST['year'];
    $mother_meter = $_POST['mother_meter'];
    $latestReading = $_POST['latest_reading'];
    $billAmount = $_POST['bill_amount'];
    $rate_ = $_POST['rate_'];
    $data = [
        'date' => $date,
        'year'=> $year,
        'months'=> $months,
        'mother_meter'=> $mother_meter,
        'latest_reading' => $latestReading,
        'bill_amount' => $billAmount,
        'rate_' => $rate_
    ];
    echo $rate_;
     $result = $ots->execute('utilities','save-mother-meter',$data);
}
