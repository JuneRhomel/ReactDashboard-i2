<?php
$return_value = [];
try{
	$condition = (isset($data['ynmother'])) ? " and mmeter_id>0" : "";
	$term = $data['term'];
	$sth = $db->prepare("select id as value, meter_name as label from {$account_db}.meters where meter_name like ? $condition");
	$sth->execute(["%" . $term . "%"]);
	$return_value = $sth->fetchAll();
}catch(Exception $e){
	$return_value = [];
}
echo json_encode($return_value);