<?php
// MENU FOR DESKTOP
$menu = [
	[
		"label" => 'Property Management',
		"icon" => '<span class="material-icons">apartment</span>',
		'submenu' => [
			[
				"location" => 'Location Library',
				'target' => WEB_ROOT . "/location/",
				'icon' => '<span class="material-symbols-outlined">location_on</span>'
			],
			[
				"location" => 'Building Personnel',
				'target' => WEB_ROOT . "/personnel/",
				'icon' => '<span class="material-icons">contacts</span>'
			],
			// [
			// 	"location" => 'Equipment Library',
			// 	'target' => "equipment",
			// 	'icon' => '<span class="material-symbols-outlined">location_on</span>'
			// ],
			// [
			// 	"location" => 'Preventive Maintenance',
			// 	'target' => "preventive",
			// 	'icon' => '<span class="material-symbols-outlined">location_on</span>'
			// ],
			// [
			// 	"location" => 'Corrective Maintenance',
			// 	'target' => "corrective",
			// 	'icon' => '<span class="material-symbols-outlined">location_on</span>'
			// ],
			// [
			// 	"location" => 'Work Orders',
			// 	'target' => "work",
			// 	'icon' => '<span class="material-symbols-outlined">location_on</span>'
			// ],
			// [
			// 	"location" => 'Building Personnel',
			// 	'target' => "building",
			// 	'icon' => '<span class="material-symbols-outlined">location_on</span>'
			// ],
			// [
			// 	"location" => 'Service Provider',
			// 	'target' => "service",
			// 	'icon' => '<span class="material-symbols-outlined">location_on</span>'
			// ],
		]
	], [
		"label" => 'Resident Management',
		"icon" => '<span class="material-icons">assignment_ind</span>',
		'submenu' => [
			[
				'location' => 'Resident',
				'target' => WEB_ROOT . '/resident/',
				'icon' => '<span class="material-icons">people_alt</span>'
			],
			[
				'location' => 'Tenant Registration',
				'target' => WEB_ROOT . '/tenant/tenant-registration',
				'icon' => '<span class="material-icons">person_add</span>'
			],
			[
				'location' => 'Tenant Billing',
				'target' => WEB_ROOT . '/tenant/tenant-billing',
				'icon' => '<span class="material-icons">account_box</span>'
			],
			[
				'location' => 'Service Request',
				'target' => WEB_ROOT . '/tenant/service-request',
				'icon' => '<span class="material-icons">receipt</span>'
			],
			[
				'location' => 'Building Application Forms',
				'target' => WEB_ROOT . '/tenant/building-application',
				'icon' => '<span class="material-icons">file_copy</span>'
			],
			[
				'location' => 'PDC Tracker',
				'target' => WEB_ROOT . '/tenant/pdc-tracker',
				'icon' => '<span class="material-symbols-outlined">folder_shared</span>'
			],

		]
	],
	[
		"label" => 'Utility Management',
		"icon" => '<span class="material-icons">settings_input_svideo</span>',
		'submenu' => [
			[
				'location' => 'Meter List',
				'target' => WEB_ROOT . '/utilities/meter-list',
				'icon' => '<span class="material-symbols-outlined">readiness_score</span>'
			],
			[
				'location' => 'Input Reading',
				'target' => WEB_ROOT . '/input-reading',
				'icon' => '<span class="material-symbols-outlined">move_to_inbox</span>'
			],
			[
				'location' => 'Utilities Biling & Rates',
				'target' => WEB_ROOT . '/utilities/utilities-billing-rates',
				'icon' => '<span class="material-symbols-outlined">speed</span>'
			],
			[
				'location' => 'Generate Billing',
				'target' => WEB_ROOT . '/utilities/generate-billing',
				'icon' => '<span class="material-symbols-outlined">invert_colors</span>'
			],
			[
				'location' => 'Meter Reading History',
				'target' => WEB_ROOT . '/utilities/meter-reading-history',
				'icon' => '<span class="material-symbols-outlined">history</span>'
			],
		]
	],
	[
		"label" => 'Permits And Contracts',
		"icon" => '<span class="material-icons">
		file_copy
		</span>',
		'submenu' => [
			[
				'location' => 'Permit Tracker',
				'target' => WEB_ROOT . '/contracts/permit-tracker',
				'icon' => '<span class="material-icons">subtitles</span>'
			],
			[
				'location' => 'Contract Tracker',
				'target' => WEB_ROOT . '/contracts/contract-tracker',
				'icon' => '<span class="material-icons">business</span>'
			],
		]
	],
	[
		"label" => 'Reports',
		"icon" => '<span class="material-icons">insert_chart</span>',
		'submenu' => [
			[
				'location' => 'Work Order Summary',
				'target' => WEB_ROOT . '/report/wo-summary',
				'icon' => '<span class="material-icons">build</span>'
			],
			[
				'location' => 'Service Request Summary',
				'target' => WEB_ROOT . '/report/sr-summary',
				'icon' => '<span class="material-icons">assignment_returned</span>'
			],
			[
				'location' => 'Utilities Consumption',
				'target' => WEB_ROOT . '/report/utilities-consumption',
				'icon' => '<span class="material-symbols-outlined">work</span>'
			],
			[
				'location' => 'Collection Efficiency',
				'target' => WEB_ROOT . '/report/collection-efficiency',
				'icon' => '<span class="material-icons">group_work</span>'
			],
			[
				'location' => 'Collection Efficiency',
				'target' => WEB_ROOT . '/report/operational-expenditures',
				'icon' => '<span class="material-symbols-outlined">work</span>'
			],
		]
	],
	[
		"label" => 'Admin',
		"icon" => '<span class="material-icons">supervisor_account</span>',
		'submenu' => [
			[
				'location' => 'Import Equipment',
				'target' => WEB_ROOT . '/admin/import-equipments',
				'icon' => '<span class="material-symbols-outlined">import_contacts</span>'
			],
			[
				'location' => 'Import Tenants',
				'target' => WEB_ROOT . '/admin/import-tenants',
				'icon' => '<span class="material-icons">supervised_user_circle</span>'
			],
			[
				'location' => 'Import Meters',
				'target' => WEB_ROOT . '/admin/import-meters',
				'icon' => '<span class="material-symbols-outlined">folder_shared</span>'
			],
			[
				'location' => 'Import Service Provider',
				'target' => WEB_ROOT . '/admin/import-service-providers',
				'icon' => '<span class="material-icons">settings_remote</span>'
			],
			[
				'location' => 'Import Personel',
				'target' => WEB_ROOT . '/admin/import-personel',
				'icon' => '<span class="material-icons">contacts</span>'
			],
			[
				'location' => 'Import Permits',
				'target' => WEB_ROOT . '/admin/import-permits',
				'icon' => '<span class="material-icons">subtitles</span>'
			],
			[
				'location' => 'Import Contracts',
				'target' => WEB_ROOT . '/admin/import-contracts',
				'icon' => '<span class="material-icons">business</span>'
			],
			[
				'location' => 'User Management',
				'target' => WEB_ROOT . '/admin/user-management',
				'icon' => '<span class="material-icons">supervised_user_circle</span>'
			],
			[
				'location' => 'User Roles',
				'target' => WEB_ROOT . '/admin/roles',
				'icon' => '<span class="material-symbols-outlined">work</span>'
			],
		]
	],
	[
		"label" => 'Settings',
		"icon" => '<span class="material-icons">settings</span>',
		'submenu' => [
			[
				'location' => 'Edit Profile',
				'target' => WEB_ROOT . '/setting/edit-profile',
				'icon' => '<span class="material-icons">manage_accounts</span>'
			],
			[
				'location' => 'Change Password',
				'target' => WEB_ROOT . '/setting/change-password',
				'icon' => '<span class="material-icons">password</span>'
			],
			[
				'location' => 'News And Announcements',
				'target' => WEB_ROOT . '/setting/news-and-announcements',
				'icon' => '<span class="material-icons">campaign</span>'
			],
		]
	],
];

// MENU FOR MOBILE APP
$menus2 = [
	'dashboard' => [
		'icon' => WEB_ROOT . '/images/icon/Dashboard.svg',
		'active' => WEB_ROOT . '/images/icon/Dashboard-active.svg',
		'target' => '',
		'label' => "Dashboard",
		"default" => WEB_ROOT,
		"submenuid" => "dashboard",
		'submenus' => [
			'dashboard' => ['label' => 'Dashboard', 'target' => '']
		]
	],
	'propman' => [
		'icon' => WEB_ROOT . '/images/icon/property-management.svg',
		'active' => WEB_ROOT . '/images/icon/property-management-active.svg',
		'header-icon' => WEB_ROOT . '/images/sidebar/header-property.png',
		'target' => '/location/',
		'label' => "Property Management",
		'default' => "/location",
		"default_submenu" => "locationlibrary",
		'submenus' => [
			'locationlibrary' => [
				'label' => 'Location Library',
				'target' =>  '/location/',
				'icon' => '<span class="material-symbols-outlined">location_on</span>',
			],
			// 'equipment' => [
			// 	'label' => 'Equipment Library',
			// 	'target' =>  '/property-management/equipment',
			// 	'icon' => '<span class="material-symbols-outlined">settings</span>',
			// ],

			// 'pm' => [
			// 	'label' => 'Preventive Maintenance',
			// 	'target' =>  '/property-management/pm',
			// 	'icon' => '<span class="material-icons">settings_input_component</span>',
			// ],
			// 'cm' => [
			// 	'label' => 'Corrective Maintenance',
			// 	'target' =>  '/property-management/cm',
			// 	'icon' => '<span class="material-symbols-outlined">work</span>',
			// ],
			// 'workorder' => [
			// 	'label' => 'Work Orders',
			// 	'target' =>  '/property-management/workorder',
			// 	'icon' => '<span class="material-icons">format_paint</span>',
			// ],
			'personnel' => [
				'label' => 'Building Personnel',
				'target' =>  '/personnel/',
				'icon' => '<span class="material-icons">contacts</span>',
			],
			// 'serviceproviders' => [
			// 	'label' => 'Service Providers',
			// 	'target' =>  '/property-management/serviceprovider',
			// 	'icon' => '<span class="material-icons">
			// 	settings_remote
			// 	</span>',
			// ],
		],
	],

	'tenant' => [
		'icon' => WEB_ROOT . '/images/icon/tenant-management.svg',
		'active' => WEB_ROOT . '/images/icon/tenant-management-active.svg',
		'header-icon' => WEB_ROOT . '/images/sidebar/header-tenant.png',
		'target' =>  '/tenant/tenant-list',
		'br', 'br',
		'label' => "Resident Management",
		'default' => "/tenant/tenant-list",
		"default_submenu" => "tenant-list",
		'submenus' => [
			'tenant_list' => [
				'label' => 'Resident',
				'target' =>  '/tenant/tenant-list',
				'icon' => '<span class="material-icons">
				people_alt
				</span>',
			],
			'tenant_registration' => [
				'label' => 'Tenant Registration',
				'target' =>  '/tenant/tenant-registration',
				'icon' => 'material-symbols-outlined',
				'icon' => '<span class="material-icons">
				person_add
				</span>',
			],
			'tenant_billing' => [
				'label' => 'Tenant Billing',
				'target' =>  '/tenant/tenant-billing',
				'icon' => '<span class="material-icons">
				account_box
				</span>',
			],
			'service_request' => [
				'label' => 'Service Request',
				'target' =>  '/tenant/service-request',
				'icon' => '<span class="material-icons">
				receipt
				</span>',
			],
			'building_application' => [
				'label' => 'Building Application Forms',
				'target' =>  '/tenant/building-application',
				'icon' => '<span class="material-icons">
				file_copy
				</span>',
			],
			'pdc_tracker' => [
				'label' => 'PDC Tracker',
				'target' =>  '/tenant/pdc-tracker',
				'icon' => '<span class="material-symbols-outlined">
				folder_shared
				</span>',
			],
			// 'building_directory' => [
			// 	'label' => 'Building Directory',
			// 	'target' =>  '/tenant/building-directory',
			// 	'icon' => '<span class="material-symbols-outlined">work</span>',
			// ],
			// 'news_announcement' => [
			// 	'label' => 'News & Announcement',
			// 	'target' =>  '/tenant/news-announcements',
			// 	'icon' => '<span class="material-symbols-outlined">work</span>',
			// ],
		]
	],

	'utilities' => [
		'icon' => WEB_ROOT . '/images/icon/utilities-management.svg',
		'active' => WEB_ROOT . '/images/icon/utilities-management-active.svg',
		'header-icon' => WEB_ROOT . '/images/sidebar/header-utilities.png',
		'target' =>  '/input-reading',
		'br', 'br',
		'label' => "Utilities Management",
		'default' => "/input-reading",
		"default_submenu" => "input-reading",
		'submenus' => [
			'meterinput' => [
				'label' => 'Input Reading',
				'target' =>  '/input-reading',
				'icon' => '<span class="material-symbols-outlined">
				move_to_inbox
				</span>',
			],
			'utilitiesbillingrates' => [
				'label' => 'Utilities Biling & Rates',
				'target' =>  '/utilities/utilities-billing-rates',
				'icon' => '<span class="material-symbols-outlined">
				speed
				</span>',
			],
			'generate_billing' => [
				'label' => 'Generate Billing',
				'target' =>  '/utilities/generate-billing',
				'icon' => '<span class="material-symbols-outlined">
				invert_colors
				</span>',
			],
			'meter_list' => [
				'label' => 'Meter List',
				'target' =>  '/utilities/meter-list',
				'icon' => '<span class="material-symbols-outlined">
				readiness_score
				</span>',
			],
			'meter_reading_history' => [
				'label' => 'Meter Reading History',
				'target' =>  '/utilities/meter-reading-history',
				'icon' => '<span class="material-symbols-outlined">
				history
				</span>',
			],
		]
	],
	'contracts' => [
		// 'icon' => 'bi bi-user-cog',
		'icon' => WEB_ROOT . '/images/icon/permits-and-contracts.svg',
		'active' => WEB_ROOT . '/images/icon/permits-and-contracts-active.svg',
		'header-icon' => WEB_ROOT . '/images/sidebar/header-permits.png',
		'target' =>  '/contracts/permit-tracker',
		'label' => "Permits and Contracts",
		'default' => "/contracts/permit-tracker",
		"default_submenu" => "permit-tracker",
		'submenus' => [
			'permittracker' => [
				'label' => 'Permit Tracker',
				'target' =>  '/contracts/permit-tracker',
				'icon' => '<span class="material-icons">
				subtitles
				</span>',
			],
			'contractracker' => [
				'label' => 'Contract Tracker',
				'target' =>  '/contracts/contract-tracker',
				'icon' => '<span class="material-icons">
				business
				</span>',
			],
		]
	],
	'report' => [
		// 'icon' => 'bi bi-bar-chart',
		'icon' => WEB_ROOT . '/images/icon/reports.svg',
		'active' => WEB_ROOT . '/images/icon/reports-active.svg',
		'target' =>  '/report/wo-summary',
		'label' => "Reports",
		'default' => "/report/wo-summary",
		"default_submenu" => "wo-summary",
		'submenus' => [
			'ws' => [
				'label' => 'Work Order Summary',
				'target' => '/report/wo-summary',
				'icon' => '<span class="material-icons">
				build
				</span>',
			],
			'ss' => [
				'label' => 'Service Request Summary',
				'target' => '/report/sr-summary',
				'icon' => '<span class="material-icons">
				assignment_returned
				</span>',
			],
			'uc' => [
				'label' => 'Utilities Consumption',
				'target' => '/report/utilities-consumption',
				'icon' => '<span class="material-symbols-outlined">work</span>',
			],
			'ce' => [
				'label' => 'Collection Efficiency',
				'target' => '/report/collection-efficiency',
				'icon' => '<span class="material-icons">
				group_work
				</span>',
			],
			'oe' => [
				'label' => 'Operational Expenditures',
				'target' => '/report/operational-expenditures',
				'icon' => '<span class="material-symbols-outlined">work</span>',
			],

		]
	],

	'admin' => [
		// 'icon' => 'bi bi-people',
		'icon' => WEB_ROOT . '/images/icon/admin.svg',
		'active' => WEB_ROOT . '/images/icon/admin-active.svg',
		'header-icon' => WEB_ROOT . '/images/sidebar/header-admin.png',
		'target' =>  '/admin',
		'br', 'br',
		'label' => "Admin",
		'default' => "/admin",
		"default_submenu" => "import-equipments",
		'submenus' => [
			'import_equipments' => [
				'label' => 'Import Equipment',
				'target' =>  '/admin/import-equipments',
				'icon' => '<span class="material-symbols-outlined">
				import_contacts
				</span>',
			],
			'import_tenants' => [
				'label' => 'Import Tenants',
				'target' =>  '/admin/import-tenants',
				'icon' => '<span class="material-icons">
				supervised_user_circle
				</span>',
			],
			'import_meters' => [
				'label' => 'Import Meters',
				'target' =>  '/admin/import-meters',
				'icon' => 'material-symbols-outlined',
				'icon' => '<span class="material-symbols-outlined">
				folder_shared
				</span>',
			],
			'import_service_provider' => [
				'label' => 'Import Service Provider',
				'target' =>  '/admin/import-service-providers',
				'icon' => '<span class="material-icons">
				settings_remote
				</span>',
			],
			'import_personel' => [
				'label' => 'Import Personel',
				'target' =>  '/admin/import-personel',
				'icon' => '<span class="material-icons">contacts</span>',
			],
			'import_permit' => [
				'label' => 'Import Permits',
				'target' =>  '/admin/import-permits',
				'icon' => '<span class="material-icons">
				subtitles
				</span>',
			],
			'import_contracts' => [
				'label' => 'Import Contracts',
				'target' =>  '/admin/import-contracts',
				'icon' => '<span class="material-icons">
				business
				</span>',
			],
			'building_profile' => [
				'label' => 'Building Profile',
				'target' =>  '/admin/building-profile',
				'icon' => '<span class="material-icons">
				assignment_ind
				</span>',
			],
			'user_management' => [
				'label' => 'User Management',
				'target' =>  '/admin/user-management',
				'icon' => '<span class="material-icons">
				supervised_user_circle
				</span>',
			],
			'user_roles' => [
				'label' => 'User Roles',
				'target' =>  '/admin/roles',
				'icon' => '<span class="material-symbols-outlined">work</span>',
			],
		]
	],
	'setting' => [
		// 'icon' => 'bi bi-gear',
		'icon' => WEB_ROOT . '/images/icon/settings.svg',
		'active' => WEB_ROOT . '/images/icon/settings-active.svg',
		'header-icon' => WEB_ROOT . '/images/sidebar/header-settings.png',
		'target' =>  '/setting',
		'label' => "Settings",

		'submenus' => [
			'edit_profile' => [
				'label' => 'Edit Profile',
				'target' =>  '/setting/edit-profile',
				'icon' => '<span class="material-icons">
				manage_accounts
				</span>',
			],
			'change_password' => [
				'label' => 'Change Password',
				'target' =>  '/admin/roles',
				'icon' => '<span class="material-icons">
				password
				</span>',
			],
			'news_announce' => [
				'label' => 'News and Announcements',
				'target' =>  '/admin/roles',
				'icon' => '<span class="material-icons">
				campaign
				</span>',
			],
		]
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
	<title><?= ($title ?? TITLE); ?></title>
	<link rel="icon" type="image/png" href="<?= WEB_ROOT ?>/images/favicon.png">
	<link href="<?= WEB_ROOT ?>/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,700,0,0" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link href="<?= WEB_ROOT ?>/themes/default/google-icon.css" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/themes/default/color.css" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/themes/default/input-field.css" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/themes/default/menu.css" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/themes/default/table.css" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/themes/default/general.css" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/themes/default/header.css" rel="stylesheet">

	<link href="<?= WEB_ROOT ?>/themes/default/ian.css?a=1" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/themes/default/mobile.css" rel="stylesheet">

	<link href="<?= WEB_ROOT ?>/css/jquery.datetimepicker.min.css" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/css/dashboard.css" rel="stylesheet">
	<link href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css" rel="stylesheet">
	<script src="<?= WEB_ROOT ?>/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
	<script src="<?= WEB_ROOT ?>/js/jquery-datetimepicket.full.min.js"></script>

	<link href="<?= WEB_ROOT ?>/css/aindata.box.css?v=<?= time() ?>" rel="stylesheet">
	<script src="<?= WEB_ROOT ?>/js/aindata-v2.js?v=<?= time() ?>"></script>

	<script src="<?= WEB_ROOT ?>/js/shared.function.js?v=<?= time() ?>"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
	<!-- TOASTR - NON-BLOCKING NOTIFS -->
	<link href="<?= WEB_ROOT ?>/css/toastr.css" rel="stylesheet">
	<script src="<?= WEB_ROOT ?>/js/toastr.min.js"></script>
	<!-- <script src="https://cdn.jsdelivr.net/gh/jquery/jquery@3.2.1/dist/jquery.min.js"></script> -->
	<!-- <script src="https://cdn.jsdelivr.net/gh/wrick17/calendar-plugin@master/calendar.min.js"></script> -->
	<script src="<?= WEB_ROOT ?>/js/calendar.js"></script>
	<script src="<?= WEB_ROOT ?>/js/calendar1.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/wrick17/calendar-plugin@master/style.css">
	<link rel="stylesheet" href="<?= WEB_ROOT ?>/css/calendar.css">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
	<script type="text/javascript" src="https://js.xendit.co/v1/xendit.min.js"></script>
	<script type="text/javascript">
		Xendit.setPublishableKey('xnd_public_development_Q8rYwjhMUahHTEbUgczGiK2eBnA7pcyLuEJNVCbUZjJi8QGQ2wTuW6q051VV');
	</script>
	<link href="<?= WEB_ROOT ?>/themes/default/style.css?v=<?= time() ?>" rel="stylesheet">
</head>

<body>

	<div class="d-flex">
		<header class="header-menu">

			<div class="box-logo">
				<img src="<?= WEB_ROOT ?>/images/Inventi-logo-blue.png" alt="">
			</div>
			<nav>
				<ul class="d-flex flex-column gap-2 navigation" role="navigation">

					<li class="menu-link dashboard">
						<a href="<?= WEB_ROOT ?>">

							<div class="d-flex align-items-center n-sub gap-2">
								<span class="material-icons">
									dashboard
								</span>
								<label>Dashboard</label>
							</div>
						</a>

					</li>
					<?php foreach ($menu as $item) : ?>
						<li class="menu-link  ">
							<button class="menu-btn  d-flex justify-content-between align-items-center ">
								<div class="d-flex align-items-center gap-2">
									<?= $item['icon'] ?>
									<label><?= $item['label'] ?></label>
								</div>
								<span class="material-icons more down-icon">
									expand_more
								</span>
							</button>
							<div class="sub-menu-list down_sub">
								<ul class="sub-menu">
									<?php foreach ($item['submenu'] as $sub) : ?>
										<li>
											<a href="<?= $sub['target'] ?>" class="link_tab">
												<div class="d-flex align-items-center gap-2">
													<?= $sub['icon'] ?>
													<label><?= $sub['location'] ?></label>
												</div>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</li>
					<?php endforeach; ?>
					<li class="menu-link ">
						<a href="<?= WEB_ROOT ?>/auth/logout">
							<div class="d-flex align-items-center n-sub  gap-2">
								<span class="material-icons">
									keyboard_return
								</span>

								<label>Log Out</label>
							</div>
						</a>
					</li>
					<li class="mt-auto">
						<div class="nav-bot-logo">
							<img src="<?= WEB_ROOT . '/images/icon/powered by.svg' ?>" alt="">
						</div>
					</li>
				</ul>
			</nav>


		</header>

		<!-- <nav class="sidebar ">
			<header>
				<div class="image-text">
					<span class="menu_logo image <?= ($_SESSION['menuopen'] ?? 'false') == 'false' ? '' : ''; ?>">
						<?php if (isset($accountdetails['settings']['menu_logo']['value'])) : ?>
							<img src="<?= $accountdetails['settings']['content_logo']['value']; ?>">
						<?php else : ?>
							<img src="<?= WEB_ROOT ?>/images/Inventi-logo-blue.png">
						<?php endif; ?>
					</span>
				</div>
			</header>
			<div class="menu-bar" style="">
				<div class="menu">
					<ul class="menu-links">
						<?php foreach ($menus2 as $index => $menu) : ?>
							<li class="nav-tab gap-0">
								<?php if ($menu['label'] === "Dashboard" || $menu['label'] === "setting") { ?>

									<a onclick="saveRAccess(this)" class="nav-tab text-nowrap  <?= $menuid == $index ? 'active' : ''; ?>" icon="<?= $menu['icon'] ?>" title="<?= $menu['label']; ?>" data-menuindex="<?= $index; ?>" href="<?= WEB_ROOT . $menu['target']; ?>?menuid=<?= $index; ?>&submenuid=">
										<div class="d-flex align-items-center p-2 box">
											<div class="sidebar-img">
												<img src="<?= $menuid == $index ? $menu['active'] : $menu['icon'] ?>" class='image-icon active'></img>
											</div>
											<div class="sidebar-text"> <?= $menu['label']; ?>
											</div>
										</div>

									</a>
								<?php continue;
								} ?>


								<a onclick="saveRAccess(this)" class="nav-tab text-nowrap  <?= $menuid == $index ? 'active' : ''; ?>" icon="<?= $menu['icon'] ?>" title="<?= $menu['label']; ?>" data-menuindex="<?= $index; ?>" href="<?= WEB_ROOT . $menu['target']; ?>?menuid=<?= $index; ?>&submenuid=<?= $menu['default_submenu'] ?>">

									<div class="d-flex align-items-center p-2 box">
										<div class="sidebar-img"><img src="<?= $menuid == $index ? $menu['active'] : $menu['icon'] ?>" class='image-icon active'></img></div>
										<div class="sidebar-text"> <?= $menu['label']; ?>
										</div>
									</div>

								</a>
							</li>
						<?php endforeach; ?>
						<li class="nav-tab gap-0">
							<a class="nav-tab text-nowrap  " href="<?= WEB_ROOT ?>/auth/logout">
								<div class="d-flex align-items-center p-2 box ">
									<div class="sidebar-img">
										<img class="image-icon" src="<?= WEB_ROOT . '/images/icon/logout.svg' ?>" alt="">
									</div>

									<div class="sidebar-text">
										Logout
									</div>

								</div>
							</a>
						</li>
						<li class="logo-menu">
							<div class="nav-logo">
								<img src="<?= WEB_ROOT . '/images/icon/powered by.svg' ?>" alt="">
							</div>
						</li>

					</ul>
				</div>

			</div>

		</nav> -->
		<!-- Mobile Nav-->
		<nav class="mobile-bottom-nav">
			<?php $i = 0 ?>
			<?php foreach ($menus2 as $index => $menu) : ?>
				<?php if ($i <= 4) : ?>
					<a href="<?= WEB_ROOT . $menu['target']; ?>?menuid=<?= $index; ?>&submenuid=" title="<?= $menu['label']; ?>" data-menuindex="<?= $index; ?>" class="mobile-bottom-nav__item <?= $menuid == $index ? 'active' : 	''; ?>">
						<div>
							<div class="mobile-bottom-nav__item-content">
								<!-- <i class="material-icons">home</i> -->
								<center>
									<img src="<?= $menuid == $index ? $menu['active'] : $menu['icon'] ?>" class='image-icon' style="width:20px"></img>
								</center>

								<?= strtok($menu['label'], " "); ?>
							</div>
						</div>
					</a>

				<?php endif; ?>
				<?php $i++; ?>
			<?php endforeach; ?>
			<a href="#" data-menuindex="<?= $index; ?>" class="mobile-bottom-nav__item <?= $menuid == $index ? 'active' : ""; ?>">
				<div>
					<div class="mobile-bottom-nav__item-content">
						<!-- <i class="material-icons">home</i> -->
						<center>
							<img src="<?= WEB_ROOT . '/images/menu-selected.png' ?>" class='image-icon ' style="width:20px"></img>
						</center>
						Menu
					</div>
				</div>
			</a>
		</nav>
		<?php
		$equipment = null;
		$settings = json_decode($ots->execute('setting', 'get-settings', []), true);

		//users
		$data = [
			'view' => 'users'
		];
		$user = $ots->execute('property-management', 'get-record', $data);
		$user = json_decode($user);

		//get profile
		$data = [
			'view' => 'attachments',
			'desc' => $user->user_name
		];
		$file = $ots->execute('setting', 'get-record', $data);
		$file = json_decode($file);
		?>
		<section class="home ml-5 <?= ($_SESSION['menuopen'] ?? 'false') == 'false' ? '' : ''; ?>">
			<!-- <div style="display: flex; flex-direction: column; align-items: flex-start; padding: 16.5px 25px; position: fixed; left: 14.06%; right: 0%; top: 0%; bottom: 95.38%;z-index: 888;height:78px;width:100%;background:#FFFF;">

			</div> -->


			<!-- <div class="p-2 bg-white d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
				<i class='bi bi-list toggle-menu <?= ($_SESSION['menuopen'] ?? 'false') == 'false' ? 'd-none' : ''; ?>' style="font-size:2em"></i>
				<a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-decoration-none">
				<?php if (isset($accountdetails['settings']['content_logo']['value'])) : ?>
						<img class="content_logo <?= ($_SESSION['menuopen'] ?? 'false') == 'false' ? '' : 'd-none'; ?>" src="<?= $accountdetails['settings']['content_logo']['value']; ?>" style="max-height:40px;max-width:100%">
					<?php else : ?>
						<img class="content_logo <?= ($_SESSION['menuopen'] ?? 'false') == 'false' ? '' : 'd-none'; ?>" src="<?= WEB_ROOT ?>/images/logoblue.png" style="max-height:40px;max-width:100%">
					<?php endif; ?>
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
						<div class="ps-2 pt-2 user-name"><span class="login-name"><?= $ots->session->getUserName(); ?></span></div>
						<div class="ps-2 user-role"><span class="login-role"><?= count($ots->session->getUserRoles()) ? implode(", ", $ots->session->getUserRoles()) : 'No Role'; ?></span></div>
					</li>
					<li class="ps-2">
						<img src="<?= WEB_ROOT ?>/images/user-img-anon.png" class="user-img">
					</li>
				</ul>
			</div> -->
			<div class="sub-menu-container <?= in_array($menuid, ['dashboard']) ? 'd-none' : ''; ?>">
				<!-- print_r($_SESSION);?> -->
				<!-- <div class="d-flex bg-blue align-items-center justify-content p-2">
		
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a class="breadcrumbs" href="echo WEB_ROOT;?>/?menuid=dashboard&submenuid=" style="color: primary;">Dashboard</a></li>
					<li class="breadcrumb-item menu-breadcrumbs"><a class="breadcrumbs" href="$menus2[$_SESSION['menuid']]['target']?>">$menus2[$_SESSION['menuid']]['label']?></a></li>
					<li class="breadcrumb-item submenu-breadcrumbs"><a class="breadcrumbs" href="$menus2[$_SESSION['menuid']]['submenus'][$_SESSION['submenuid']]['target']?>">$menus2[$_SESSION['menuid']]['submenus'][$_SESSION['submenuid']]['label']?></a></li>
				</ol>
			</nav>
		</div>
		<div class="d-flex bg-blue align-items-center justify-content p-2">
			<div><img src="$menus2[$_SESSION['menuid']]['header-icon']?>" class='image-icon active'></img></div><div><h3 class='text-primary'>&nbsp;<?= $menus2[$_SESSION['menuid']]['label'] ?></h3></div>
		</div> -->

			</div>
			<div class="d-flex flex-grow-1 main-display-container ">
				<!--June  -->
				<div class="<?= ($menus2[$_SESSION['menuid']]['label'] == 'Dashboard') ? 'bg-white' : 'bg-fade-white' ?> main-display flex-grow-1 ">
					<div>
						<header class=" nav-header ">
							<div class="user d-flex align-items-center order-1 gap-3 w-100">
								<div class="menu-collaps-btn">
									<span class="material-icons">
										menu
									</span>
								</div>
								<div class="header-avatar-container">
									<img src="<?= $file->attachment_url ?>" alt="">
								</div>
								<div class="header-welcome-text">Welcome, <?= strtoupper($user->first_name) ?>!</div>
							</div>
							<div class="navheader-icon-container order-3">
								<div class="d-flex justify-content-end align-items-center  ">
									<div class="p-3 help">
										<svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M16 0H2C0.89 0 0 0.9 0 2V16C0 17.1 0.9 18 2 18H6L8.29 20.29C8.68 20.68 9.31 20.68 9.7 20.29L12 18H16C17.1 18 18 17.1 18 16V2C18 0.9 17.1 0 16 0ZM10 16H8V14H10V16ZM12.07 8.25L11.17 9.17C10.59 9.76 10.18 10.27 10.05 11.23C9.99 11.66 9.64 11.99 9.2 11.99H8.89C8.37 11.99 7.97 11.53 8.04 11.01C8.15 10.1 8.57 9.29 9.18 8.67L10.42 7.41C10.78 7.05 11 6.55 11 6C11 4.9 10.1 4 9 4C8.13 4 7.38 4.57 7.11 5.35C6.98 5.72 6.67 5.99 6.28 5.99H5.98C5.4 5.99 5 5.43 5.16 4.87C5.65 3.21 7.18 2 9 2C11.21 2 13 3.79 13 6C13 6.88 12.64 7.68 12.07 8.25Z" fill="#0F1108" />
										</svg>
									</div>
									<div class="p-3 notification">
										<svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M8.00054 20C9.10054 20 10.0005 19.1 10.0005 18H6.00054C6.00054 19.1 6.89054 20 8.00054 20ZM14.0005 14V9C14.0005 5.93 12.3605 3.36 9.50054 2.68V2C9.50054 1.17 8.83054 0.5 8.00054 0.5C7.17054 0.5 6.50054 1.17 6.50054 2V2.68C3.63054 3.36 2.00054 5.92 2.00054 9V14L0.71054 15.29C0.0805397 15.92 0.52054 17 1.41054 17H14.5805C15.4705 17 15.9205 15.92 15.2905 15.29L14.0005 14Z" fill="#0F1108" />
										</svg>
									</div>
								</div>
							</div>
							<form class="position-relative search-container order-2">
								<input type="search" class=" search" placeholder="Search" id="searchboxglobal">
								<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.5006 11.4996H11.7106L11.4306 11.2296C12.6306 9.82965 13.2506 7.91965 12.9106 5.88965C12.4406 3.10965 10.1206 0.889649 7.32063 0.549649C3.09063 0.029649 -0.469374 3.58965 0.0506256 7.81965C0.390626 10.6196 2.61063 12.9396 5.39063 13.4096C7.42063 13.7496 9.33063 13.1296 10.7306 11.9296L11.0006 12.2096V12.9996L15.2506 17.2496C15.6606 17.6596 16.3306 17.6596 16.7406 17.2496C17.1506 16.8396 17.1506 16.1696 16.7406 15.7596L12.5006 11.4996ZM6.50063 11.4996C4.01063 11.4996 2.00063 9.48965 2.00063 6.99965C2.00063 4.50965 4.01063 2.49965 6.50063 2.49965C8.99063 2.49965 11.0006 4.50965 11.0006 6.99965C11.0006 9.48965 8.99063 11.4996 6.50063 11.4996Z" fill="#0F1108" />
								</svg>
							</form>
						</header>
						<i class="fi fi-rs-arrow-to-left"></i>
						<!-- <div class="module-title w-50 mt-4"> echo $menus2[$menuid]['label']	;?></div> -->

						<!-- Recently Accessed  -->
						<div class="main-container d-flex justify-content-between recently " style="top: 10px; position: relative;">
							<div class="<?= ($menus2[$_SESSION['menuid']]['label'] != 'Dashboard') ? ' col-sm-12 col-12' : 'col-12' ?>">
								<!-- <nav aria-label="breadcrumb">
									<ol class="breadcrumb">
										<?php if ($menus2[$_SESSION['menuid']]['label'] == 'Dashboard') : ?>
										<?php else : ?>
											<li class="breadcrumb-item"><a class="breadcrumbs" href="<?= WEB_ROOT ?>/?menuid=dashboard&submenuid=" style="">Dashboard</a></li>
											<li class="breadcrumb-item menu-breadcrumbs"><a class="<?= ($menus2[$_SESSION['menuid']]['label'] != 'Dashboard') ? 'breadcrumbs' : 'breadcrumbs_dashboard' ?>" href="<?= $menus2[$_SESSION['menuid']]['target'] ?>?menuid=<?= $_SESSION['menuid']; ?>&submenuid="><?= $menus2[$_SESSION['menuid']]['label'] ?></a></li>
											<li class="breadcrumb-item submenu-breadcrumbs"><a class="<?= ($menus2[$_SESSION['menuid']]['label'] != 'Dashboard') ? 'breadcrumbs' : 'breadcrumbs_dashboard' ?>" href="<?= $menus2[$_SESSION['menuid']]['submenus'][$_SESSION['submenuid']]['target'] ?>?submenuid=<?= $_SESSION['submenuid']; ?>"><?= $menus2[$_SESSION['menuid']]['submenus'][$_SESSION['submenuid']]['label'] ?></a></li>
										<?php endif; ?>


									</ol>
								</nav> -->
								<!-- var_dump($menus2[$_SESSION['menuid']]['label']);?> -->
								<ul class="row my-2 my-md-0 text-small p-1 gap-4">
									<div class="d-flex align-items-center justify-content p-2 <?= ($menus2[$_SESSION['menuid']]['label'] != 'Dashboard') ? '' : 'd-none' ?>">
										<div><img src="<?= $menus2[$_SESSION['menuid']]['header-icon'] ?>" class='image-icon active'></img></div>
										<div>&nbsp;<label class="text-required text-primary" style="font-size: 25px;"><?= $menus2[$_SESSION['menuid']]['label'] ?></label></h4>
										</div>
									</div>

									<?php $submenuctr = 1; ?>
									<!-- color -->
									<div class="d-flex gap-4 sub-menu-category">
										<?php foreach ($menus2[$menuid]['submenus'] as $index => $submenu) : ?>
											<?php if (!is_array($submenu) && $submenu == 'hr') : ?>
											<?php else : ?>
												<?php if ($menus2[$_SESSION['menuid']]['label'] != 'Dashboard') : ?>
													<a href="<?= WEB_ROOT ?><?= $submenu['target']; ?>?submenuid=<?= $index ?>">
														<li class="card-nav <?= ($submenuid == $index || ($submenuctr == 0 && $submenuid == '')) ? 'active-icon' : ''; ?> ">
															<div class="icon-container">
																<?= $submenu['icon'] ?>
															</div>
															<div>
																<label><?= $submenu['label'] ?></label>
															</div>
														</li>
													</a>
													<!-- <li class="nav-sub-link p-3 <?= ($submenuid == $index || ($submenuctr == 0 && $submenuid == '')) ? 'active' : ''; ?> ">
														<a class="nav-sub-link  <?= ($submenuid == $index || ($submenuctr == 1 && $submenuid == '')) ? 'active' : ''; ?>" data-menuindex="<?= $index; ?>" href="<?= WEB_ROOT ?><?= $submenu['target']; ?>?submenuid=<?= $index; ?>">
															<img src="<?= $submenuid == $index ? $submenu['active'] : $submenu['icon'] ?>" class='sub-menu-list-image align-center'>
														</a>

														<div class="d-flex align-items-center justify-content-center p-1">
															<a class="nav-sub-link <?= ($submenuid == $index || ($submenuctr == 1 && $submenuid == '')) ? 'active' : ''; ?>" data-menuindex="<?= $index; ?>" href="<?= WEB_ROOT ?><?= $submenu['target']; ?>?submenuid=<?= $index; ?>"><?= $submenu['label']; ?></a>
														</div>
													</li> -->
												<?php else : ?>
													<?php
													$recently_access = $ots->execute('dashboard', 'get-recently-access');
													$recently_access = json_decode($recently_access, true);
													?>

													<div class="recent-request-container w-100">
														<h5 class="m-0">Recently Accessed : </h5>
														<?php foreach ($recently_access['data'] as $recent_access) : ?>
															<div class="recent-access-container align-content-md-stretch recently-access">
																<button class="btn btn-md">
																	<div class="d-flex">
																		<div class="d-flex align-items-center">
																			<label class="px-2"><?= $recent_access['Name'] ?></label><i class="fa-sharp fa-solid fa-xmark close-mark"></i>
																		</div>
																		<!-- <div class="p-1" >
																<img src="<?= WEB_ROOT ?>/images/dashboard/dashboard-recent-access-removeicon.png" style="width:100%;">
															</div> -->
																	</div>

																</button>
															</div>
														<?php endforeach; ?>
														<!-- <div class="recent-access-container align-content-md-stretch">
												<button class="btn btn-md" style="border-radius:20px;background:#6098E2">
													<div class="d-flex">
														<div class="" style="max-width:30px;min-width:25px">
															<img class="" src="<?= WEB_ROOT ?>/images/dashboard/dashboard-recent-access-pm.png" style="width:100%;">
														</div>
														<div class="p-1">
															Preventive Maintenance
														</div>
														<div class="p-1" style="max-width:25px;width:20px">
															<img src="<?= WEB_ROOT ?>/images/dashboard/dashboard-recent-access-removeicon.png" style="width:100%;">
														</div>
													</div>
														
												</button>
											</div> -->
														<!-- <div class="recent-access-container">
												<button class="btn-primary btn" style="border-radius:20px;background:#6098E2">
													<div class="d-flex">
														<div style="max-width:30px;min-width:25px">
															<img src="<?= WEB_ROOT ?>/images/dashboard/dashboard-recent-access-reading.png" style="width:100%;">
														</div>
														<div class="p-1">
															Input Reading
														</div>
														<div class="p-1" style="max-width:25px;width:20px">
															<img id="remove-input-reading"  class="" src="<?= WEB_ROOT ?>/images/dashboard/dashboard-recent-access-removeicon.png" style="width:100%;">
														</div>
													</div>
												</button>
											</div> -->
														<!-- <div class="recent-access-container">
												<button class="btn-primary btn" style="border-radius:20px;background:#6098E2">
													<div class="d-flex">
														<div style="max-width:30px;min-width:25px">
															<img src="<?= WEB_ROOT ?>/images/dashboard/dashboard-recent-access-pm.png" width="25">
														</div>
														<div class="p-1">
															PDC Tracker
														</div>
														<div class="p-1" style="max-width:25px;width:20px">
															<img id="remove-input-reading"  class="" src="<?= WEB_ROOT ?>/images/dashboard/dashboard-recent-access-removeicon.png" width="13">
														</div>
													</div>
												</button>
											</div> -->
														<!-- <div class="recent-access-container">
												<button class="btn-primary btn" style="border-radius:20px;background:#6098E2">
													<div class="d-flex">
														<div style="max-width:30px;min-width:25px">
															<img src="<?= WEB_ROOT ?>/images/dashboard/dashboard-recent-access-billing.png" width="25" style="border: 1px solid #6098E2;background:#ffff;border-radius:20px;">
														</div>
														<div class="p-1">
															Utilities Billing
														</div>
														<div class="p-1" style="max-width:25px;width:20px">
															<img id="remove-input-reading"  class="" src="<?= WEB_ROOT ?>/images/dashboard/dashboard-recent-access-removeicon.png" width="13">
														</div>
													</div>	
												</button>
											</div> -->

													</div>
												<?php endif; ?>

											<?php endif; ?>
											<?php $submenuctr++; ?>
										<?php endforeach; ?>
										<div>

								</ul>
							</div>
							<!-- <?php if ($_SESSION['submenuid'] == 'pm') : ?>
							<div id="" class="clearfix dashboard-calendar col-4"></div>
						<?php else : ?>

						<?php endif; ?> -->
						</div>

						<script>
							var currentLocation = window.location.href;
							console.log('<?php echo WEB_ROOT ?>/')
							$('.link_tab').each(function() {

								if (currentLocation === '<?php echo WEB_ROOT ?>/') {
									console.log("test")
									$('.dashboard').addClass('active-menu')
								}
								if (currentLocation.indexOf($(this).attr('href')) !== -1) {
									$(this).addClass('active-menu');
								}
							});
							$('.menu-link').each(function() {
								const menu = $(this);
								const active = menu.find('.active-menu');
								const sub_menu = menu.find('.down_sub');
								const more = menu.find('.more');

								if (active.length === 1) {
									sub_menu.addClass('show-sub');
									sub_menu.removeClass('down_sub');
									more.removeClass('more');
								}
							});


							$('.menu-link').each(function() {
								$(this).hover(function() {
									$(this).find('.down_sub').addClass('show-sub');
									$(this).find('.more').addClass('rotate');
								}, function() {
									$(this).find('.more').removeClass('rotate');
									$(this).find('.down_sub').removeClass('show-sub');
								});
							});

							$('.menu-collaps-btn').click(function() {
								$('.sidebar').toggleClass('colaps-menu');

								$('.header-menu').toggleClass('collapse-menu')
							});





							function show_modal_upload(button_data) {
								$('#upload').modal('show');
								reference_table = $(button_data).attr('reference-table');
								reference_id = $(button_data).attr('reference-id');
								update_table = $(button_data).attr('update-table');

								$("#upload #reference_table").val(reference_table);
								$("#upload #update_table").val(update_table);
								$("#upload #reference_id").val(reference_id);
							}

							$('.close-mark').on('click', function() {
								$(this).closest('.recent-access-container').hide();
							});

							// $('.dashboard-calendar').calendar({
							// enableMonthChange: true,
							// showTodayButton: false,
							// prevButton: '<i class="bi bi-chevron-left" style="font-size: 15px;  font-weight: 600"></i>',
							// nextButton: '<i class="bi bi-chevron-right" style="font-size: 15px; font-weight: 600"></i>',
							// onClickDate: function (date) {

							// 	// var todayDate = new Date(date).toLocaleString().slice(0, 10);
							// 	var date = new Date(date);
							// 	var year = date.toLocaleString("default", { year: "numeric" });
							// 	var month = date.toLocaleString("default", { month: "2-digit" });
							// 	var day = date.toLocaleString("default", { day: "2-digit" });
							// 	var formattedDate = year + "-" + month + "-" + day;
							// 	$.ajax({
							// 		url: "<?= WEB_ROOT . "/dashboard/get-pm-sched-calendar" ?>",
							// 		type: 'post',
							// 		data: JSON.stringify({date: formattedDate}),
							// 		dataType: 'html',
							// 		success: function(data) {
							// 			$(".stock-transaction-data").html(data);
							// 		},
							// 	});
							// }
							// });

							function selectDate(date) {
								$('.dashboard-calendar').updateCalendarOptions({
									date: date
								});
								$('#date').val(moment(dateformatted).format('YYYY-MM-DD'));
								let provider = "<?= $Provider['__rowid'] ?>";
								let url = "<?= MAININDEX ?>";
								let sessionid = "<?= $_SESSION['sessionid'] ?? '' ?>";
								let parameters = {
									'ver': 1,
									'requestid': '',
									'sessionid': sessionid,
									'params': {
										'date': moment(dateformatted).format('YYYY-MM-DD'),
										'provider': provider
									}
								};

							};
						</script>
						<div class="modal" tabindex="-1" role="dialog" id='upload'>
							<div class="modal-dialog  modal-dialog-centered" role="document">
								<div class="modal-content px-1 pb-4 pt-2">
									<div class="modal-header justify-content-end pb-0" style="border-bottom: 0px;">
										<!-- <h5 class="modal-title">Upload Documents</h5> -->
										<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#upload").modal("hide")' aria-label="Close">
											<span aria-hidden="true"></span>
										</button>
									</div>
									<div class="modal-body pt-0">
										<h3 class="modal-title text-primary align-center text-center mb-3">Upload Documents</h3>
										<form action="<?= WEB_ROOT ?>/files/upload-attachments?display=plain" method='post' id='form-upload' enctype="multipart/form-data">
											<input type="hidden" name='update_table' id='update_table'>
											<input type="hidden" name='reference_table' id='reference_table'>
											<input type="hidden" name='reference_id' id='reference_id'>
											<div class="col-12 my-4">
												<label class="text-required">Attachments <span class="text-danger">*</span></label><br>
												<input type="file" name="file[]" id="file" class='upload_file' multiple>
											</div>

											<div class="col-12 my-4">
												<label for="description" class="text-required">Description <span class="text-danger">*</span></label>
												<textarea name="description" class='form-control' style="heigth: 100%" required></textarea>
											</div>

											<div class="d-flex justify-content-center gap-4 w-100">
												<button type='submit' class='btn btn-primary px-5'>Submit</button>
												<a class='btn btn-light btn-cancel px-5' onclick='$("#upload").modal("hide")'>Cancel</a>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="modal" tabindex="-1" role="dialog" id='contact-us-modal' style="overflow-y: auto;">
							<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header" style="border-bottom: 0px;">
										<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#contact-us-modal").modal("hide")' aria-label="Close"></button>
									</div>
									<div class="modal-body pt-0">
										<h3 class="modal-title text-primary align-center text-center mb-3">Contact Us</h3>
										<!-- <form action="<?= WEB_ROOT ?>/property-management/pm-update-stage?display=plain" method='post' id='form-update-stage' enctype="multipart/form-data"> -->

										<!-- <input type="hidden" name='reference_table' id='reference_table' > -->
										<div class="col-12 my-4">
											<label for="name" class="text-required pb-2">Name <span class="text-danger">*</span></label>
											<input type="text" name='name' id='name' class='form-control'>
										</div>
										<div class="col-12 my-4">
											<label for="phone" class="text-required pb-2">Phone Number <span class="text-danger">*</span></label>
											<input type="text" name='contact_no' id='contact_no' class='form-control'>
										</div>
										<div class="col-12 my-4">
											<label for="email" class="text-required pb-2">Email <span class="text-danger">*</span></label>
											<input type="email" name='email' id='email' class='form-control'>
										</div>
										<div class="col-12 my-4">
											<label for="company" class="text-required pb-2">Company</label>
											<input type="text" name='company' id='company' class='form-control'>
										</div>
										<div class="col-12 my-4">
											<label for="subject" class="text-required pb-2">Subject <span class="text-danger">*</span></label>
											<select name="subject" class="form-select">
												<option value="Use it in my company">Use it in my company</option>
												<option value="Others">Others</option>
											</select>
										</div>
										<div class="col-12 my-4">
											<label for="size" class="text-required pb-2">Your Company Size <span class="text-danger">*</span></label>
											<select name="size" class="form-select">
												<option value="Big">Big</option>
												<option value="Small">Small</option>
											</select>
										</div>
										<div class="col-12 my-4">
											<label for="question" class="text-required pb-2">Question</label>
											<textarea name='question' id='question' class='form-control'></textarea>
										</div>

										<div class="d-flex justify-content-center gap-4 w-100">
											<button type='submit' class='btn btn-primary px-5'>Submit</button>
											<a class='btn btn-light btn-cancel px-5' onclick='$("#contact-us-modal").modal("hide")'>Cancel</a>
										</div>
										</form>
									</div>
								</div>
							</div>

						</div>
						<script>
							$(document).ready(function() {





								$('#form-upload').submit(function(e) {
									e.preventDefault();
									console.log(new FormData($(this)[0]));
									$.ajax({
										url: $(this).prop('action'),
										type: 'POST',
										dataType: 'JSON',
										data: new FormData($(this)[0]),
										cache: false,
										contentType: false,
										processData: false,
										success: function(data) {
											// $("#upload").modal("hide")
											if (data.success == 1) {
												// location.reload();
												show_success_modal_upload($("#upload").modal("hide"));
											} else {
												show_modal_upload_message_err();
											}
										},
										complete: function() {


										},
										error: function(jqXHR, textStatus, errorThrown) {

										}
									});

								});
								$('#contact-us-modal').on('shown.bs.modal', function() {
									$('section').addClass('modal-open');
								});

								// When the modal is closed
								$('#contact-us-modal').on('hidden.bs.modal', function() {
									$('section').removeClass('modal-open');
								});


								if (window.location.href != "<?= WEB_ROOT ?>/property-management/pm?submenuid=pm") {
									$(".dashboard-calendar").hide();
								}
								// $('.menu-breadcrumbs').on("click",function(e) {
								// 	$(".submenu-breadcrumbs").hide();
								// 	$(".dashboard-calendar").hide()
								// });


							});

							function saveRAccess(a_data) {
								title = $(a_data).attr("title")
								icon = $(a_data).attr("icon")

								$.ajax({
									url: "<?= WEB_ROOT ?>/dashboard/save-record?display=plain",
									type: 'POST',
									dataType: 'JSON',
									data: {
										module_name: title,
										module_icon: icon
									},
									beforeSend: function() {},
									success: function(data) {
										console.log(data);
										// if(data.success == 1)
										// {
										// 	show_success_modal($('input[name=redirect]').val());
										// }	
									},
									complete: function() {

									},
									error: function(jqXHR, textStatus, errorThrown) {

									}
								});
							}
						</script>