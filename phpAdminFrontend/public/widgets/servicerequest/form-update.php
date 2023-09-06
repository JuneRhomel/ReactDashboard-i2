<?php
	$statuses = [
		'New','Acknowledged','Processing','Closed'
	];
	
	$servicerequest_result = $ots->execute('servicerequest','get-servicerequest',['srid'=>$args[0]]);
	$servicerequest = json_decode($servicerequest_result,true);
?>

<div class="page-title">Add Update</div>
<div class="col-12 col-sm-6 bg-white p-3">
	<form method="post" action="<?php echo WEB_ROOT;?>/servicerequest/save-update?display=plain" class="bg-white" id="form-servicerequest">
		<div class="form-group mb-2">
			<label for="" class="text-required">Description</label>
			<textarea class="form-control" name="description" value="" rows="10" required></textarea>
		</div>

		<div class="form-group mb-2">
			<label for="" class="text-required">Status</label>
			<select class="form-control" name="status" required>
				<?php foreach($statuses as $status):?>
				<option <?php echo $status==$servicerequest['status'] ? 'selected' : '';?>><?php echo $status;?></option>
				<?php endforeach;?>
			</select>
		</div>

		<button type="button" class="btn btn-light btn-cancel">Cancel</button>

		<button class="btn btn-primary">Submit</button>
		<input type="hidden" value="<?php echo $args[0] ?? '';?>" name="sr_id">
	</form>
</div>

<script>
	$(document).ready(function(){
		$("#form-servicerequest").off('submit').on('submit',function(e){
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
							window.location.href = '<?php echo WEB_ROOT;?>/servicerequest/view/<?php echo $args[0] ?? '';?>';
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
			window.location.href = '<?php echo WEB_ROOT;?>/servicerequest';
		});
	});
</script>