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
                status,
                fullname,
                location_name,
                category_name as 'category',
                'Work Permit' AS `type`,
                'workpermit' AS `module`
            FROM {$account_db}.vw_workpermit  WHERE deleted_on = 0
        )
        UNION ALL
        (
            SELECT   
                id,
                date_upload,
                status,
                fullname,
                unit as location_name,
                type as 'category',
                'Gate Pass' AS `type`,
                'gatepass' AS `module`
            FROM {$account_db}.vw_gatepass  WHERE deleted_on = 0
        )
        UNION ALL
        (
            SELECT 
                id,
                date_upload,
                status,
                fullname,
                location_name,
                issue_name as 'category',
                'Report Issue' AS `type`,
                'reportissue' AS `module`
            FROM {$account_db}.vw_report_issue  WHERE deleted_on = 0
        )
        UNION ALL
        (
            SELECT
                id,
                date_upload,
                status,
                fullname,
                location_name,
                'Visitor' as 'category',
                'Visitor Pass' AS `type`,
                'visitorpass' AS `module`
            FROM {$account_db}.vw_visitor_pass  WHERE deleted_on = 0
        )
    ) AS combined_result 
    WHERE STR_TO_DATE(date_upload, '%M %d, %Y %h:%i %p') < NOW()
    ORDER BY STR_TO_DATE(date_upload, '%M %d, %Y %h:%i %p') DESC
    LIMIT {$limit};
";





    $sth = $db->prepare($query);

    $sth->execute();
    $records = $sth->fetchAll();
    foreach ($records as &$item) {
        $item["enc_id"] = encryptData($item["id"]);
    }
    
    $return_value = $records;


} catch (Exception $err) {
    $return_value = ['success' => 0, 'description' => $err->getMessage()];
}
echo json_encode($return_value);
