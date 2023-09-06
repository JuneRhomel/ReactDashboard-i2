<?php
$return_value = ['success'=>1,'description'=>'Visitor approved!'];
try{
	$visitor_id = decryptData($data['visitor_id']);

	$sth = $db->prepare("update {$account_db}.visitors set status='Approved' where id=?");
	$sth->execute([$visitor_id]);
	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);