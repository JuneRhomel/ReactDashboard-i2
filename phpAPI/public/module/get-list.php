<?php
$return_value = ['success' => 1, 'data' => []];
try {
	$view = $data['view'];
	$table = "{$account_db}.{$view}";
	$key = "id";
	$params = $data;
	$order = null;
	$filter = (isset($data['filter']) ? $data['filter'] : null);
	//$debug = false;

	if ($view == "view_service_request") {
		$record_count = "0";

		$sth = $db->prepare("select * from {$account_db}.view_unit_repair where deleted_on=0");
		$sth->execute();
		$unit_repairs = $sth->fetchAll();
		$record_count = count($unit_repairs);
		$result = [];


		foreach ($unit_repairs as $unit_repair) {
			$result[] = [
				'id' => $unit_repair['id'],
				'rec_id' => $unit_repair['rec_id'],
				'requestor_name' => $unit_repair['requestor_name'],
				'unit' => $unit_repair['unit'],
				'description' => $unit_repair['description'],
				'approve' => $unit_repair['approve'],
				'created_on' => $unit_repair['created_on'],
				'sr_type' => $unit_repair['sr_type'],
				'priority_level' => $unit_repair['priority_level']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_gate_pass where deleted_on=0");
		$sth->execute();
		$gate_passes = $sth->fetchAll();
		$record_count += count($gate_passes);

		foreach ($gate_passes as $gate_pass) {
			$result[] = [
				'id' => $gate_pass['id'],
				'rec_id' => $gate_pass['rec_id'],
				'requestor_name' => ($gate_pass['name']) ? $gate_pass['name'] : 0,
				'unit' => $gate_pass['unit'],
				'approve' => $gate_pass['approve'],
				'created_on' => $gate_pass['created_on'],
				'sr_type' => $gate_pass['sr_type']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_visitor_pass where deleted_on=0");
		$sth->execute();
		$visitor_passes = $sth->fetchAll();
		$record_count += count($visitor_passes);

		foreach ($visitor_passes as $visitor_pass) {
			$result[] = [
				'id' => $visitor_pass['id'],
				'rec_id' => $visitor_pass['rec_id'],
				'requestor_name' => $visitor_pass['name'],
				'unit' => $visitor_pass['unit'],
				'approve' => $visitor_pass['approve'],
				'created_on' => $visitor_pass['created_on'],
				'sr_type' => $visitor_pass['sr_type']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_reservation where deleted_on=0");
		$sth->execute();
		$reservations = $sth->fetchAll();
		$record_count += count($reservations);

		foreach ($reservations as $reservation) {
			$result[] = [
				'id' => $reservation['id'],
				'rec_id' => $reservation['rec_id'],
				'requestor_name' => $reservation['name'],
				'unit' => $reservation['unit'],
				'approve' => $reservation['approve'],
				'created_on' => $reservation['created_on'],
				'sr_type' => $reservation['sr_type']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_move_in where deleted_on=0");
		$sth->execute();
		$move_ins = $sth->fetchAll();
		$record_count += count($move_ins);

		foreach ($move_ins as $move_in) {
			$result[] = [
				'id' => $move_in['id'],
				'rec_id' => $move_in['rec_id'],
				'requestor_name' => $move_in['name'],
				'unit' => $move_in['unit'],
				'approve' => $move_in['approve'],
				'created_on' => $move_in['created_on'],
				'sr_type' => $move_in['sr_type']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_move_out where deleted_on=0");
		$sth->execute();
		$move_outs = $sth->fetchAll();
		$record_count += count($move_outs);

		foreach ($move_outs as $move_out) {
			$result[] = [
				'id' => $move_out['id'],
				'rec_id' => $move_out['rec_id'],
				'requestor_name' => $move_out['name'],
				'unit' => $move_out['unit'],
				'approve' => $move_out['approve'],
				'created_on' => $move_out['created_on'],
				'sr_type' => $move_out['sr_type']
			];
		}

		$sth = $db->prepare("select * from {$account_db}.view_work_permit where deleted_on=0");
		$sth->execute();
		$work_permits = $sth->fetchAll();
		$record_count += count($work_permits);

		foreach ($work_permits as $work_permit) {
			$result[] = [
				'id' => $work_permit['id'],
				'rec_id' => $work_permit['rec_id'],
				'requestor_name' => $work_permit['name'],
				'unit' => $work_permit['unit'],
				'approve' => $work_permit['approve'],
				'created_on' => $work_permit['created_on'],
				'sr_type' => $work_permit['sr_type']
			];
		}
		$new_result = [];

		foreach ($result as $res) {
			// echo $res['sr_type'];
			if ($res['sr_type'] == $data['filter']['sr_type']) {
				$new_result[] = $res;
			}
		}

		if ($data['filter']['sr_type'] == 'all' || $data['filter']['sr_type'] == NULL) {
			$new_result = $result;
		}

		$new_filtered_result = [];

		foreach ($new_result as $res) {
			// echo $res['sr_type'];
			if ($res['approve'] == $data['filter']['approve']) {
				$new_filtered_result[] = $res;
			}
		}

		if ($data['filter']['approve'] == 'all' || $data['filter']['approve'] == NULL) {
			$new_filtered_result = $new_result;
		}

		$return_value = [
			'data' => $new_filtered_result,
			'recordsTotal' => $record_count,
			'recordsFiltered' => $record_count,
			'recordpost' => $data
		];
	}
	else if($view == "view_soa") {
		$record_count = "0";

		$sth = $db->prepare("SELECT view_soa.*, tenant.tenant_name FROM {$account_db}.view_soa 
		LEFT JOIN {$account_db}.tenant ON tenant.id = view_soa.tenant_id
		WHERE view_soa.deleted_on = 0");	
		$sth->execute();
		$view_billing_soa = $sth->fetchAll();
		$record_count += count($view_billing_soa);

		foreach ($view_billing_soa as $billing_soa) {
			$result[] = [
				'id' => $billing_soa['id'],
				'rec_id' => $billing_soa['rec_id'],
				'tenent_name' => $billing_soa['tenant_name'],
				'remaining_balance' => $billing_soa['remaining_balance'],
				'amount_due' => $billing_soa['amount_due'],
				'due_month' => $billing_soa['due_month'],
				'total_amount_due' => $billing_soa['total_amount_due']
			];
		}
		$return_value = [
			'data' => $result,
			'recordsTotal' => $record_count,
			'recordsFiltered' => $record_count
		];
	}
	else if ($view == "view_wo_summary") {

		$record_count = "0";

		$sth = $db->prepare("select wo.*,equipments.equipment_name,_users.full_name,service_providers.company from {$account_db}.wo 
		left join {$account_db}.service_providers ON service_providers.id=wo.service_provider_id
		left join {$account_db}.equipments ON equipments.id=wo.equipment_id
		left join {$account_db}._users ON _users.id=wo.created_by
		where wo.deleted_on=0");
		$sth->execute();
		$work_orders = $sth->fetchAll();
		$record_count = count($work_orders);
		$result = [];


		foreach ($work_orders as $work_order) {
			$result[] = [
				'rec_id' => "WO_" . $work_order['id'],
				'created_by_full_name' => $work_order['full_name'],
				'equipment_name' => $work_order['equipment_name'],
				'priority_level' => $work_order['priority_level'],
				'assigned_personnel_id' => $work_order['assigned_personnel_id'],
				'service_provider_name' => $work_order['company'],
				'wo_start_date' => $work_order['wo_start_date'],
				'wo_end_date' => $work_order['wo_end_date'],
				'stage' => $work_order['stage'],
				'amount' => $work_order['amount']
			];
		}

		$sth = $db->prepare("select pm.*,equipments.equipment_name,_users.full_name,service_providers.company from {$account_db}.pm 
		left join {$account_db}.equipments ON equipments.id=pm.equipment_id
		left join {$account_db}._users ON _users.id=pm.created_by
		left join {$account_db}.service_providers ON service_providers.id=pm.service_provider_id
		where pm.deleted_on=0");
		$sth->execute();
		$pms = $sth->fetchAll();
		$record_count += count($pms);

		foreach ($pms as $pm) {
			$result[] = [
				'rec_id' => "PM_" . $pm['id'],
				'created_by_full_name' => $pm['full_name'],
				'equipment_name' => $pm['equipment_name'],
				'priority_level' => $pm['priority_level'],
				'service_provider_name' => $pm['company'],
				'assigned_personnel_id' => 'None',
				'wo_start_date' => $pm['pm_start_date'],
				'stage' => $pm['stage'],
				'amount' => 0
			];
		}

		$sth = $db->prepare("select cm.*,equipments.equipment_name,_users.full_name,service_providers.company from {$account_db}.cm 
		left join {$account_db}.service_providers ON service_providers.id=cm.service_provider_id
		left join {$account_db}.equipments ON equipments.id=cm.equipment_id
		left join {$account_db}._users ON _users.id=cm.created_by
		where cm.deleted_on=0");
		$sth->execute();
		$cms = $sth->fetchAll();
		$record_count += count($cms);

		foreach ($cms as $cm) {
			$result[] = [
				'rec_id' => "CM_" . $cm['id'],
				'created_by_full_name' => $cm['full_name'],
				'equipment_name' => $cm['equipment_name'],
				'priority_level' => $cm['priority_level'],
				'assigned_personnel_id' => $cm['assigned_personnel_id'],
				'service_provider_name' => $cm['company'],
				'wo_start_date' => $cm['cm_start_date'],
				'stage' => $cm['stage'],
				'amount' => $cm['amount']
			];
		}

		$new_result = [];

		foreach ($result as $res) {
			// echo $res['sr_type'];
			if ($data['filter']['stage'] == 'aging') {
				if (in_array($res['stage'], ['work-started', 'acknowledged', 'work-completed', 'property-manager-verification'])) {
					$new_result[] = $res;
				}
			} else {
				if ($res['stage'] == $data['filter']['stage']) {
					$new_result[] = $res;
				}
			}
		}

		if ($data['filter']['stage'] == 'all' || $data['filter']['stage'] == NULL) {
			$new_result = $result;
		}

		$return_value = [
			'data' => $new_result,
			'recordsTotal' => $record_count,
			'recordsFiltered' => $record_count,
		];
	} else if ($view == "view_pdc_tracker") {

		$record_count = "0";

		$sth = $db->prepare("select * from {$account_db}.pdcs 
		where deleted_on=0");
		$sth->execute();
		$pdcs = $sth->fetchAll();
		$record_count = count($pdcs);
		$result = [];


		foreach ($pdcs as $pdc) {
			$result[] = [
				'rec_id' => $pdc['id'],
				'unit' => $pdc['unit'],
				'check_number' => $pdc['check_number'],
				'check_date' => $pdc['check_date'],
				'check_amount' => $pdc['check_amount'],
				'status' => $pdc['status'],
			];
		}

		$return_value = [
			'data' => $result,
			'recordsTotal' => $record_count,
			'recordsFiltered' => $record_count
		];
	} else {
		$return_value = $db->getRecords($table, $key, $params, $order, $filter, $view);
	}

	foreach ($return_value['data'] as $index => $record) {
		$return_value['data'][$index]['id'] = encryptData($record['id']);
		$return_value['data'][$index]['data_id'] = $record['id'];
		if (isset($record['tenant_id']))
			$return_value['data'][$index]['enc_tenant_id'] = encryptData($record['tenant_id']);
		if (isset($record['location_id']))
			$return_value['data'][$index]['enc_loc_id'] = encryptData($record['location_id']);
		if (isset($record['reserved_from']))
			$return_value['data'][$index]['schedule'] = date('M d Y h:i a', $record['reserved_from']) . ' to ' . (date('Y-m-d', $record['reserved_from']) == date('Y-m-d', $record['reserved_to']) ?  date('h:i a', $record['reserved_to']) :  date('M d Y h:i a', $record['reserved_to']));

		if (isset($record['expiration_date'])) {
			if ($record['expiration_date'] != 'N/A') {
				$remaining_days = compute_days_to_expire($record['expiration_date']);
				$return_value['data'][$index]['remaining_days_to_expire'] = $remaining_days;
			} else {
				$return_value['data'][$index]['remaining_days_to_expire'] = 0;
			}
		}

		if (isset($record['equipment_id'])) {
			$sql = "select * from {$account_db}.equipments WHERE id={$record['equipment_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$equipment = $sth->fetch()['equipment_name'];
			$return_value['data'][$index]['equipment_name'] = $equipment;
		}
		if (isset($record['service_provider_id'])) {
			$sql = "select * from {$account_db}.service_providers WHERE id={$record['service_provider_id']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$service_providers = $sth->fetch()['company'];
			$return_value['data'][$index]['service_providers_name'] = $service_providers;
		}
		if (isset($record['created_by'])) {
			$sql = "select * from {$account_db}._users WHERE id={$record['created_by']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$equipment = $sth->fetch()['full_name'];
			$return_value['data'][$index]['created_by_full_name'] = $equipment;
		}
		if (isset($record['tenant'])) {
			$sql = "select * from {$account_db}.tenant WHERE id={$record['tenant']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$tenant = $sth->fetch()['owner_name'];
			if ($record['tenant'] == 'Common Area')
				$return_value['data'][$index]['tenant_name'] = 'Common Area';
			else
				$return_value['data'][$index]['tenant_name'] = $tenant;
		}
		if (isset($record['tenant'])) {
			$sql = "select * from {$account_db}.tenant WHERE id={$record['tenant']}";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$tenant = $sth->fetch()['owner_name'];
			if ($record['tenant'] == 'Common Area')
				$return_value['data'][$index]['tenant_name'] = 'Common Area';
			else
				$return_value['data'][$index]['tenant_name'] = $tenant;
		}
		if ($view == 'view_service_request') {
			// var_dump($return_value);
			if (isset($record['requestor_name'])) {
				$sql = "select * from {$account_db}.tenant WHERE id={$record['requestor_name']}";
				$sth = $db->prepare($sql);
				$sth->execute($data);
				$tenant_name = $sth->fetch()['owner_name'];
				$return_value['data'][$index]['tenant_name'] = $tenant_name;
			}
		}
		if ($view == 'view_billing_and_rates') {
			$rate = $record['bill_amount'] / $record['consumption'];
			$return_value['data'][$index]['rate'] = number_format($rate, 2);
		}
	}
} catch (Exception $e) {
	$return_value = ['success' => 0, 'description' => $e->getMessage(), 'sql' => $sql];
}
echo json_encode($return_value);
