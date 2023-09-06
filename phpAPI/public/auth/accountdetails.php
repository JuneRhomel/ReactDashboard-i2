<?php
$return_value = ['success'=>1,'description'=>'','data'=>[]];
try{
	//get account details

	$sth = $db->prepare('select id as account_id,account_code,account_name,session_timeout,2fa_enable from accounts where account_code=:account_code');
	$sth->execute(['account_code'=>$accountcode]);
	$account = $sth->fetch();
	if(!$account)
		throw new Exception("Account not found or has not been configured.");

	$sth = $db->prepare('select * from ' . DB_NAME . '_' . $account['account_id'] . '._settings where deleted_at=0');
	$sth->execute();
	$settings_rows = $sth->fetchAll();
	$settings = [];
	foreach($settings_rows as $setting)
	{
		$settings[$setting['setting_name']] = ['value'=>$setting['setting_value'],'label'=>($setting['setting_label'] ?? '')];
	}

	$return_value = ['success'=>1,'description'=>'','data'=> ['details'=>$account,'settings'=>$settings]];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'data'=>[]];
}

echo json_encode($return_value);