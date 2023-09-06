<?php
$return_value = [];
try {
    $table = $data['table'];
    $field = (isset($data['field'])) ? $data['field'] : "*";
    $condition = "deleted_on=0";
    $condition .= (isset($data['condition'])) ? " and " . $data['condition'] : "";
    $orderby = (isset($data['orderby'])) ? $data['orderby'] : "id";
    $limit = (isset($data['limit'])) ? $data['limit'] : "100";
    $sth = $db->prepare("SELECT {$field} FROM {$account_db}.{$table} WHERE {$condition} ORDER BY {$orderby} DESC LIMIT {$limit}");
    $sth->execute();
    $records = $sth->fetchAll();

    foreach ($records as &$record) {
        // Assuming you have a function called 'encryptData' for encrypting the 'id'
        $encryptedId = encryptData($record['id']);
        $record['enc_id'] = $encryptedId;
    }

    $return_value = $records;
} catch (Exception $err) {
    $return_value = ['success' => 0, 'description' => $err->getMessage()];
}

echo json_encode($return_value);
?>
