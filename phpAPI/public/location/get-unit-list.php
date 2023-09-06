<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$sth = $db->prepare("select * from {$account_db}.view_locations where location_type='unit' order by location_name");
	$sth->execute();
	$return_value = $sth->fetchAll();

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);