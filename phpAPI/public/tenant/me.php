<?php
$return_value = [];
$unit_id = $data['unit_id'];
try{
	$sth = $db->prepare("select
	tenant.id,
	tenant.tenant_name,
	tenant.email,
	tenant.mobile,
	tenant.email2,
	tenant.id_url,
	tenant.notify_email,
	tenant.notify_viber,
	tenant.allow_push,
	locations.location_name,locations.floor_area,tenant_locations.turnover_date from {$account_db}.tenants 
	left join {$account_db}.tenant_locations on tenant_locations.tenant_id=tenants.id 
	left join {$account_db}.locations on tenant_locations.location_id=locations.id 
	where tenant_locations.location_id=? and tenants.id=?");
	$sth->execute([$unit_id,$user_id]);
	$return_value = $sth->fetch();

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value,JSON_NUMERIC_CHECK);	