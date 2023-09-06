<?php
$return_value = [];
try{
	$punchlist_id = decryptData($data['punchlist_id']);
	$records = $db->prepare("select * from {$account_db}.view_tenant_punchlists where id=?");
	
	$records->execute([$punchlist_id]);
	
	$return_value = $records->fetch();
	$return_value['punchlist_id'] = $return_value['id'];
	$return_value['id'] = encryptData($return_value['id']);
	$return_value['enc_tenant_id'] = encryptData($return_value['tenant_id']);
	$return_value['enc_loc_id'] = encryptData($return_value['location_id']);

	$attachments = $db->prepare("select attachment_url,filename from {$account_db}.attachments where reference_table='punchlists' and reference_id=:reference_id");
	$attachments->execute(['reference_id'=>$punchlist_id]);

	$return_value['attachments'] = $attachments->fetchAll();
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);