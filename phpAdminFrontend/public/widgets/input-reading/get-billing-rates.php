<?php


$data = [
    'utility_type' => $_POST['utility_type'],
    'month' => $_POST['month'],
    'year' => $_POST['year'],
    'date' =>$_POST['date']
];

// if (isset($_POST['date']) && !empty($_POST['date'])) {
//     $data['date'] = $_POST['date'];
// }

// echo $_POST['utility_type'];
// echo json_encode($data);
$results = $ots->execute('utilities', 'get-billing-rates', $data);
echo $results;
// $rates = number_format($rates, 2);
