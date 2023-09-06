<?php
$return_value = [];
try {
	$table = $data['table'];
	$field = (isset($data['field'])) ? $data['field'] : "*";
	$condition = "deleted_on=0";
	$condition .= (isset($data['condition'])) ? " and ".$data['condition'] : "";
	$orderby = (isset($data['orderby'])) ? $data['orderby'] : "id";

	$sth = $db->prepare("SELECT COUNT(*) AS count FROM {$account_db}.{$table} WHERE {$condition} order by {$orderby}");
	$sth->execute();
	$records = $sth->fetchAll();
	if ($field=="*") {
		$return_value = $records;
		foreach ($records as $key=>$val) {
			$return_value[$key]['enc_id'] = encryptData($val[$id]);
		}
	} else {
		foreach ($records as $key=>$val) {
			$return_value[] = $val[$field];
		}
	}
} catch (Exception $err) {
	$return_value = [ 'success'=>0, 'description'=>$err->getMessage()];
}
echo json_encode($return_value);