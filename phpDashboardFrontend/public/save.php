<?php


session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = $_POST;
if (isset($_FILES['attachments']['tmp_name'])) {
    $attachment = [
        'filename' => $_FILES['attachments']['name'],
        'data' => chunk_split(base64_encode(file_get_contents($_FILES['attachments']['tmp_name'])))
    ];
    $data['attachments'] = [$attachment];
}




$result = apiSend('tenant','save',$data);

echo  $result;


?>
