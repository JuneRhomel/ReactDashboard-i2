<?php
$return_value = ['success'=>1,'description'=>'Gate Pass updated!'];
try{
	$gatepass_id = decryptData($data['gatepass_id']);
	$status = $data['status'];

	$sth = $db->prepare("update {$account_db}.gatepasses set status=? where id=?");
	$sth->execute([$status,$gatepass_id]);
	
	$return_value = ['success'=>1,'description'=>"Gate Pass updated as {$status}"];

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);