<?php
	$location = null;
	if(count($args))
	{
		$data = [
			'id'=>$args[0],
			'view'=>'building_personnel_view'
		];

		$bp_result = $ots->execute('property-management','get-record',$data);
		$building_p = json_decode($bp_result,true);
	}
?>

<!-- <div class="page-title"><?=count($args) ? 'Edit' : 'Edit';?> Form</div> -->
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white rounded-sm">
		<form method="post" action="<?=WEB_ROOT;?>/property-management/save-record?display=plain" id="save-bp" class="bg-white">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/property-management/view-building-personnel/<?= $args[0]?>/View' >
			<input type="hidden" name='table'  id='id' value= 'building_personnel'>
			<input type="hidden" name='view_table'  id='id' value= 'building_personnel_view'>
			<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Employee Number <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="employee_number" value="<?= $building_p['employee_number'];?>" required>
						</div>
					</div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Name <span class="text-danger">*</span></label>
							<input type="text" class='form-control' name='employee_name' value='<?= $building_p['employee_name'];?>' required>
							
						</div>
					</div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Username <span class="text-danger">*</span></label>
							<input type="text" class='form-control' name='username' value='<?= $building_p['username'];?>' required>
						</div>
					</div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
						
							<label for="" class="text-required">Email <span class="text-danger">*</span></label>
							<input type="email" class="form-control" name="email" value="<?= $building_p['email'];?>" required>
						</div>
					</div>
					
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
						
							<label for="" class="text-required">Contact Number  <span class="text-danger">*</span></label>
							<input type="text" name='contact_number' value='<?= $building_p['contact_number'];?>' required class='form-control'>
						</div>
					</div>
				
					<div class="col-8 mb-3 my-4">
						<div class="form-group">
							<label for="" class="text-required">Home Address <span class="text-danger">*</span></label>
							<input type="text" name='home_address' class='form-control' value='<?= $building_p['home_address'];?>' required>
						</div>
					</div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
						
							<label for="" class="text-required">Working Schedule <span class="text-danger">*</span></label>
							<select class="form-control form-select category" name="working_schedule" required>
								<option value="weekdays"<?= ($building_p['working_schedule']=='Weekdays')?'selected':'';?>>Weekdays</option>
								<option value="weekends"<?= ($building_p['working_schedule']=='Weekends')?'selected':'';?>>Weekends</option>
							</select>
						</div>
					</div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
						
							<label for="" class="text-required">Working Hours <span class="text-danger">*</span></label>
							<select class="form-control form-select category" name="working_hours" required>
								<option value="6am-2pm"<?= ($building_p['working_hours']=='6am-2pm')?'selected':'';?>>6am-2pm</option>
								<option value="8am-5pm"<?= ($building_p['working_hours']=='8am-5pm')?'selected':'';?>>8am-5pm</option>
								<option value="9am-6pm"<?= ($building_p['working_hours']=='9am-6pm')?'selected':'';?>>9am-6pm</option>
								<option value="2pm-10pm"<?= ($building_p['working_hours']=='2pm-10pm')?'selected':'';?>>2pm-10pm</option>
								<option value="10pm-6pm"<?= ($building_p['working_hours']=='10pm-6pm')?'selected':'';?>>10pm-6am</option>
							</select>
						</div>
					</div>
					
					<div class="col-12 col-sm-4 my-4">
							<div class="form-group">
							
								<label for="" class="text-required">Person To Contact In Case Of Emergency <span class="text-danger">*</span></label>
								<input type="text" name='person_to_contact_in_case_of_emergency'  class='form-control' value='<?= $building_p['person_to_contact_in_case_of_emergency'];?>' required>
							</div>
						</div>

						<div class="col-12 col-sm-4 my-4">
							<div class="form-group">
							
								<label for="" class="text-required">Relationship <span class="text-danger">*</span></label>
								<input type="text" name='relationship'  class='form-control' value='<?= $building_p['relationship'];?>' required>
							</div>
						</div>

						<div class="col-12 col-sm-4">
							<div class="form-group">
							
								<label for="" class="text-required">Contact Number <span class="text-danger">*</span></label>
								<input type="text" name='emergency_contact_number'  class='form-control' value='<?= $building_p['emergency_contact_number']; ?>' required>
							</div>
						</div>
				</div>
				<div class="btn-group-buttons pull-right my-4">
					<div class="mb-3 float-end" style="padding: 5px;">
						<button type="submit" class="btn btn-dark btn-primary px-5">Save</button>
						<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
					</div>
					<br>
				</div>
		</form>
	</div>
	
</div>

<script>
	$(document).ready(function(){
		$("#save-bp").off('submit').on('submit',function(e){
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
						show_success_modal($('input[name=redirect]').val());
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
			history.back();
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