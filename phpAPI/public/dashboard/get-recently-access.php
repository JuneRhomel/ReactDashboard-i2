<?php
$return_value = ['success'=>1,'data'=>$data];

try{
    $datas=[];

    $sql1 = "select * from {$account_db}.recently_access
            WHERE deleted_on=0 ORDER BY id DESC
            LIMIT 4";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute();
    $records1 = $record_sth1->fetchAll();

    foreach($records1 as $record){
        $datas[] = [
            'Name' => $record['module_name'],
            'Icon'=> $record['module_icon']
        ];
    }
    
   $return_value['data'] = $datas;

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);