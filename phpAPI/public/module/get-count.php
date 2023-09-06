<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$view = $data['view'];
	//$return_value = $db->getRecords("{$account_db}.{$view}","id",$data,null,(isset($data['filter']) ? $data['filter'] : null));
	$sth = $db->prepare("select count(id) as cnt from {$account_db}.{$view}");
	$sth->execute();
	$return_value = $sth->fetch();
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);