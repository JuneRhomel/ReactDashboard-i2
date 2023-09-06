<?php
/**
 * Param 
 */
$return_value = ['success'=>1,'data'=>[]];
$sql_test = '';

try{
    $filter_query = '';
    $filter_vals = [];
    if($data['filters']){
        $where = [];
        foreach($data['filters'] as $filter_keys => $filter_values){
            if($filter_values != "all"){
                $where[] = "work_order.{$filter_keys} = ?";
                $filter_vals[] = $filter_values;
            }
        }
        $filter_query = $where? "and " . implode(" and ",$where): "";
    }
    
    $sth = $db->prepare("select work_order.*, users.full_name as created_name 
        from
        (
            select wo.id, wo.deleted_on, wo.created_on, wo.wo_type, 
            wo.location, wo.equipment_id, wo.priority_level, wo.service_provider_id, wo.rank, wo.critical, wo.created_by, wo_updates.stage, wo.category_id
            from {$account_db}.wo as wo
            left join (
                select {$account_db}.wo_updates.stage, rec_id, ROW_NUMBER() OVER (PARTITION BY wo_updates.rec_id ORDER BY wo_updates.id DESC) AS rn 
                from {$account_db}.wo_updates where type = 'stage'
            ) wo_updates
            on wo_updates.rec_id = wo.id AND wo_updates.rn = 1
            UNION ALL
            select cm.id, cm.deleted_on, cm.created_on, cm.wo_type, 
            cm.location, cm.equipment_id, cm.priority_level, cm.service_provider_id, cm.rank, cm.critical, cm.created_by, cm_updates.stage, cm.category_id
            from {$account_db}.cm as cm
            left join (
                select {$account_db}.cm_updates.stage, rec_id, ROW_NUMBER() OVER (PARTITION BY cm_updates.rec_id ORDER BY cm_updates.id DESC) AS rn 
                from {$account_db}.cm_updates where type = 'stage'
            ) cm_updates
            on cm_updates.rec_id = cm.id AND cm_updates.rn = 1
            UNION ALL
            select pm.id, pm.deleted_on, pm.created_on, 'Preventive Maintenance' as wo_type,
            pm.location, pm.equipment_id, pm.priority_level, pm.service_provider_id, pm.rank, pm.critical, pm.created_by, pm_updates.stage, 'N/A' as category_id
            from {$account_db}.pm as pm
            left join (
                select {$account_db}.pm_updates.stage, rec_id, ROW_NUMBER() OVER (PARTITION BY pm_updates.rec_id ORDER BY pm_updates.id DESC) AS rn 
                from {$account_db}.pm_updates where type = 'stage'
            ) pm_updates
            on pm_updates.rec_id = pm.id AND pm_updates.rn = 1
        ) as work_order

        left join {$account_db}._users AS users on users.id=work_order.created_by
        where work_order.deleted_on=0 {$filter_query}
    ");
    $sth->execute($filter_vals);
    $work_order = $sth->fetchAll();
    
    $return_value['success']= 1;
    $return_value['wo_data'] = $work_order;
    $return_value['record_count'] =count($work_order);
    $return_value['filter_query']=  $filter_query ;
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(), 'sql_test' => $sql_test];
}
echo json_encode($return_value);