<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_tenant'
	];
	$tenant = $ots->execute('tenant','get-record',$data);
	$tenant = json_decode($tenant);

	$data = [
		'reference_table' => 'tenant',
		'reference_id' => $args['0']
	];
	$attachments = $ots->execute('files','get-attachments',$data);
	$attachments = json_decode($attachments);

//PERMISSIONS
//get user role
$data = [	
	'view'=>'users'
];
$user = $ots->execute('property-management','get-record',$data);
$user = json_decode($user);

//check if has access
$data = [
	'role_id'=>$user->role_type,
	'table'=>'register_tenant',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>

<div class="main-container">
	
	<div class="d-flex justify-content-between mb-3">
		<a onclick="history.back()"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $tenant->owner_name?></a>
		<?php if($role_access->update == true): ?>	
			<a href='<?= WEB_ROOT ?>/tenant/form-edit-tenant-registration/<?= $args[0] ?>/Edit'  class='btn main-btn float-end btn-view-form '>Edit</a>
		<?php endif; ?>
	</div>

	<table class="table table-data table-bordered tenant border-table text-capitalize" >
		<tr>
			<th>Type</th><td><?php echo $tenant->owner_name?></td>
		</tr>
		<tr>
			<th>First Name</th><td><?php echo $tenant->owner_contact?></td>
		</tr>
		<tr>
			<th>Last Name</th><td><?php echo $tenant->owner_spouse?></td>
		</tr>
        <tr>
			<th>Unit</th><td><?php echo $tenant->owner_spouse_contact?></td>
		</tr>
		<tr>
			<th>Contact Number</th><td><?php echo $tenant->owner_email?></td>
		</tr>
        <tr>
			<th>Email</th><td><?php echo $tenant->owner_username?></td>
		</tr>
		<tr>
			<th>Contract</th><td><?php echo $tenant->unit_id?></td>
		</tr>
       
	</table>

	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class="btn main-cancel btn-cancel">Back</button>
		</div>
	</div>

<script>

	$(".btn-cancel").on('click',function(){
		//loadPage('<?=WEB_ROOT;?>/location');
		window.location.href = '<?=WEB_ROOT;?>/tenant/tenant-registration?submenuid=tenant_registration';
	});

</script>
