<?php
$return_value = [ 'success'=>1, 'data'=>[] ];
try {
	$view = $data['view'];
	$table = "{$account_db}.{$view}";
	$key = "id";
	$params = $data;
	$order = null;
	$filter = (isset($data['filter']) ? $data['filter'] : null);

	$return_value = $db->getRecords($table, $key, $params, $order, $filter, $view);
	foreach ($return_value['data'] as $index => $record) {
		$return_value['data'][$index]['enc_id'] = encryptData($record['id']);
		if (isset($record['tenant_id']))
			$return_value['data'][$index]['enc_tenant_id'] = encryptData($record['tenant_id']);
		if (isset($record['location_id']))
			$return_value['data'][$index]['enc_loc_id'] = encryptData($record['location_id']);
	}
	$return_value['table'] = $table;
} catch (Exception $err) {
	$return_value = [ 'success'=>0, 'description'=>$err->getMessage()];
}
echo json_encode($return_value);