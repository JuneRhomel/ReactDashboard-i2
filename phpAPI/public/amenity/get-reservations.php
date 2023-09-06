<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$return_value = $db->getRecords("{$account_db}.view_reservations","id",$data,null,(isset($data['filter']) ? $data['filter'] : null));
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['schedule'] = date('M d Y h:i a',$record['reserved_from']) . ' to ' . (date('Y-m-d',$record['reserved_from']) == date('Y-m-d',$record['reserved_to']) ?  date('h:i a',$record['reserved_to']) :  date('M d Y h:i a',$record['reserved_to']));
		$return_value['data'][$index]['id'] = encryptData($record['id']);
	}

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);