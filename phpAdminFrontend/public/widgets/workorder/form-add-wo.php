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

<div class="page-title"><?php echo count($args) ? 'Edit' : 'Add';?> Form</div>
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white p-4 rounded-sm">
		<form method="post" action="<?php echo WEB_ROOT;?>/workorder/save?display=plain" class="bg-white" id="form-pm">
			<div class="row forms">
		
				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Location</label>
							<select class="form-control" name="location" required>
							<option value="0">OTS</option>
                            <option value="1">Building</option>
							</select>
					</div>
				</div>

				<div><br></div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Work Order Type</label>
						<select class="form-control" name="wo_type" required>
							<?php foreach($equipment_types as $equipment_type):?>
								<option <?php echo $equipment && $equipment['equipment_type'] == $equipment_type ? 'selected' : '';?>><?php echo $equipment_type;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
                        <label for="" class="text-required">Category</label>
                        <select class="form-control" name="category">
                            <option value="0">Category 1</option>
                            <option value="1">Category 2</option>
                        </select>
                    </div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
                        <label for="" class="text-required">Equipment</label>
                        <select class="form-control" name="equipment">
                            <option value="0">Equipment 1</option>
                            <option value="1">Equipment 2</option>
                        </select>
                    </div>
				</div>
                
                <div class="col-12 col-sm-4">
					<div class="form-group">
						<br>
                        <label for="" class="text-required">Scope of Work/Issue</label>
						<input type="text" class="form-control" name="scope" value="" required>
					</div>
				</div>
				
                <div class="col-12 col-sm-4">
					<div class="form-group">
						<br>
                        <label for="" class="text-required">Priority Level</label>
                        <select class="form-control" name="priority">
                            <option value="0">Frequency 1</option>
                            <option value="1">Frequency 2</option>
                        </select>
                    </div>
				</div>

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
                        <label for="" class="text-required">Priority Level</label>
						<input type="text" class="form-control" name="priority_level" value="" required>
					</div>
				</div>
               
                <div class="col-12 col-sm-4">
					<div class="form-group">
                        <label for="" class="text-required">Breakdown</label>
                        <select class="form-control" name="breakdown">
                            <option value="0">Breakdown 1</option>
                            <option value="1">Breakdown 2</option>
                        </select>
                    </div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<br>
                        <label for="" class="text-required">Amount</label>
						<input type="text" class="form-control" name="amount" value="" required>
					</div>
				</div>
               
               <div class="col-12 col-sm-4">
					<div class="form-group">
                    <br>
                        <label for="" class="text-required">Target Date</label>
                        <select class="form-control" name="target_date">
                            <option value="0">Date 1</option>
                            <option value="1">Date 2</option>
                        </select>
                    </div>
				</div>

			</div>
            <div><br></div>
            <button class="btn btn-primary btn-save">Add</button>

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