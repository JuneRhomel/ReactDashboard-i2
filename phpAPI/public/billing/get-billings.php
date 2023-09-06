<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	unset($data['billing_number']);
	$return_value = $db->getRecords("{$account_db}.view_billings","id",$data);
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['billing_number'] = $record['id'];
		$return_value['data'][$index]['id'] = encryptData($record['id']);
	}
}catch(PDOException $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);