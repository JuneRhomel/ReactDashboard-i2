<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$view = $data['view'];
	$data['id'] = is_numeric($data['id']) ? encryptData($data['id']) : $data['id'];
	$return_value = $db->getRecord("{$account_db}.{$view}",['id'=>decryptData($data['id'])]);

	if (isset($return_value['resident_id']))
		$return_value['data']['enc_resident_id'] = encryptData($return_value['resident_id']);
	if (isset($return_value['location_id']))
		$return_value['data']['enc_loc_id'] = encryptData($returned_value['location_id']);
	if (isset($return_value['reserved_from']))		
		$return_value['data']['schedule'] = date('M d Y h:i a',$returned_value['reserved_from']) . ' to ' . (date('Y-m-d',$returned_value['reserved_from']) == date('Y-m-d',$returned_value['reserved_to']) ?  date('h:i a',$returned_value['reserved_to']) :  date('M d Y h:i a',$returned_value['reserved_to']));
	$return_value['accountcode'] = $accountcode;
	//$return_value['id'] = encryptData($return_value['id']);
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);