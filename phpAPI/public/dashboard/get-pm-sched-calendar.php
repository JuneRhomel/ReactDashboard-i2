<?php
$return_value = ['success'=>1,'data'=>$data];

try{
        // $data = json_decode($data, true);
        $date_json = '';
        foreach($data as $in => $val){
                $date_json = $in;
            }

$date_json = json_decode($date_json, true);
// print_r($date_json);
    $sql1 = "select * from {$account_db}.pm
            WHERE deleted_on=0 AND pm_start_date LIKE '{$date_json['date']}%'";

           
    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute();
    $records1 = $record_sth1->fetchAll();
    
   $return_value['data'] = $records1;


}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}

echo json_encode($return_value);