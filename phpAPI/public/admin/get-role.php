<?php
$return_value = ['success' => 1, 'data' => []];
try {
    // print_r($data);
    $view = $data['view'];
    $table = "{$account_db}.{$view}";

    $sql = "SELECT * FROM {$table} WHERE deleted_on = 0 AND id > 2 LIMIT 1000";



    $record_sth = $db->prepare($sql);
    $record_sth->execute([]);
    $records = $record_sth->fetchAll();
    
    $return_value['data'] = $records;
} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage()];
}

// Set the content type to JSON
header('Content-Type: application/json');

// Encode $return_value as JSON and print it
echo json_encode($return_value);
