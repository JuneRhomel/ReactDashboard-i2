<?php


$_POST['id']? $data['id'] = $_POST['id'] : '';
$data = [
    'id' => $_POST['id'],
    'meter_id' => $_POST['meter_id'],
    'new_reading' => $_POST['new_reading'],
    'consumption' => $_POST['consumption'],
    'month'=> $_POST['month'],
    'year'=> $_POST['year'],
];

if (!empty($_FILES['image']['tmp_name'])) {
    $attachment = [
        'filename' => $_FILES['image']['name'],
        'data' => chunk_split(base64_encode(file_get_contents($_FILES['image']['tmp_name'])))
    ];
    $data['attachments'] = [$attachment];
}

// echo json_encode($data);

$results = $ots->execute('utilities', 'input-reading', $data);
echo $results;
