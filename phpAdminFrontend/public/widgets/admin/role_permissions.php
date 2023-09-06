<?php
    $data = [
		'id'=>$args[0],
        'view'=>'roles'
	];
	$roles = $ots->execute('admin','get-record',$data);
	$role_details = json_decode($roles);

	$data = [
		'role_id'=>$role_details->id,
        'view'=>'role_rights'
	];
	$role_rights = $ots->execute('admin','get-role-rights',$data);
	$role_rights = json_decode($role_rights);
	// var_dump($role_rights);
	// print_r($role_rights->equipments->read);

	$property_management = [
		'Equipments' => [
			'table' => 'equipments',
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
		'Preventive Maintenance' => [
			'table' => 'pm',
			'rights' => [
				'read' => 'View',
				'create' => 'Add',
				'update' => 'Edit',
				'delete' => 'Delete',
				'download' => 'Download',
				'import' => 'Import',
				'upload' => 'Upload',
				'update_thread' => 'Update Stages',
			]		
		],
		'Corrective Maintenance' => [
			'table' => 'cm',
			'rights' => [
				'read' => 'View',
				'create' => 'Add',
				'update' => 'Edit',
				'delete' => 'Delete',
				'download' => 'Download',
				'import' => 'Import',
				'upload' => 'Upload',
				'update_thread' => 'Update Stages',
			]		
		],
		'Work Order' => [
			'table' => 'wo',
			'rights' => [
				'read' => 'View',
				'create' => 'Add',
				'update' => 'Edit',
				'delete' => 'Delete',
				'download' => 'Download',
				'import' => 'Import',
				'upload' => 'Upload',
				'update_thread' => 'Update Stages',
			]		
		],
		'Building Personnel' => [
			'table' => 'building_personnel',
			'rights' => [
				'read' => 'View',
				'create' => 'Add',
				'update' => 'Edit',
				'delete' => 'Delete',
				'download' => 'Download',
				'import' => 'Import',
			]		
		],
		'Service Providers' => [
			'table' => 'service_providers',
			'rights' => [
				'read' => 'View',
				'create' => 'Add',
				'update' => 'Edit',
				'delete' => 'Delete',
				'download' => 'Download',
				'import' => 'Import',
			]		
		]
	];

	$tenant_management = [
		'Service Request' => [
			'table' => 'sr',
			'rights' => [
				'read' => 'View',
				'create' => 'Add',
				'update' => 'Edit',
				'delete' => 'Delete',
				'download' => 'Download',
				'import' => 'Import',
				'upload' => 'Upload',
				'approval' => 'Approval',
			]		
		],
		'Tenant List' => [
			'table' => 'tenant',
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
			'table' => 'register_tenant',
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
		'Permit Tracker' => [
			'table' => 'permits',
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
		'Contract Tracker' => [
			'table' => 'contracts',
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
			'table' => 'sr_report',
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
		'Import Equipment' => [
			'table' => 'import_equipment',
			'rights' => [
				'read' => 'View',
				'upload' => 'Upload Now'
			]		
		],
		'Import Tenants' => [
			'table' => 'import_tenant',
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
		'Building Profile' => [
			'table' => 'building_profile',
			'rights' => [
				'read' => 'View',
				'update' => 'Edit'
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

	<div class="d-flex justify-content-between mb-3">
		<a onclick="history.back()"><label class="data-title backIcon"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i></label></a>
	</div>

    <div class="card">
		<div class="card-header role-header">Role Permissions [<?= $role_details->role_name ?>]</div>
		<div class="card-body">
			<form action="<?php echo WEB_ROOT;?>/admin/role-permission-save?display=plain" method="post" id="form-role-permission">
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
				<br/>

				<h5 class="mt-4 menu-categories">Tenant Management</h5>
				<?php foreach ($tenant_management as $label => $permission) : ?>
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
				<br/>

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
				<br/>
				
				<h5 class="mt-4 menu-categories">Permit and Contracts</h5>
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
				<br/>

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
				<br/>

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
				<br/>
				
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
				<br/>
				<br>
				<button class="btn btn-primary"><span class="fa fa-save"></span> Save</button>
			</form>
		</div>
	</div>
    
	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class="btn btn-dark btn-primary btn-back px-5">Back</button>
		</div>
	</div>		

<script>
	$(document).ready(function(){
		$(".btn-back").on('click',function(){
			window.location.href = '<?=WEB_ROOT;?>/admin/roles?submenuid=roles';
		});

		$("#form-role-permission").on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				dataType: 'JSON',
				data: $(this).serialize(),
				success: function(data) {
					console.log(data);
				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});
		});
	});		
</script>