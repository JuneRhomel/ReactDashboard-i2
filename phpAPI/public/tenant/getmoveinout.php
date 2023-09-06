
<?php
$return_value = [];
try{
	$records = $db->prepare("select moveinout.*,locations.location_name from {$account_db}.moveinout left join {$account_db}.locations on locations.id=moveinout.location_id where owner_id=? ");
	$records->execute([$user_id]);
	$return_value = $records->fetchAll();
	
	foreach($return_value as $index=>$record)
	{
		$attachments = $db->prepare("select attachment_url from {$account_db}.attachments where reference_table='moveinout' and reference_id=:reference_id");
		$attachments->execute(['reference_id'=>$record['id']]);

		$return_value[$index]['attachments'] = $attachments->fetchAll();
	}

}catch(Exception $e){
	$return_value[$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);