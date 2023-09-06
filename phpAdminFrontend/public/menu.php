<?php
// $user = $ots->execute('property-management', 'get-record', ['view' => 'users']);
// $user = json_decode($user);
// $parent_condition = "role_id = $user->role_type and  right_name = 'read'";

$result =  $ots->execute('module', 'get-listnew', ['table' => 'system_info']);
$info = json_decode($result);
// var_dump($info[0]->ownership);
// echo '<script>console.log('.json_encode($roles[0]->table_name).');</script>';
// MENU FOR DESKTOP

$result = $ots->execute('form', 'get-role', []);
$user = json_decode($result);

$menu = [
	[
		"label" => 'Property Management',
		"icon" => '<span class="material-icons">apartment</span>',
		'submenu' => [
			[
				'table_name' => 'location',
				"location" => 'Location',
				'target' => WEB_ROOT . "/location/",
				'icon' => '<span class="material-symbols-outlined">location_on</span>'
			],
			/*[
				"location" => 'Building Personnel',
				'target' => WEB_ROOT . "/personnel/",
				'icon' => '<span class="material-icons">contacts</span>'
			],*/
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
		"label" => 'Occupant Management',
		"icon" => '<span class="material-icons">assignment_ind</span>',
		'submenu' => [
			[
				'location' => 'Occupant',
				'target' => WEB_ROOT . '/resident/',
				'icon' => '<span class="material-icons">people_alt</span>'
			],
			[
				'location' => 'Send Invite',
				'target' => WEB_ROOT . '/send-invite',
				'icon' => '<span class="material-symbols-outlined">forward_to_inbox</span>'
			],
			[
				'location' => 'Occupant Registration',
				'target' => WEB_ROOT . '/occupant_registration/',
				'icon' => '<span class="material-icons">person_add</span>'
			],
			[
				'location' => 'Statement of Account',
				'target' => WEB_ROOT . '/soa/',
				'icon' => '<span class="material-icons">account_box</span>'
			],
			/*[
				'location' => 'Building Application Forms',
				'target' => WEB_ROOT . '/tenant/building-application',
				'icon' => '<span class="material-icons">file_copy</span>'
			],*/
			[
				'location' => 'PDC Tracker',
				'target' => WEB_ROOT . '/pdc/',
				'icon' => '<span class="material-symbols-outlined">folder_shared</span>'
			],
			[
				'location' => 'Gate Pass',
				'target' => WEB_ROOT . '/gatepass/',
				'icon' => '<span class="material-icons">
				business_center
				</span>'
			],
			[
				'location' => 'Visitor Pass',
				'target' => WEB_ROOT . '/visitorpass/',
				'icon' => '<span class="material-icons">
				emoji_people
				</span>'
			],
			[
				'location' => 'Work Permit',
				'target' => WEB_ROOT . '/workpermit/',
				'icon' => '<span class="material-icons">
				receipt
				</span>'
			],
			[
				'location' => 'Report An Issue',
				'target' => WEB_ROOT . '/reportissue/',
				'icon' => '<span class="material-icons">
				build
				</span>'
			],

		]
	],
	[
		"label" => 'Utility Management',
		"icon" => '<span class="material-icons">settings_input_svideo</span>',
		'submenu' => [
			[
				'location' => 'Meter',
				'target' => WEB_ROOT . '/meter/',
				'icon' => '<span class="material-symbols-outlined">readiness_score</span>'
			],
			[
				'location' => 'Input Reading',
				'target' => WEB_ROOT . '/input-reading',
				'icon' => '<span class="material-symbols-outlined">move_to_inbox</span>'
			],
			[
				'location' => 'Utility Setting',
				'target' => WEB_ROOT . '/util-setting',
				'icon' => '<span class="material-symbols-outlined">speed</span>'
			],
			/*[
				'location' => 'Generate Billing',
				'target' => WEB_ROOT . '/utilities/generate-billing',
				'icon' => '<span class="material-symbols-outlined">invert_colors</span>'
			],
			[
				'location' => 'Meter Reading History',
				'target' => WEB_ROOT . '/utilities/meter-reading-history',
				'icon' => '<span class="material-symbols-outlined">history</span>'
			],*/
		]
	],
	[
		"label" => 'Contract Management',
		"icon" => '<span class="material-icons">
		file_copy
		</span>',
		'submenu' => [
			[
				'location' => 'Contract',
				'target' => WEB_ROOT . '/contract/',
				'icon' => '<span class="material-icons">business</span>'
			],
			[
				'location' => 'Contract Template',
				'target' => WEB_ROOT . '/contract-template/',
				'icon' => '<span class="material-icons">business</span>'
			],
			[
				'location' => 'Field Library',
				'target' => WEB_ROOT . '/contract-field/',
				'icon' => '<span class="material-icons">business</span>'
			],
		]
	],
	[
		"label" => 'Reports',
		"icon" => '<span class="material-icons">insert_chart</span>',
		'submenu' => [
			/*[
				'location' => 'Work Order Summary',
				'target' => WEB_ROOT . '/work-order/',
				'icon' => '<span class="material-icons">build</span>'
			],*/
			[
				'location' => 'Service Request Summary',
				'target' => WEB_ROOT . '/service-request-summary/',
				'icon' => '<span class="material-icons">assignment_returned</span>'
			],
			[
				'location' => 'Utility Consumption Summary',
				'target' => WEB_ROOT . '/utility-consumption-summary/',
				'icon' => '<span class="material-symbols-outlined">work</span>'
			],
			[
				'location' => 'Collection Efficiency',
				'target' => WEB_ROOT . '/collection-efficiency/',
				'icon' => '<span class="material-icons">group_work</span>'
			],
			/*[
				'location' => 'Operational Expenditures',
				'target' => WEB_ROOT . '/report/operational-expenditures',
				'icon' => '<span class="material-symbols-outlined">work</span>'
			],*/
		]
	],
	[
		"label" => 'Admin',
		"icon" => '<span class="material-icons">supervisor_account</span>',
		'submenu' => [
			[
				'location' => 'Import Location',
				'target' => WEB_ROOT . '/admin/import-location/',
				'icon' => '<span class="material-symbols-outlined">location_on</span>'
			],
			[
				'location' => 'Import Occupant',
				'target' => WEB_ROOT . '/admin/import-occupant/',
				'icon' => '<span class="material-icons">supervised_user_circle</span>'
			],
			[
				'location' => 'Import Meter',
				'target' => WEB_ROOT . '/admin/import-meter',
				'icon' => '<span class="material-symbols-outlined">folder_shared</span>'
			],
			[
				'location' => 'Import Contract',
				'target' => WEB_ROOT . '/admin/import-contract',
				'icon' => '<span class="material-icons">business</span>'
			],
			/*[
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
			*/
			[
				'location' => 'User Management',
				'target' => WEB_ROOT . '/user-management/',
				'icon' => '<span class="material-icons">supervised_user_circle</span>'
			],
			[
				'location' => 'User Roles',
				'target' => WEB_ROOT . '/user-roles/',
				'icon' => '<span class="material-symbols-outlined">work</span>'
			],
			[
				'location' => 'Generate SOA',
				'target' => WEB_ROOT . '/generate-soa',
				'icon' => '<span class="material-symbols-outlined">invert_colors</span>'
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
				'target' => WEB_ROOT . '/news/',
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
				'table_name' => 'location',
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
				'label' => 'Resident Registration',
				'target' =>  '/tenant/tenant-registration',
				'icon' => 'material-symbols-outlined',
				'icon' => '<span class="material-icons">
				person_add
				</span>',
			],
			'tenant_billing' => [
				'label' => 'Resident Billing',
				'target' =>  '/tenant/tenant-billing',
				'icon' => '<span class="material-icons">
				account_box
				</span>',
			],
			'service_request' => [
				'label' => 'Service Request',
				'target' =>  '/service-request/',
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
				'target' =>  '/pdc/',
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
// foreach ($roles as $role) {

// 	foreach ($menu as $index) {
// 		foreach ($index['submenu'] as $sub) {
// 			echo '<script>console.log('.json_encode($role->table_name === $sub['table_name']).');</script>';
//         }
//     }
// }

// GET MODULE NAME AND DISPLAY AS PAGE TITLE
$page_title = "";
$arr = explode("/", $_SERVER['REQUEST_URI']);
$ct = ($arr[2] == "") ? 1 : 2;
$uri = $arr[$ct];
foreach ($menu as $val) {
	foreach ($val['submenu'] as $val2) {
		$arr2 = explode("/", $val2['target']);
		$target = $arr2[$ct + 2];
		if ($target == $uri)
			$page_title = $val2['location'];
	}
}
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
	<link href="<?= WEB_ROOT ?>/themes/default/dashboard.css" rel="stylesheet">

	<link href="<?= WEB_ROOT ?>/themes/default/ian.css?a=1" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/themes/default/mobile.css" rel="stylesheet">

	<link href="<?= WEB_ROOT ?>/css/jquery.datetimepicker.min.css" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/css/dashboard.css" rel="stylesheet">
	<link href="<?= WEB_ROOT ?>/css/jquery-ui.css" rel="stylesheet">
	<script src="<?= WEB_ROOT ?>/js/bootstrap.min.js"></script>
	<script src="<?= WEB_ROOT ?>/js/jquery-3.6.0.min.js"></script>
	<script src="<?= WEB_ROOT ?>/js/jquery-ui.min.js"></script>
	<script src="<?= WEB_ROOT ?>/js/jquery-datetimepicket.full.min.js"></script>

	<link href="<?= WEB_ROOT ?>/css/aindata.box.css?v=<?= time() ?>" rel="stylesheet">
	<script src="<?= WEB_ROOT ?>/js/aindata-v2.js?v=<?= time() ?>"></script>
	<script src="<?= WEB_ROOT ?>/js/donut-chart.js"></script>

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

					<li class="menu-link main-menu dashboard">
						<a href="<?= WEB_ROOT ?>">
							<div class="d-flex align-items-center main-menu n-sub p-3 gap-2">
								<span class="material-icons">
									dashboard
								</span>
								<label>Dashboard</label>
							</div>
						</a>
					</li>
					<?php
					foreach ($menu as $item) :
						$ynshow = true;
						if ($user->role_type != 1 && $item['label'] == 'Admin')
							$ynshow = false;

						if ($ynshow) {
							// if($info[0]->ownership === 'SO') {
							// 	foreach($item['submenu'] as $sub) {
							// 		var_dump()
							// 	} 
							// }
							// var_dump($item);
					?>

							<li class="menu-link ">
								<button class="menu-btn main-menu menu-link-hover p-3  d-flex justify-content-between align-items-center ">
									<div class="d-flex align-items-center gap-2">
										<?= $item['icon'] ?>
										<label><?= $item['label'] ?></label>
									</div>
									<span class="material-icons more down-icon">
										expand_more
									</span>
								</button>
								<!-- <div class="sub-menu-list down_sub"> -->
								<div class="sub-menu-list down_sub">
									<ul class="sub-menu">
										<?php foreach ($item['submenu'] as $sub) : ?>
											<?php
											if ($info[0]->ownership === 'HOA') {
												if (
													$sub['location'] === 'Contract Template' ||
													$sub['location'] === 'Field Library'

												) {
													continue;
												}
											}
											?>
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
					<?php
						}
					endforeach;
					?>
					<li class="menu-link ">
						<a href="<?= WEB_ROOT ?>/auth/logout">
							<div class="d-flex align-items-center n-sub main-menu menu-link-hover p-3  gap-2">
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

		$profilepic = ($file->attachment_url) ?? API_URL . "/uploads/profilepic.jpg";
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
				<div class="<?= ($menus2[$_SESSION['menuid']]['label'] == 'Dashboard') ? '' : 'bg-fade-white' ?> main-display flex-grow-1 ">
					<div>
						<header class="nav-header mb-4">
							<div class="user d-flex align-items-center order-1 gap-3 w-100">
								<div class="menu-collaps-btn">
									<span class="material-icons">
										menu
									</span>
								</div>
								<div class="header-avatar-container">
									<img src="<?= $profilepic ?>" alt="">
								</div>
								<div class="header-welcome-text">Welcome, <?= strtoupper($user->first_name) ?>!<h2 id='h2'></h2>
								</div>
							</div>
							<div class="navheader-icon-container order-3">
								<div class="d-flex justify-content-end gap-2 align-items-center  ">
									<div class=" help">
										<span class="material-icons">
											live_help
										</span>
									</div>
									<div class="position-relative">

										<div class=" notification">
											<span class="material-icons">
												notifications
											</span>
										</div>
										<div class="box-notification position-absolute ">
											<div>
												<h3>Notification</h2>
											</div>
											<div class="none-notif">
												<span>No Notification</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<form class="position-relative search-container order-2 mx-3">
								<input type="search" class=" search" placeholder="Search" id="searchboxglobal">
								<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.5006 11.4996H11.7106L11.4306 11.2296C12.6306 9.82965 13.2506 7.91965 12.9106 5.88965C12.4406 3.10965 10.1206 0.889649 7.32063 0.549649C3.09063 0.029649 -0.469374 3.58965 0.0506256 7.81965C0.390626 10.6196 2.61063 12.9396 5.39063 13.4096C7.42063 13.7496 9.33063 13.1296 10.7306 11.9296L11.0006 12.2096V12.9996L15.2506 17.2496C15.6606 17.6596 16.3306 17.6596 16.7406 17.2496C17.1506 16.8396 17.1506 16.1696 16.7406 15.7596L12.5006 11.4996ZM6.50063 11.4996C4.01063 11.4996 2.00063 9.48965 2.00063 6.99965C2.00063 4.50965 4.01063 2.49965 6.50063 2.49965C8.99063 2.49965 11.0006 4.50965 11.0006 6.99965C11.0006 9.48965 8.99063 11.4996 6.50063 11.4996Z" fill="#0F1108" />
								</svg>
							</form>
						</header>
						<h2 class="text-primary ps-3"><b><?= $page_title ?></b></h2>
						<script>
							$('.box-notification').hide()
							$('.notification').click(function() {
								console.log('tets')
								$('.box-notification').toggle(200)
							})
							var currentLocation = window.location.href;
							$('.link_tab').each(function() {
								if (currentLocation === '<?php echo WEB_ROOT ?>/') {
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

							// $('.menu-link').each(function() {
							// 	$(this).hover(function() {
							// 		console.log("click")
							// 		$(this).find('.down_sub').addClass('show-sub');
							// 		$(this).find('.more').addClass('rotate');
							// 	}, function() {
							// 		$(this).find('.more').removeClass('rotate');
							// 		$(this).find('.down_sub').removeClass('show-sub');
							// 	});
							// });

							$('.menu-link').each(function() {
								$(this).click(function() {
									console.log("click");
									// $(this).removeClass('menu-link-hover')
									$(this).find('.sub-menu-list').toggleClass('show-sub');
									$(this).find('.more').toggleClass('rotate');
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