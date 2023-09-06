<?php

$return_value = ['success' => 1, 'data' => []];
try {

    $id = ($data['id']) ? decryptData($data['id']) : 0;		unset($data['id']);
	$module = $data['module']; 								unset($data['module']);
	$table = $data['table']; 								unset($data['table']);
	$loc_id = $data['loc_id']; 								unset($data['loc_id']);
	$content = $data['content'];							unset($data['content']);

    $account_code = $data['account_code'];
    unset($data['account_code']);
    if ($id) {
        // Update logic
        $fields = array_keys($data);
        $updateValues = array_map(fn($field) => "$field = :$field", $fields);
        $sth = $db->prepare("UPDATE {$account_db}.{$table} SET " . implode(", ", $updateValues) . " WHERE id = :id");
        $data['id'] = $id;
        $sth->execute($data);
        
        if ($sth->rowCount() > 0) {
            $return_value = ['success' => 1, 'description' => 'Record updated.', 'id' => $id];
        } else {
            $return_value = ['success' => 0, 'description' => 'Failed to update the record.'];
        }
    } else {
        // Insert logic
        $data['user_name'] = $data['email'];
        $data['created_by'] = $user_token['user_id'];
        $data['created_on'] = time();
        $data['password'] = md5($data['password']); 
        $data['fcm_token'] = md5(randomString() . $data['user_id'] . time()); 
        
        $email = $data['email'];
        
        $sth = $db->prepare("SELECT COUNT(*) FROM i2accounts.accounts WHERE username = ?");
        $sth->execute([$email]);
        $count = $sth->fetchColumn();
        
        if ($count > 0) {
            // Update existing account
            $sth = $db->prepare("UPDATE i2accounts.accounts SET __createtime = ?, account = ? WHERE username = ?");
            $sth->execute([time(), $account_code, $email]);
        } else {
            // Insert new account
            $sth = $db->prepare("INSERT INTO i2accounts.accounts SET __createtime = ?, username = ?, account = ?");
            $sth->execute([time(), $email, $account_code]);
        }
        
        if ($sth->rowCount() > 0) {
            // Proceed with insertion into {$account_db}.{$table}
            $fields = array_keys($data);
            $placeholders = ":" . implode(",:", $fields);
            $sth = $db->prepare("INSERT INTO {$account_db}.{$table} (" . implode(",", $fields) . ") VALUES ($placeholders)");
            $sth->execute($data);
            $id = $db->lastInsertId();
        
            $return_value = ['success' => 1, 'description' => 'Record saved.', 'id' => $id];
        } else {
            $return_value = ['success' => 0, 'description' => 'Failed to insert/update the record in i2accounts.accounts.'];
        }
    }
    
    


} catch (Exception $e) {
    if ($e->getCode() === '23000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
        $return_value = ['success' => 0, 'description' => 'The email is already taken.'];
    } else {
        $return_value = ['success' => 0, 'description' => $e->getMessage()];
    }
}
echo json_encode($return_value);


?>