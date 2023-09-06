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

	$menus = [
		'dashboard' => [
				'icon'=> 'bi bi-columns-gap' ,
				'target' => '',
				'label' => "Dashboard",
				'submenus'=>[
					'dashboard'=>['label'=>'Dashboard','target'=> '']
				]],
		'tenant' => [
					'icon' => 'bi bi-people',
					'target' =>  '/tenant',
					'label' => "Resident Management",
					'submenus'=> [
						'tenant'=>['label'=>'Residents','target' =>  '/tenant'],
						'turnover'=>['label'=>'Turnover','target' =>  '/tenant/turnovers'],
						'punchlist'=>['label'=>'Punch List','target' =>  '/tenant/punchlists'],
						'moveio'=>['label'=>'Move In / Move Out','target' =>  '/tenant/movements'],
						'hr',
						'registration'=>['label'=>'Registrations','target' =>  '/visitor/index'],
						'gatepass'=>['label'=>'Gate Pass','target' =>  '/gatepass'],
						'servicerequest'=>['label'=>'Service Requests','target' =>  '/servicerequest'],
						'reservation'=>['label'=>'Reservations','target' =>  '/reservation'],
						'submittedforms'=>['label'=>'Submitted Forms','target' =>  '/form/submitted'],	
						'news'=>['label'=>'News and Announcements','target' =>  '/news'],	
						'hr',
						'billing' => ['label'=>'Billings','target'=> '/billing'],
						'pdc'=>['label'=>'PDC Tracker','target' =>  '/pdc'],
						'hr',
						'header' => ['label'=>'<h6><b>SETUP</b><h6>','target'=>''],
						'form' => ['label'=>'Types of Form','target'=> '/form'],
						'document' => ['label'=>'Types of Document','target'=> '/document'],
						'amenity' => ['label'=>'Amenities','target'=> '/amenity'],
						'rates'=>['label'=>'Rates','target' =>  '/rate'],
						'stages'=>['label'=>'Stages','target' =>  '/stage'],
				]],
		'propman' => [
						'icon' => 'bi bi-building',
						'target' => '/location',
						'label' => "Property Management",
						'submenus'=>[
							'location'=>['label'=>'Locations','target'=>  '/location'],
							'meter'=>['label'=>'Meters and Gauges', 'target'=>  '/meter'],
							'meterinput'=>['label'=>'Meter Input', 'target'=>  '/meter/meter-input'],
							// 'equipment'=>['label'=>'Equipment', 'target'=>  '/equipment'],
							// 'workorder'=>['label'=>'Work Orders', 'target'=>  '/workorder'],
							// 'pm'=>['label'=>'Preventive Maintenance', 'target'=>  '/pm'],
							
							// 'serviceproviders'=>['label'=>'Service Providers', 'target'=>  '/serviceprovider'],
							// 'technician'=>['label'=>'Technicians', 'target'=>  '/technician'],
							/*'incident'=>['label'=>'Incident Report', 'target'=>  '/incident'],*/
					]],
		'report' => [
			'icon' => 'bi bi-bar-chart',
			'target' =>  '/report/billing-collection',
			'label' => "Reports",
			'submenus'=> [
				'collection' => ['label'=>'Collection','target'=> '/report/billing-collection'],
				'unpaid' => ['label'=>'Unpaid','target'=> '/report/billing-unpaid'],
				'overdue' => ['label'=>'Overdue','target'=> '/report/billing-overdue'],
				'pdc' => ['label'=>'PDC for the Month','target'=> '/report/pdc-uncleared'],
				'generate' => ['label'=>'Generate Billing','target'=> '/report/billing-generate'],
			]],
		'setting' => [
			'icon' => 'bi bi-gear',
			'target' =>  '/setting',
			'label' => "Settings",
			'submenus'=> []
		],
	];

	$return_value = ['success'=>1,'description'=>'','data'=> ['details'=>$account,'settings'=>$settings,'menus'=>$menus]];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(),'data'=>[]];
}

echo json_encode($return_value);