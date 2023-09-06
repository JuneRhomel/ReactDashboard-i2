<?php
$return_value = ['success'=>1,'data'=>[]];
try{
    

    $id = decryptData($data['id']);
    
    // $id = decryptData($data[2]);
    $table = $data['table'];

	$sth = $db->prepare("update {$account_db}.{$table} set deleted_by=:deleted_by,deleted_on=:deleted_on where id=:id");
	$sth->execute([ 'deleted_by'=>$user_token['user_id'],'deleted_on'=>time(),'id'=>$id ]);
    if($data['view_table']){
        $sth = $db->prepare("update {$account_db}.view_{$table} set deleted_by=:deleted_by,deleted_on=:deleted_on where id=:id");
    	$sth->execute([ 'deleted_by'=>$user_token['user_id'],'deleted_on'=>time(),'id'=>$id ]);
    }

    $return_value = ['success'=>1,'description'=>'Record saved.', 'id' => decryptData($id) , 'data'=>$data];
    // print_r($data);
    
    

	// if ($module=="stage") {
	// 	// REARRANGE SORTING ORDER
	// 	$sth = $db->prepare("select * from {$account_db}.stages where deleted_on=0 and stage_type=:stage_type and id<>:id and rank>=:rank order by rank");
	// 	$sth->execute([ 'stage_type'=>$data['stage_type'],'rank'=>$data['rank'],'id'=>$id ]);
	// 	$records = $sth->fetchAll();
	// 	if ($records) {
	// 		$ct = $data['rank']+1;
	// 		foreach ($records as $record) {
	// 			$sth = $db->prepare("update {$account_db}.stages set rank=:rank where id=:id");
	// 			$sth->execute([ 'rank'=>$ct,'id'=>$record['id'] ]);
	// 			$ct++;
	// 		}
	// 	}
	// }

	

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);