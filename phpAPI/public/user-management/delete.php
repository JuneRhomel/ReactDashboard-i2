<?php
$return_value = ['success' => 1, 'data' => []];
try {
    $table = $data[1];
    $id = decryptData($data[2]);
    $sth = $db->prepare("UPDATE {$account_db}.{$table} SET deleted_by=:deleted_by, deleted_on=:deleted_on, deleted_at=:deleted_at WHERE id=:id");
    $sth->execute([
        'deleted_by' => $user_token['user_id'],
        'deleted_on' => time(),
        'deleted_at' => time(),
        'id' => $id
    ]);

    $return_value = ['success' => 1, 'description' => 'Record deleted.'];
} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage()];
}
echo json_encode($return_value);
