<?php
$return_value = ['success'=>1,'data'=>[]];

try{
	//$return_value = $db->getRecords("{$account_db}.rates","id",$data);
	$sth = $db->prepare("select rates.id as rate_id,rates.* from {$account_db}.rates where deleted_on=0");
	$sth->execute();	
	$return_value['data'] = $sth->fetchAll();
	$return_value['recordsFiltered'] = $return_value['recordsTotal'] = $sth->rowCount();
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['id'] = encryptData($record['id']);
	}

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);