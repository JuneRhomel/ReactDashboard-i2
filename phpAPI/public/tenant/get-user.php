<?php
$return_value = ['success' => 1, 'data' => []];
try {
    if ($data['view'] === "users") {
        $sql = "select * from {$account_db}.vw_resident WHERE id=:user_id";
        $record_sth = $db->prepare($sql);
        $record_sth->execute(['user_id' => $user_token['tenant_id']]);
        $record = $record_sth->fetch();
        $return_value = $record;
    } else {
        $sql = "select * from {$account_db}.{$table} WHERE deleted_on=0 and id=:id";
        $record_sth = $db->prepare($sql);
        $record_sth->execute(['id' => $id]);
        $record = $record_sth->fetch();
    }
    //$return_value = $data;
} catch (Exception $e) {
    $return_value = ['success'=>0, 'description' => $e->getMessage()];
}
echo json_encode($return_value);
