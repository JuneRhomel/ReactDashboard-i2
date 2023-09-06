<?php
$data = [
	'id' => $args[0],
	'view' => 'view_tenant'
];
$tenant = $ots->execute('tenant', 'get-record', $data);
$tenant = json_decode($tenant);

$data = [
	'reference_table' => 'tenant',
	'reference_id' => $args['0']
];
$attachments = $ots->execute('files', 'get-attachments', $data);
$attachments = json_decode($attachments);


//PERMISSIONS
//get user role
$data = [
	'view' => 'users'
];
$user = $ots->execute('property-management', 'get-record', $data);
$user = json_decode($user);

//check if has access
$data = [
	'role_id' => $user->role_type,
	'table' => 'tenant',
	'view' => 'role_rights'

];
$role_access = $ots->execute('form', 'get-role-access', $data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>
	<div class="main-container">

		<div class="d-flex justify-content-between mb-3">
			<a onclick="history.back()"><label class="data-title" style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $tenant->owner_name ?></a>
			<?php if ($role_access->update == true) : ?>
				<a href='<?= WEB_ROOT ?>/tenant/form-edit-tenant-list/<?= $args[0] ?>/Edit' class='btn main-btn btn-view-form '>Edit</a>
			<?php endif; ?>
		</div>
		<table class="table table-data table-bordered tenant border-table text-capitalize">
			<tr>
				<th>Owner Name</th>
				<td><?php echo $tenant->owner_name ?></td>
			</tr>
			<tr>
				<th>Contact #</th>
				<td><?php echo $tenant->owner_contact ?></td>
			</tr>
			<tr>
				<th>Owner Spouse</th>
				<td><?php echo $tenant->owner_spouse ?></td>
			</tr>
			<tr>
				<th>Spouse Contact #</th>
				<td><?php echo $tenant->owner_spouse_contact ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?php echo $tenant->owner_email ?></td>
			</tr>
			<tr>
				<th>Username</th>
				<td><?php echo $tenant->owner_username ?></td>
			</tr>
			<tr>
				<th>Unit #</th>
				<td><?php echo $tenant->unit_id ?></td>
			</tr>
			<tr>
				<th>Unit Area (sqm)</th>
				<td><?php echo $tenant->unit_area ?></td>
			</tr>
			<tr>
				<th>Tenant Name</th>
				<td><?php echo $tenant->tenant_name; ?></td>
			</tr>
			<tr>
				<th>Tenant Contact #</th>
				<td><?php echo $tenant->tenant_contact; ?></td>
			</tr>
			<tr>
				<th>Tenant Email</th>
				<td><?php echo $tenant->tenant_email; ?></td>
			</tr>
			<tr>
				<th>Tenant Username</th>
				<td><?php echo $tenant->tenant_username; ?></td>
			</tr>
		</table>

		<div class="d-flex justify-content-between my-4">
			<span style='font-size:20px'>Attachments</span>
			<?php if ($role_access->upload == true) : ?>
				<button class='btn main-btn' onclick="show_modal_upload(this)" reference-table='tenant' reference-id='<?php echo $args[0]; ?>' id='<?php echo $args[0]; ?>'>Upload</button>
			<?php endif; ?>
		</div>
		<table class="table table-data table-bordered tenant border-table text-capitalize">
			<tr>
				<th>Create By</th>
				<th>Document</th>
				<th>Created By</th>
			</tr>
			<?php
			foreach ($attachments as $attachment) {
			?>
				<tr>
					<td><?= $attachment->created_by_full_name ?></td>
					<td><a href='<?= $attachment->attachment_url ?>'><?= $attachment->filename ?></a></td>
					<td><?= date('Y-m-d', $attachment->created_on); ?></td>

				</tr>
			<?php
			}
			?>
		</table>

		<span style='font-size:20px'>Edit History</span>
		<table class="table table-data table-bordered tenant border-table">
			<table class="table table-data table-bordered tenant border-table text-capitalize">
				<tr>
					<th>Edited By</th>
					<th>Description</th>
					<th>Date and Time Created</th>
				</tr>
				<?php

				foreach ($stages as $stage) {
				?>
					<tr>
						<td><?= $stage->created_by_full_name ?></td>
						<td><?= $stage->comment ?></td>
						<td><?= date('Y-m-d h:i:s', $stage->created_on) ?></td>
					</tr>
				<?php
				}
				?>
			</table>
		</table>


	</div>
	<script>
		$(".btn-cancel").on('click', function() {
			//loadPage('<?= WEB_ROOT; ?>/location');
			window.location.href = '<?= WEB_ROOT; ?>/tenant/tenant-list?submenuid=tenant_list';
		});
	</script>