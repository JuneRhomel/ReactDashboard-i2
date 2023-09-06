<?php
$return_value = ['success'=>1,'data'=>[]];

try{
	$location_id = decryptData($data['locationid']);

	$sth = $db->prepare("select a.*,b.tenant_name from {$account_db}.turnovers a left join {$account_db}.tenants b on a.tenant_id=b.id where a.location_id=:location_id order by a.id desc");
	$sth->execute([ "location_id"=>$location_id ]);
	$return_value['data'] = $sth->fetchAll();
	$return_value['recordsFiltered'] = $return_value['recordsTotal'] = $sth->rowCount();
	//$return_value = $db->getRecords("{$account_db}.turnovers","id",$data,null,"location_id={$location_id}");
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['id'] = encryptData($record['id']);
		$return_value['data'][$index]['turnover_id'] = $record['id'];
	}

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);