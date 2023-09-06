<?php
$return_value = ['success'=>1,'data'=>[]];
// echo '12312312';
try{
	
	$view = $data['view'];

	$table = "{$account_db}.{$view}"; 
	$key = "id";
 	$params = $data;
	$order = null;
	$filter = (isset($data['filter']) ? $data['filter'] : null);
	$debug = true;
	// $filter['month'] =(isset($filter['month'] ))?$filter['month'] : date('m');

	// $filter['year'] =(isset($filter['year'] ))?$filter['year'] : date('Y');


	
	$return_value = $db->getRecords($table,$key,$params,$order,$filter,$view);


	// print_R($return_value);
	
	foreach($return_value['data'] as $index=>$record)
	{
		$return_value['data'][$index]['id'] = encryptData($record['id']);
		$return_value['data'][$index]['data_id'] = $record['id'];
		// var_dump($record['id']);
		if (isset($record['tenant_id']))
			$return_value['data'][$index]['enc_tenant_id'] = encryptData($record['tenant_id']);
		if (isset($record['location_id']))
			$return_value['data'][$index]['enc_loc_id'] = encryptData($record['location_id']);
		if (isset($record['reserved_from']))		
			$return_value['data'][$index]['schedule'] = date('M d Y h:i a',$record['reserved_from']) . ' to ' . (date('Y-m-d',$record['reserved_from']) == date('Y-m-d',$record['reserved_to']) ?  date('h:i a',$record['reserved_to']) :  date('M d Y h:i a',$record['reserved_to']));
		
		if (isset($record['expiration_date'])){
			if($record['expiration_date'] != 'N/A'){
				$remaining_days = compute_days_to_expire($record['expiration_date']);
				$return_value['data'][$index]['remaining_days_to_expire'] = $remaining_days;
			}
			else{
				$return_value['data'][$index]['remaining_days_to_expire'] = 0;
			}
		}

		if (isset($record['equipment_id'])){
			$sql = "select * from {$account_db}.equipments WHERE id={$record['equipment_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$equipment = $sth->fetch()['equipment_name'];
			$return_value['data'][$index]['equipment_name'] = $equipment;
		}
		if (isset($record['service_provider_id'])){
			$sql = "select * from {$account_db}.service_providers WHERE id={$record['service_provider_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$service_providers = $sth->fetch()['company'];
			$return_value['data'][$index]['service_providers_name'] = $service_providers;
		}
		if (isset($record['created_by'])){
			$sql = "select * from {$account_db}._users WHERE id={$record['created_by']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$equipment = $sth->fetch()['full_name'];
			$return_value['data'][$index]['created_by_full_name'] = $equipment;
		}
		if (isset($record['tenant_id'])){
			$sql = "select * from {$account_db}.tenant WHERE id={$record['tenant_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$tenant = $sth->fetch()['owner_name'];
			if($record['tenant'] == 'Common Area')
				$return_value['data'][$index]['tenant_name'] = 'Common Area';
			else
				$return_value['data'][$index]['tenant_name'] = $tenant;
		}
		if (isset($record['tenant'])){
			$sql = "select * from {$account_db}.tenant WHERE id='{$record['tenant']}'";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$tenant = $sth->fetch()['owner_name'];
			if($record['tenant'] == 'Common Area')
				$return_value['data'][$index]['tenant_name'] = 'Common Area';
			else
				$return_value['data'][$index]['tenant_name'] = $tenant;
		}
		if($view == 'view_billing_and_rates'){
			$rate = $record['bill_amount'] / $record['consumption'];
			$return_value['data'][$index]['rate'] = number_format($rate,2);
		}
		if($view == 'view_bills'){
			$sql = "select * from {$account_db}.tenant WHERE id={$record['tenant_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$area = $sth->fetch()['unit_area'];
			
			$total_amount = $return_value['data'][$index]['association_dues'] + $return_value['data'][$index]['electricity'] + $return_value['data'][$index]['water'];
			$return_value['data'][$index]['total_amount_due'] = number_format($total_amount,2);
			$return_value['data'][$index]['association_dues'] = number_format($return_value['data'][$index]['association_dues'],2); 
			$return_value['data'][$index]['electricity'] = number_format($return_value['data'][$index]['electricity'],2) ;
			$return_value['data'][$index]['water'] = number_format($return_value['data'][$index]['water'],2) ;
			$return_value['data'][$index]['area'] = $area;
		}
		if($view == 'view_soa'){
			$id = $record['id'];
			$month = $record['due_mont'];
			$year = $record['due_mont'];

			$sql = "select * from {$account_db}.soa_items WHERE soa_id={$id} AND item_name = 'unpaid_balance' order by id desc";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$balance_from_previous = $sth->fetch()['item_amount'];
			$return_value['data'][$index]['balance_from_previous'] = $balance_from_previous ?? 0;
			$return_value['data'][$index]['sql'] = $sql;
			$return_value['data'][$index]['balance_from_previous_formated'] = number_format($balance_from_previous,2) ?? 0;
			$return_value['data'][$index]['remaining_balance_formated'] = number_format($record['remaining_balance'],2,'.',',') ?? 0;
			$return_value['data'][$index]['sql'] = $sql;
		}
	}
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e,'sql'=>$sql];
}
echo json_encode($return_value);