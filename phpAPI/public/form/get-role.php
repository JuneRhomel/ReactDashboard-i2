<?php
$return_value = ['success' => 1, 'data' => []];
try {
    $sql = "select role_type from {$account_db}._users where _users.id = {$user_token['user_id']}";
    $record_sth = $db->prepare($sql);
    $record_sth->execute();
    $return_value = $record_sth->fetch();
} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage()];
}
echo json_encode($return_value);
