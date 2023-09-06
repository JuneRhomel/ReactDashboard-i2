<?php
$return_value = ['success'=>1,'data'=>[]];

try{
	$sth = $db->prepare("select stages.id as stage_id,stages.* from {$account_db}.stages where deleted_on=0");
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