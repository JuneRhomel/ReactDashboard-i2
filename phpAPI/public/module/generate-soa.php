<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$month_of = $data['month_of'];
	$year_of = $data['year_of'];
	$month = date("F",strtotime("2023-{$month_of}-01"));
	$prev_month = intval(date("m",strtotime("-1 month", strtotime("$year_of-$month_of-01"))));
	$prev_year = intval(date("Y",strtotime("-1 month", strtotime("$year_of-$month_of-01"))));
	$prev_month_word = date("F",strtotime("2023-{$prev_month}-01"));

	// DELETE EXISTING RECORDS FOR THE MONTH/YEAR
	// Delete in SOA Detail
	$sql = "delete {$account_db}.soa_detail, {$account_db}.soa 
		from {$account_db}.soa_detail left join {$account_db}.soa on {$account_db}.soa.id={$account_db}.soa_detail.soa_id 
		where {$account_db}.soa.month_of=? and {$account_db}.soa.year_of=?";
	$sth = $db->prepare($sql);
	$sth->execute([ $month_of,$year_of ]);
	// Delete in SOA Payment
	$sql = "delete {$account_db}.soa_payment, {$account_db}.soa 
		from {$account_db}.soa_payment left join {$account_db}.soa on {$account_db}.soa.id={$account_db}.soa_payment.soa_id 
		where {$account_db}.soa.month_of=? and {$account_db}.soa.year_of=?";
	$sth = $db->prepare($sql);
	$sth->execute([ $month_of,$year_of ]);
	// Delete in SOA
	$sth = $db->prepare("delete from {$account_db}.soa where month_of=? and year_of=?");
	$sth->execute([ $month_of,$year_of ]);
	// END >>> DELETE EXISTING RECORDS FOR THE MONTH/YEAR

	// CREATE SOA FOR THE MONTH/YEAR
	$sql = "insert into {$account_db}.soa (resident_id,month_of,year_of,balance,charge_amount,electricity,water,current_charges,amount_due,due_date,status,created_by,created_on) 
		select a.id,$month_of,$year_of,0,b.monthly_rate,0,0,0,0,date_format(concat(year(curdate()),'-',month(curdate()),'-',b.day_due),'%Y-%m-%d'),'Unpaid',".$user_token['user_id'].",".time()." 
		from {$account_db}.resident a left join {$account_db}.contract b on b.resident_id=a.id 
		where a.deleted_on=0 and b.deleted_on=0 and b.status='Active'";
	$sth = $db->prepare($sql);
	$sth->execute();

	// SET 'POSTED' OF PREVIOUS SOA TO TRUE SO ADMIN CAN'T PAY
	$sth = $db->prepare("update {$account_db}.soa set posted=1 where month_of=? and year_of=?");
	$sth->execute([ intval($prev_month),intval($prev_year) ]);

	// GET PREVIOUS BALANCE IF ANY
	$sql = "select b.soa_id,a.resident_id,sum(b.amount_bal) as balance from {$account_db}.soa a left join {$account_db}.soa_detail b on b.soa_id=a.id where a.month_of=? and a.year_of=? group by b.soa_id,a.resident_id";
	$sth = $db->prepare($sql);
	$sth->execute([ intval($prev_month),intval($prev_year) ]);
	$soa = $sth->fetchAll();
	if ($soa) {
		foreach($soa as $key=>$val) {
			if ($val['balance']>0) {
				// GET SOA ID
				$sql = "select id from {$account_db}.soa where month_of=? and year_of=? and resident_id=?";
				$sth = $db->prepare($sql);
				$sth->execute([ $month_of,$year_of,$val['resident_id'] ]);
				$rec = $sth->fetch();
				if ($rec) {
					$soa_id = $rec['id'];
					// UPDATE SOA BALANCE
					$sth = $db->prepare("update {$account_db}.soa set balance=? where id=?");
					$sth->execute([ $val['balance'],$soa_id ]);					
					// INSERT INTO SOA DETAIL
					$sth = $db->prepare("insert into {$account_db}.soa_detail set soa_id=?,type='Balance',particular=?,amount=?,amount_bal=?,created_by=?,created_on=?");
					$sth->execute([ $soa_id,"Balance - $prev_month_word $year_of",$val['balance'],$val['balance'],$user_token['user_id'],time() ]);	
				}
			}
		}
	}

	// INSERT RENTAL FEE INTO SOA DETAIL
	$sql = "select id,charge_amount from {$account_db}.soa where month_of=? and year_of=?";
	$sth = $db->prepare($sql);
	$sth->execute([ $month_of,$year_of ]);
	$soa = $sth->fetchAll();
	if ($soa) {
		foreach($soa as $key=>$val) {
			// INSERT INTO SOA DETAIL
			$sth = $db->prepare("insert into {$account_db}.soa_detail set soa_id=?,type='Charge',particular=?,amount=?,amount_bal=?,created_by=?,created_on=?");
			$sth->execute([ $val['id'],"Rental Fee - $month $year_of",$val['charge_amount'],$val['charge_amount'],$user_token['user_id'],time() ]);	
		}
	}


	$elec_rate = $water_rate = 0;
	// GET ELECTRICITY CHARGES
	$sql = "select * from {$account_db}.billing_and_rates where utility_type='Electricity' and months=? and year=?";
	$sth = $db->prepare($sql);
	$sth->execute([ $prev_month,$prev_year ]);
	$elec_mmeter = $sth->fetch();
	if ($elec_mmeter)
		$elec_rate = $elec_mmeter['rate_'];
	// GET WATER CHARGES
	$sql = "select * from {$account_db}.billing_and_rates where utility_type='Water' and months=? and year=?";
	$sth = $db->prepare($sql);
	$sth->execute([ $prev_month,$prev_year ]);
	$water_mmeter = $sth->fetch();
	if ($water_mmeter)
		$water_rate = $water_mmeter['rate_'];

	// LOOP THRU SOA AND UPDATE CHARGES
	$sql = $sql0 = "select a.id as soa_id,c.id,c.meter_name,c.utility_type,d.reading,d.consumption from {$account_db}.soa a left join {$account_db}.resident b on b.id=a.resident_id left join {$account_db}.meter c on c.unit_id=b.unit_id left join {$account_db}.meter_readings d on d.meter_id=c.id where a.deleted_on=0 and b.deleted_on=0 and c.deleted_on=0 and d.deleted_on=0 and a.month_of=:month and a.year_of=:year and d.month=:prev_month and d.year=:prev_year and b.unit_id<>0 and (c.id is not null)";
	$sth = $db->prepare($sql);
	$sth->execute([ 'month'=>$month_of,'year'=>$year_of,'prev_month'=>$prev_month,'prev_year'=>$prev_year ]);
	$soa = $sth->fetchAll();
	if ($soa) {
		foreach($soa as $key=>$val) {
			$soa_id = $val['soa_id'];
			$consumption = $val['consumption'];
			if ($consumption>0) {
				if ($val['utility_type']=="Electricity") {				
					$electricity = $consumption * $elec_rate;				
					$sth = $db->prepare("update {$account_db}.soa set electricity=? where id=?");
					$sth->execute([ $electricity,$soa_id ]);
					// INSERT INTO SOA DETAIL
					$sth = $db->prepare("insert into {$account_db}.soa_detail set soa_id=?,type='Electricity',particular=?,amount=?,amount_bal=?,created_by=?,created_on=?");
					$sth->execute([ $soa_id,"Electricity - $month $year_of ($consumption kWh)",$electricity,$electricity,$user_token['user_id'],time() ]);
				} elseif ($val['utility_type']=="Water") {
					$water_consumption = floatval($consumption);
					$water = $consumption * $water_rate;
					$sth = $db->prepare("update {$account_db}.soa set water=? where id=?");
					$sth->execute([ $water,$soa_id ]);
					// INSERT INTO SOA DETAIL
					$sth = $db->prepare("insert into {$account_db}.soa_detail set soa_id=?,type='Water',particular=?,amount=?,amount_bal=?,created_by=?,created_on=?");
					$sth->execute([ $soa_id,"Water - $month $year_of ($consumption cum)",$water,$water,$user_token['user_id'],time() ]);
				}
			}
		}
	}

	// UPDATE CURRENT CHARGES AND AMOUNT DUE IN SOA
	$sql = "update {$account_db}.soa set current_charges = charge_amount + electricity + water, amount_due = balance + charge_amount + electricity + water where month_of=? and year_of=?";
	$sth = $db->prepare($sql);
	$sth->execute([ $month_of,$year_of ]);

	$return_value = ['success'=>1,'description'=>"SOA generate for $month $year_of.","soa"=>$soa,"water_rate"=>$water_rate,"water"=>$water,"consumption"=>$water_consumption,"tmp"=>$water];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}
echo json_encode($return_value);