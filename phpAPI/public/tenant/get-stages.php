<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$sth = $db->prepare("select * from {$account_db}.stages where stage_type=? order by rank");
	$sth->execute([$data['stage_type']]);
	$return_value = $sth->fetchAll();
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);