<?php 

$data = $_POST;
$file_name= $data['file_name'];
unset($data['file_name']);
// var_dump($data);

echo $result = $ots->execute('property-management',$file_name,$data);