<?php
$return_value = [];
try {
    $sth = $db->prepare("
        SELECT 
            FORMAT(SUM(amount_due), 2) AS total_collectibles,
            FORMAT(SUM(CASE WHEN status = 'paid' THEN amount_due ELSE 0 END), 2) AS total_collected,
            FORMAT(SUM(CASE WHEN status = 'unpaid' THEN amount_due ELSE 0 END), 2) AS total_unpaid
        FROM {$account_db}.vw_soa
        WHERE month_of = :month_of AND year_of = YEAR(CURRENT_DATE);
    ");

    $sth->bindValue(':month_of', $data['month'], PDO::PARAM_INT);
    $sth->execute();
    $records = $sth->fetchAll();

    $return_value = $records;
} catch (Exception $err) {
    $return_value = ['success' => 0, 'description' => $err->getMessage()];
}
echo json_encode($return_value);
?>
