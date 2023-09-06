<?php
$return_value = ['success'=>1,'data'=>$data];

try{
    // print_r($data);
    
    $view = $data['view'];
    $table = "{$account_db}.{$view}"; 
    
    $filter_query = '';
    $filter_vals = [];
    
    if($data['filters']){
        $where = [];
        foreach($data['filters'] as $filter_keys => $filter_values){
            $where[] = "{$filter_keys} = ?";
            $filter_vals[] = $filter_values;
        }
        $filter_query = "and " . implode(" and ",$where);
        
    }
    
    $sql = "select * from {$table} WHERE deleted_on=0 " . $filter_query;
    
    $records_sth = $db->prepare($sql);
    $records_sth->execute($filter_vals);
    $records = $records_sth->fetchAll();
    $return_value = $records;
    $term = $data['term'];

    if($data['auto_complete']){
        $return_value = [];
        if($view == 'view_equipments'){
            
            $condition = ($data['filter']!="") ? " and equipment_type='".$data['filter']."'" : "";
            $sth = $db->prepare("select id as value, equipment_name as label from {$account_db}.equipments where equipment_name like ? $condition");
            $sth->execute(["%" . $term . "%"]);
            $return_value = $sth->fetchAll();
        }
        else if($view == 'service_providers_view'){
            
            $condition = ($data['filter']!="") ? " and type='".$data['filter']."'" : "";

            $sth = $db->prepare("select id as value, company as label from {$account_db}.{$data['view']} where company like ? $condition");
            $sth->execute(["%" . $term . "%"]);
            $return_value = $sth->fetchAll();
        }
        else if($view == 'tenant'){
            
            $condition = ($data['filter']!="") ? " and type='".$data['filter']."'" : "";

            $sth = $db->prepare("select id as value, tenant_name as label from {$account_db}.{$data['view']} where tenant_name like ? $condition");
            $sth->execute(["%" . $term . "%"]);
            $return_value = $sth->fetchAll();
        }
    }

    // $return_value['sql'] = $sql;

	
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);