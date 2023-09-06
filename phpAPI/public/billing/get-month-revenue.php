<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$start = strtotime(date("Y-m-01"));
	$end = time();
	$sth = $db->prepare("select sum(amount) as amount from {$account_db}.billing_payments where created_on >= {$start} and created_on <= {$end}");
	$sth->execute();
	$return_value['data'] = $sth->fetch(); 
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);