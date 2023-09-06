<?php
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
			'import' => 'Import',
			'upload' => 'Upload',
			'comment' => 'Comment',
		]
	],
	// 'Equipments' => [
	// 	'table' => 'equipments',
	// 	'rights' => [
	// 		'read' => 'View',
	// 		'create' => 'Add',
	// 		'update' => 'Edit',
	// 		'delete' => 'Delete',
	// 		'download' => 'Download',
	// 		'import' => 'Import',
	// 		'upload' => 'Upload',
	// 		'comment' => 'Comment',
	// 	]		
	// ],
	// 'Preventive Maintenance' => [
	// 	'table' => 'pm',
	// 	'rights' => [
	// 		'read' => 'View',
	// 		'create' => 'Add',
	// 		'update' => 'Edit',
	// 		'delete' => 'Delete',
	// 		'download' => 'Download',
	// 		'import' => 'Import',
	// 		'upload' => 'Upload',
	// 		'update_thread' => 'Update Stages',
	// 	]		
	// ],
	// 'Corrective Maintenance' => [
	// 	'table' => 'cm',
	// 	'rights' => [
	// 		'read' => 'View',
	// 		'create' => 'Add',
	// 		'update' => 'Edit',
	// 		'delete' => 'Delete',
	// 		'download' => 'Download',
	// 		'import' => 'Import',
	// 		'upload' => 'Upload',
	// 		'update_thread' => 'Update Stages',
	// 	]		
	// ],
	// 'Work Order' => [
	// 	'table' => 'wo',
	// 	'rights' => [
	// 		'read' => 'View',
	// 		'create' => 'Add',
	// 		'update' => 'Edit',
	// 		'delete' => 'Delete',
	// 		'download' => 'Download',
	// 		'import' => 'Import',
	// 		'upload' => 'Upload',
	// 		'update_thread' => 'Update Stages',
	// 	]		
	// ],
	'Building Personnel' => [
		'table' => 'personnel',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'comment' => 'Comment',
		]
	],
	// 'Service Providers' => [
	// 	'table' => 'service_providers',
	// 	'rights' => [
	// 		'read' => 'View',
	// 		'create' => 'Add',
	// 		'update' => 'Edit',
	// 		'delete' => 'Delete',
	// 		'download' => 'Download',
	// 		'import' => 'Import',
	// 	]		
	// ]
];

$resident_management = [
	// 'Service Request' => [
	// 	'table' => 'sr',
	// 	'rights' => [
	// 		'read' => 'View',
	// 		'create' => 'Add',
	// 		'update' => 'Edit',
	// 		'delete' => 'Delete',
	// 		'download' => 'Download',
	// 		'import' => 'Import',
	// 		'upload' => 'Upload',
	// 		'approval' => 'Approval',
	// 	]
	// ],
	'Resident List' => [
		'table' => 'resident',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'upload' => 'Upload',
		]
	],
	'Tenant Billing' => [
		'table' => 'soa',
		'rights' => [
			'read' => 'View',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'paynow' => 'Pay Now',
		]
	],
	'Tenant Registration' => [
		'table' => 'tenant',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'upload' => 'Upload',
			// 'approval' => 'Approval',
		]
	],
	'Building Application Form' => [
		'table' => 'building_app_form',
		'rights' => [
			'read' => 'View',
			'upload' => 'Upload',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
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
			'import' => 'Import',
			'deposit' => 'Deposit',
			'cleared' => 'Clear',
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
			'import' => 'Import',
			'publishing' => 'Publish/Unpublish',
			'upload' => 'Upload'
		]
	]
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
			'import' => 'Import',
			'publishing' => 'Publish/Unpublish',
			'upload' => 'Upload'
		]
	],
	'Input Reading' => [
		'table' => 'meter_readings',
		'rights' => [
			'read' => 'View',
			'save' => 'Save Reading',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
		]
	],
	'Utilities Billing & Rates' => [
		'table' => 'billing_and_rates',
		'rights' => [
			'read' => 'View',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
		]
	],
	'Generate Billing' => [
		'table' => 'bills',
		'rights' => [
			'read' => 'View',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'generate' => 'Generation',
			'send_out' => 'Send Out',
			'assoc_dues' => 'Edit Association',
		]
	],
	'Meter List' => [
		'table' => 'meters',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'upload' => 'Upload',
		]
	],
	'Meter Reading History' => [
		'table' => 'view_meters',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'upload' => 'Upload',
		]
	]
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
			'import' => 'Import',
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
			'import' => 'Import',
			'upload' => 'Upload',
			'renew' => 'Renew',
		]
	]
];

$reports = [
	'Work Order Summary' => [
		'table' => 'wo_report',
		'rights' => [
			'read' => 'View',
			// 'create' => 'Add',
			// 'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'upload' => 'Upload',
			// 'renew' => 'Renew',
		]
	],
	'Service Request Summary' => [
		'table' => 'service_request',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'upload' => 'Upload',
			'renew' => 'Renew',
		]
	],
	'Utilities Consumption' => [
		'table' => 'utilities_report',
		'rights' => [
			'read' => 'View',
			// 'create' => 'Add',
			// 'update' => 'Edit',
			// 'delete' => 'Delete',
			// 'download' => 'Download',
			// 'import' => 'Import',
			// 'upload' => 'Upload',
			// 'renew' => 'Renew',
		]
	],
	'Collection Efficiency' => [
		'table' => 'collection_report',
		'rights' => [
			'read' => 'View',
			// 'create' => 'Add',
			// 'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'upload' => 'Upload',
			// 'renew' => 'Renew',
		]
	],
	'Operational Expenditures' => [
		'table' => 'opex_report',
		'rights' => [
			'read' => 'View',
			'water_edit' => 'Water Edit Button',
			'elec_edit' => 'Electricity Edit Button',
			'cm_edit' => 'CM Edit Button',
		]
	]
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
	'User Roles' => [
		'table' => 'role',
		'rights' => [
			'read' => 'View',
			'create' => 'Add',
			'update' => 'Edit',
			'delete' => 'Delete',
			'download' => 'Download',
			'import' => 'Import',
			'upload' => 'Upload',
		]
	]
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
	]
];
?>

<div class="main-container">



	<div class="card">
		<div class="card-header role-header">Role Permissions [<?= $role_details->role_name ?>]</div>
		<div class="card-body">
			<form action="<?php echo WEB_ROOT; ?>/user-roles/role-permission-save?display=plain" method="post" id="form-role-permission">
				<input type="hidden" name="id" value="<?= $role_details->id; ?>">

				<h5 class="mt-4 menu-categories">Property Management</h5>
				<?php foreach ($property_management as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1" style="border:1px solid #efefef">
								<label>
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories">Resident Management</h5>
				<?php foreach ($resident_management as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1" style="border:1px solid #efefef">
								<label>
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories">Utilities Management</h5>
				<?php foreach ($utilities_management as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1" style="border:1px solid #efefef">
								<label>
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories">Contract Management</h5>
				<?php foreach ($permits_contracts as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1" style="border:1px solid #efefef">
								<label>
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories">Reports</h5>
				<?php foreach ($reports as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1" style="border:1px solid #efefef">
								<label>
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories">Admin</h5>
				<?php foreach ($admins as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1" style="border:1px solid #efefef">
								<label>
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />

				<h5 class="mt-4 menu-categories">Setting</h5>
				<?php foreach ($settings as $label => $permission) : ?>
					<h6 style="border-bottom: 1px solid #c0c0c0;padding-top:10px;background-color:#eae9e6" class="mt-2 p-2 sortme"><?php echo $label ?></h6>
					<div class="row">
						<?php foreach ($permission['rights'] as $rights_id => $rights) : ?>
							<?php $table = $permission['table']; ?>
							<div class="col-2 pt-1" style="border:1px solid #efefef">
								<label>
									<input type="checkbox" name="<?php echo $permission['table']; ?>[<?php echo $rights_id; ?>]" value="<?php echo $rights_id; ?>" <?php echo ($role_rights->$table->$rights_id ?? ''); ?>> <?php echo $rights; ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<br />
				<br>
				<button class="main-btn"><span class="fa fa-save"></span> Save</button>
			</form>
		</div>
	</div>

	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class=" main-btn btn-back ">Back</button>
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
									location = redirect;
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