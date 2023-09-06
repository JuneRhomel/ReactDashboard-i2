<?php
$turnover = null;
if(count($args))
{
	$turnover = json_decode($ots->execute('tenant','get-turnover',['turnover_id'=>$args[0]]),true);	
	$updates_result = $ots->execute('tenant','get-turnover-updates',['turnover_id'=>$args[0]]);
	$updates = json_decode($updates_result,true);
}
?>
<div class="main-container">

	<div class="page-title">Turnover #<?=$turnover ? $turnover['turnover_id'] : '';?></div>
	<div class="bg-white p-2 rounded">
		<div class="row">
			<div class="col-2"><b>Date Created</b></div>
			<div class="col-2"><?=$turnover['created_date'];?></div>
		</div>
		<div class="row">
			<div class="col-2"><b>Tenant</b></div>
			<div class="col-2"><a href="<?=WEB_ROOT?>/tenant/form-resident/<?=$turnover['enc_tenant_id']?>/View" target="_blank"><?=$turnover['tenant_name'];?></a></div>
		</div>
		<div class="row">
			<div class="col-2"><b>Location</b></div>
			<div class="col-2"><a href="<?=WEB_ROOT?>/location/view/<?=$turnover['enc_loc_id']?>?menuid=propman" target="_blank"><?=$turnover['location_name'];?></a></div>
		</div>
		<!-- <div class="row">
			<div class="col-2"><b>Remarks</b></div>
			<div class="col-8"><?=$turnover['details'];?></div>
		</div> -->
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
					<td>Stage</td>
					<td>Attachment</td>
				</tr>
			</thead>
			<?php foreach($updates as $update):?>
				<tr>
					<td><?=$update['description'];?></td>
					<td><?=$update['first_name'] . ' ' .  $update['last_name'];?></td>
					<td><?=date('F d, Y h:i a',$update['created_on']);?></td>
					<td><?=$update['status'];?></td>
				<td>
					<?php foreach($update['attachments'] as $attachment):?>
						<a href="<?=$attachment['attachment_url'];?>" target="_blank"><?=$attachment['filename'];?></a>
						<?php endforeach;?>
					</td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>
		
		<div class="page-title mt-3">Files</div>
		<div class="bg-white p-2 rounded mt-3 w-50">
			<table class="table">
				<thead>
					<tr>
						<td>File Name</td>
					</tr>
				</thead>
				<?php 
		foreach($updates as $update):
			if ($update['attachments']) {
				?>
			<tr>
				<td>
					<?php foreach($update['attachments'] as $attachment):?>
						<a href="<?=$attachment['attachment_url'];?>" target="_blank"><?=$attachment['filename'];?></a>
						<?php endforeach;?>
					</td>
				</tr>
				<?php 
			}
		endforeach;
		?>
	</table>
</div>

</div>
<script>
	$(document).ready(function(){
		$(".btn-add-update").on('click',function(){
			window.location.href = '<?=WEB_ROOT;?>/tenant/form-turnover-update/<?=$turnover['id'];?>';
		});
	});
</script>