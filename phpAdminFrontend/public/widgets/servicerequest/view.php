<?php
$servicerequest = null;
if(count($args))
{
	$servicerequest = json_decode($ots->execute('servicerequest','get-servicerequest',['srid'=>$args[0]]),true);
	$updates = json_decode($ots->execute('servicerequest','get-updates',['srid'=>$args[0]]),true);
}
?>
<style>.row { height:25px} </style>
<div class="page-title">Service Request #<?=$servicerequest ? $servicerequest['servicerequest_id'] : '';?></div>
<div class="bg-white p-2 rounded">
	<div class="row">
		<div class="col-2">
			<b>Requested By</b>
		</div>
		<div class="col-2">
			<?=$servicerequest['tenant_name'];?> on <?=date('F d, Y h:i a',$servicerequest['created_on']);?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
			<b>Stage</b>
		</div>
		<div class="col-2">
			<?=$servicerequest['status'];?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
			<b>Stage</b>
		</div>
		<div class="col-2">
			<?=$servicerequest['status'];?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
			<b>Type</b>
		</div>
		<div class="col-2">
			<?=$servicerequest['sr_type'];?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
			<b>Detail</b>
		</div>
		<div class="col-2">
			<?=$servicerequest['details'];?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
			<b>File(s)</b>
		</div>
		<div class="col-2">
			<?php if(count($servicerequest['attachments'])):?>
				<?php foreach($servicerequest['attachments'] as $attachment):?>
				<a href="<?=$attachment['attachment_url'];?>" target="_blank"><?=$attachment['filename'];?></a>
				<?php endforeach;?>
			<?php endif;?>
		</div>
	</div>
</div>
<div class="my-3">
	<button class="btn btn-secondary btn-sm" onclick="history.back()">Back</button>
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
			window.location.href = '<?=WEB_ROOT;?>/servicerequest/form-update/<?=$servicerequest['id'];?>';
		});
	});
</script>