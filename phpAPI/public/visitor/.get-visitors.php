<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$return_value = $db->getRecords("{$account_db}.view_visitors","id",$data,null,(isset($data['filter']) ? $data['filter'] : null));
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['id'] = encryptData($record['id']);
		if (isset($record['tenant_id']))
			$return_value['data'][$index]['enc_tenant_id'] = encryptData($record['tenant_id']);
		if (isset($record['location_id']))
			$return_value['data'][$index]['enc_loc_id'] = encryptData($record['location_id']);
	}
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);