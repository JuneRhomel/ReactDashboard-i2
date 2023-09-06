<?php
$return_value = [];
try {
	$table = $data['table'];
	$field = (isset($data['field'])) ? $data['field'] : "*";
	$condition = "deleted_on=0";
	$condition = "deleted_on=0";
	$condition .= (isset($data['condition'])) ? " and ".$data['condition'] : "";
	$orderby = (isset($data['orderby'])) ? $data['orderby'] : "id";
	$limit = (isset($data['limit'])) ? $data['limit'] : "100";

	$sth = $db->prepare("SELECT {$field} FROM {$account_db}.{$table} WHERE {$condition} ORDER BY {$orderby} DESC LIMIT {$limit}");
	$sth->execute();
	$records = $sth->fetchAll();
	if ($field=="*") {
		$return_value = $records;
	} else {
		foreach ($records as $key=>$val) {
			$return_value[] = $val[$field];
		}
	}

    foreach ($records as $record) {
        $record['enc_id'] = encryptData($record['id']);
        $encryptedRecords[] = $record;
    }
    $return_value = $encryptedRecords;
} catch (Exception $err) {
	$return_value = [ 'success'=>0, 'description'=>$err->getMessage()];
}
echo json_encode($return_value);