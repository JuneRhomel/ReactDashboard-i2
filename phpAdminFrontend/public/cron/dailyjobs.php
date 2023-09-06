<?php
include('../../../apii2-sandbox.inventiproptech.com/config.php');
include('../../../apii2-sandbox.inventiproptech.com/db.php');
include('../../../apii2-sandbox.inventiproptech.com/shared.php');
include('../../../apii2-sandbox.inventiproptech.com/mailer/mailer.class.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try{
	// GET ALL ACTIVE ACCOUNTS
	$sth = $db->prepare("select id from otsi2.accounts where is_active=1");
	$sth->execute();
	$accounts = $sth->fetchAll();

	foreach($accounts as $account) {
		// CHECK FIRST IF THERE IS CONTRACT TABLE IN THAT ACCOUNT
		$sth = $db->prepare("select * from information_schema.tables where table_schema=? and table_name='contract'");
		$sth->execute([ "otsi2_{$account['id']}" ]);
		$check = $sth->fetch();
		if ($check) {
			// CHECK FOR EXPIRED CONTRACT AND UPDATE STATUS TO EXPIRED
			$sth = $db->prepare("select * from otsi2_{$account['id']}.contract where status='Active' and curdate()>end_date");
			$sth->execute();
			$contracts = $sth->fetchAll();
			foreach($contracts as $contract) {
				// SET STATUS TO EXPIRED IN CONTRACT
				$sth = $db->prepare("update otsi2_{$account['id']}.contract set status='Expired' where id=?");
				$sth->execute([ $contract['id'] ]);
				// RESET UNIT NO TO ZERO IN RESIDENT
				$sth = $db->prepare("update otsi2_{$account['id']}.resident set unit_id=0 where id=?");
				$sth->execute([ $contract['resident_id'] ]);
			}
		}

		// *******************************************************************************
		// ADD CURRENT SERVICE REQUEST TO NOTIF
		// *******************************************************************************
		// CHECK GATE PASS FOR TODAY WHERE APPROVE=1 FOR APPROVED
		$sql = "select a.*,b.category_name from otsi2_{$account['id']}.gatepass a left join otsi2_{$account['id']}.list_gatepasscategory b on b.id=a.gp_type 
			where a.deleted_on=0 and a.approve=1 and a.gp_date=curdate()";
		$sth = $db->prepare($sql);
		$sth->execute();
		$records = $sth->fetchAll();
		foreach($records as $record) {
			$datetime = date("m/d/Y h:m A",strtotime($record['gp_date'].' '.$record['gp_time']));
			$description = "{$record['category_name']} on {$datetime}";
			$sth = $db->prepare("insert into otsi2_{$account['id']}.notif set occupant_id=?,title=?,description=?,created_on=unix_timestamp()");
			//$sth->execute([ $record['name_id'],"Gass Pass",$description ]);
		}
		// CHECK VISITOR PASS FOR TODAY WHERE APPROVE=1 FOR APPROVED
		$sql = "select a.* from otsi2_{$account['id']}.visitorpass a 
			where a.deleted_on=0 and a.approve=1 and a.arrival_date=curdate()";
		$sth = $db->prepare($sql);
		$sth->execute();
		$records = $sth->fetchAll();
		foreach($records as $record) {
			$datetime = date("m/d/Y h:m A",strtotime($record['arrival_date'].' '.$record['arrival_time']));
			$description = "Visitor(s) arriving on {$datetime}";
			$sth = $db->prepare("insert into otsi2_{$account['id']}.notif set occupant_id=?,title=?,description=?,created_on=unix_timestamp()");
			//$sth->execute([ $record['name_id'],"Visitor Pass",$description ]);
		}
		// CHECK WORK PERMIT FOR TODAY WHERE STATUS_ID=1 FOR OPEN
		$sql = "select a.*,b.category from otsi2_{$account['id']}.workpermit a left join otsi2_{$account['id']}.list_workpermitcategory b on b.id=a.workpermitcategory_id
			where a.deleted_on=0 and a.status_id=1 and a.start_date=curdate()";
		$sth = $db->prepare($sql);
		$sth->execute();
		$records = $sth->fetchAll();
		foreach($records as $record) {
			$date = date("m/d/Y",strtotime($record['start_date']));
			$description = "{$record['category']} on {$date}";
			$sth = $db->prepare("insert into otsi2_{$account['id']}.notif set occupant_id=?,title=?,description=?,created_on=unix_timestamp()");
			$sth->execute([ $record['name_id'],"Work Permit",$description ]);
		}
	}
	


	echo "DONE";

} catch(Exception $e) {
	echo "ERROR: ".$e->getMessage();
}