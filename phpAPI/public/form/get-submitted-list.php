<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$return_value = $db->getRecords("{$account_db}.view_forms_uploaded","id",$data,null,(isset($data['filter']) ? $data['filter'] : null));
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['id'] = encryptData($record['id']);
	}
}catch(PDOException $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);