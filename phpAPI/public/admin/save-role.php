<?php
$return_value = ['success' => 1, 'data' => $data];
$sql_test = '';

try {
    if (isset($data['id'])) {
        $id = decryptData($data['id']);
        $role_name = $data['role_name'];
        $description = $data['description'];
    
        $update_data = [
            'role_name' => $role_name,
            'description' => $description,
            'created_at' => time()
        ];
        
        $update_values = [];
        foreach ($update_data as $field => $value) {
            $update_values[] = "$field = ?";
        }
        
        $update_values[] = "updated_at = ?";
        $update_data['updated_at'] = time();
        $update_values[] = "updated_by = ?";
        $update_data['updated_by'] = $user_token['user_id'];
        
        $update_query = "UPDATE {$account_db}._roles SET " . implode(", ", $update_values) . " WHERE id = ?";
        $update_data[] = $id;
        
        $sth = $db->prepare($update_query);
        $sth->execute(array_values($update_data));
    } else {
        // Insert operation
        $role_name = $data['role_name'];
        $description = $data['description'];
    
        $insert_data = [
            'role_name' => $role_name,
            'description' => $description,
            'created_at' => time()
        ];
    
        $sth = $db->prepare("INSERT INTO {$account_db}._roles (" . implode(",", array_keys($insert_data)) . ") VALUES (?" . str_repeat(",?", count(array_keys($insert_data)) - 1) . ")");
        $sth->execute(array_values($insert_data));
    }
    
    $return_value = ['success' => 1, 'description' => $return_value];
} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage()];
}

echo json_encode($return_value);
