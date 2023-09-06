<?php
$return_value = ['success'=>1,'data'=>['count'=>0]];
try{
	$count = 0;
	
	$sth = $db->query("select count(id) as c from {$account_db}.view_unit_repair where deleted_on=0 and approve=0");
	$record = $sth->fetch();
	$count += $record['c'];

	$sth = $db->query("select count(id) as c from {$account_db}.view_gate_pass where deleted_on=0 and approve=0");
	$record = $sth->fetch();
	$count += $record['c'];

	$sth = $db->query("select count(id) as c from {$account_db}.view_visitor_pass where deleted_on=0 and approve=0");
	$record = $sth->fetch();
	$count += $record['c'];

	$sth = $db->query("select count(id) as c from {$account_db}.view_reservation where deleted_on=0 and approve=0");
	$record = $sth->fetch();
	$count += $record['c'];

	$sth = $db->query("select count(id) as c from {$account_db}.view_move_in where deleted_on=0 and approve=0");
	$record = $sth->fetch();
	$count += $record['c'];

	$sth = $db->query("select count(id) as c from {$account_db}.view_move_out where deleted_on=0 and approve=0");
	$record = $sth->fetch();
	$count += $record['c'];

	$sth = $db->query("select count(id) as c from {$account_db}.view_work_permit where deleted_on=0 and approve=0");
	$record = $sth->fetch();
	$count += $record['c'];

	$return_value['data']['count'] = $count;
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);