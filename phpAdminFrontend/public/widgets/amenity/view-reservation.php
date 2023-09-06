<?php
$reservation = null;
if(count($args))
{
	$reservation = json_decode($ots->execute('amenity','get-reservation',['reservation_id'=>$args[0]]),true);

	$updates_result =   $ots->execute('amenity','get-updates-reservation',['reservation_id'=>$args[0]]);
	$updates = json_decode($updates_result,true);
}
?>

<div class="page-title">Reservation #<?php echo $reservation ? $reservation['reservation_id'] : '';?></div>
<div class="bg-white p-2 rounded">
	<div class="row">
		<div class="col-2">
			Amenity
		</div>
		<div class="col-2">
			<?php echo $reservation['amenity_name'];?>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-2">
			Tenant
		</div>
		<div class="col-2">
			<?php echo $reservation['tenant_name'];?>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-2">
			Schedule
		</div>
		<div class="col-4">
			<?php echo date('F d Y, h:i a',$reservation['reserved_from']);?> - <?php echo date('F d Y, h:i a',$reservation['reserved_to']);?>
		</div>
	</div>

	
	<div class="row mt-3">
		<div class="col-2">
			Email
		</div>
		<div class="col-2">
			<?php echo $reservation['email'];?>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-2">
			Mobile
		</div>
		<div class="col-2">
			<?php echo $reservation['mobile'];?>
		</div>
	</div>
</div>

<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add-update">Add Update <span class="bi bi-plus-circle"></span></button>
<div class="page-title mt-3">Updates</div>

<div class="bg-white p-2 rounded mt-3">
	<table class="table">
		<thead>
			<tr>
				<td>Description</td>
				<td>Posted By</td>
				<td>Posted On</td>
				<td>Status</td>
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

<script>
	$(document).ready(function(){
		$(".btn-add-update").on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/amenity/form-update-reservation/<?php echo $reservation['id'];?>';
		});
	});
</script>