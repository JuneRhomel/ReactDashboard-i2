<?php
    $data = [
		'id'=>$args[0],
        'view'=>'roles'
	];
	$roles = $ots->execute('admin','get-record',$data);
	$roles = json_decode($roles);
?>

<div class="rounded-sm title">

	<div class="d-flex justify-content-between mb-3">
		<a onclick="history.back()"><label class="data-title backIcon"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i></label></a>
	</div>
	<table class="table table-data table-bordered property-management border-table text-capitalize" >
		<tr>
			<th>Role ID</th><td><?php echo $roles->id?></td>
		</tr>
		<tr>
			<th>Role Name</th><td><?php echo $roles->role_name?></td>
		</tr>
		<tr>
			<th>Description</th><td><?php echo $roles->description?></td>
		</tr>
	</table>
    
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
	});		
</script>