<?php
$return_value = ['success' => 1, 'data' => $data];
$sql_test = '';

try {
    $id = $data['user_id'];
    $role_id = $data['role_id'];

    $update_data = [
        'role_type' => $role_id,
        'created_at' => time(),
        'updated_at' => time()
    ];

    $update_values = [];
    foreach ($update_data as $field => $value) {
        $update_values[] = "`$field` = $value";
    }

    $update_query = "UPDATE {$account_db}.`_users` SET " . implode(", ", $update_values) . " WHERE `id` = $id";

    $sth = $db->prepare($update_query);
    $sth->execute();

    $return_value = ['success' => 1, 'description' => 'User role successfully updated'];
} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage()];
}

// Set the content type to JSON


// Encode $return_value as JSON and print it
echo json_encode($return_value);
