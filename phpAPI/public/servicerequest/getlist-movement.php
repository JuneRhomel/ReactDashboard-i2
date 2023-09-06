<?php
$return_value = [];
try{
	$offset = $data['offset'] ?? 0;
	$limit  = $data['limit'] ?? 5;
	$records = $db->prepare("select * from {$account_db}.view_tenant_movements where tenant_id=? limit {$offset},{$limit}");
	$records->execute([$user_id]);
	$return_value = $records->fetchAll();

	foreach($return_value as $index=>$record)
	{
		// $attachments = $db->prepare("select attachment_url,filename from {$account_db}.attachments where reference_table='servicerequests' and reference_id=:reference_id");
		// $attachments->execute(['reference_id'=>$record['id']]);

		$return_value[$index]['record_id'] = $record['id'];
		$return_value[$index]['id'] = encryptData($record['id']);
		// $return_value[$index]['attachments'] = $attachments->fetchAll();
	}
	
}catch(Exception $e){
	$return_value[$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);