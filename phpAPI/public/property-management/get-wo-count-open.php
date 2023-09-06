<?php
$return_value = ['success'=>1,'data'=>['count'=>0]];
try{
	$count = 0;
	
	$sth = $db->query("select count(id) as c from {$account_db}.cm where deleted_on=0 and stage != 'closed'");
	$record = $sth->fetch();
	$count += $record['c'];

	$sth = $db->query("select count(id) as c from {$account_db}.pm where deleted_on=0 and stage != 'closed'");
	$record = $sth->fetch();
	$count += $record['c'];

	$sth = $db->query("select count(id) as c from {$account_db}.wo where deleted_on=0 and stage != 'closed'");
	$record = $sth->fetch();
	$count += $record['c'];

	$return_value['data']['count'] = $count;
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);