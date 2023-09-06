<?php
/**
 * Param 
 */
$return_value = ['success'=>1,'data'=>[]];
$sql_test = '';
try{
    // print_r($data);
    
    $sth = $db->prepare("select * from {$account_db}.view_unit_repair where deleted_on=0");
    $sth->execute();
    $unit_repairs = $sth->fetchAll();
    $result = [];

    foreach($unit_repairs as $unit_repair)
    {
        $result[] = [
            'id'=>$unit_repair['id'],
            'rec_id' => $unit_repair['rec_id'],
            'requestor_name'=>$unit_repair['requestor_name'],
            'unit'=>$unit_repair['unit'],
            'description'=>$unit_repair['description'],
            'approve'=>$unit_repair['approve'],
            'created_on'=>$unit_repair['created_on'],
            'sr_type'=>$unit_repair['sr_type']
        ];
    }

    $sth = $db->prepare("select * from {$account_db}.view_gate_pass where deleted_on=0");
    $sth->execute();
    $gate_passes = $sth->fetchAll();
    foreach($gate_passes as $gate_pass)
    {
        $result[] = [
            'id'=>$gate_pass['id'],
            'rec_id' => $gate_pass['rec_id'],
            'requestor_name'=>$gate_pass['name'],
            'unit'=>$gate_pass['unit'],
            'approve'=>$gate_pass['approve'],
            'created_on'=>$gate_pass['created_on'],
            'sr_type'=>$gate_pass['sr_type']
        ];
    }

    $sth = $db->prepare("select * from {$account_db}.view_visitor_pass where deleted_on=0");
    $sth->execute();
    $visitor_passes = $sth->fetchAll();
    foreach($visitor_passes as $visitor_pass)
    {
        $result[] = [
            'id'=>$visitor_pass['id'],
            'rec_id' => $visitor_pass['rec_id'],
            'requestor_name'=>$visitor_pass['name'],
            'unit'=>$visitor_pass['unit'],
            'approve'=>$visitor_pass['approve'],
            'created_on'=>$visitor_pass['created_on'],
            'sr_type'=>$visitor_pass['sr_type']
        ];
    }

    $sth = $db->prepare("select * from {$account_db}.view_reservation where deleted_on=0");
    $sth->execute();
    $reservations = $sth->fetchAll();
    foreach($reservations as $reservation)
    {
        $result[] = [
            'id'=>$reservation['id'],
            'rec_id' => $reservation['rec_id'],
            'requestor_name'=>$reservation['name'],
            'unit'=>$reservation['unit'],
            'approve'=>$reservation['approve'],
            'created_on'=>$reservation['created_on'],
            'sr_type'=>$reservation['sr_type']
        ];
    }

    $sth = $db->prepare("select * from {$account_db}.view_move_in where deleted_on=0");
    $sth->execute();
    $move_ins = $sth->fetchAll();
    foreach($move_ins as $move_in)
    {
        $result[] = [
            'id'=>$move_in['id'],
            'rec_id' => $move_in['rec_id'],
            'requestor_name'=>$move_in['name'],
            'unit'=>$move_in['unit'],
            'approve'=>$move_in['approve'],
            'created_on'=>$move_in['created_on'],
            'sr_type'=>$move_in['sr_type']
        ];
    }

    $sth = $db->prepare("select * from {$account_db}.view_move_out where deleted_on=0");
    $sth->execute();
    $move_outs = $sth->fetchAll();
    foreach($move_outs as $move_out)
    {
        $result[] = [
            'id'=>$move_out['id'],
            'rec_id' => $move_out['rec_id'],
            'requestor_name'=>$move_out['name'],
            'unit'=>$move_out['unit'],
            'approve'=>$move_out['approve'],
            'created_on'=>$move_out['created_on'],
            'sr_type'=>$move_out['sr_type']
        ];
    }

    $sth = $db->prepare("select * from {$account_db}.view_work_permit where deleted_on=0");
    $sth->execute();
    $work_permits = $sth->fetchAll();
    foreach($work_permits as $work_permit)
    {
        $result[] = [
            'id'=>$work_permit['id'],
            'rec_id' => $work_permit['rec_id'],
            'requestor_name'=>$work_permit['name'],
            'unit'=>$work_permit['unit'],
            'approve'=>$work_permit['approve'],
            'created_on'=>$work_permit['created_on'],
            'sr_type'=>$work_permit['sr_type']
        ];
    }

    $new_result = [];

    foreach($result as $res){
        if($res['sr_type'] == $data['filter']['sr_type']){
            $new_result[] = $res; 
        }
    }
    
    if($data['filter']['sr_type'] == 'all'|| $data['filter']['sr_type'] == NULL){
        $new_result = $result;
    }

    $new_filtered_result = [];
    
    foreach($new_result as $res){
        if($res['approve'] == $data['filter']['approve']){
            $new_filtered_result[] = $res; 
        }
    }

    if($data['filter']['approve'] == NULL){
        $new_filtered_result = $new_result;
    }
    $return_value['success']= 1;
    $return_value['sr_data'] =$new_filtered_result;
    $return_value['record_count'] =count($new_filtered_result);
    
    

    
    
    // $return_value['post_data'] = $data;
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(), 'sql_test' => $sql_test];
}
echo json_encode($return_value);
