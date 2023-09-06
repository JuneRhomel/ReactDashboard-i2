<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$id = ($data['id']) ? decryptData($data['id']) : 0;		unset($data['id']);
	$module = $data['module']; 								unset($data['module']);
	$table = $data['table']; 								unset($data['table']);
	$loc_id = $data['loc_id']; 								unset($data['loc_id']);
	$content = $data['content'];							unset($data['content']);
	// DEFINE UNIQUE FIELDS
	$arrUnique = [];
	if (isset($data['unique'])) {
		$arrUnique = explode(',',$data['unique']);
		unset($data['unique']);
	}
	if ($table=="contract")
		unset($data['company_name']);

	// EDIT RECORD ***********************************************************************
	if ($id) {
		if ($module=="soa") {
			$arrAmount = (array) $data['amount'];
			$soa_status = "Paid";
			// UPDATE SOA DETAIL			
			foreach($data['payment'] as $key=>$val) {
				if ($arrAmount[$key]!=$val)
					$soa_status = "Partially Paid";
				$sth = $db->prepare("update {$account_db}.{$table} set amount_bal=amount_bal-? where id=?");	
				$sth->execute([ $val, $key ]);
				// GET PARTICULAR
				$sth = $db->prepare("select particular from {$account_db}.soa_detail where id=?");	
				$sth->execute([ $key ]);
				$soa_detail = $sth->fetch();
				// INSERT INTO SOA_PAYMENT
				$sth = $db->prepare("insert {$account_db}.soa_payment set soa_id=?,payment_type=?,particular=?,amount=?,created_by=?,created_on=?");	
				$sth->execute([ $id, $data['payment_type'], $soa_detail['particular'], $val, $user_token['user_id'], time() ]);
			}
			// IF CHECK, INSERT INTO PDC
			if ($data['payment_type']=="Check") {
				// GET RESIDENT AND UNIT INFO
				$sth = $db->prepare("select a.resident_id,b.unit_id from {$account_db}.soa a left join {$account_db}.resident b on b.id=a.resident_id where a.id=?");	
				$sth->execute([ $id ]);
				$info = $sth->fetch();
				// ADD PDC
				$sth = $db->prepare("insert {$account_db}.pdcs set unit_id=?,resident_id=?,check_no=?,check_date=?,check_amount=?,status_id=1,created_by=?,created_on=?");	
				$sth->execute([ $info['unit_id'],$info['resident_id'], $data['check_no'], $data['check_date'], $data['check_amount'], $user_token['user_id'], time() ]);
			}
			// UPDATE SOA
			$sth = $db->prepare("update {$account_db}.soa set status=? where id=?");	
			$sth->execute([ $soa_status, $id ]);
		} else {
			// INIT UNIQUE FIELDS
			if ($arrUnique) {
				$unique_data['id'] = $id;
				foreach ($arrUnique as $unique) {
					$uniques[] = "{$unique}=:{$unique}";
					$unique_data[$unique] = $data[$unique];
				}
				// CHECK IF EXISTING DUPLICATE RECORD BASE ON UNIQUE FIELDS
				$sql = "select * from {$account_db}.{$table} where id<>:id and " . implode(" and ",$uniques);
				$sth = $db->prepare("select * from {$account_db}.{$table} where deleted_on=0 and id<>:id and " . implode(" and ",$uniques));
				$sth->execute($unique_data);
				$check = $sth->fetch();
				if ($check) {
					echo json_encode(['success'=>0,'description'=>'Duplicate record.']);
					exit;
				} 
			}

			$fields = [];
			foreach (array_keys($data) as $field) {
				$fields[] = "{$field}=:{$field}";
			}
			$sth = $db->prepare("update {$account_db}.{$table} set " . implode(",",$fields). " where id={$id}");
			$sth->execute($data);
		}

	// ADD RECORD ************************************************************************
	} else {
		if ($module=="util-setting") {			
			$sth = $db->prepare("update {$account_db}.{$table} set setting_value=? where setting_name='electricity_due_day'");
			$sth->execute([ $data['electricity_due_day'] ]);
			$sth = $db->prepare("update {$account_db}.{$table} set setting_value=? where setting_name='water_due_day'");
			$sth->execute([ $data['water_due_day'] ]);
		} else {
			// INIT UNIQUE FIELDS
			if ($arrUnique) {
				$unique_data = [];
				foreach ($arrUnique as $unique) {
					$uniques[] = "{$unique}=:{$unique}";
					$unique_data[$unique] = $data[$unique];
				}
				// CHECK IF EXISTING DUPLICATE RECORD BASE ON UNIQUE FIELDS
				$sth = $db->prepare("select * from {$account_db}.{$table} where deleted_on=0 and " . implode(" and ",$uniques));
				$sth->execute($unique_data);
				$check = $sth->fetch();
				if ($check) {
					echo json_encode(['success'=>0,'description'=>'Duplicate record.']);
					exit;
				} 
			}

			if ($table=="meter") {
				// CHECK IF EXISTING MOTHER METER
				if ($data['meter_type']=="Mother Meter") {
					$sth = $db->prepare("select * from {$account_db}.{$table} where deleted_on=0 and meter_type='Mother Meter' and utility_type=?");
					$sth->execute([ $data['utility_type'] ]);
					$check = $sth->fetch();
					if ($check) {
						echo json_encode(['success'=>0,'description'=>'Mother meter for '.strtolower($data['utility_type']).' already exist.']);
						exit;
					} 
				}
			}

			$data['created_by'] = $user_token['user_id'];
			$data['created_on'] = time();

			if ($module=='user-management') {
				$data['password'] = md5($data['password']); 
				$data['fcm_token'] = md5(randomString() . $data['user_id'] . time()); 
			}

			$fields = array_keys($data);
			$sth = $db->prepare("insert {$account_db}.{$table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
			$sth->execute($data);
			$id = $db->lastInsertId(); 
		}
	}
	/*if ($module=="stage") {
		// REARRANGE SORTING ORDER
		$sth = $db->prepare("select * from {$account_db}.stages where deleted_on=0 and stage_type=:stage_type and id<>:id and rank>=:rank order by rank");
		$sth->execute([ 'stage_type'=>$data['stage_type'],'rank'=>$data['rank'],'id'=>$id ]);
		$records = $sth->fetchAll();
		if ($records) {
			$ct = $data['rank']+1;
			foreach ($records as $record) {
				$sth = $db->prepare("update {$account_db}.stages set rank=:rank where id=:id");
				$sth->execute([ 'rank'=>$ct,'id'=>$record['id'] ]);
				$ct++;
			}
		}
	}*/

	$acctdir = DIR_ROOT . "/public/uploads/{$accountcode}/";
	if(!is_dir($acctdir)) {
		mkdir($acctdir,0777,true);
	}

	$dir = DIR_ROOT . "/public/uploads/{$accountcode}/contract_template/";
	if(!is_dir($dir)) {
		mkdir($dir,0777,true);
	}

	if ($module=="contract") {
		// UPDATE UNIT RENTED BY TENANT IN RESIDENT TABLE
		$sth = $db->prepare("update {$account_db}.resident set unit_id=? where id=?");
		$sth->execute([ $data['unit_id'],$data['resident_id'] ]);
	}	

	if ($module=="contract-template") {
		// PROCESS CONTENT OF CONTRACT TEMPLATE
		$filename =  DIR_ROOT . "/public/uploads/$accountcode/contract_template/{$id}.html";
		file_put_contents($filename,$content);
	}

	if ($module=="contract-field") {
		// ADD NEW FIELD TO CONTRACT
		$sth = $db->prepare("alter table {$account_db}.contract add {$data['fieldname']} varchar(255)");
		$sth->execute();

		// UPDATE CONTRACT VIEW
		$sth = $db->prepare("create or replace view {$account_db}.vw_contract as 
			select a.*,b.fullname AS resident_name,c.location_name AS unit_name,d.template AS template_name,concat(to_days(a.end_date) - to_days(a.start_date),' day(s)') AS expire_days 
			from ((({$account_db}.contract a left join {$account_db}.vw_resident b on(b.id = a.resident_id)) left join {$account_db}.location c on(c.id = a.unit_id)) left join {$account_db}.contract_template d on(d.id = a.template_id)) 
			where a.deleted_on = 0");
		$sth->execute();
	}

	$return_value = ['success'=>1,'description'=>'Record saved.','loc_id'=>$loc_id,'module'=>$module,'sql'=>$sql,'detail'=>$data['payment'],'tmp'=>$tmp];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'sql'=>$sql,'uniquedata'=>$unique_data];
}
echo json_encode($return_value);