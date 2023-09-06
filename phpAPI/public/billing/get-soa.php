<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$return_value = $db->getRecord("{$account_db}.view_billings",[ 'id'=> decryptData($data['billingid']) ]);
	$return_value['billing_number'] = $return_value['id'];
	$return_value['id'] = encryptData($return_value['id']);


	// get past due
	$billing = $db->getRecord("{$account_db}.view_billings",[ 'tenant_id'=>$return_value['tenant_id'],'billing_date'=>$return_value['billing_date'],'billing_type'=>'Past Due' ]);	
	$return_value['pastdue'] = 0;
	if ($billing)
		$return_value['pastdue'] = $billing['amount'];

	// get past due
	$billing = $db->getRecord("{$account_db}.view_billings",[ 'tenant_id'=>$return_value['tenant_id'],'billing_date'=>$return_value['billing_date'],'billing_type'=>'Association Dues' ]);	
	$return_value['assodues'] = 0;
	if ($billing)
		$return_value['assodues'] = $billing['amount'];

	// get interest
	$billing = $db->getRecord("{$account_db}.view_billings",[ 'tenant_id'=>$return_value['tenant_id'],'billing_date'=>$return_value['billing_date'],'billing_type'=>'Interest' ]);	
	$return_value['interest'] = 0;
	if ($billing)
		$return_value['interest'] = $billing['amount'];
	
	// get location info
	$location = $db->getRecord("{$account_db}.view_locations",[ 'id'=>$return_value['location_id'] ]);	
	$return_value['floor'] = $location['parent_location_name'];
	$return_value['unitarea'] = $location['floor_area'];
	$return_value['type'] = $location['location_use'];

	// get asso dues rate
	$rate = $db->getRecord("{$account_db}.rates",[ 'rate_code'=>'AD' ]);	
	$return_value['rate'] = $rate['rate_value'];

	//$return_value = $location;

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);