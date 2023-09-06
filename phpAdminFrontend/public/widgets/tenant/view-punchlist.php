<?php
$punchlist = null;
if(count($args))
{
	$punchlist = json_decode($ots->execute('tenant','get-punchlist',['punchlist_id'=>$args[0]]),true);	
	$updates = json_decode($ots->execute('tenant','get-punchlist-updates',['punchlist_id'=>$args[0]]),true);
}
?>
<div class="main-container">

	<div class="page-title">Punch List #<?=$punchlist ? $punchlist['punchlist_id'] : '';?></div>
	<div class="bg-white p-2 rounded">
		<div class="row">
			<div class="col-2">Date Created</div>
			<div class="col-2"><?=$punchlist['created_date'];?></div>
		</div>
		
		<div class="row">
			<div class="col-2">Name of Owner</div>
			<div class="col-2"><a href="<?=WEB_ROOT?>/tenant/form-resident/<?=$punchlist['enc_tenant_id']?>/View" target="_blank"><?=$punchlist['tenant_name'];?></a></div>
		</div>
		
		<div class="row">
			<div class="col-2">Location</div>
			<div class="col-2"><a href="<?=WEB_ROOT?>/location/view/<?=$punchlist['enc_loc_id']?>?menuid=propman" target="_blank"><?=$punchlist['location_name'];?></a></div>
		</div>
		
		<div class="row">
			<div class="col-2">Remarks</div>
			<div class="col-8"><?=$punchlist['details'];?></div>
		</div>
		
		<?php foreach($punchlist['attachments'] as $attachment):?>
		<img src="<?=$attachment['attachment_url'];?>" target="_blank" style="max-width:200px">
		<?php endforeach;?>
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
						<?php if (strpos($attachment['attachment_url'],"jpg")!==false || strpos($attachment['attachment_url'],"jpeg")!==false || strpos($attachment['attachment_url'],"png")!==false) { ?>
					<img src="<?=$attachment['attachment_url']?>" width="50" height="50">&nbsp;&nbsp;
					<?php } ?>
					<a href="<?=$attachment['attachment_url'];?>" target="_blank"><?=$attachment['filename'];?></a>&nbsp;
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
						<?php if (strpos($attachment['attachment_url'],"jpg")!==false || strpos($attachment['attachment_url'],"jpeg")!==false || strpos($attachment['attachment_url'],"png")!==false) { ?>
							<img src="<?=$attachment['attachment_url']?>" width="50" height="50">&nbsp;&nbsp;
							<?php } ?>
							<a href="<?=$attachment['attachment_url'];?>" target="_blank"><?=$attachment['filename'];?></a>&nbsp;
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
			window.location.href = '<?=WEB_ROOT;?>/tenant/form-punchlist-update/<?=$punchlist['id'];?>';
		});
	});
</script>