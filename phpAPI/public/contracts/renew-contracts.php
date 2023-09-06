<?php
$return_value = ['success'=>1,'data'=>[]];
try{

    // print_r($data);
    $table = 'contracts';
    $id = $data['renew_id'];
    $fields = [];
    $data_fields = $data;
    $fields = [
        'effectivity_date = ?', 
        'expiration_date = ?', 
        'contract_number = ?',
        'status = ?'
    ];
    // print_R($fields);
    $sql = "update {$account_db}.{$table} set " . implode(",",$fields). " where id={$id}";
    $sth = $db->prepare($sql);
    $sth->execute([
        $data['effectivity_date'],
        $data['expiration_date'],
        $data['contract_number'],
        'active'
        ]
        
    );


    $sql = "update {$account_db}.view_{$table} set " . implode(",",$fields). " where id={$id}";
    $sth = $db->prepare($sql);
    $sth->execute([
        $data['effectivity_date'],
        $data['expiration_date'],
        $data['contract_number'],
        'active'
        ]
    );
    //insert into update
    $table = 'contract_updates';
    $fields = [
        'description',
        'created_on',
        'created_by',
        'status',
        'contract_id',
        'contract_number',
        'effectivity_date',
        'expiration_date'
    ];
    $sql = "insert {$account_db}.{$table} (" . implode(",",$fields). ") values(?" . str_repeat(",?",count($fields)-1) . ")";
    $sth = $db->prepare($sql);
    $sth->execute([
        'Renewal',
        time(),
        $user_token['user_id'],
        'renewed',
        $id,
        $data['contract_number'],
        $data['effectivity_date'],
        $data['expiration_date']
        ]
    );
    
    $return_value = ['success'=>1,'description'=>'Record saved.', 'id' => encryptData($id)];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);