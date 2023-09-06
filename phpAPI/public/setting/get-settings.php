<?php
$return_value = ['success'=>1,'data'=>[]];
try{
	$sth = $db->prepare("select * from {$account_db}.settings");
	$sth->execute();
	$settings_tmp = $sth->fetchAll();

	$settings = [];
	foreach($settings_tmp as $st)
	{
		$settings[$st['setting_name']] = $st['setting_value'];
	}
	$return_value['data'] = $settings;
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);