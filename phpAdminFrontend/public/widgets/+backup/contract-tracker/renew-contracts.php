<?php
// header('Content-Type: application/json; charset=utf-8');

// print_r($_POST);
$data=[];
if($args[0]){
    $data = ['renew_id' => decryptData($args[0])];
}else{
    $data = $_POST;
}

echo $result = $ots->execute('contracts','renew-contracts',$data);