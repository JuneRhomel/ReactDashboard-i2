<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$return_value = $db->getRecords("{$account_db}.view_servicerequests","id",$data,null,(isset($data['filter']) ? $data['filter'] : null));
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['id'] = encryptData($record['id']);

		$attachments = $db->prepare("select attachment_url,filename from {$account_db}.attachments where reference_table='servicerequests' and reference_id=:reference_id");
		$attachments->execute(['reference_id'=>$record['id']]);

		$return_value[$index]['attachments'] = $attachments->fetchAll();
	}

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);