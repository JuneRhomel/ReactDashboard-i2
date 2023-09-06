<?php
$return_value = [];
try{
	$term = $data['term'];
	$condition = ($data['filter']!="") ? " and location_type='".$data['filter']."'" : "";
	$sth = $db->prepare("select id as value, location_name as label from {$account_db}.locations where location_name like ? $condition");
	$sth->execute(["%" . $term . "%"]);
	$return_value = $sth->fetchAll();
}catch(Exception $e){
	$return_value = [];
}
echo json_encode($return_value);