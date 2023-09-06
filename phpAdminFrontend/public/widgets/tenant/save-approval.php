<?php 
// print_r($_GET);
$id = explode('/', $_GET['url'])[2];
$data = $_GET;
$data['id'] = $id;
$redirect = $data['redirect'];
unset($data['redirect']);

// print_R($data);
$result = $ots->execute('tenant','save-approval',$data);
$result = json_decode($result);
if($result->success == 1){
    header ('location:' . WEB_ROOT . "{$redirect}");
}