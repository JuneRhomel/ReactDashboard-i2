<?php
$return_value = ['success'=>1,'data'=>$data];

try{
    // print_r($data);
    
    $view = $data['view'];
    $table = "{$account_db}.{$view}"; 
    
    $filter_query = '';
    $filter_vals = [];
    if($view=="view_bills_report"){
        $sql = "select *, sum(association_dues) as assoc,sum(electricity) as elec,sum(water) as water from {$account_db}.view_bills group by month, year";
        
        $records_sth = $db->prepare($sql);
        $records_sth->execute();
        $records = $records_sth->fetchAll();
        $return_value = $records;

    }else{
        if($data['filters']){
            $where = [];
            foreach($data['filters'] as $filter_keys => $filter_values){
                $where[] = "{$filter_keys} = ?";
                $filter_vals[] = $filter_values;
            }
            $filter_query = "and " . implode(" and ",$where);
            
        }
        
        $sql = "select * from {$table} WHERE deleted_on=0 " . $filter_query;
        
        $records_sth = $db->prepare($sql);
        $records_sth->execute($filter_vals);
        $records = $records_sth->fetchAll();
        $return_value = $records;
        $term = $data['term'];
    }

    if($data['auto_complete']){
        $return_value = [];
        if($view == 'view_equipments'){
            
            $condition = ($data['filter']!="") ? " and equipment_type='".$data['filter']."'" : "";
            $sth = $db->prepare("select id as value, equipment_name as label from {$account_db}.equipments where equipment_name like ? $condition");
            $sth->execute(["%" . $term . "%"]);
            $return_value = $sth->fetchAll();
        }
        else if($view == 'service_providers_view'){
            
            $condition = ($data['filter']!="") ? " and type='".$data['filter']."'" : "";

            $sth = $db->prepare("select id as value, company as label from {$account_db}.{$data['view']} where company like ? $condition");
            $sth->execute(["%" . $term . "%"]);
            $return_value = $sth->fetchAll();
        }
        else if($view == 'view_tenant'){
            
            $condition = ($data['filter']!="") ? " and type='".$data['filter']."'" : "";

            $sth = $db->prepare("select id as value, owner_name as label from {$account_db}.{$data['view']} where owner_name like ? $condition");
            $sth->execute(["%" . $term . "%"]);
            $return_value = $sth->fetchAll();
        }
    }
    
    foreach($return_value as $index=>$record)
	{
		$return_value[$index]['id'] = encryptData($record['id']);
		if (isset($record['tenant_id']))
			$return_value[$index]['enc_tenant_id'] = encryptData($record['tenant_id']);
		if (isset($record['location_id']))
			$return_value[$index]['enc_loc_id'] = encryptData($record['location_id']);
		if (isset($record['reserved_from']))		
			$return_value[$index]['schedule'] = date('M d Y h:i a',$record['reserved_from']) . ' to ' . (date('Y-m-d',$record['reserved_from']) == date('Y-m-d',$record['reserved_to']) ?  date('h:i a',$record['reserved_to']) :  date('M d Y h:i a',$record['reserved_to']));
		
		if (isset($record['expiration_date'])){
			if($record['expiration_date'] != 'N/A'){
				$remaining_days = compute_days_to_expire($record['expiration_date']);
				$return_value[$index]['remaining_days_to_expire'] = $remaining_days;
			}
			else{
				$return_value[$index]['remaining_days_to_expire'] = 0;
			}
		}

		if (isset($record['equipment_id'])){
			$sql = "select * from {$account_db}.equipments WHERE id={$record['equipment_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$equipment = $sth->fetch()['equipment_name'];
			$return_value[$index]['equipment_name'] = $equipment;
		}
		if (isset($record['service_provider_id'])){
			$sql = "select * from {$account_db}.service_providers WHERE id={$record['service_provider_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$service_providers = $sth->fetch()['company'];
			$return_value[$index]['service_providers_name'] = $service_providers;
		}
		if (isset($record['created_by'])){
			$sql = "select * from {$account_db}._users WHERE id={$record['created_by']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$equipment = $sth->fetch()['full_name'];
			$return_value[$index]['created_by_full_name'] = $equipment;
		}
		if (isset($record['tenant'])){
			$sql = "select * from {$account_db}.tenant WHERE id={$record['tenant']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$tenant = $sth->fetch()['owner_name'];
			if($record['tenant'] == 'Common Area')
				$return_value[$index]['tenant_name'] = 'Common Area';
			else
				$return_value[$index]['tenant_name'] = $tenant;
        }
        if($view == 'view_meters'){
            $sql2 = "select * from {$account_db}.meter_readings WHERE meter_id= :meter_id ";
            $record_sth2 = $db->prepare($sql2);
            $record_sth2->execute(['meter_id'=>$record['id']]);
            $meter_records = $record_sth2->fetchAll();
            $return_value[$index]['meter_readings'] = $meter_records;

        }
	}

    // $return_value['sql'] = $sql;

	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);