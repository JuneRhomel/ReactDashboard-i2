<?php
$return_value = ['success'=>1,'data'=>$data];

try{
    $year = date('Y');
    $mos = date('m');
    $start_date = strtotime(date("{$year}-{$mos}-01 00:00:00"));
    $end_date = strtotime(date("{$year}-{$mos}-31 23:59:59"));
    $collectibles=0;

    $sql = "select bills.*,soa.remaining_balance,soa.due_month,soa.id as soa_id from {$account_db}.bills,{$account_db}.soa
    WHERE soa.deleted_on=0 and bills.deleted_on=0 and
    soa.bill_id=bills.id";

    $record_sth = $db->prepare($sql);
    $record_sth->execute();
    $records = $record_sth->fetchAll();

    if($records){
        foreach($records as $rec){
            $sql1 = "select * from {$account_db}.payments
                WHERE deleted_on=0 and soa_id={$rec['soa_id']} and created_on BETWEEN $start_date and $end_date";

            $record_sth1 = $db->prepare($sql1);
            $record_sth1->execute();
            $records1 = $record_sth1->fetch();

            if($records1){
                if($rec['remaining_balance'] <= 0){
                    $collectibles += $rec['association_dues'];
                    // $test[]= $rec['association_dues'];
                }
            }
        }
    }
    
   $return_value['data']['collectibles'] = '100000';
   $return_value['data']['collected'] = $collectibles;
   $return_value['data']['remaining'] = 100000-$collectibles;

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);