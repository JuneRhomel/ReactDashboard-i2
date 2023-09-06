<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$due_date = date("Y-m-d");
	$sth = $db->prepare("select * from {$account_db}.view_billings where amount > payment and due_date < CURDATE()");
	$sth->execute();
	$return_value['data'] = $sth->fetchAll(); 
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);