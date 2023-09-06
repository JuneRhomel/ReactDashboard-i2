<?php

$module = "user-roles";
$table = "role";
$view = "_roles";
$data = [
	'id' => $args[0],
	'view' => '_roles'
];
$roles = $ots->execute('admin', 'get-record', $data);
$role_details = json_decode($roles);
// var_dump($roles);


$data = [
	'role_id' => $role_details->id,
	'view' => '_role_rights'
];
$role_rights = $ots->execute('admin', 'get-role-rights', $data);
$role_rights = json_decode($role_rights);


$property_management = [
	'Location' => [
		'table' => 'location',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',

			'upload' => 'Upload',
			// 'comment' => 'Comment',
		]
	],
];

$resident_management = [

	'Occupant' => [
		'table' => 'resident',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'print_contracts' => 'Print contracts',


			'upload' => 'Upload',
		]
	],
	'Occupant Registration' => [
		'table' => 'occupant_reg',
		'rights' => [
			'read' => 'View',
			// 'create' => 'Add',
			// 'update' => 'Edit',
			// 'delete' => 'Delete',
			// 'download' => 'Download',


			// 'upload' => 'Upload',
			// 'approval' => 'Approval',
		]
	],
	'Statement of Account' => [
		'table' => 'soa',
		'rights' => [
			'read' => 'View',
			// 'upload' => 'Upload',
			// 'delete' => 'Delete',
			'download' => 'Download',
			'paynow' => 'Paynow',
			// 'update' => 'Update',
			'print' => 'Print',
		]
	],
	'PDC Tracker' => [
		'table' => 'pdcs',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
		]
	],
	'Gate Pass' => [
		'table' => 'gatepass',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',

		]
	],
	'Visitor Pass' => [
		'table' => 'visitorpass',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',


		]
	],
	'Work Permit' => [
		'table' => 'workpermit',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',


		]
	],
	'Report an Issue' => [
		'table' => 'report_issue',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',

		]
	],

];

$utilities_management = [
	'Meter' => [
		'table' => 'meter',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
		]
	],
	'Input Reading' => [
		'table' => 'meter_readings',
		'rights' => [
			'read' => 'View',
			'save' => 'Save Reading',
			'delete' => 'Delete',
			'download' => 'Download',

		]
	],
	'Utility Setting' => [
		'table' => '_setting',
		'rights' => [
			'read' => 'View',
		]
	],

];

$permits_contracts = [
	'Contract' => [
		'table' => 'contract',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'print' => 'Print',
			'void' => 'Void',
			// 'upload' => 'Upload',
			'renew' => 'Renew',
		]
	],
	'Contract Template' => [
		'table' => 'contract_template',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'upload' => 'Upload',
			'renew' => 'Renew',
			'print' => 'Print',
		]
	],
	'Field Library' => [
		'table' => 'contract_field',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'upload' => 'Upload',
			'renew' => 'Renew',
			'print' => 'Print',
		]
	]
];

$reports = [
	// 'Work Order Summary' => [
	// 	'table' => 'wo_report',
	// 	'rights' => [
	// 		'read' => 'View',
	// 		'delete' => 'Delete',
	// 		'download' => 'Download',
	// 		'upload' => 'Upload',
	// 	]
	// ],
	'Service Request Summary' => [
		'table' => 'service_request',
		'rights' => [
			'read' => 'View',
		]
	],
	'Utilities Consumptionm Summary' => [
		'table' => 'utility_consumption',
		'rights' => [
			'read' => 'View',
			// 'create' => 'Add',
			// 'update' => 'Edit',
			// 'delete' => 'Delete',
			// 'download' => 'Download',
			// 
			// 'upload' => 'Upload',
			// 'renew' => 'Renew',
		]
	],
	'Collection Efficiency' => [
		'table' => 'collection_efficiency',
		'rights' => [
			'read' => 'View',
		]
	],
	// 'Operational Expenditures' => [
	// 	'table' => 'opex_report',
	// 	'rights' => [
	// 		'read' => 'View',
	// 		'water_edit' => 'Water Edit Button',
	// 		'elec_edit' => 'Electricity Edit Button',
	// 		'cm_edit' => 'CM Edit Button',
	// 	]
	// ]
];

$admins = [
	'Import Location' => [
		'table' => 'import_location',
		'rights' => [
			'read' => 'View',
			'upload' => 'Upload Now'
		]
	],
	'Import Equipment' => [
		'table' => 'import_equipment',
		'rights' => [
			'read' => 'View',
			'upload' => 'Upload Now'
		]
	],
	'Import Resident' => [
		'table' => 'import_resident',
		'rights' => [
			'read' => 'View',
			'upload' => 'Upload Now'
		]
	],
	'Import Meters' => [
		'table' => 'import_meter',
		'rights' => [
			'read' => 'View',
			'upload' => 'Upload Now'
		]
	],
	'Import Service Provider' => [
		'table' => 'import_sp',
		'rights' => [
			'read' => 'View',
			'upload' => 'Upload Now'
		]
	],
	'Import Personel' => [
		'table' => 'import_personel',
		'rights' => [
			'read' => 'View',
			'upload' => 'Upload Now'
		]
	],
	'Import Permit' => [
		'table' => 'import_permit',
		'rights' => [
			'read' => 'View',
			'upload' => 'Upload Now'
		]
	],
	'Import Contract' => [
		'table' => 'import_contract',
		'rights' => [
			'read' => 'View',
			'upload' => 'Upload Now'
		]
	],
	'User Management' => [
		'table' => '_users',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'access' => 'Access',
		]
	],
	'User Roles' => [
		'table' => 'role',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'access' => 'Access',
		]
	],

];

$settings = [
	'Setting' => [
		'table' => 'settings',
		'rights' => [
			'read' => 'View',
			'change_profile' => 'Change Profile',
			'update' => 'Edit Information',
			'change_pass' => 'Change Password',
		]
	],
	'News and Announcement' => [
		'table' => 'news',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',

			'publishing' => 'Publish/Unpublish',
			'upload' => 'Upload'
		]
	]

];
?>

<div class="main-container">



	<div class="card">
		<div class="card-header fs-5 role-header">Role Permissions [<?= $role_details->role_name ?>]</div>
		<div class="card-body">
			<form action="<?php echo WEB_ROOT; ?>/user-roles/role-permission-save?display=plain" method="post" id="form-role-permission">
				<input type="hidden" name="id" value="<?= $role_details->id; ?>">

				<h5 class="mt-4 menu-categories fs-2">Property Management</h5>
				<?php foreach ($property_management as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1 ">
								<label class="bold check fs-6">
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories fs-2">Occupant Management</h5>
				<?php foreach ($resident_management as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1 ">
								<label class="bold check fs-6">
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories fs-2">Utilities Management</h5>
				<?php foreach ($utilities_management as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1 ">
								<label class="bold check fs-6">
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories fs-2">Contract Management</h5>
				<?php foreach ($permits_contracts as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1 ">
								<label class="bold check fs-6">
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories fs-2">Reports</h5>
				<?php foreach ($reports as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1 ">
								<label class="bold check fs-6">
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories fs-2">Admin</h5>
				<?php foreach ($admins as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1 ">
								<label class="bold check fs-6">
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories fs-2">Setting</h5>
				<?php foreach ($settings as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1 ">
								<label class="bold check fs-6">
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />
				<br>

				<div class="btn-group-buttons">
					<div class="d-flex">
						<button class="main-btn"><span class="fa fa-save"></span> Save</button>
						<button type="submit" class="main-btn ms-2 btn-back">Back</button>
					</div>
				</div>

			</form>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$(".btn-back").on('click', function() {
				window.location.href = '<?= WEB_ROOT; ?>/user-roles/';
			});

			$("#form-role-permission").on('submit', function(e) {
				e.preventDefault();
				$.ajax({
					url: $(this).prop('action'),
					type: 'POST',
					dataType: 'JSON',
					data: $(this).serialize(),
					success: function(data) {
						if (data.success == 1) {

							toastr.success(data.description, 'User role successfully updated', {
								timeOut: 2000,
								onHidden: function() {
									location = "<?= WEB_ROOT . "/$module/" ?>";
								}
							});
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {

					}
				});
			});
		});
	</script>