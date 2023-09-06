<?php
$return_value = ['success'=>1,'description'=>'PDC updated!'];
try{
	$pdc_id = decryptData($data['pdc_id']);
	$status = $data['status'];

	$sth = $db->prepare("update {$account_db}.pdcs set status=? where id=?");
	$sth->execute([$status,$pdc_id]);
	
	$return_value = ['success'=>1,'description'=>"PDC updated as {$status}"];

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);