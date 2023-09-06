<?php
// header('Content-Type: application/json; charset=utf-8');
$redirect = $_POST['redirect'];


unset($_POST['redirect']);
// print_r($_POST);

$data = $_POST;
// print_R($data);
// exit();
echo $result = $ots->execute('contracts','update-permit-contracts',$_POST);
// $result = json_decode($result);
// // print_r($result);
// // exit();
// if($result->success == 1){
//     $redirect_view = $result->id ?? '';
//     $redirect = $redirect . $redirect_view ?? '';
//     $header = 'Location: ' . $redirect;
//     // exit();
//     header($header);
// }
// else{
//     print_r($result);
// }