<?php
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
				'br', 'br',
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

?>
<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta charset="UTF-8">
		<title><?php echo ($title ?? TITLE);?></title>
		<link rel="icon" type="image/png" href="<?php echo WEB_ROOT;?>/images/favicon.png">	
		<link href="<?php echo WEB_ROOT;?>/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
		<link href="<?php echo WEB_ROOT;?>/themes/default/style.css?a=1" rel="stylesheet">
		<link href="<?php echo WEB_ROOT;?>/themes/default/menu.css" rel="stylesheet">
		<link href="<?php echo WEB_ROOT;?>/css/aindata.box.css" rel="stylesheet">
		<link href="<?php echo WEB_ROOT;?>/css/jquery.datetimepicker.min.css" rel="stylesheet">
		<link href="<?php echo WEB_ROOT;?>/css/dashboard.css" rel="stylesheet">
		<link href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css" rel="stylesheet">
		<script src="<?php echo WEB_ROOT;?>/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
		<script src="<?php echo WEB_ROOT;?>/js/jquery-datetimepicket.full.min.js"></script>
		<script src="<?php echo WEB_ROOT;?>/js/aindata.box.js"></script>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
		<!-- TOASTR - NON-BLOCKING NOTIFS -->
		<link href="<?php echo WEB_ROOT;?>/css/toastr.css" rel="stylesheet">
		<script src="<?php echo WEB_ROOT;?>/js/toastr.min.js"></script>		
	</head>
	<body>
	<nav class="sidebar <?php echo ($_SESSION['menuopen'] ?? 'false') == 'false' ? 'close' : '';?>">
		<header>
			<div class="image-text">
				<span class="menu_logo image <?php echo ($_SESSION['menuopen'] ?? 'false') == 'false' ? 'd-none' : '';?>">
					<?php if(isset($accountdetails['settings']['menu_logo']['value'])):?>
						<img src="<?php echo $accountdetails['settings']['content_logo']['value'];?>" style="max-height:40px;max-width:100%">
					<?php else:?>
						<img src="<?php echo WEB_ROOT;?>/images/whitelogo.png" style="max-height:40px;max-width:100%">
					<?php endif;?>
				</span>

				<i class='bi bi-list toggle-menu <?php echo ($_SESSION['menuopen'] ?? 'false') == 'false' ? '' : 'd-none';?>' style="font-size:2em"></i>

				<!--div class="text logo-text">
					<span class="name"><?php echo $accountdetails['details']['account_name'];?></span>
					<span class="profession">Web developer</span>
				</div-->
			</div>

			<!--i class='bi bi-list toggle'></i-->
		</header>

		<div class="menu-bar">
			<div class="menu">
				<ul class="menu-links">
					<?php foreach($menus as $index=>$menu):?>
						<li class="nav-link">
							<a class="nav-link text-nowrap <?php echo $menuid == $index ? 'active' : '';?>" title="<?php echo $menu['label'];?>" data-menuindex="<?php echo $index;?>" href="<?php echo WEB_ROOT . $menu['target'];?>?menuid=<?php echo $index;?>&submenuid="><i class="<?php echo $menu['icon'];?> nav-icon icon"></i> <?php echo $menu['label'];?></a>
						</li>
					<?php endforeach;?>

				</ul>
			</div>

			<div class="bottom-content">
				<li class="">
					<a href="<?php echo WEB_ROOT;?>/auth/logout">
						<i class='bi bi-door-closed icon' ></i>
						<span class="text nav-text">Logout</span>
					</a>
				</li>

				<!--li class="mode">
					<div class="sun-moon">
						<i class='bx bx-moon icon moon'></i>
						<i class='bx bx-sun icon sun'></i>
					</div>
					<span class="mode-text text">Dark mode</span>

					<div class="toggle-switch">
						<span class="switch"></span>
					</div>
				</li-->
				
			</div>
		</div>

	</nav>
	<section class="home ml-5 <?php echo ($_SESSION['menuopen'] ?? 'false') == 'false' ? 'ps-2' : '';?>">
		<div class="justify-content-center">
			<div class="p-2 bg-white d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
				<i class='bi bi-list toggle-menu <?php echo ($_SESSION['menuopen'] ?? 'false') == 'false' ? 'd-none' : '';?>' style="font-size:2em"></i>
				<a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-decoration-none">
					<?php if(isset($accountdetails['settings']['content_logo']['value'])):?>
						<img class="content_logo <?php echo ($_SESSION['menuopen'] ?? 'false') == 'false' ? '' : 'd-none';?>" src="<?php echo $accountdetails['settings']['content_logo']['value'];?>" style="max-height:40px;max-width:100%">
					<?php else:?>
						<img class="content_logo <?php echo ($_SESSION['menuopen'] ?? 'false') == 'false' ? '' : 'd-none';?>" src="<?php echo WEB_ROOT;?>/images/logoblue.png" style="max-height:40px;max-width:100%">
					<?php endif;?>
				</a>

				<ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
					<li>
						<div class="pe-4 pt-2">
							<i class="bi bi-envelope sile-notification-icon ps-2"></i> 
							
							<i class="ps-2 bi bi-bell sile-notification-icon"></i>
						</div>
					</li>
					<li>
						<div class="vertical-line"></div>
					</li>
					<li class="justify-content-center my-md-0 ">
						<div class="ps-2 pt-2 user-name"><span class="login-name"><?php echo $ots->session->getUserName();?></span></div>
						<div class="ps-2 user-role"><span class="login-role"><?php echo count($ots->session->getUserRoles()) ? implode(", ",$ots->session->getUserRoles()) : 'No Role';?></span></div>
					</li>
					<li class="ps-2">
						<img src="<?php echo WEB_ROOT;?>/images/user-img-anon.png" class="user-img">
					</li>
				</ul>
			</div>
		</div>
		<div class="d-flex flex-grow-1 main-display-container">
		
			<div class="sub-menu-container <?php echo in_array($menuid,['dashboard','setting']) ? 'd-none' : '';?>">
			<i class="fi fi-rs-arrow-to-left"></i>
				<div class="module-title w-50 mt-4"><?php echo $menus[$menuid]['label']	;?></div>
				<ul class="sub-menu-list col-12 col-lg-auto my-2 my-md-0 text-small p-1">
					<?php $submenuctr = 1;?>
					<?php foreach($menus[$menuid]['submenus'] as $index=>$submenu):?>
						<?php if(!is_array($submenu) && $submenu == 'hr'):?>
							<li class="nav-sub-link"><hr></li>
						<?php else:?>
							<li class="nav-sub-link <?php echo ($submenuid == $index || ($submenuctr == 1 && $submenuid == '')) ? 'active' : '';?> "><a class="nav-sub-link  <?php echo ($submenuid == $index || ($submenuctr == 1 && $submenuid == '')) ? 'active' : '';?>"  data-menuindex="<?php echo $index;?>" href="<?php echo WEB_ROOT;?><?php echo $submenu['target'];?>?submenuid=<?php echo $index;?>"><?php echo $submenu['label'];?></a></li>
						<?php endif;?>
						<?php $submenuctr++;?>
					<?php endforeach;?>
				</ul>
			</div>
			<div class="main-display flex-grow-1">