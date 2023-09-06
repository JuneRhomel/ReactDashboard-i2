<?php 
$return_value = [
    'success' =>1,
    'data'=>$data
];
try{
    if($data['soa_id'] == null){
        throw new Exception('Missing Soa Id');
    }
    $data_insert = $data;
    $data_insert['created_by'] = $user_token['user_id'];
    $data_insert['created_on'] = time();

    $fields = array_keys($data_insert);

    $sql = "insert {$account_db}.payments (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
    $sth = $db->prepare($sql);
    $sth->execute($data_insert);

    $sql = "select *  from {$account_db}.soa WHERE id= :id";
    $sth = $db->prepare($sql);
    
    $sth->execute(['id'=> $data['soa_id']]);
    $id = $db->lastInsertId();
    $result = $sth->fetch();
    $return_value['soa_datails']['total_amount_due'] = $result['total_amount_due'];
    $return_value['soa_datails']['remaining_balance'] = $result['remaining_balance'];
    $new_amount = 0;
    // if($result['remaining_balance'] > 0){
    //     if($data['amount'] > $result['remaining_balance'])
    //         throw new Exception('Payment Amount must not be higher that Remaining Balance');
    // }
    // if($data['amount'] > $result['amount_due']){
    //     throw new Exception('Payment amount must not be higher than Statement Amount Due');
    // }
    // else{
        $soa_balance = $result['remaining_balance'] - $data['amount'];
        $return_value['remaining_balance'] = $soa_balance;

        $data_update_soa = [];
        $data_update_soa['remaining_balance'] = $soa_balance;
        $data_update_soa['created_by'] = $user_token['user_id'];
        $data_update_soa['created_on'] = time();
        $fields = [];
        foreach( array_keys($data_update_soa) as $field) {
			$fields[] = "{$field}=:{$field}";
		}
        $sql = "update {$account_db}.soa set " . implode(",",$fields). " where id={$data['soa_id']}";
		$sth = $db->prepare($sql);
		$sth->execute($data_update_soa);

        $sql = "update {$account_db}.view_soa set " . implode(",",$fields). " where rec_id={$data['soa_id']}";
		$sth = $db->prepare($sql);
		$sth->execute($data_update_soa);

        //updates
        $update_table = 'soa_updates';
        
        $update_data['rec_id'] = $data['soa_id'];
        $update_data['created_by'] = $user_token['user_id'];
        $update_data['created_on'] = time();

        $update_data['type'] = 'stage';
        
        $update_data['stage'] = 'patially-paid';
        $update_data['comment'] = 'patially-paid';
        $update_data['description'] = 'patially-paid';
        $update_data['rank'] = '3';

        if($soa_balance < 0){
            $update_data['stage'] = 'paid';
            $update_data['comment'] = 'paid';
            $update_data['description'] = 'paid';
            $update_data['rank'] = '4';
        }
        
        $fields = array_keys($update_data);
            
        $sql = "insert {$account_db}.{$update_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
        $sth = $db->prepare($sql);
        $sth->execute($update_data);
    //truncate soa; truncate view_soa; truncate soa_updates; truncate payments;        
    // }
}
catch(Exception $e){
    $return_value = [
        'success' =>0,
        'data'=>$e->getMessage()
    ];
}

echo json_encode($return_value);