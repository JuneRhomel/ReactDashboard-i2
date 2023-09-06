<?php
	// $equipment = null;
	// if(count($args))
	// {
	// 	$equipment_result = $ots->execute('equipment','get-equipment',['equipmentid'=>$args[0]]);
	// 	$equipment = json_decode($equipment_result,true);
	// }
	// $equipment_types_result =  $ots->execute('equipment','get-equipment-types');
	// $equipment_types = json_decode($equipment_types_result);

	// $equipment_uses_result =  $ots->execute('equipment','get-equipment-use');
	// $equipment_uses = json_decode($equipment_uses_result);

	// $equipment_statuses_result =  $ots->execute('equipment','get-equipment-statuses');
	// $equipment_statuses = json_decode($equipment_statuses_result);
?>

<div class="page-title"><?php echo count($args) ? 'Edit' : 'Edit';?> Form</div>
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white p-4 rounded-sm">
		<form method="post" action="<?php echo WEB_ROOT;?>/pm/save?display=plain" class="bg-white" id="form-pm">
			<div class="row forms">
		
				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Location</label>
						<input type="text" class="form-control" name="pm_location" value="<?php echo $equipment ? $equipment['equipment_name'] : '';?>" required>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Equipment</label>
						<select class="form-control" name="pm_equipment" required>
							<?php foreach($equipment_types as $equipment_type):?>
								<option <?php echo $equipment && $equipment['equipment_type'] == $equipment_type ? 'selected' : '';?>><?php echo $equipment_type;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>

				<div><br></div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
                        <label for="" class="text-required">PM Start Date</label>
                        <select class="form-control" name="start_date">
                            <option value="0">Start Date 1</option>
                            <option value="1">Start Date 2</option>
                        </select>
                    </div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
                        <label for="" class="text-required">Time</label>
                        <select class="form-control" name="start_time">
                            <option value="0">Time 1</option>
                            <option value="1">Time 2</option>
                        </select>
                    </div>
				</div>

                <div><br></div>
                
                <div class="col-12 col-sm-4">
					<div class="form-group">
                        <label for="" class="text-required">PM End Date</label>
                        <select class="form-control" name="end_date">
                            <option value="0">End Date 1</option>
                            <option value="1">End Date 2</option>
                        </select>
                    </div>
				</div>
				
                <div class="col-12 col-sm-4">
					<div class="form-group">
                        <label for="" class="text-required">Time</label>
                        <select class="form-control" name="end_time">
                            <option value="0">Time 1</option>
                            <option value="1">Time 2</option>
                        </select>
                    </div>
				</div>

                <div class="col-12 col-sm-4">
					<div class="form-group">
                        <label for="" class="text-required">Frequency</label>
                        <select class="form-control" name="frequency">
                            <option value="0">Frequency 1</option>
                            <option value="1">Frequency 2</option>
                        </select>
                    </div>
				</div>
               
                <div class="mt-2">
                    <div class="row">
                        <div class="col-12 col-sm-1">
                        <br>
                            <label><input type="checkbox" name="sched_repeat"> Repeat</label>
                        </div>
                        <div class="col-12 col-sm-8	">
                        <br>
                            Notify <input name="days_notify" class="text-center" type="text" value="30" style="width:50px"> days before the next schedule
                        </div>
                    </div>
                </div>
                <div><br></div>
                <div class="col-12 col-sm-4">
					<div class="form-group">
                        <label for="" class="text-required">Priority Level</label>
                        <select class="form-control" name="priority">
                            <option value="0">Frequency 1</option>
                            <option value="1">Frequency 2</option>
                        </select>
                    </div>
				</div>
                <div><br></div>
            </div>

               <h4><b>Vendor Details</b></h4>

            <div class="row forms">
               <div class="col-12 col-sm-4">
					<div class="form-group">
                    <br>
                        <label for="" class="text-required">Service Provider</label>
                        <select class="form-control" name="service_provider">
                            <option value="0">Provider 1</option>
                            <option value="1">Provider 2</option>
                        </select>
                    </div>
				</div>

                <div class="col-12 col-sm-4">
					<div class="form-group">
                    <br>
                        <label for="" class="text-required">Person In-Charge</label>
                        <select class="form-control" name="person">
                            <option value="0">Person 1</option>
                            <option value="1">Person 2</option>
                        </select>
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
						<label for="" class="text-required">Contact #</label>
						<input type="text" class="form-control" name="contact" value="<?php echo $equipment ? $equipment['equipment_name'] : '';?>" required>
					</div>
				</div>
                <div class="mt-2">
                    <div class="row">
                        
                        <div class="col-12 col-sm-8	">
                        <br>
                            Notify Vendor <input name="days_notify" class="text-center" type="text" value="30" style="width:50px"> days before the next schedule
                        </div>
                    </div>
                </div>
			</div>
            <div><br></div>
            <button class="btn btn-primary btn-save">Save</button>

            <button class="btn btn-primary btn-preview">Preview</button>

            <button type="button" class="btn btn-light btn-cancel">Cancel</button>

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