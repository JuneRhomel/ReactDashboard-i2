<?php
	$equipment = null;
	if(count($args))
	{
		$equipment_result = $ots->execute('equipment','get-equipment',['equipmentid'=>$args[0]]);
		$equipment = json_decode($equipment_result,true);
	}
	$equipment_types_result =  $ots->execute('equipment','get-equipment-types');
	$equipment_types = json_decode($equipment_types_result);

	// $equipment_uses_result =  $ots->execute('equipment','get-equipment-use');
	// $equipment_uses = json_decode($equipment_uses_result);

	// $equipment_statuses_result =  $ots->execute('equipment','get-equipment-statuses');
	// $equipment_statuses = json_decode($equipment_statuses_result);
?>

<div class="page-title"><?php echo count($args) ? 'Edit' : 'Add';?> Form</div>
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white p-4 rounded-sm">
		<form method="post" action="<?php echo WEB_ROOT;?>/equipment/save?display=plain" class="bg-white" id="form-equipment">
			<div class="row forms">
		
				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Name</label>
						<input type="text" class="form-control" name="equipment_name" value="<?php echo $equipment ? $equipment['equipment_name'] : '';?>" required>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Category</label>
						<select class="form-control" name="equipment_category" required>
							<?php foreach($equipment_types as $equipment_type):?>
								<option <?php echo $equipment && $equipment['equipment_type'] == $equipment_type ? 'selected' : '';?>><?php echo $equipment_type;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Type</label>
						<select class="form-control" name="equipment_type" required>
							<?php foreach($equipment_types as $equipment_type):?>
								<option <?php echo $equipment && $equipment['equipment_type'] == $equipment_type ? 'selected' : '';?>><?php echo $equipment_type;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Location</label>
						<input type="text" class="form-control" id="equipment_location" value="<?php echo $equipment ? $equipment['location_name'] : '';?>">
						<input value="<?php echo $equipment ? $equipment['equipment_location'] : '0';?>" type="text" style="width:0px;opacity:0;float:right" class="form-control" name="equipment_location">
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Area Served</label>
						<input type="text" class="form-control" id="equipment_location" value="<?php echo $equipment ? $equipment['location_name'] : '';?>">
						<input value="<?php echo $equipment ? $equipment['equipment_location'] : '0';?>" type="text" style="width:0px;opacity:0;float:right" class="form-control" name="equipment_location">
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Brand</label>
						<input type="text" class="form-control" name="equipment_name" value="" required>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Model</label>
						<input type="text" class="form-control" name="equipment_model" value="" required>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Serial #</label>
						<input type="text" class="form-control" name="equipment_serial" value="" required>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Capacity</label>
						<input type="text" class="form-control" name="equipment_capacity" value="" required>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Date Installed</label>
						<input type="number" name='date_install' class='form-control' value='<?= $contract->days_to_notify?>' required>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Asset #</label>
						<input type="text" class="form-control" name="equipment_asset" value="" required>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Critical Equipment</label>
						<select class="form-control" name="is_critical">
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Service Provider</label>
						<input type="text" class="form-control" name="service_provider" value="" required>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Maintenance Frequency</label>
						<select class="form-control" name="maintenance">
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
					</div>
				</div>
			</div>
			<div><br></div>
			<div class="btn-group pull-right">
				<button type="submit" class="btn btn-dark btn-primary">Add</button>
				<button type="button" class="btn btn-light btn-cancel">Cancel</button>
			</div>


				<input type="hidden" value="<?php echo $args[0] ?? '';?>" name="id">
			
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$("#form-equipment").off('submit').on('submit',function(e){
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
						<?php if(!$equipment):?>	
						$("#form-equipment")[0].reset();
						<?php endif;?>
					}	
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});

		$('#datepicker').datepicker({
			format: 'yy-mm-d',
			timepicker: false,
		});


		$(".btn-cancel").off('click').on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/equipment';
		});

		$("input[id=equipment_location]").autocomplete({
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
					url: '<?php echo WEB_ROOT;?>/location/search?display=plain',
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

		$("select[name=equipment_type]").on('change',function(){
			if($(this).val().toLowerCase() == 'property')
			{
				$(".equipment-container").addClass('d-none');
				$("input[name=parent_equipment]").val('');
				$("#parent_equipment_id").val(0);
			}else{
				$(".equipment-container").removeClass('d-none');
			}
		});
	});
</script>