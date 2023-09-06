<?php
$reservation = null;
if(count($args))
{
	$reservation = json_decode($ots->execute('amenity','get-reservation',['reservation_id'=>$args[0]]),true);
	$updates = json_decode($ots->execute('amenity','get-updates-reservation',['reservation_id'=>$args[0]]),true);
}
?>
<style>.row { height:25px} </style>
<div class="page-title">Reservation #<?=$reservation ? $reservation['reservation_id'] : '';?></div>
<div class="bg-white p-2 rounded">
	<div class="row">
		<div class="col-2">
		<b>Amenity </b></div>
		<div class="col-2">
			<?=$reservation['amenity_name'];?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
		<b>Resident</b></div>
		<div class="col-2">
			<?=$reservation['tenant_name'];?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
		<b>Schedule </b></div>
		<div class="col-4">
			<?=date('F d Y, h:i a',$reservation['reserved_from']);?> - <?=date('F d Y, h:i a',$reservation['reserved_to']);?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
		<b>Email </b></div>
		<div class="col-2">
			<?=$reservation['email'];?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
		<b>Mobile</b> </div>
		<div class="col-2">
			<?=$reservation['mobile'];?>
		</div>
	</div>
</div>
<div class="my-3">
	<button class="btn btn-secondary btn-sm" onclick="history.back()">Back</button>
</div>
<button class="btn btn-sm btn-primary float-end me-3 btn-add-update">Add Update <span class="bi bi-plus-circle"></span></button>
<div class="page-title">Updates</div>
<div class="bg-white p-2 rounded">
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
				<td><?=$update['description'];?></td>
				<td><?=$update['first_name'] . ' ' .  $update['last_name'];?></td>
				<td><?=date('F d, Y h:i a',$update['created_on']);?></td>
				<td><?=$update['status'];?></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>
<script>
	$(document).ready(function(){
		$(".btn-add-update").on('click',function(){
			window.location.href = '<?=WEB_ROOT;?>/reservation/form-update-reservation/<?=$reservation['id'];?>';
		});
	});
</script>