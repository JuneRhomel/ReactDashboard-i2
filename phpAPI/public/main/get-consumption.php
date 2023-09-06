<?php
$return_value = [];
try {

    $sth = $db->prepare("SELECT
    YEAR(CONCAT(year, '-', month, '-01')) AS Year,
    MONTH(CONCAT(year, '-', month, '-01')) AS Month,
    MONTHNAME(CONCAT(year, '-', month, '-01')) AS MonthName,
    SUM(CASE WHEN utility_type = 'Water' THEN CAST(consumption AS DECIMAL(10, 2)) ELSE 0 END) AS WaterConsumption,
    SUM(CASE WHEN utility_type = 'Electricity' THEN CAST(consumption AS DECIMAL(10, 2)) ELSE 0 END) AS ElectricityConsumption
FROM {$account_db}.vw_meter_readings
WHERE CONCAT(year, '-', month, '-01') BETWEEN DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH), '%Y-%m-01') AND CURRENT_DATE
GROUP BY Year, Month
ORDER BY Year, Month");


    $sth->execute();
    $records = $sth->fetchAll();
    $return_value = $records;
} catch (Exception $err) {
    $return_value = ['success' => 0, 'description' => $err->getMessage()];
}
echo json_encode($return_value);
