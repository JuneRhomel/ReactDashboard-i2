<?php
$return_value = [];
try {
	$table = $data['table'];
	$field = (isset($data['field'])) ? $data['field'] : "*";
	$condition = "deleted_on=0";
	$condition .= (isset($data['condition'])) ? " and ".$data['condition'] : "";
	$orderby = (isset($data['orderby'])) ? $data['orderby'] : "id";
	$limit = (isset($data['limit'])) ? $data['limit'] : "100";

	// Assuming the 'id' column name is 'id' (you can replace it with the actual column name)
	$id = 'id';

	$sth = $db->prepare("SELECT {$field}, month_of, year_of FROM {$account_db}.{$table} WHERE {$condition} ORDER BY year_of DESC, month_of DESC LIMIT {$limit}");
	$sth->execute();
	$records = $sth->fetchAll();

	if ($field == "*") {
		$return_value = $records;
		foreach ($records as $key => $val) {
			// Assuming 'encryptData' is a function that encrypts data (you can replace it with the actual encryption logic)
			$return_value[$key]['enc_id'] = encryptData($val[$id]);
		}
	} else {
		foreach ($records as $key => $val) {
			$return_value[] = $val[$field];
		}
	}
} catch (Exception $err) {
	$return_value = ['success' => 0, 'description' => $err->getMessage()];
}

echo json_encode($return_value);
