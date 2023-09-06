<?php
$return_value = ['success'=>1];

try{
    $year = date('Y');
    $datetoday = date('d');
    $start_date = strtotime(date("{$year}-01-01 00:00:00"));
    $end_date = strtotime(date("{$year}-{$data['month']}-31 23:59:59"));    
    $collected=0;
    $unpaid=0;
    $overdue=0;
    $t_unpaid=0;
    $test = [];

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
                        $collected += $rec['association_dues'];
                        // $test[]= $rec['association_dues'];
                    }else{
                        if($rec['due_month'] == $data['month']){
                            $unpaid += $rec['association_dues'];  
                        }else{
                            $overdue += $rec['association_dues'];
                        }
                    }
                }else{
                    if($rec['due_month'] == $data['month']){
                        $unpaid += $rec['association_dues'];  
                    }else{
                        $overdue += $rec['association_dues'];
                    }
                }
            }
            $collectibles =100000 * $data['month'];
            $t_unpaid =$collectibles-$collected;
        }else{
            $collectibles =100000 * $data['month'];
            $t_unpaid =$collectibles-$collected;
        }

    // $return_value['data']['test'] = $test;

    $return_value['data']['collectibles'] = $collectibles;
    $return_value['data']['collected'] = $collected;
    $return_value['data']['unpaid_amount'] = $unpaid;
    $return_value['data']['overdue_bills'] = $overdue;
    $return_value['data']['total_unpaid'] = $t_unpaid;

}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql];
}
echo json_encode($return_value);