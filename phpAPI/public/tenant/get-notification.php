<?php
$return_value = ['success' => 1, 'description' => ''];
try {
	$id = decryptData($user_token['tenant_id'] ?? encryptData(0));
	$sth = $db->prepare("SELECT id, type, date_upload
		FROM {$account_db}.vw_gatepass
		WHERE created_by = {$user_token['tenant_id']} 
		AND DATE_FORMAT(STR_TO_DATE(date_upload, '%M %d, %Y %h:%i %p'), '%Y-%m-%d') = CURDATE()
		LIMIT 20;");
	$sth->execute();
	$gatepass = $sth->fetchAll();
	
	// Update the fields and add a new field to each row in the $gatepass array
	foreach ($gatepass as &$row) {
		$row['rec_id'] = $row['id'];
		$row['rec_type'] = $row['type'];
		$row['table'] = "gatepass";
		$row['date_upload'] = date("Y-m-d H:i:s", strtotime($row['date_upload']));
		$row['created_by'] = $user_token['tenant_id'];
		$row['created_on'] = time();
	
		// Remove the old 'id' and 'type' fields if you don't need them anymore
		unset($row['id']);
		unset($row['type']);
	}
	
	// Prepare the SQL query for the insert statement
	// $fields = array_keys($gatepass[0]);
	// $placeholders = ":" . implode(",:", $fields);
	// $columns = implode(",", $fields);
	
	// $sth = $db->prepare("INSERT INTO {$account_db}.notif ($columns) VALUES ($placeholders)");
	
	// // Execute the insert statement for each row in the $gatepass array
	// foreach ($gatepass as $row) {
	// 	$sth->execute($row);
	// }
	
	// $id = $db->lastInsertId();
	$return_value  = $gatepass ;

} catch (Exception $e) {
	$return_value = ['success' => 0, 'description' => $e->getMessage()];
}

echo json_encode($return_value);
