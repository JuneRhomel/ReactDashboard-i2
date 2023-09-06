<?php
$return_value = ['success'=>1,'data'=>[]];

try{
	$location_id = decryptData($data['locationid']);
	$return_value = $db->getRecords("{$account_db}.view_locations","id",$data,null,"parent_location_id={$location_id}");
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['id'] = encryptData($record['id']);
	}

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);