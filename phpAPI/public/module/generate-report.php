<?php
try{
	$report = $data['report'];
	$view = $data['view'];
	if ($report=="sr-summary") {
		$condition = ($data['sr_type']=="ALL") ? "" : "and type='{$data['sr_type']}'";
		if ($data['generated_by']=="monthyear") {
			$sql = "select * from {$account_db}.{$view} where month(trans_date)=? and year(trans_date)=? $condition";
			$sth = $db->prepare($sql);	
			$sth->execute([ $data['month'],$data['year'] ]);
			$records = $sth->fetchAll();
		} else {
			$sql = "select * from {$account_db}.{$view} where trans_date between ? and ? $condition";
			$sth = $db->prepare($sql);	
			$sth->execute([ $data['from_date'],$data['to_date'] ]);
			$records = $sth->fetchAll();
		}
	} elseif ($report=="uc-summary") {
		$sql = "select * from {$account_db}.{$view} where month=? and year=?";
		$sth = $db->prepare($sql);	
		$sth->execute([ $data['month'],$data['year'] ]);
		$records = $sth->fetchAll();
	} elseif ($report=="ce") {
		$sql = "select * from {$account_db}.{$view} where 1=? and year_of=?";
		$sth = $db->prepare($sql);	
		$sth->execute([ $data['month'],$data['year'] ]);
		$records = $sth->fetchAll();
	}
	

	$return_value = ['success'=>1,'description'=>'Report generated.','data'=>$records];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);