<?php
	$location = null;
	if(count($args))
	{
		$location_result = $ots->execute('location','get-location',['locationid'=>$args[0]]);
		$location = json_decode($location_result,true);
	}
	$location_types_result =  $ots->execute('location','get-location-types');
	$location_types = json_decode($location_types_result);

	$location_uses_result =  $ots->execute('location','get-location-use');
	$location_uses = json_decode($location_uses_result);

	$location_statuses_result =  $ots->execute('location','get-location-statuses');
	$location_statuses = json_decode($location_statuses_result);
?>

<div class="page-title"><?=count($args) ? 'Edit' : 'Add';?> Location</div>
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white p-4 rounded-sm">
		<form method="post" action="<?=WEB_ROOT;?>/location/save?display=plain" class="bg-white" id="form-location">
			<div class="row forms">
					<div class="col-12 col-sm-4">
						<div class="form-group">
							<label>Employee Number </label>
							<input type="text" class="form-control" name="employee_number" value="">
						</div>
					</div>

					<div class="col-12 col-sm-4">
						<div class="form-group">
							<label for="" class="text-required">Name</label>
							<input type="text" class='form-control' name='employee_name' value='<?= $contract->contract_name?>' required>
							
						</div>
					</div>

					<div class="col-12 col-sm-4">
						<div class="form-group">
							<label for="" class="text-required">Username</label>
							<input type="text" class='form-control' name='username' value='<?= $contract->contract_number?>' required>
						</div>
					</div>

					<div class="col-12 col-sm-4">
						<div class="form-group">
						<br>
							<label for="" class="text-required">Email</label>
							<input type="email" class="form-control" name="email" value="<?php echo $equipment ? $equipment['equipment_name'] : '';?>" required>
						</div>
					</div>
					
					<div class="col-12 col-sm-4">
						<div class="form-group">
						<br>
							<label>Contact Number </label>
							<input type="text" name='contact' value='' required class='form-control'>
						</div>
					</div>
				
					<div class="form-group mb-2">
					<br>
						<label for="" class="text-required">Home Address</label>
						<input type="text" name='home_address' class='form-control value='<?= $contract->office_address?>' required>
					</div>

				
					<div class="col-12 col-sm-4">
						<div class="form-group">
						<br>
							<label for="" class="text-required">Working Schedule</label>
							<input type="text" class='form-control' name='work_schedule' value='<?= $contract->contact_person?>' required>
						</div>
					</div>

					<div class="col-12 col-sm-4">
						<div class="form-group">
						<br>
							<label for="" class="text-required">Working Hours</label>
							<input type="text" name='working_hours'  class='form-control' value='<?= $contract->contact_person?>' required>
						</div>
					</div>

					<div><br></div>
					
					<div class="col-12 col-sm-4">
							<div class="form-group">
							<br>
								<label for="" class="text-required">Person To Contact In Case Of Emergency</label>
								<input type="text" name='emergency_contact'  class='form-control' value='<?= $contract->contact_person?>' required>
							</div>
						</div>

						<div class="col-12 col-sm-4">
							<div class="form-group">
							<br>
								<label for="" class="text-required">Relationship</label>
								<input type="text" name='relationship'  class='form-control' value='<?= $contract->contact_person?>' required>
							</div>
						</div>

						<div class="col-12 col-sm-4">
							<div class="form-group">
							<br>
								<label for="" class="text-required">Contact Number</label>
								<input type="text" name='contact_number'  class='form-control' value='<?= $contract->contact_person?>' required>
							</div>
						</div>
				</div>
				<br>
				<button class="btn btn-primary">Submit</button>
				<button type="button" class="btn btn-light btn-cancel">Cancel</button>
				
				<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$("#form-location").off('submit').on('submit',function(e){
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
						$(".notification-success").fadeIn('slow');
						<?php if(!$location):?>	
						$("#form-location")[0].reset();
						<?php endif;?>
					}	
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});

		$(".btn-cancel").off('click').on('click',function(){
			//loadPage('<?=WEB_ROOT;?>/location');
			window.location.href = '<?=WEB_ROOT;?>/location';
		});

		$("input[id=parent_location]").autocomplete({
			autoSelect : true,
			autoFocus: true,
			search: function(event, ui) { 
				$('.spinner').show();
			},
			response: function(event, ui) {
				$('.spinner').hide();
			},
			source: function( request, response ) {
				$.ajax({
					url: '<?=WEB_ROOT;?>/location/search?display=plain',
					dataType: "json",
					type: 'post',
					data: {
						term: request.term,
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {

				$(event.target).prev().val(ui.item.value);
				$(event.target).val(ui.item.label);

				return false;
			},
			change: function(event, ui){
				if(ui.item == null)
				{
					$(event.target).prev('input').val(0);
				}
			}
		});

		$("select[name=location_type]").on('change',function(){
			if($(this).val().toLowerCase() == 'property')
			{
				$(".location-container").addClass('d-none');
				$("input[name=parent_location]").val('');
				$("#parent_location_id").val(0);
			}else{
				$(".location-container").removeClass('d-none');
			}
		});
	});
</script>