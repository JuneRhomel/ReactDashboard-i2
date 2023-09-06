<?php
$movement = null;
if(count($args))
{
	$movement = json_decode($ots->execute('tenant','get-moveinout',['movement_id'=>$args[0]]),true);	
	$updates_result =   $ots->execute('tenant','get-moveinout-updates',['movement_id'=>$args[0]]);
	$updates = json_decode($updates_result,true);
}
?>
<div class="main-container">

	<div class="page-title"><?php echo $movement['move_type'];?> #<?php echo $movement ? $movement['movement_id'] : '';?></div>
	<div class="bg-white p-2 rounded">
	<div class="row">
		<div class="col-2">Date</div>
		<div class="col-2"><?php echo $movement['move_date'];?></div>
	</div>
	
	<div class="row">
		<div class="col-2">Tenant</div>
		<div class="col-2"><?php echo $movement['tenant_name'];?></div>
	</div>
	
	<div class="row">
		<div class="col-2">Location</div>
		<div class="col-2"><?php echo $movement['location_name'];?></div>
	</div>
	
	<div class="row">
		<div class="col-2">Remarks</div>
		<div class="col-8"><?php echo $movement['description'];?></div>
	</div>
	
</div>

<?php if($movement['closed'] == 0):?>
	<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add-update">Add Update <span class="bi bi-plus-circle"></span></button>
	<?php endif;?>
	
	<div class="page-title mt-3">Updates</div>
	
	<div class="bg-white p-2 rounded mt-3">
		<table class="table">
		<thead>
			<tr>
				<td>Description</td>
				<td>Posted By</td>
				<td>Posted On</td>
				<td>Stage</td>
			</tr>
		</thead>
		<?php foreach($updates as $update):?>
			<tr>
				<td><?php echo $update['description'];?></td>
				<td><?php echo $update['first_name'] . ' ' .  $update['last_name'];?></td>
				<td><?php echo date('F d, Y h:i a',$update['created_on']);?></td>
				<td><?php echo $update['status'];?></td>
			</tr>
			<?php endforeach;?>
		</table>
	</div>
	
	</div>
	<script>
	$(document).ready(function(){
		$(".btn-add-update").on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/tenant/form-movement-update/<?php echo $movement['id'];?>';
		});
	});
</script>