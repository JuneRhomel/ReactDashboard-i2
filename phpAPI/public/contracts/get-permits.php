<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	
	$return_value = $db->getRecord("{$account_db}.view_permits",['id'=> decryptData($data['permit_id'])]);
	
	$return_value['id'] = encryptData($return_value['id']);
	$return_value['data']= $data;

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);