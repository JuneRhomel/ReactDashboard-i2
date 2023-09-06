<?php
	$location = null;
	if(count($args))
	{
		$data = [
			'id'=>$args[0],
			'view'=>'building_personnel_view'
		];
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
<style>
*{
    margin: 0;
    padding: 0;
}
.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}

</style>

<div class="main-container">
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class=" rounded-sm">
		<form method="post" action="<?=WEB_ROOT;?>/property-management/save-record?display=plain" id="save-bp"  >
				<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/property-management/building-personnel'>
				<input type="hidden" name='table'  id='id' value= 'building_personnel'>
				<input type="hidden" name='view_table'  id='id' value= 'building_personnel_view'>
				<!-- <input type="hidden" name='update_table'  id='id' value= 'contract_updates'> -->
				<label class="required-field mt-4">* Please Fill in the required fields</label>
				<div class="row forms">
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
								<input type="text" placeholder="Type Here"  class="form-control" name="employee_number" value="" required>
								<label for="" class="text-required">Employee Number <span class="text-danger">*</span></label>
							</div>
						</div>
	
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
								<input type="text" placeholder="Type Here" class="form-control" name="employee_name" value="" required>
								<label for="" class="text-required">Employee Name <span class="text-danger">*</span></label>
							</div>
						</div>
	
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
								<input type="text" placeholder="Type Here" class="form-control" name="username" value="" required>
								<label for="" class="text-required">Username <span class="text-danger">*</span></label>
							</div>
						</div>
	
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
							
								<input type="email" placeholder="Type Here" class="form-control" name="email" value="" required>
								<label for="" class="text-required">Email <span class="text-danger">*</span></label>
							</div>
						</div>
						
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
							
								<input type="text" placeholder="Type Here" name='contact_number' value='' required class='form-control'>
								<label for="" class="text-required">Contact Number  <span class="text-danger">*</span></label>
							</div>
						</div>
					
						<div class="col-8 mb-3 my-4">
							<div class="form-group input-box">
								<input type="text" placeholder="Type Here" name='home_address' class='form-control' value='<?= $contract->office_address?>' required>
								<label for="" class="text-required">Home Address <span class="text-danger">*</span></label>
							</div>
						</div>
	
					
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
							
								<select class="form-control form-select category" name="working_schedule" required>
								<option value="" selected disabled></option>
									<option value="weekdays">Weekdays</option>
									<option value="weekends">Weekends</option>
								</select>
								<label for="" class="text-required">Working Schedule <span class="text-danger">*</span></label>
							</div>
						</div>
						
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
							
								<select class="form-control form-select category" name="working_hours" required>
									<option value="" selected disabled></option>
									<option value="6am-2pm">6am-2pm</option>
									<option value="8am-5pm">8am-5pm</option>
									<option value="9am-6pm">9am-6pm</option>
									<option value="2pm-10pm">2pm-10pm</option>
									<option value="10pm-6pm">10pm-6am</option>
								</select>
								<label for="" class="text-required">Working hours <span class="text-danger">*</span></label>
							</div>
						</div>
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
							
								<input type="text" placeholder="Type Here" class='form-control' name='person_to_contact_in_case_of_emergency' value='<?= $contract->contact_person?>' required>
								<label for="" class="text-required">Person to contact in case of emergency <span class="text-danger">*</span></label>
							</div>
						</div>
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
							
								<input type="text" placeholder="Type Here" class='form-control' name='relationship' value='<?= $contract->contact_person?>' required>
								<label for="" class="text-required">Relationship <span class="text-danger">*</span></label>
							</div>
						</div>
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
							
								<input type="text" placeholder="Type Here" class='form-control' name='emergency_contact_number' value='<?= $contract->contact_person?>' required>
								<label for="" class="text-required">Emergency Contact Number <span class="text-danger">*</span></label>
							</div>
						</div>
	
					</div>
					<div class="btn-group-buttons pull-right">
						<div class="mb-3 d-flex gap-3 justify-content-end" style="padding: 5px;">
							<button type="submit" class="main-btn">Save</button>
							<button type="button" class="main-cancel btn-cancel ">Cancel</button>
						</div>
					</div>
					
					<!-- <input type="hidden" value="<?=$args[0] ?? '';?>" name="id"> -->
			</form>
		</div>
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
			Swal.fire({
					text: "This information will be deleted once you exit, are you sure you want to exit?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes',
				}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					window.location.href = '<?php echo WEB_ROOT;?>/property-management/building-personnel?submenuid=location';
				}
			})
			// window.location.href = '<?php echo WEB_ROOT;?>/property-management/pm';
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


