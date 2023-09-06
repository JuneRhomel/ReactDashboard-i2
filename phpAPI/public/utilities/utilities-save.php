<?php
$return_value = ['success' => 1, 'data' => []];
$sql_test = '';
try {
	// print_r($data);
	if ($data['repeat_notif'] == 'on') {
		$rr = repeat_record($data, $db, $account_db, $user_token);
		// print_r($rr);
		$return_value = ['success' => 1, 'description' => 'Record saved.', 'id' => encryptData($id)];
		echo json_encode($return_value);
		exit();
	}
	unset($data['repeat_notif']);
	// print_r($data);
	// exit();
	$table =  $data['table'];
	$view_table =  $data['view_table'] ?? null;
	unset($data['stage_table']);
	$update_table =  $data['update_table'] ?? null;
	$id = null ?? decryptData($data['id']);
	$id = decryptData($data['id']);
	unset($data['table']);
	unset($data['update_table']);
	unset($data['view_table']);
	unset($data['id']);
	$files = $data['file'];
	unset($data['file']);
	//singledata
	$singledata = $data['single_data_only'];
	unset($data['single_data_only']);
	// print_r($data);
	// exit();

	if ($id) {
		$fields = [];
		foreach (array_keys($data) as $field) {
			$fields[] = "{$field}=:{$field}";
		}
		$sth = $db->prepare("update {$account_db}.{$table} set " . implode(",", $fields) . " where id={$id}");
		$sth->execute($data);

		if ($view_table != null) {

			$fields = [];
			foreach (array_keys($data) as $field) {
				$fields[] = "{$field}=:{$field}";
			}
			if ($view_table == "building_personnel_view") {
				$sth = $db->prepare("update {$account_db}.{$view_table} set " . implode(",", $fields) . " where rec_id={$id}");
				$sth->execute($data);
			} else if ($view_table == "service_providers_view") {
				$sth = $db->prepare("update {$account_db}.{$view_table} set " . implode(",", $fields) . " where rec_id={$id}");
				$sth->execute($data);
			} else {
				$sth = $db->prepare("update {$account_db}.{$view_table} set " . implode(",", $fields) . " where rec_id={$id}");
				$sth->execute($data);
			}
		}

		if ($update_table != null) {

			// $update_data['rec_id'] = $id;
			$update_data = [];
			$update_data['created_by'] = $user_token['user_id'];
			$update_data['created_on'] = time();
			if ($update_table == 'pm_updates' || $update_table == 'cm_updates' || $update_table == 'wo_updates') {
				$update_data['type'] = 'comment';
				$update_data['comment'] = 'created';
			}
			$fields = array_keys($update_data);

			$sql = "insert {$account_db}.{$update_table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";
			$sth = $db->prepare($sql);
			$sth->execute($update_data);
		}
	} else {
		if ($singledata == 'true' && $table == 'billing_and_rates') {
			$sth = $db->prepare("update {$account_db}.{$table} set deleted_on='1' WHERE months={$data['months']} and year={$data['year']} and utility_type='{$data['utility_type']}'");
			$sth->execute();

			$sth = $db->prepare("update {$account_db}.{$view_table} set deleted_on='1' WHERE months={$data['months']} and year={$data['year']} and utility_type='{$data['utility_type']}'");
			$sth->execute();
		}
		$data['created_by'] = $user_token['user_id'];
		$data['created_on'] = time();

		$fields = array_keys($data);
			// unset($data['id']);
			$sql_test =  $sql = "insert {$account_db}.{$table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";
			$sth = $db->prepare($sql);
			$sth->execute($data);
			$id = $db->lastInsertId();
		

		if ($view_table != null) {
			$data['rec_id'] = $id;
			$data['created_by'] = $user_token['user_id'];
			$data['created_on'] = time();

			$fields = array_keys($data);
			$sth = $db->prepare("insert {$account_db}.{$view_table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")");
			$sth->execute($data);
		}

		if ($update_table != null) {
			$update_data = [];
			$update_data['rec_id'] = $id;
			$update_data['created_by'] = $user_token['user_id'];
			$update_data['created_on'] = time();

			if ($update_table == 'pm_updates' || $update_table == 'cm_updates' || $update_table == 'wo_updates' || $update_table == 'billing_and_rate_updates') {
				$update_data['type'] = 'comment';
				$update_data['comment'] = 'created';
				$update_data['description'] = 'created';
			}
			$fields = array_keys($update_data);

			$sql = "insert {$account_db}.{$update_table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";
			$sth = $db->prepare($sql);
			$sth->execute($update_data);

			$update_data = [];
			$update_data['rec_id'] = $id;
			$update_data['created_by'] = $user_token['user_id'];
			$update_data['created_on'] = time();

			if ($update_table == 'pm_updates' || $update_table == 'cm_updates' || $update_table == 'wo_updates' || $update_table == 'billing_and_rate_updates') {
				$update_data['type'] = 'stage';
				$update_data['stage'] = 'open';
				$update_data['comment'] = 'open';
				$update_data['description'] = 'open';
				$update_data['rank'] = '1';
			}
			$fields = array_keys($update_data);

			$sql = "insert {$account_db}.{$update_table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";
			$sth = $db->prepare($sql);
			$sth->execute($update_data);
		}
	}

	$return_value = ['success' => 1, 'description' => 'Record saved.', 'id' => $data];
} catch (Exception $e) {
	$return_value = ['success' => 0, 'description' => $e->getMessage(), 'sql_test' => $sql_test];
}
echo json_encode($return_value);


function repeat_record($data, $db, $account_db, $user_token)
{
	// Repeat

	$saved_data = 1;
	try {
		$dates = [];
		$start_month = 1;

		if (strtotime($data['pm_start_date'] . " " . $data['pm_start_time']) > strtotime(date('Y-m-d h:i')))
			$start_month = 0;

		$ctr = 1;

		if ($data['frequency'] == 'monthly')
			$ctr = 1;
		if ($data['frequency'] == 'quarterly')
			$ctr = 3;
		if ($data['frequency'] == 'semi-annual')
			$ctr = 6;
		if ($data['frequency'] == 'annual')
			$ctr = 12;

		$monts_to_display = [];

		//Loop the months
		for ($m = $start_month; $m <= 12; $m = $m + $ctr) {

			$month = date('M', strtotime("+{$m} months", strtotime($data['pm_start_date'] . " " . $data['pm_start_time'])));
			$fmonth = date('F', strtotime("+{$m} months", strtotime($data['pm_start_date'] . " " . $data['pm_start_time'])));
			array_push($monts_to_display, $fmonth);


			$active_start_date_orig_format = date('Y-m-d', strtotime("+{$m} months", strtotime($data['pm_start_date'] . " " . $data['pm_start_time'])));
			$day = date('D', strtotime($active_start_date_orig_format));
			$notify = date('Y-m-d', strtotime("-{$data['notify_days_before_next_schedule']} days", strtotime($active_start_date_orig_format)));

			$active_start_date = date('Y-m-d h:i:s', strtotime("+{$m} months", strtotime($data['pm_start_date'] . " " . $data['pm_start_time'])));;

			$active_end_date = date('Y-m-d h:i:s', strtotime("+{$m} months", strtotime($data['pm_end_date'] . " " . $data['pm_end_time'])));
			array_push($dates, [
				'day' => $day,
				'week_number' => weekOfMonth($active_start_date_orig_format),
				'starts' => $active_start_date,
				'ends' => $active_end_date,
				'notify' => $notify
			]);
		}

		$counter = 1;
		$return_values = [];
		$table =  $data['table'];
		$view_table =  $data['view_table'] ?? null;
		unset($data['stage_table']);
		$update_table =  $data['update_table'] ?? null;
		$id = null ?? decryptData($data['id']);
		$id = decryptData($data['id']);
		unset($data['table']);
		unset($data['update_table']);
		unset($data['view_table']);
		unset($data['id']);
		unset($data['file']);
		$parent = 0;
		foreach ($dates as $date) {

			$saved_data++;
			$data['pm_start_date'] = $date['starts'];
			$data['pm_end_date'] = $date['ends'];

			$data['created_by'] = $user_token['user_id'];
			$data['created_on'] = time();
			$data['parent'] = $parent;
			$fields = array_keys($data);
			$sql = "insert {$account_db}.{$table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";

			$sth = $db->prepare($sql);
			$sth->execute($data);
			$return_values[$counter]['insert_pm'] = $sth;
			$return_values[$counter]['insert_pm_data'] = $data;
			$id = $db->lastInsertId();
			if ($counter == 1) {
				$parent = $id;
			}
			if ($view_table != null) {
				$view_data = $data;
				$view_data['rec_id'] = $id;
				$view_data['created_by'] = $user_token['user_id'];
				$view_data['created_on'] = time();
				if ($counter == 1) {
					$parent = $id;
				}
				$view_data['parent'] = $parent;
				$fields = array_keys($view_data);
				$sql = "insert {$account_db}.{$view_table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";

				$sth = $db->prepare($sql);
				$sth->execute($view_data);
				$return_values[$counter]['insert_views_pm'] = $sth;
				$return_values[$counter]['insert_views_pm_data'] = $view_data;
			}

			if ($update_table != null) {
				$update_data = [];
				$update_data['rec_id'] = $id;
				$update_data['created_by'] = $user_token['user_id'];
				$update_data['created_on'] = time();

				if ($update_table == 'pm_updates' || $update_table == 'cm_updates' || $update_table == 'wo_updates') {
					$update_data['type'] = 'comment';
					$update_data['comment'] = 'created';
					$update_data['description'] = 'created';
				}
				$fields = array_keys($update_data);

				$sql = "insert {$account_db}.{$update_table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";

				$sth = $db->prepare($sql);
				$sth->execute($update_data);

				$return_values[$counter]['insert_update_comments'] = $sth;
				$return_values[$counter]['insert_update_comments_data'] = $update_data;
				$update_data = [];
				$update_data['rec_id'] = $id;
				$update_data['created_by'] = $user_token['user_id'];
				$update_data['created_on'] = time();

				if ($update_table == 'pm_updates' || $update_table == 'cm_updates' || $update_table == 'wo_updates') {
					$update_data['type'] = 'stage';
					$update_data['stage'] = 'open';
					$update_data['comment'] = 'open';
					$update_data['description'] = 'open';
					$update_data['rank'] = '1';
				}
				$fields = array_keys($update_data);

				$sql = "insert {$account_db}.{$update_table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")";

				$sth = $db->prepare($sql);
				$sth->execute($update_data);
				$return_values[$counter]['insert_update_stage'] = $sth;
				$return_values[$counter]['insert_update_stage_data'] = $update_data;
				// print_r($sth);
				$counter++;
			}
		}
		// print_r($return_values);
		$return_value = ['success' => 1, 'description' => 'Record saved.'];
	} catch (Exception $e) {
		$return_value = ['success' => 0, 'description' => $e->getMessage(), 'sql_test' => $sql_test, 'saved_data' => $saved_data];
	}
	return $return_value;
}


function weekOfMonth($date)
{
	// estract date parts
	list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($date)));

	// current week, min 1
	$w = 1;

	// for each day since the start of the month
	for ($i = 1; $i < $d; ++$i) {
		// if that day was a sunday and is not the first day of month
		if ($i > 1 && date('w', strtotime("$y-$m-$i")) == 0) {
			// increment current week
			++$w;
		}
	}

	// now return
	return $w;
}
