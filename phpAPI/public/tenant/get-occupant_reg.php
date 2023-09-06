<?php
$return_value = ['success' => 1, 'data' => []];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Assuming you have a valid database connection as $db
    $table = $data['table'];
    $unitowner = $data['unitowner'];
    $itemsPerPage = 5; // Adjust as needed

    $currentPage = isset($data['page']) ? intval($data['page']) : 1;
    if ($currentPage < 1) {
        $currentPage = 1;
    }

    $startIndex = ($currentPage - 1) * $itemsPerPage;

    $sql = "
        SELECT 
            a.id,
            a.firstname as first_name,
            a.lastname as last_name,
            a.company_name,
            a.type,
            a.address,
            a.contact_no,
            a.email,
            a.status,
            a.unit_id,
            a.fullname
        FROM 
            {$account_db}.{$table} a
        WHERE
            a.deleted_on = 0 and status IN ('Disapproved', 'Approved')
            and a.type = 'Tenant'
            and a.created_by = $unitowner
        ORDER BY id DESC
        LIMIT $startIndex, $itemsPerPage;
    ";

    $sth = $db->prepare($sql);
    $sth->execute();
    $records = $sth->fetchAll();

    $encryptedRecords = [];
    foreach ($records as $record) {
        $record['enc_id'] = encryptData($record['id']);
        $encryptedRecords[] = $record;
    }

    $return_value['data'] = $encryptedRecords;

    $countSql = "SELECT count(*) as total FROM {$account_db}.{$table} WHERE deleted_on = 0";
    $sthCount = $db->prepare($countSql);
    $sthCount->execute();
    $limit = $sthCount->fetch();

    $return_value['max'] = ceil($limit['total'] / $itemsPerPage); // Get the 'total' column from the fetched data
} catch (Exception $err) {
    $return_value = ['success' => 0, 'description' => $err->getMessage()];
}

echo json_encode($return_value);
?>
