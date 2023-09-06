<?php
	$data = [
		'id'=>$args[0],
		'view'=>'views_pm'
	];
	$pm = $ots->execute('property-management','get-record',$data);
	$pm = json_decode($pm);
	// var_dump($pm);

	// p_r($pm);
	$equipment_types_result =  $ots->execute('equipment','get-equipment-types');
	$equipment_types = json_decode($equipment_types_result);

	$data= [
		'view'=>'service_providers_view'
	];
	$providers = $ots->execute('property-management','get-records',$data);
	$providers = json_decode($providers);
	// p_r($providers);
	
	$data= [
		'view'=>'view_equipments'
	];
	$equipments = $ots->execute('property-management','get-records',$data);
	$equipments = json_decode($equipments);


	$data= [
		'_id'=>$pm->service_provider_id,
		'view'=>'service_providers'
	];
	$provider = $ots->execute('property-management','get-record',$data);
	$pm_provider = json_decode($provider);
	
	$data= [	
		'_id'=>$pm->equipment_id,
		'view'=>'equipments'
	];
	$equipment = $ots->execute('property-management','get-record',$data);
	$pm_equipment = json_decode($equipment);

	$missing = null;
	$next_url = WEB_ROOT . "/property-management/equipment?submenuid=equipment";
	
	// p_r($equipments);
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

<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<?php 
		if($missing){
			?>
			<script>
				Swal.fire({
					title: "<?= $title ?>",
					isDismissed:false,
					confirmButtonText: 'Yes',
					html:'<?= $html ?>',
					allowOutsideClick: false
				}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					window.location.href = "<?= $next_url ?>";
				} 
				})
			</script>
			<?php
		}
	?>
	<div class="bg-white rounded-sm <?=($providers)?'' :'opacity-25'?>">
		<form method="post" action="<?=WEB_ROOT;?>/property-management/save-pm?display=plain" class="bg-white" disabled id='pm-form-edit'>
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/property-management/view-pm/<?= $args[0]?>' >
			<input type="hidden" name='id'  id='id' value= '<?= $args[0]?>'>
			<input type="hidden" name='table'  id='id' value= 'pm'>
			<input type="hidden" name='stage_table'  id='id' value= 'stages'>
			<input type="hidden" name='view_table'  id='id' value= 'views_pm'>
			<input type="hidden" name='update_table'  id='id' value= 'pm_updates'>
			<!-- <input type="text" name='test'  id='test' value=<?= decryptData($args[0]) ?>> -->
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Equipment <span class="text-danger">*</span></label>
					<input name="equipment_id" type="hidden" value="<?= $pm->equipment_id ?>" required>
					<input id="equipment_id" type="text" class="form-control" value="<?= $pm_equipment->equipment_name?>" placeholder="Search location.." required>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Location <span class="text-danger">*</span></label>
						<select name="location"  class='form-control' id='location' required>
						<?php
						 	$selected = '';
							//belowground
							for($i=1; $i<=$building_profile->below_ground; $i++){
								if($pm->location == "Basement {$i}"){
									$selected = 'selected';
								}else{
									$selected = '';
								}

								echo "<option value='Basement {$i}' $selected>Basement ".$i."</option>";
							}

							//aboveground
							for($i=1; $i<=$building_profile->ground_above; $i++){
								$j = $i % 10;
								$k = $i % 100;
								if ($j == 1 && $k != 11) {
									if($pm->location == "{$i}st floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}st floor' $selected>".$i."st floor</option>";
								}
								else if ($j == 2 && $k != 12) {
									if($pm->location == "{$i}nd floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}nd floor' $selected>".$i."nd floor</option>";
								}
								else if ($j == 3 && $k != 13) {
									if($pm->location == "{$i}rd floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}rd floor' $selected>".$i."rd floor</option>";
								}
								else{
									if($pm->location == "{$i}th floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}th floor' $selected>".$i."th floor</option>";
								}
							}
						?>
						</select>
					</div>
				</div>
			</div>
			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Preventive Maintenance Start Date <span class="text-danger">*</span></label>
						<input type="date1" class="form-control" name='pm_start_date' value= '<?= explode(' ',$pm->pm_start_date)[0] ?>' >
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Time <span class="text-danger">*</span></label>
						<input type="time1" class="form-control" name='pm_start_time' value='<?= explode(' ',$pm->pm_start_date)[1] ?>'>
					</div>
				</div>
			</div>
			<div class="row forms">
				<div class="col-4 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Preventive Maintenance End Date <span class="text-danger">*</span></label>
						<input type="date1" class="form-control" name='pm_end_date' value='<?= explode(' ',$pm->pm_end_date)[0] ?>'>
					</div>
				</div>
				<div class="col-4 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Time <span class="text-danger">*</span></label>
						<input type="tim1e" class="form-control" name='pm_end_time' value='<?= explode(' ',$pm->pm_end_date)[1] ?>'>
					</div>
				
				</div>
				<div class="col-4 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Frequency <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="frequency">
							<option value='annual' <?= ($pm->frequency == 'annual')?'selected':'' ?>>Annual</option>
							<option value='semi-annual' <?= ($pm->frequency == 'semi-annual')?'selected':'' ?>>Semi-Annual</option>
							<option value='quarterly' <?= ($pm->frequency == 'quarterly')?'selected':'' ?>>Quarterly</option>
							<option value='monthy' <?= ($pm->frequency == 'monthly')?'selected':'' ?>>Monthly</option>
						</select>
						
					</div>
				</div>
			</div>
			<div class="row forms my-3">
				<div class="col-4 d-flex">
					<input type="checkbox" class="form-check" name='repeat_notif' id='repeat' <?= ($pm->repeat_notif == 'on')?'checked':'' ?>>  &nbsp;
					<label for="repeat" class="text-required px-2" style="padding: 5px">Repeats</label> 
					<label for="notify_days_before_next_schedule" class='px-2 text-required' style="padding: 5px">Notify</label> 
					<input type="number"  size='2' name='notify_days_before_next_schedule' class='px-2 form-control' style='width:50px;height30px;' required value="<?= $pm->notify_days_before_next_schedule ?>" >
					<label for="" class="text-required" style="padding: 5px">Days before the next schedule <span class="text-danger">*</span></label> 
				</div>
			</div>
			<div class="row forms">				
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Priority Level <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="priority_level">
							<option value="1" <?= ($pm->priority_level == 1 )?'selected':'' ?>>Priority 1</option>
							<option value="2" <?= ($pm->priority_level == 2 )?'selected':'' ?>>Priority 2</option>
							<option value="3" <?= ($pm->priority_level == 3 )?'selected':'' ?>>Priority 3</option>
							<option value="4" <?= ($pm->priority_level == 4 )?'selected':'' ?>>Priority 4</option>
							<option value="5" <?= ($pm->priority_level == 5 )?'selected':'' ?>>Priority 5</option>
						</select>
						<label class="text-danger text-required mt-2 p1-prio active-label">Resolution Time 24 Hours</label>
						<label class="text-danger text-required mt-2 p2-prio">Resolution Time 48 hours</label>
						<label class="text-danger text-required mt-2 p3-prio">Resolution Time 72 hours</label>
						<label class="text-danger text-required mt-2 p4-prio">Resolution Time 96 hours</label>
						<label class="text-danger text-required mt-2 p5-prio">Resolution Time 120 hours</label>
					</div>
				</div>
				
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<label for="" class="text-required">Critical Equipment <span class="text-danger">*</span></label>
						<select name="critical" id="critical" class='form-select'>
							<option value="No" <?= ($pm->critical == 'No' )?'selected':'' ?>>No</option>
							<option value="Yes" <?= ($pm->critical == 'Yes' )?'selected':'' ?>>Yes</option>
						</select>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col">
					<h5 class='py-2'>Vendor Details</h5>
				</div>
			</div>
			<div class="row forms">				
				<div class="col-12 col-sm-4 my-4">	
					<label for="" class="text-required">Service Provider <span class="text-danger">*</span></label>
					<input name="service_provider_id" type="hidden" value="<?= $pm->service_provider_id?>" required>
					<input id="service_provider_id" type="text" class="form-control" value="<?= $pm_provider->company ?>" placeholder="Search Provider" required>
					
				</div>
				<div class="col-12 col-sm-4 my-4">	
					<label for="" class="text-required">Person In-charge <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="person_in_charge" value=""  <?=($providers)?'' :'disabled'?>>
				</div>
				<div class="col-12 col-sm-4 my-4">	
					<label for="" class="text-required">Email  <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="email" value="" <?=($providers)?'' :'disabled'?>>
				</div>
			</div>
			<div class="row forms">				
				<div class="col-12 col-sm-4 my-4">	
					<label for="" class="text-required">Contact # <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="contact_number" value="" <?=($providers)?'' :'disabled'?>>
				</div>
			</div>
			<div class="row forms">				
				<div class="col-12 d-flex">
					<label for="notify_days_before_next_schedule" class='px-2 text-required'  style="padding: 5px">Notify Vendor</label> 
					<input type="number"  size='2' name='notify_vendor_before_next_schedule' class='px-2 form-control' style='width:50px;height30px;' value='<?= $pm->service_provider_id?>'>
					<label for="" class="text-required"  style="padding: 5px">Days before the next schedule </label> 
				</div>
			</div>
			<div><br></div>
			<div class="btn-group-buttons pull-right">
				<div class="mb-3 float-end" style="padding: 5px;">
					<button type="submit" class="btn btn-dark btn-primary px-5">Save</button>
					<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
				</div>
				<br>
			</div>
		</form>
	</div>
</div>
	<div class="modal" tabindex="-1" role="dialog" id='pm-preview'>
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Pm Preview</h5>
					<button type="button" class="close btn-close" data-dismiss="modal" onclick='$("#pm-preview").modal("hide")' aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					
				</div>
				<div class="modal-footer">
					
				</div>
			</div>
		</div>
		
	</div>

<script>
		
	$(document).ready(function(){

		var start_date;
		$('input[name=pm_start_date],input[name=pm_start_time]').change(function(){
			$('input[name=pm_end_date]').prop('min', $('input[name=pm_start_date]').val());
			start_date = $('input[name=pm_start_date]').val() + " " + $('input[name=pm_start_time]').val();
			start_date = new Date(start_date).getTime();
		});

		$('input[name=pm_end_time]').change(function(){
			end_date = $('input[name=pm_end_date]').val() + " " + $('input[name=pm_end_time]').val();
			end_date = new Date(end_date).getTime();

			if(end_date < start_date){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'End date must be not be earlier than start date',
					
				})
				$('input[name=pm_end_time]').val('');
				$('input[name=pm_end_time]').focus();
			}
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

		$("#pm-form-edit").off('submit').on('submit',function(e){
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
			window.location.href = '<?=WEB_ROOT;?>/property-management/view-pm/<?= $args[0]?>';
		});
		$("input[id=equipment_id]").autocomplete({
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
						view: 'view_equipments',
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
				$('input[name="location"]').val(ui.item.location);
				return false;
			},
			change: function(event, ui){
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
			}
		});

		$(".btn-preview").on('click',function(){
			$.ajax({
				url: '<?=WEB_ROOT;?>/property-management/pm-schedule-preview?display=plain',
				type: 'POST',
				data: $("#pm-form-save").serialize(),
				dataType: 'HTML',
				beforeSend: function(){
				},
				success: function(data){
					$("#pm-preview").modal('show');
					$("#pm-preview .modal-body").html(data);
					
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
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
				$('#person_in_charge').val(ui.item.contact_person);
				$('#email').val(ui.item.email);
				$('#contact_number').val(ui.item.contact_number);
				return false;
			},
			change: function(event, ui){
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
			}
		});
		$('#datepicker').datepicker({
			format: 'yy-mm-d',
			timepicker: false,
		});

	});

	$("select[name=category]").on('change', function() {
		$("select[name=type").find('option').remove();
		if($("select[name=category]").val() == 1){
			$("select[name=type").append('<option value="Air-conditioning">Air-conditioning</option><option value="Elevator">Elevator</option><option value="Fire Detection & Alarm System">Fire Detection & Alarm System</option><option value="Pumps">Pumps</option><option value="Generator">Generator</option><option value="Building Management System">Building Management System</option><option value="CCTV">CCTV</option><option value="Pressurization Blower/Fan">Pressurization Blower/Fan</option><option value="Exhaust Fan">Exhaust Fan</option><option value="Gondola">Gondola</option><option value="Others">Others</option>');
		}
		else if($("select[name=category]").val() == 2){
			$("select[name=type").append('<option value="Transformers">Transformers</option><option value="UPS">UPS</option><option value="Automatic Transfer Switch">Automatic Transfer Switch</option><option value="Control Gear">Control Gear</option><option value="Switch Gear">Switch Gear</option><option value="Capacitor">Capacitor</option><option value="Breakers/Panel Boards">Breakers/Panel Boards</option><option value="Meters">Meters</option><option value="Others">Others</option>');
		}
		else if($("select[name=category]").val() == 3){
		$("select[name=type").append('<option value="Sprinklers">Sprinklers</option><option value="Smoke Detectors">Smoke Detectors</option><option value="Manual Pull Stations">Manual Pull Stations</option><option value="Fire Alarm">Fire Alarm</option><option value="FDAS Panel">FDAS Panel</option><option value="Others">Others</option>');
		}
		else{
		$("select[name=type").append('<option value="N/A">N/A</option>');
		}
	});
</script>