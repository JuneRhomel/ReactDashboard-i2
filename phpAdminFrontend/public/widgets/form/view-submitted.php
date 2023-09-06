<?php
$form = null;
if(count($args))
{
	$form = json_decode($ots->execute('form','get-submitted',['submitted_id'=>$args[0]]),true);
	$updates = json_decode($ots->execute('form','get-updates-uploads',['submitted_id'=>$args[0]]),true);
}
?>
<style>.row { height:25px} </style>
<div class="page-title">Submitted Form #<?php echo $form ? $form['form_id'] : '';?></div>
<div class="bg-white p-2 rounded">
	<div class="row">
		<div class="col-2">
		<b>Resident</b> </div>
		<div class="col-2">
			<?php echo $form['tenant_name'];?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
		<b>Form </b></div>
		<div class="col-2">
			<?php echo $form['title'];?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
		<b>Date </b></div>
		<div class="col-2">
			<?php echo date('F d, Y',$form['created_on']);?>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
		<b>File </b></div>
		<div class="col-2">
			<a href="<?php echo $form['file_url'];?>" target="_blank">Download</a>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
			<b>Stage</b></div>
		<div class="col-2">
			<?php echo $form['status'];?>
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
			window.location.href = '<?php echo WEB_ROOT;?>/form/form-update-upload/<?php echo $form['id'];?>';
		});
	});
</script>