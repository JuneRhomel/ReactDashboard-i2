<?php
$return_value = [];
try {
    // Assuming you have a database connection object named $db established
    $condition = "deleted_on=0";
    $condition .= (isset($data['condition'])) ? " and " . $data['condition'] : "";
    $orderby = (isset($data['orderby'])) ? $data['orderby'] : "id";
    $limit = (isset($data['limit'])) ? $data['limit'] : "100";

    $query = "
    SELECT * FROM (
        (
            SELECT                     
                id, 
                date_upload,
                'Work Permit' AS `type`,
                'vw_workpermit' AS `table`
            FROM {$account_db}.vw_workpermit  WHERE name_id = {$condition} AND deleted_on = 0
        )
        UNION ALL
        (
            SELECT   
                id,
                date_upload,
                'Gate Pass' AS `type`,
                'vw_gatepass' AS `table`
            FROM {$account_db}.vw_gatepass  WHERE name_id = {$condition} AND deleted_on = 0
        )
        UNION ALL
        (
            SELECT 
                id,
                date_upload,
                'Report Issue' AS `type`,
                'vw_report_issue' AS `table`
            FROM {$account_db}.vw_report_issue  WHERE name_id = {$condition} AND deleted_on = 0
        )
        UNION ALL
        (
            SELECT
                id,
                date_upload,
                'Visitor Pass' AS `type`,
                'vw_visitor_pass' AS `table`
            FROM {$account_db}.vw_visitor_pass  WHERE name_id = {$condition} AND deleted_on = 0
        )
    ) AS combined_result 
    WHERE STR_TO_DATE(date_upload, '%M %d, %Y %h:%i %p') < NOW()
    ORDER BY STR_TO_DATE(date_upload, '%M %d, %Y %h:%i %p') DESC
    LIMIT {$limit};
";





    $sth = $db->prepare($query);

    $sth->execute();
    $records = $sth->fetchAll();
    $return_value = $records;
} catch (Exception $err) {
    $return_value = ['success' => 0, 'description' => $err->getMessage()];
}
echo json_encode($return_value);
