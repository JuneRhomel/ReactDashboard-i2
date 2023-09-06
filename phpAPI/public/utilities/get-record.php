<?php
$return_value = ['success' => 1, 'data' => []];
try {
    $view = $data['view'];
    $table = "{$account_db}.{$view}";
    $id = ($data['_id'] == null) ? decryptData($data['id']) : $data['_id'];

    if ($view == 'view_meters') {
        $sql = "SELECT {$view}.*, tenant.owner_name AS owner_name FROM {$table}
            LEFT JOIN {$account_db}.tenant AS tenant ON tenant.id = {$view}.tenant
            WHERE {$view}.deleted_on = 0 AND {$view}.id = :id";
    } else {
        $sql = "SELECT * FROM {$table} WHERE deleted_on = 0 AND id = :id";
    }

    $record_sth = $db->prepare($sql);
    $record_sth->execute(['id' => $id]);
    $record = $record_sth->fetch();
    $return_value['data'] = $record;

    // if ($view == 'view_meters') {
    //     $sql = "SELECT * FROM {$account_db}.meter_readings WHERE meter_id = :meter_id ORDER BY id DESC";
    //     $record_sth = $db->prepare($sql);
    //     $record_sth->execute(['meter_id' => $id]);
    //     $records = $record_sth->fetchAll();
    //     $return_value['data']['meter_readings'] = $records;
    // }

} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage()];
}

echo json_encode($return_value);
