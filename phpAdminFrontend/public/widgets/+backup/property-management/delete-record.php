<?php 
// print_r($_GET);
$id = explode('/', $_GET['url'])[2];
$data = $_GET;
$data['id'] = $id;
$redirect = $data['redirect'];
unset($data['redirect']);
$result = $ots->execute('property-management','delete-record',$data);
$result = json_decode($result);
$redirect .= "&submenuid=".$result->data->submenuid;
if($result->success == 1){
    header ('location:' . WEB_ROOT . "{$redirect}");
}