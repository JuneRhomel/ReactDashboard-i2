<?php
$return_value = ['success'=>1,'data'=>['count'=>0]];
$stage = $data['stage'];

try{
	$count = 0;
	
	$sth = $db->query("select count(id) as c from {$account_db}.view_cm where deleted_on=0 and stage='{$stage}'");
	$record = $sth->fetch();
	$count += $record['c'];

	$sth = $db->query("select count(id) as c from {$account_db}.views_pm where deleted_on=0 and stage='{$stage}'");
	$record = $sth->fetch();
	$count += $record['c'];

	$sth = $db->query("select count(id) as c from {$account_db}.view_wo where deleted_on=0 and stage='{$stage}'");
	$record = $sth->fetch();
	$count += $record['c'];

	$return_value['data']['count'] = $count;
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);
