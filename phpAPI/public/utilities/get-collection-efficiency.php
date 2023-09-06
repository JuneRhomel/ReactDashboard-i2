<?php
$return_value = ['success'=>1,'data'=>$data];

try{
    $collections=0;
    $datas=[];

    $sql1 = "select *,SUM(association_dues) AS assoc_per_month from {$account_db}.bills
            WHERE bills.deleted_on=0 GROUP BY month";

    $record_sth1 = $db->prepare($sql1);
    $record_sth1->execute();
    $records1 = $record_sth1->fetchAll();

    $sql2 = "select * from {$account_db}.view_soa
            WHERE view_soa.deleted_on=0";

    $record_sth2 = $db->prepare($sql2);
    $record_sth2->execute();
    $records2 = $record_sth2->fetchAll();

    foreach($records1 as $record){
        foreach($records2 as $r2){
            if($r2['remaining_balance'] <= 0){ //paid or not
                if($r2['bill_id'] == $record['id']){ // record bills
                    if($r2['due_month'] == $record['month']){ // same month
                        $collections += $record['association_dues'];
                        $percteage = ($collections / 100000) * 100;
                        $datas[] = [
                            'month' => $record['month'],
                            'collectibles'=>'100000',
                            'collected' => $collections,
                            'unpaid' => 100000 - $collections,
                            'percent' => $percteage.' %'
                        ];
                    }
                }
            }
        }
    }
    
   $return_value['data']['collected'] = $datas;

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);