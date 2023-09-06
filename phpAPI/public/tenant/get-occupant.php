<?php
$return_value = ['success' => 1, 'data' => []];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $table = $data['table'];
    $unitowner = $data['unitowner'];
    $itemsPerPage = 5; // Adjust as needed

    $currentPage = isset($data['page']) ? intval($data['page']) : 1;
    if ($currentPage < 1) {
        $currentPage = 1;
    }

    $startIndex = ($currentPage - 1) * $itemsPerPage;

    // Assuming you have a valid database connection as $db
    $sql = "
        SELECT 
            a.id,
            a.first_name,
            a.last_name,
            a.company_name,
            a.type,
            a.address,
            a.contact_no,
            a.email,
            a.status,
            a.unit_id,
            a.created_by,
            b.location_name AS unit_name,
            p.attachment_url AS profile_pic,
            CONCAT(a.first_name, ' ', a.last_name) AS fullname
        FROM 
            {$account_db}.{$table} a
        LEFT JOIN 
            {$account_db}.location b ON (b.id = a.unit_id)
        LEFT JOIN 
            {$account_db}.photos p ON (p.reference_id = a.id AND p.reference_table = 'resident')
        WHERE 
            a.deleted_on = 0 
            AND a.type = 'Tenant'
            AND a.created_by = $unitowner
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

    $sql = "SELECT count(*) as total FROM {$account_db}.{$table} WHERE deleted_on = 0"; 
    $sth = $db->prepare($sql);
    $sth->execute();
    $limit = $sth->fetch();

    $return_value['max'] = ceil($limit['total'] / $itemsPerPage); // Get the 'total' column from the fetched data
} catch (Exception $err) {
    $return_value = ['success' => 0, 'description' => $err->getMessage()];
}

echo json_encode($return_value);
?>
