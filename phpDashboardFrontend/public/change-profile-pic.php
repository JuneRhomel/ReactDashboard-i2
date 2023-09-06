<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = $_POST;
$data = [
    'filename' => $_POST['filename'],
    'reference_table' => $_POST['reference_table'],
    'reference_id' => $_POST['reference_id'],
    'table' => 'photos',
    'module' => 'occupant-profile',
    'description' => $_POST['description'],

];
if($_POST['id']) {
    $data['id']= $_POST['id'];
};
if (!empty($_FILES['profile']['tmp_name'])) {
    $attachment = [
        'filename' => $_FILES['profile']['name'],
        'data' => chunk_split(base64_encode(file_get_contents($_FILES['profile']['tmp_name'])))
    ];
    $data['profile'] = [$attachment];
}


$result = apiSend('tenant','change-profile-pic',$data);
// echo  json_encode($data);
echo $result;

?>