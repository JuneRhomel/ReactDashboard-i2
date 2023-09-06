<?php
$data = $_POST;
$data = [
    'id' => $_POST['id'],
    'issue_id' => $_POST['issue_id'],
    'contact_no' => $_POST['contact_no'],
    'description' => $_POST['description'],
    'module' => $_POST['module'],
    'name_id' => $_POST['name_id'],
    'table'=> $_POST['table'],
    'unit_id'=> $_POST['unit_id'],
    'status_id'=> $_POST['status_id'],
    'date'=>  date('Y-m-d H:i:s'),
];

if (!empty($_FILES['attachments']['tmp_name'])) {
    $attachment = [
        'filename' => $_FILES['attachments']['name'],
        'data' => chunk_split(base64_encode(file_get_contents($_FILES['attachments']['tmp_name'])))
    ];
    $data['attachments'] = [$attachment];
}


$result = $ots->execute('report','report-issue-save',$data);
// echo  json_encode($data);
echo  $result;
?>
