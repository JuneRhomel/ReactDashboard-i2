<?php
	//$statuses = [ 'New','Acknowledged','Processing','Closed' ];
	$movement = json_decode($ots->execute('tenant','get-moveinout',['movement_id'=>$args[0]]),true);
	$stages =  json_decode($ots->execute('tenant','get-stages',['stage_type'=>'Movement']),true);
?>

<div class="page-title">Add Update</div>
<div class="col-12 col-sm-6 bg-white p-3">
	<?php if($movement['closed']== 0):?>
	<form method="post" action="<?php echo WEB_ROOT;?>/tenant/save-movement-update?display=plain" class="bg-white" id="form-movement">
		<div class="form-group mb-2">
			<label for="" class="text-required">Description</label>
			<textarea class="form-control" name="description" value="" rows="10" required></textarea>
		</div>

		<div class="form-group mb-2">
			<label for="" class="text-required">Stage</label>
			<select class="form-control form-select" name="status" required>
				<?php foreach($stages as $stage):?>
				<option <?=$stage['stage_name']==$movement['status'] ? 'selected' : '';?>><?=$stage['stage_name']?></option>
				<?php endforeach;?>
			</select>
		</div>

		<button type="button" class="btn btn-light btn-cancel">Cancel</button>

		<button class="btn btn-primary">Submit</button>
		<input type="hidden" value="<?php echo $args[0] ?? '';?>" name="movement_id">
	</form>
	<?php else:?>
		Updating of this record is no longer allowed.
	<?php endif;?>
</div>

<script>
	$(document).ready(function(){
		$("#form-movement").off('submit').on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function(){
				},
				success: function(data){
					if(data.success == 1)
					{
						$(".notification-success-message").html(data.description);
						$(".notification-success").fadeIn('slow',function(){
							window.location.href = '<?php echo WEB_ROOT;?>/tenant/view-movement/<?php echo $args[0] ?? '';?>';
						});	
					}	
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});

		$(".btn-cancel").off('click').on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/tenant/view-movement/<?php echo $args[0] ?? '';?>';
		});
	});
</script>