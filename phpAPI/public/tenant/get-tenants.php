<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$return_value = $db->getRecords("{$account_db}.view_tenants","id",$data,null,$data['filter']??[]);
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['id'] = encryptData($record['id']);
		$return_value['data'][$index]['tenant_id'] = $record['id'];
		$return_value['data'][$index]['enc_loc_id'] = encryptData($record['location_id']);
	}

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);