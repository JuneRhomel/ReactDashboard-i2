
<?php
$return_value = [];
try{
	$records = $db->prepare("select tenant_registrations.*,locations.location_name from {$account_db}.tenant_registrations,{$account_db}.locations  where owner_id=? and tenant_registrations.location_id=locations.id");
	$records->execute([$user_id]);
	$return_value = $records->fetchAll();
	
}catch(Exception $e){
	$return_value[$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);