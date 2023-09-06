<?php
	$punchlist = json_decode($ots->execute('tenant','get-punchlist',['punchlist_id'=>$args[0]]),true);
	$stages =  json_decode($ots->execute('tenant','get-stages',['stage_type'=>'Punch List']),true);
?>

<div class="page-title">Add Update</div>
<div class="col-12 col-sm-6 bg-white p-3">
	<form method="post" action="<?php echo WEB_ROOT;?>/tenant/save-punchlist-update?display=plain" class="bg-white" id="form-punchlist" enctype="multipart/form-data">
		<div class="form-group mb-2">
			<label for="" class="text-required">Description</label>
			<textarea class="form-control" name="description" value="" rows="10" required></textarea>
		</div>

		<div class="form-group mb-2">
			<label for="" class="text-required">Stage</label>
			<select class="form-control form-select" name="status" required>
				<?php foreach($stages as $stage):?>
				<option <?=$stage['stage_name']==$punchlist['status'] ? 'selected' : '';?>><?=$stage['stage_name']?></option>
				<?php endforeach;?>
			</select>
		</div>

		<div class="form-group mb-2">
			<label for="" class="text-required">Attachments</label>
			<input type="file" class="form-control" name="file[]" value="" multiple>
		</div>

		<button type="button" class="btn btn-light btn-cancel">Cancel</button>

		<button class="btn btn-primary">Submit</button>
		<input type="hidden" value="<?=$args[0] ?? '';?>" name="punchlist_id">
	</form>
</div>

<script>
	$(document).ready(function(){
		$("#form-punchlist").off('submit').on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				dataType: 'JSON',
				data: new FormData($(this)[0]),
				contentType: false,
				processData: false,
				beforeSend: function(){},
				success: function(data){
					if(data.success == 1)
					{
						$(".notification-success-message").html(data.description);
						$(".notification-success").fadeIn('slow',function(){
							window.location.href = '<?=WEB_ROOT;?>/tenant/view-punchlist/<?=$args[0] ?? '';?>';
						});	
					}	
				},
				complete: function(){},
				error: function(jqXHR, textStatus, errorThrown){}
			});
		});

		$(".btn-cancel").off('click').on('click',function(){
			window.location.href = "<?=WEB_ROOT;?>/tenant/view-punchlist/<?=$args[0] ?? '';?>";
		});
	});
</script>