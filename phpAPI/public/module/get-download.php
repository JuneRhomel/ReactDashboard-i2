<?php
$fields = $return_value = [];
foreach( json_decode($data['fields']) as $key=>$field) {
	$fields[] = $field;
}
try{
	if($data['view'] == "view_service_request"){
		$record_count="0";

		$sth = $db->prepare("select * from {$account_db}.view_unit_repair where deleted_on=0");
		$sth->execute();
		$unit_repairs = $sth->fetchAll();
		$record_count = count($unit_repairs);
		$result = [];
		

		foreach($unit_repairs as $unit_repair)
		{
			$result[] = [
				'id'=>$unit_repair['id'],
				'requestor_name'=>$unit_repair['requestor_name'],
				'unit'=>$unit_repair['unit'],
				'description'=>$unit_repair['description']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_gate_pass where deleted_on=0");
		$sth->execute();
		$gate_passes = $sth->fetchAll();
		$record_count += count($gate_passes);

		foreach($gate_passes as $gate_pass)
		{
			$result[] = [
				'id'=>$gate_pass['id'],
				'requestor_name'=> ($gate_pass['name']) ? $gate_pass['name'] : 0,
				'unit'=>$gate_pass['unit']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_visitor_pass where deleted_on=0");
		$sth->execute();
		$visitor_passes = $sth->fetchAll();
		$record_count += count($visitor_passes);

		foreach($visitor_passes as $visitor_pass)
		{
			$result[] = [
				'id'=>$visitor_pass['id'],
				'requestor_name'=>$visitor_pass['name'],
				'unit'=>$visitor_pass['unit']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_reservation where deleted_on=0");
		$sth->execute();
		$reservations = $sth->fetchAll();
		$record_count += count($reservations);

		foreach($reservations as $reservation)
		{
			$result[] = [
				'id'=>$reservation['id'],
				'requestor_name'=>$reservation['name'],
				'unit'=>$reservation['unit']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_move_in where deleted_on=0");
		$sth->execute();
		$move_ins = $sth->fetchAll();
		$record_count += count($move_ins);

		foreach($move_ins as $move_in)
		{
			$result[] = [
				'id'=>$move_in['id'],
				'requestor_name'=>$move_in['name'],
				'unit'=>$move_in['unit']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_move_out where deleted_on=0");
		$sth->execute();
		$move_outs = $sth->fetchAll();
		$record_count += count($move_outs);

		foreach($move_outs as $move_out)
		{
			$result[] = [
				'id'=>$move_out['id'],
				'requestor_name'=>$move_out['name'],
				'unit'=>$move_out['unit']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_work_permit where deleted_on=0");
		$sth->execute();
		$work_permits = $sth->fetchAll();
		$record_count += count($work_permits);

		foreach($work_permits as $work_permit)
		{
			$result[] = [
				'id'=>$work_permit['id'],
				'requestor_name'=>$work_permit['name'],
				'unit'=>$work_permit['unit']
			];
		}
		$new_result = [];

		foreach($result as $res){
			// echo $res['sr_type'];
			if($res['sr_type'] == $data['filter']['sr_type']){
				$new_result[] = $res; 
			}
		}
		
		if($data['filter']['sr_type'] == 'all'|| $data['filter']['sr_type'] == NULL){
			$new_result = $result;
		}

		$new_filtered_result = [];
		
		foreach($new_result as $res){
			// echo $res['sr_type'];
			if($res['approve'] == $data['filter']['approve']){
				$new_filtered_result[] = $res; 
			}
		}

		if($data['filter']['approve'] == NULL){
			$new_filtered_result = $new_result;
		}

		$return_value = $new_filtered_result;
		
	}else if($data['view'] == "tenant"){
		if($data['status'] == 0){
			$records = $db->prepare("select ".implode(",",$fields)." from {$account_db}.".$data['view']." WHERE status='disapproved' order by id");
			$records->execute();
			
			$return_value = $records->fetchAll();
		}else{
			$records = $db->prepare("select ".implode(",",$fields)." from {$account_db}.".$data['view']." WHERE status='approved' order by id");
			$records->execute();
			
			$return_value = $records->fetchAll();
		}
	}else{
		if($data['id']){
			$records = $db->prepare("select ".implode(",",$fields)." from {$account_db}.".$data['view']." WHERE id=".decryptData($data['id'])." order by id");
			$records->execute();
			
			$return_value = $records->fetchAll();
		}else{
			$records = $db->prepare("select ".implode(",",$fields)." from {$account_db}.".$data['view']." order by id");
			$records->execute();
			
			$return_value = $records->fetchAll();
		}
	}

	foreach($return_value as $index=>$record)
	{
		if (isset($record['equipment_id'])){
			$sql = "select * from {$account_db}.equipments WHERE id={$record['equipment_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$equipment = $sth->fetch()['equipment_name'];
			$return_value[$index]['equipment_id'] = $equipment;
		}
		if (isset($record['service_provider_id'])){
			$sql = "select * from {$account_db}.service_providers WHERE id={$record['service_provider_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$service_providers = $sth->fetch()['company'];
			$return_value[$index]['service_provider_id'] = $service_providers;
		}
		if (isset($record['assigned_personnel_id'])){
			$sql = "select * from {$account_db}.building_personnel WHERE id={$record['assigned_personnel_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$providers = $sth->fetch()['employee_name'];
			$return_value[$index]['assigned_personnel_id'] = $providers;
		}
		if (isset($record['requestor_name'])){
			$sql = "select * from {$account_db}.tenant WHERE id={$record['requestor_name']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$tenant_name = $sth->fetch()['owner_name'];
			$return_value[$index]['requestor_name'] = $tenant_name;
		}
		if (isset($record['tenant'])){
			if($record['tenant'] != 'Common Area'){
				$sql = "select * from {$account_db}.tenant WHERE id={$record['tenant']}";
				$sth = $db->prepare($sql);
				$sth->execute($data);
				$tenant = $sth->fetch()['owner_name'];
				$return_value[$index]['tenant'] = $tenant;
			}else{
				$return_value[$index]['tenant'] = 'Common Area';
			}
		}
	}
	
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);