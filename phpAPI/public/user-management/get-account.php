<?php
$return_value = [];
try {
    // print_r($data);
    $view = $data['view'];
    $username = $data['username'];
    $table = "i2accounts.{$view}";

    $sql = "SELECT account FROM {$table} WHERE __deleted = 0 AND username = '{$username}' LIMIT 1000";



    $record_sth = $db->prepare($sql);
    $record_sth->execute([]);
    $records = $record_sth->fetchAll();
    foreach ($records as &$item) {
        $item["account_enc"] = encryptData($item["account"]);
    }

    $return_value = $records;
} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage()];
}

// Set the content type to JSON
header('Content-Type: application/json');

// Encode $return_value as JSON and print it
echo json_encode($return_value);
