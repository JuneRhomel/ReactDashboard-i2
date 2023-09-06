<?php
header('Content-Type: application/json; charset=utf-8');
$redirect = $_POST['redirect'];
unset($_POST['redirect']);

if($_FILES['file']['name']){ 
    $attachments = [];
    foreach($_FILES['file']['name'] as $index=>$name)
    {
        $attachments[] = [
            'filename' => $_FILES['file']['name'][$index],
            'data' => chunk_split(base64_encode(file_get_contents($_FILES['file']['tmp_name'][$index])))
        ];
    }
    $_POST['attachments'] = $attachments;
}

$data = $_POST;
echo $result = $ots->execute('admin','save-data',$data);