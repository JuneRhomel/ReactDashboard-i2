<?php

//get units
$sth = $db->prepare("select tenant_locations.*,tenants.tenant_name,locations.location_name,locations.floor_area from {$account_db}.tenant_locations left join  {$account_db}.tenants on tenants.id=tenant_locations.tenant_id  left join {$account_db}.locations on locations.id=tenant_locations.location_id");
$sth->execute();
$units = $sth->fetchAll();

//get association dues rate
$sth = $db->prepare("select * from {$account_db}.rates where rate_name='Association Dues'");
$sth->execute();
$rate = $sth->fetch();

// 22-0905 atr: get monthly interest rate
$sth = $db->prepare("select * from {$account_db}.rates where rate_code='INT'");
$sth->execute();
$rate_int = $sth->fetch();

foreach($units as $index=>$unit)
{
	$amount = $rate['rate_value'] * floatval($unit['floor_area']);
	$units[$index]['location_name'] = $units[$index]['location_name'] . " ({$unit['floor_area']} sqm)";
	$units[$index]['asso_dues'] = number_format($amount,2);
	$units[$index]['info'] = "{$rate['rate_value']} per sqm";

	//save to billing records;
	$sth = $db->prepare("insert into {$account_db}.billings set tenant_id=?,billing_date=?,billing_type=?,amount=?,created_on=?,created_by=?,due_date=?,location_id=?");
	$sth->execute([
		$unit['tenant_id'],
		date('Y-m-d'),
		'Association Dues',
		$amount,
		time(),
		$user_id,
		date('Y-m-d',strtotime("+7 days")),
		$unit['location_id']
	]);

	// 22-0905 atr: check if there are balances in asso. dues of each tenant
	$sth = $db->prepare("select sum(amount-payment) as sumamt from {$account_db}.view_billings where deleted_on=0 and amount-payment>0 and tenant_id=? and location_id=?");
	$sth->execute([
		$unit['tenant_id'],
		$unit['location_id']
	]);
	$balances = $sth->fetch();
	$unpaid_balance = $interest = 0;
	if ($balances) {
		if ($balances['sumamt']>0) {
			$unpaid_balance = $balances['sumamt'];
			// if there is unpaid balance create new billing
			$interest = $unpaid_balance * ($rate_int['rate_value']/100);
			$sth = $db->prepare("insert into {$account_db}.billings set tenant_id=?,billing_date=?,billing_type=?,amount=?,created_on=?,created_by=?,due_date=?,location_id=?");
			$sth->execute([
				$unit['tenant_id'],
				date('Y-m-d'),
				'Interest',
				$interest,
				time(),
				$user_id,
				date('Y-m-d',strtotime("+7 days")),
				$unit['location_id']	
			]);
		}
	}
	$units[$index]['unpaid_balance'] = number_format($unpaid_balance,2);
	$units[$index]['interest'] = number_format($interest,2);
	$units[$index]['amount'] = number_format($amount+$interest,2);

}

echo json_encode($units,JSON_NUMERIC_CHECK);