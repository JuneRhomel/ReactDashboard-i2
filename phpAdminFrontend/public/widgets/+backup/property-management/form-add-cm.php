<?php
	// $equipment = null;
	// if(count($args))
	// {
	// 	$equipment_result = $ots->execute('equipment','get-equipment',['equipmentid'=>$args[0]]);
	// 	$equipment = json_decode($equipment_result,true);
	// }
	$data= [
		'view'=>'service_providers_view'
	];
	$providers = $ots->execute('property-management','get-records',$data);
	$providers = json_decode($providers);
	$data= [
		'view'=>'view_equipments'
	];
	$equipments = $ots->execute('property-management','get-records',$data);
	$equipments = json_decode($equipments);

	$data= [
		'view'=>'building_personnel_view'
	];
	$personnels = $ots->execute('property-management','get-records',$data);
	$personnels = json_decode($personnels);


	$missing = null;
	$next_url = WEB_ROOT . "/property-management/equipment?submenuid=equipment";
	if($providers == null && $equipments == null){
		$missing = 1;
		$title = 'Data are mising';
		$next_url = WEB_ROOT . "/property-management/equipment?submenuid=serviceproviders";
		$html = "Equipments and Service Provider are missing";
	}
	else{
		if($providers == null){
			$missing = 1;
			$title = 'Data are mising';
			$next_url = WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders";
			$html = "Service Provider are missing<br><a href=\'" . WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders\' class=\'button\'>Add Service Provider</a>";
		}
		if($equipments == null){
			$missing = 1;
			$title = 'Data are mising';
			$next_url = WEB_ROOT . "/property-management/equipment?submenuid=equipment";
			$html = "Equipments are missing<br><a href=\'" . WEB_ROOT . "/property-management/equipment?submenuid=serviceproviders\' class=\'button\'>Add Equipments</a>";
		}
	}

	$data = [    
		'view'=>'building_profile',
	];
	$building_profile = $ots->execute('admin','get-record',$data);
	$building_profile = json_decode($building_profile);
?>

<div class="main-container">

	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="bg-white rounded-sm">
			<form method="post" action="<?php echo WEB_ROOT;?>/property-management/save-record?display=plain" class="bg-white" id="form-cm-save" enctype="multipart/form-data">
				<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/property-management/cm?submenuid=cm' >
				<input type="hidden" name='table' value= 'cm'>
				<input type="hidden" name='stage_table' value= 'stages'>
				<input type="hidden" name='view_table' value= 'view_cm'>
				<input type="hidden" name='update_table' value= 'cm_updates'>
				<label class="required-field mt-4">* Please Fill in the required fields</label>
				<div class="row forms">
				<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<label for="" class="text-required">Equipment <span class="text-danger">*</span></label>
							<input name="equipment_id" type="hidden" required>
							<input id="equipment_id" type="text" class="form-control" value="<?=$record ? $record['location_name'] : '';?>" placeholder="Search Equipment.." required>
						</div>
					</div>
					
				</div>
				<div class="row forms">
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<select class="form-control form-select" name="wo_type" required>
								<option>Preventive Maintenance</option>
								<option>Corrective Maintenance</option>
							</select>
							<label for="" class="text-required">Work Order Type <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<select class="form-control form-select" name="category_id">
								<option value="Mechanical">Mechanical</option>
								<option value="Electrical">Electrical</option>
								<option value="Fire Protection">Fire Protection</option>
								<option value="Plumbing Sanitary">Plumbing & Sanitary</option>
								<option value="Civil">Civil</option>
								<option value="Structural">Structural</option>
							</select>
							<label for="" class="text-required">Category <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<select name="location"  class='form-control' id='location' required>
								<?php
								//belowground
								for($i=1; $i<=$building_profile->below_ground; $i++){
									echo "<option value='Basement {$i}'>Basement ".$i."</option>";
								}
								
								//aboveground
								for($i=1; $i<=$building_profile->ground_above; $i++){
									$j = $i % 10;
									$k = $i % 100;
									if ($j == 1 && $k != 11) {
										echo "<option value='{$i}st floor'>".$i."st floor</option>";
									}
									else if ($j == 2 && $k != 12) {
										echo "<option value='{$i}nd floor'>".$i."nd floor</option>";
									}
									else if ($j == 3 && $k != 13) {
										echo "<option value='{$i}rd floor'>".$i."rd floor</option>";
									}
									else{
										echo "<option value='{$i}th floor'>".$i."th floor</option>";
									}
								}
								?>
							</select>
							<label for="" class="text-required">Location <span class="text-danger">*</span></label>
							
							<!-- <input type="text" class="form-control" name="location" value="" required> -->
						</div>
					</div>
					
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<label for="" class="text-required">Scope of Work/Issue <span class="text-danger">*</span></label>
							<input type="text" placeholder="Type Here" class="form-control" name="scope_of_work" value="" required>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
						
							<label for="" class="text-required">Assigned Building Personnel <span class="text-danger">*</span></label>
							<input name="assigned_personnel_id" type="hidden" required>
							<input id="assigned_personnel_id" type="text" class="form-control"  placeholder="Search Personel" required>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<select name="priority_level" id="priority_level" class='form-select'>
								<option value="1">Priority 1</option>
								<option value="2">Priority 2</option>
								<option value="3">Priority 3</option>
								<option value="4">Priority 4</option>
								<option value="5">Priority 5</option>
							</select>
							<label for="" class="text-required">Priority Level <span class="text-danger">*</span></label>
							<!-- <label class="text-danger text-required mt-2 p1-prio active-label">Resolution Time 24 Hours</label>
							<label class="text-danger text-required mt-2 p2-prio">Resolution Time 48 hours</label>
							<label class="text-danger text-required mt-2 p3-prio">Resolution Time 72 hours</label>
							<label class="text-danger text-required mt-2 p4-prio">Resolution Time 96 hours</label>
							<label class="text-danger text-required mt-2 p5-prio">Resolution Time 120 hours</label> -->
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3 ">
						<div class="input-box">
							<input name="service_provider_id" type="hidden" required>
							<input id="service_provider_id" type="text" class="form-control" placeholder="Search Provider" required>
							<label for="" class="text-required">Service Provider <span class="text-danger">*</span></label>
	
						</div>
					</div>
				   
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<select class="form-control form-select" name="breakdown">
								<option>No</option>
								<option>Yes</option>
							</select>
							<label for="" class="text-required">Breakdown <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<select name="critical" id="critical" class='form-select'>
								<option value="No">No</option>
								<option value="Yes">Yes</option>
							</select>
							<label for="" class="text-required">Critical Equipment <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
						
							<input type="number" placeholder="Type Here" class="form-control" name="amount" value="" required>
							<label for="" class="text-required">Amount <span class="text-danger">*</span></label>
						</div>
					</div>
				   
				   <div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
						
							<label for="" class="text-required">Target Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name='cm_start_date'>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							
							
							<input type="file" name="file[]" id="file" class='form-control' multiple> 
						</div>
					</div>
	
				</div>
				<div class="btn-group-buttons pull-right">
					<div class="mb-3 d-flex gap-3 justify-content-end" style="padding: 5px;">
						<button type="submit" class="main-btn btn-save">Add</button>
						<button type="button" class="main-cancel btn-cancel ">Cancel</button>
					</div>
				</div>
				
					<input type="hidden" value="<?php echo $args[0] ?? '';?>" name="id">
				
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

		$(".btn-cancel").off('click').on('click',function(){
			Swal.fire({
					text: "This ticket will be deleted once you exit, are you sure you want to exit?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes',
				}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					window.location.href = '<?php echo WEB_ROOT;?>/property-management/cm?submenuid=cm';
				}
			})
		});

		$(".p2-prio").hide();
		$(".p3-prio").hide();
		$(".p4-prio").hide();
		$(".p5-prio").hide();

		$('select[name=priority_level]').on('click', function(e) {
			if($(this).val() == '1')
			{
				$(".p1-prio").show();
				$(".p2-prio").hide();
				$(".p3-prio").hide();
				$(".p4-prio").hide();
				$(".p5-prio").hide();
				
			}
			else if($(this).val() == '2')
			{
				$(".p2-prio").show();
				$(".p1-prio").hide();
				$(".p3-prio").hide();
				$(".p4-prio").hide();
				$(".p5-prio").hide();

			}
			else if($(this).val() == '3')
			{
				$(".p3-prio").show();
				$(".p1-prio").hide();
				$(".p2-prio").hide();
				$(".p4-prio").hide();
				$(".p5-prio").hide();

			}
			else if($(this).val() == '4')
			{
				$(".p4-prio").show();
				$(".p1-prio").hide();
				$(".p2-prio").hide();
				$(".p3-prio").hide();
				$(".p5-prio").hide();

			}
			else if($(this).val() == '5')
			{
				$(".p5-prio").show();
				$(".p1-prio").hide();
				$(".p2-prio").hide();
				$(".p3-prio").hide();
				$(".p4-prio").hide();

			}
		});

		$("#form-cm-save").on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				dataType: 'JSON',
				data: new FormData($(this)[0]),
				contentType: false,
				processData: false,
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

		$("input[id=equipment_id]").autocomplete({
			autoSelect : true,
			autoFocus: true,
			search: function(event, ui) { $('.spinner').show();	},
			response: function(event, ui) {	$('.spinner').hide(); },
			source: function( request, response ) {
				var category = $("select[name=category_id]").val();

				$.ajax({
					url: '<?=WEB_ROOT;?>/property-management/get-records?display=plain',
					dataType: "json",
					type: 'post',
					data: {	
						view: 'view_equipments',
						auto_complete:true,
						term:request.term, filter_field:'category', filter:category
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
				$('input[name="location"]').val(ui.item.location);
				return false;
			},
			change: function(event, ui){
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
			}
		});
		
		$("input[id=assigned_personnel_id]").autocomplete({
			autoSelect : true,
			autoFocus: true,
			search: function(event, ui) { $('.spinner').show();	},
			response: function(event, ui) {	$('.spinner').hide(); },
			source: function( request, response ) {
				$.ajax({
					url: '<?=WEB_ROOT;?>/property-management/get-records?display=plain',
					dataType: "json",
					type: 'post',
					data: {	
						view: 'building_personnel_view',
						auto_complete:true,
						term:request.term, filter:''
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
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
			}
		});

		$("input[id=service_provider_id]").autocomplete({
			autoSelect : true,
			autoFocus: true,
			search: function(event, ui) { $('.spinner').show();	},
			response: function(event, ui) {	$('.spinner').hide(); },
			source: function( request, response ) {
				$.ajax({
					url: '<?=WEB_ROOT;?>/property-management/get-records?display=plain',
					dataType: "json",
					type: 'post',
					data: {	
						view: 'service_providers_view',
						auto_complete:true,
						term:request.term, filter:''
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
				if(ui.item == null)	{
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

		$("input[id=assigned_personnel_id]").autocomplete({
			autoSelect : true,
			autoFocus: true,
			search: function(event, ui) { $('.spinner').show();	},
			response: function(event, ui) {	$('.spinner').hide(); },
			source: function( request, response ) {
				$.ajax({
					url: '<?=WEB_ROOT;?>/property-management/get-records?display=plain',
					dataType: "json",
					type: 'post',
					data: {	
						view: 'building_personnel_view',
						auto_complete:true,
						term:request.term, filter:''
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
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
			}
		});
	});
</script>