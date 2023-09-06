<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_visitor_pass'
	];
	$visitor_pass = $ots->execute('tenant','get-record',$data);
	$visitor_pass = json_decode($visitor_pass);

	//get guest
	$data = [
		'view'=>'vp_guest',
        'filters'=>[
            'vp_id' => $visitor_pass->id
        ]
	];
	$vp_guest = $ots->execute('tenant','get-records',$data);
	$vp_guest = json_decode($vp_guest);

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
	'table'=>'sr',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>

<div class="main-container">
	
	<div class="d-flex justify-content-between mb-3">
		<a onclick="window.location.href = '<?=WEB_ROOT;?>/tenant/service-request?submenuid=service_request'"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $visitor_pass->tenant_name?></a>
		<?php if($role_access->update == true): ?>
			<a href='<?= WEB_ROOT ?>/tenant/form-edit-visitor-pass/<?= $args[0] ?>/Edit'  class='btn btn-sm btn-primary float-end btn-view-form px-5'>Edit</a>
		<?php endif; ?>
	</div>
	<table class="table table-data table-bordered tenant border-table text-capitalize" >
		<tr>
			<th>Requestor Name</th><td><?php echo $visitor_pass->tenant_name?></td>
		</tr>
		<tr>
			<th>Resident Type</th><td><?php echo $visitor_pass->resident_type?></td>
		</tr>
		<tr>
			<th>Unit Number</th><td><?php echo $visitor_pass->unit?></td>
		</tr>
        <tr>
			<th>Contact Number</th><td><?php echo $visitor_pass->contact_num?></td>
		</tr>
		<tr>
			<th>Date Of Arrival</th><td><?php echo $visitor_pass->date_from?></td>
		</tr>
		<tr>
			<th>Date Of Departure</th><td><?php echo $visitor_pass->date_to?></td>
		</tr>
		<tr>
			<th>Time Of Arrival</th><td><?php echo $visitor_pass->time_arrival?></td>
		</tr>
		<tr>
			<th>Time Of Departure</th><td><?php echo $visitor_pass->time_departure?></td>
		</tr>
		<tr>
			<th>Purpose of Visit</th><td><?php echo $visitor_pass->purpose?></td>
		</tr>
	</table>
    
	<br>
	<br>
	<span style='font-size:20px'>Visitor Guest</span> 
	<table class="table table-data table-bordered gp-items border-table text-capitalize" >
		<tr>
			<th>Guest Name</th>
			<th>Guest Number</th>
			<th>Guest Address</th>
		</tr>
		<?php 
			foreach($vp_guest as $vpg){
				?>
				<tr>
					<td><?= $vpg->guest_name?></td>
					<td><?= $vpg->guest_num?></td>
					<td><?= $vpg->guest_add?></td>
				</tr>
				<?php
			}
		?>
	</table>

	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class="btn btn-dark btn-primary btn-cancel px-5">Back</button>
		</div>
	</div>

<script>

	$(".btn-cancel").on('click',function(){
		//loadPage('<?=WEB_ROOT;?>/location');
		window.location.href = '<?=WEB_ROOT;?>/tenant/service-request?submenuid=service_request';
	});

</script>
