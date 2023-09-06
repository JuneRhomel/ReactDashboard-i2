<?php
$return_value = ['success'=>1,'data'=>['count'=>0]];
$category = $data['kpi_type'];

try{
	$count = 0;
	$r_count = 0;

	if($category == 'service_request'){
		$sth = $db->query("select count(id) as c from {$account_db}.view_unit_repair where deleted_on=0 and sla='YES'");
		$record = $sth->fetch();
		$count += $record['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.view_gate_pass where deleted_on=0 and sla='YES'");
		$record = $sth->fetch();
		$count += $record['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.view_visitor_pass where deleted_on=0 and sla='YES'");
		$record = $sth->fetch();
		$count += $record['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.reservation where deleted_on=0 and sla='YES'");
		$record = $sth->fetch();
		$count += $record['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.view_move_in where deleted_on=0 and sla='YES'");
		$record = $sth->fetch();
		$count += $record['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.view_move_out where deleted_on=0 and sla='YES'");
		$record = $sth->fetch();
		$count += $record['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.view_work_permit where deleted_on=0 and sla='YES'");
		$record = $sth->fetch();
		$count += $record['c'];

		//ALL RECORDS:
		$sth = $db->query("select count(id) as c from {$account_db}.view_unit_repair where deleted_on=0");
		$records = $sth->fetch();
		$r_count += $records['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.view_gate_pass where deleted_on=0");
		$records = $sth->fetch();
		$r_count += $records['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.view_visitor_pass where deleted_on=0");
		$records = $sth->fetch();
		$r_count += $records['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.reservation where deleted_on=0");
		$records = $sth->fetch();
		$r_count += $records['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.view_move_in where deleted_on=0");
		$records = $sth->fetch();
		$r_count += $records['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.view_move_out where deleted_on=0");
		$records = $sth->fetch();
		$r_count += $records['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.view_work_permit where deleted_on=0");
		$records = $sth->fetch();
		$r_count += $records['c'];
	}else if($category == 'contracts_permit'){
		$sth = $db->query("select count(id) as c from {$account_db}.contracts where deleted_on=0 and sla='YES'");
		$record = $sth->fetch();
		$count += $record['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.permits where deleted_on=0 and sla='YES'");
		$record = $sth->fetch();
		$count += $record['c'];

		//ALL RECORDS:
		$sth = $db->query("select count(id) as c from {$account_db}.contracts where deleted_on=0");
		$records = $sth->fetch();
		$r_count += $records['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.permits where deleted_on=0");
		$records = $sth->fetch();
		$r_count += $records['c'];
	}else{
		$sth = $db->query("select count(id) as c from {$account_db}.{$category} where deleted_on=0 and sla='YES'");
		$record = $sth->fetch();
		$count += $record['c'];

		//ALL RECORDS:
		$sth = $db->query("select count(id) as c from {$account_db}.{$category} where deleted_on=0");
		$records = $sth->fetch();
		$r_count += $records['c'];
	}

	$return_value['data']['count'] = $count;
	$return_value['data']['r_count'] = $r_count;
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);