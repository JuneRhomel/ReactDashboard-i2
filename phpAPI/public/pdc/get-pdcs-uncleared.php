<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$start = date("Y-m-01");
	$end = date("Y-m-d");
	$sth = $db->prepare("select * from {$account_db}.view_pdcs where check_date >= '{$start}' and check_date <= '{$end}'");
	$sth->execute();
	$return_value = $sth->fetchAll();
}catch(PDOException $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);