<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$view = $data['view'];
	$location_id = $data['location_id'];
	
	$sth = $db->prepare("select * from {$account_db}.{$view} where location_id=:location_id order by id desc");
	$sth->execute([ "location_id"=>$location_id ]);
	$return_value['data'] = $sth->fetchAll();
	$return_value['recordsFiltered'] = $return_value['recordsTotal'] = $sth->rowCount();
	//$return_value = $db->getRecords("{$account_db}.turnovers","id",$data,null,"location_id={$location_id}");
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['id'] = encryptData($record['id']);
		$return_value['data'][$index]['turnover_id'] = $record['id'];
	}
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['id'] = encryptData($record['id']);
		if (isset($record['tenant_id']))
			$return_value['data'][$index]['enc_tenant_id'] = encryptData($record['tenant_id']);
		if (isset($record['location_id']))
			$return_value['data'][$index]['enc_loc_id'] = encryptData($record['location_id']);
		if (isset($record['reserved_from']))		
			$return_value['data'][$index]['schedule'] = date('M d Y h:i a',$record['reserved_from']) . ' to ' . (date('Y-m-d',$record['reserved_from']) == date('Y-m-d',$record['reserved_to']) ?  date('h:i a',$record['reserved_to']) :  date('M d Y h:i a',$record['reserved_to']));
	}
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);