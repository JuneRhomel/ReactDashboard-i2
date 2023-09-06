<?php
$data = $_POST;
$data = [
    'id' => $_POST['id'],
    'title' => $_POST['title'],
    'subtitle' => $_POST['subtitle'],
    'content' => $_POST['content'],
    'module' => $_POST['module'],
    'table'=> $_POST['table'],
    'date'=> $_POST['date'],
];

if (!empty($_FILES['thumbnail']['tmp_name'])) {
    $attachment = [
        'filename' => $_FILES['thumbnail']['name'],
        'data' => chunk_split(base64_encode(file_get_contents($_FILES['thumbnail']['tmp_name'])))
    ];
    $data['thumbnail'] = [$attachment];
}


$result = $ots->execute('news','save',$data);
// echo  json_encode($data);
echo  $result;
?>
