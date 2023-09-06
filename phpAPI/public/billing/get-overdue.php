<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$due_date = date("Y-m-d");
	$sth = $db->prepare("select sum(amount-payment) as amount from {$account_db}.billings where due_date < '{$due_date}' and amount > payment");
	$sth->execute();
	$return_value['data'] = $sth->fetch(); 
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);