<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$reading_datetime =  $data['reading_date']." ".date('H:i:s');

	// SAVE PHOTO FILE
	/*$filename =  '';
	$upload_url = '';
	if($_FILES['files']['error'][$key] == 0)
	{
		$name = $_FILES['files']["name"][$key];
		$ext = end((explode(".", $name)));
		$filename = uniqueFilename($ext);

		$upload_dir = DIR_UPLOADS . DS . 'cm_files' . DS . decryptData($this->session->getAccount());
		$upload_url = '/uploads/cm_files/' . decryptData($this->session->getAccount()) . '/' . $filename;
		if(!is_dir($upload_dir))
		{
			mkdir($upload_dir);
		}

		move_uploaded_file($_FILES['files']['tmp_name'][$key],$upload_dir  . DS . $filename);
	}*/

	$sth = $db->prepare("select * from {$account_db}.meter_readings where meter_id=:meter_id and reading_datetime=:reading_datetime");
	$sth->execute([ 'meter_id'=>$data['meter_id'],'reading_datetime'=>$reading_datetime ]);
	$record = $sth->fetch();
	if (!$record) {
		$sth = $db->prepare("insert into {$account_db}.meter_readings set meter_id=:meter_id,reading=:reading,reading_datetime=:reading_datetime,note=:note,amount=:amount");
		$data0 = [
			'meter_id'=>$data['meter_id'],
			'reading'=>$data['reading'],
			'reading_datetime'=>$reading_datetime,
			'note'=>$data['note'],
			'amount'=>$data['amount'],
		];
		$sth->execute($data0);
	}

	// RECOMPUTE COMPSUMPTION STARTING FROM BEGINNING
	$sth = $db->prepare("select * from {$account_db}.meter_readings where meter_id=:meter_id order by id");
	$sth->execute([ 'meter_id'=>$data['meter_id'] ]);
	$records = $sth->fetchAll();

	$ct = 1;
	// LOOP THRU ALL READINGS OF METER
	foreach ($records as $val) {
		if ($ct==1) {
			$consumption = 0;
			$reading = $val['reading'];
		} else {
			$consumption = $val['reading'] - $reading;
			$reading = $val['reading'];
		}
		// UPDATE DELTA
		$sth = $db->prepare("update {$account_db}.meter_readings set consumption=:consumption where id=:reading_id");
		$sth->execute([ 'reading_id'=>$val['id'],'consumption'=>$consumption ]);
		$ct++;
	}

	$return_value = ['success'=>1,'description'=>'Record saved.'];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);