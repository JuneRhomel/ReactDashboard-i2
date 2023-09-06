<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_gate_pass'
	];
	$gate_pass = $ots->execute('tenant','get-record',$data);
	$gate_pass = json_decode($gate_pass);

	//get items
	$data = [
		'view'=>'gp_items',
        'filters'=>[
            'gp_id' => $gate_pass->id
        ]
	];
	$gp_items = $ots->execute('tenant','get-records',$data);
	$gp_items = json_decode($gp_items);

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
		<a onclick="window.location.href = '<?=WEB_ROOT;?>/tenant/service-request?submenuid=service_request'"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $gate_pass->tenant_name?></label></a>
		<?php if($role_access->update == true): ?>
			<a href='<?= WEB_ROOT ?>/tenant/form-edit-gate-pass/<?= $args[0] ?>/Edit'  class='btn btn-sm btn-primary float-end btn-view-form px-5'>Edit</a>
		<?php endif; ?>
	</div>
	<table class="table table-data table-bordered tenant border-table text-capitalize" >
		<tr>
			<th>Gate Pass Type</th><td><?php echo $gate_pass->gp_type?></td>
		</tr>
		<tr>
			<th>Date</th><td><?php echo $gate_pass->gp_date?></td>
		</tr>
        <tr>
			<th>Time</th><td><?php echo $gate_pass->gp_time?></td>
		</tr>
		<tr>
			<th>Requestor Name</th><td><?php echo $gate_pass->tenant_name?></td>
		</tr>
		<tr>
			<th>Unit Number</th><td><?php echo $gate_pass->unit?></td>
		</tr>
        <tr>
			<th>Contact Number</th><td><?php echo $gate_pass->contact_num?></td>
		</tr>
		<tr>
			<th>Courier</th><td><?php echo $gate_pass->courier?></td>
		</tr>
		<tr>
			<th>Courier Name</th><td><?php echo $gate_pass->courier_name?></td>
		</tr>
		<tr>
			<th>Courier Contact</th><td><?php echo $gate_pass->courier_contact?></td>
		</tr>
	</table>
    
	<br>
	<br>
	<span style='font-size:20px'>Gate Pass Items</span> 
	<table class="table table-data table-bordered gp-items border-table text-capitalize" >
		<tr>
			<th>Item Number</th>
			<th>Item Name</th>
			<th>Quantity</th>
			<th>Description</th>
		</tr>
		<?php 
			foreach($gp_items as $gp_item){
				?>
				<tr>
					<td><?= $gp_item->item_num?></td>
					<td><?= $gp_item->item_name?></td>
					<td><?= $gp_item->item_qty?></td>
					<td><?= $gp_item->description?></td>
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
