<?php
    $data = [
		'id'=>$args[0],
        'view'=>'vw_user_roles'
	];
	$roles = $ots->execute('admin','get-record',$data);
	$role_details = json_decode($roles);


	$data = [
		'role_id'=>$role_details->id,
        'view'=>'_role_rights'
	];
	$role_rights = $ots->execute('admin','get-role-rights',$data);
	$role_rights = json_decode($role_rights);
	
?>

<div class="rounded-sm title main-container mt-5">


	<table class="table table-data table-bordered property-management border-table text-capitalize" >
		<tr>
			<th>ID</th><td><?php echo $role_details->id?></td>
		</tr>
		<tr>
			<th>Full Name</th><td><?php echo $role_details->fullname?></td>
		</tr>
		<tr>
			<th>Role Name</th><td><?php echo $role_details->role?></td>
		</tr>
		<!-- <tr>
			<th>Description</th><td><?php echo $role_details->description?></td>
		</tr> -->
	</table>
    
	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class=" btn-back main-btn">Back</button>
		</div>
	</div>		

<script>
	$(document).ready(function(){
		$(".btn-back").on('click',function(){
			window.location.href = '<?=WEB_ROOT;?>/user-management/';
		});
	});		
</script>