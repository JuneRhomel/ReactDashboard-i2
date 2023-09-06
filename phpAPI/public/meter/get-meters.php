<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$condition = "";
	if ($data['meter_id']!="")
		$condition = " and id=".$data['meter_id'];
	elseif ($data['tenant_id']!="")
		$condition = " and tenant_id=".$data['tenant_id'];
	elseif ($data['meter_type']!="ALL")
		$condition = " and meter_type='{$data['meter_type']}'";
	$sth = $db->prepare("select * from {$account_db}.view_meters where mmeter_id<>0 $condition");
	$sth->execute();
	$return_value = $sth->fetchAll();

	//get last readings
	foreach($return_value as $key=>$val) {       
		$return_value[$key]['last_reading'] = $return_value[$key]['last_consumption'] = 0; 
		$return_value[$key]['last_reading_date'] = 'N/A';

		$sth = $db->prepare("select * from {$account_db}.meter_readings where meter_id=".$val['id']." order by reading_datetime desc");
		$sth->execute();
		$record = $sth->fetch();
		if ($record) {       
			$return_value[$key]['last_reading'] = number_format($record['reading'],3);
			$return_value[$key]['last_reading_date'] = $record['reading_datetime'];
			$return_value[$key]['last_consumption'] = $record['consumption'];
		}
	}
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);