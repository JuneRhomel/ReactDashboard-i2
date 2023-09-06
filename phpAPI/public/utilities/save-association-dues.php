<?php
$return_value = ['success'=>1,'data'=>[]];
$sql_test = '';
try{
    $table = 'assoc_dues';
    // print_r($data);
    $data['created_by'] = $user_token['user_id'];
    $data['created_on'] = time();

    $fields = array_keys($data);
    
	$return_value = ['success'=>1,'description'=>'Record saved.', 'id' => encryptData($id)];

    $sql = "insert {$account_db}.{$table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    $sth = $db->prepare($sql);
    $sth->execute($data);
    $id = $db->lastInsertId(); 


    //get all bills from db usinig month and year
    $month = $data['month'];
    $year = $data['year'];

    $sql = "select * from {$account_db}.bills,{$account_db}.tenant WHERE  month = :month AND year = :year AND bills.tenant_id = tenant.id  ";
    $record_sth = $db->prepare($sql);
    $record_sth->execute([
        'month'=>$month,
        'year'=>$year
    ]);
    $dues = $data['dues'];
    unset($data['dues']);
    $records = $record_sth->fetchAll();
    foreach($records as $record){
        
        $association_dues = $record['unit_area'] * $dues;
        $data['association_dues'] = $association_dues;
        $data['tenant_id'] = $record['tenant_id'];
        $data_update = $data;
        // print_r($data);
        $sth = $db->prepare("update {$account_db}.bills set association_dues = :association_dues , created_by = :created_by ,  created_on= :created_on where month = :month AND year=:year AND tenant_id = :tenant_id");
        $sth->execute($data_update);

        $sth = $db->prepare("update {$account_db}.view_bills set association_dues = :association_dues , created_by = :created_by ,  created_on= :created_on where month = :month AND year=:year AND tenant_id = :tenant_id");
        $sth->execute($data_update);
    }

    $return_value = ['success'=>1,'data'=>[]];

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(), 'sql_test' => $sql_test];
}

echo json_encode($return_value);