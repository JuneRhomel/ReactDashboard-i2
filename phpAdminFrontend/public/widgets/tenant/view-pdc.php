<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_pdcs'
	];
	$pdc = $ots->execute('tenant','get-record',$data);
	$pdc = json_decode($pdc);

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
	'table'=>'pdcs',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>
<div class="main-container">

	<div class="d-flex justify-content-between mb-3">
		<a onclick="window.location.href = '<?=WEB_ROOT;?>/tenant/pdc-tracker?submenuid=pdc_tracker'"><label class="data-title text-primary"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> Back</a></label>
		<?php if($role_access->update == true): ?>
			<a href='<?= WEB_ROOT ?>/tenant/form-edit-pdc/<?= $args[0] ?>/Edit'  class='btn btn-sm btn-primary float-end btn-view-form px-5'>Edit</a>
			<?php endif; ?>
		</div>
		<table class="table table-data table-bordered property-management border-table text-capitalize" >
			<tr>
				<th>Check Date</th><td><?php echo $pdc->check_date; ?></td>
			</tr>
			<tr>
				<th>Check Number</th><td><?php echo $pdc->check_number;?></td>
			</tr>
			<tr>
				<th>Amount</th><td><?php echo $pdc->check_amount;?></td>
			</tr>
			<tr>
				<th>Unit</th><td><?php echo $pdc->unit;?></td>
			</tr>
			<tr>
				<th>Sequence Number</th><td><?php echo $pdc->sequence_number;?></td>
			</tr>
			<tr>
			<th>Total PDC Count</th><td><?php echo $pdc->total_pdc_count;?></td>
		</tr>
		
	</table>
	
	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class="btn btn-dark btn-primary btn-cancel px-5">Back</button>
		</div>
	</div>
</div>
	
	<script>
		$(document).ready(function(){
			
			
			$(".btn-cancel").on('click',function(){
				//loadPage('<?=WEB_ROOT;?>/location');
				window.location.href = '<?=WEB_ROOT;?>/tenant/service-request?submenuid=service_request';
			});
			
			
	});
</script>