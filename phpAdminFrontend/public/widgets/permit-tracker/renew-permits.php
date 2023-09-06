<?php
// header('Content-Type: application/json; charset=utf-8');

// print_r($_POST);

$data = $_POST;
// print_R($data);

echo $result = $ots->execute('contracts','renew-permits',$_POST);


