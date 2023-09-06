<?php
	$equipment = null;
	if(count($args))
	{
		$data = [
			'id'=>$args[0],
			'view'=>'view_equipments'
		];

		$equipment_result = $ots->execute('property-management','get-record',$data);
		$equipment = json_decode($equipment_result,true);
	}
	$data= [
		'view'=>'service_providers_view'
	];
	$providers = $ots->execute('property-management','get-records',$data);
	$providers = json_decode($providers);

	$data= [
		'_id'=>$equipment['service_provider'],
		'view'=>'service_providers'
	];
	$provider = $ots->execute('property-management','get-record',$data);
	$provider = json_decode($provider,true);
	// var_dump($provider);




	$missing = null;
	$next_url = WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders";
	
	if($providers == null){
		$missing = 1;
		$title = 'Data are mising';
		$next_url = WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders";
		$html = "Service Provider are missing";
	}else{
		if($providers == null){
			$missing = 1;
			$title = 'Data are mising';
			$next_url = WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders";
			$html = "Service Provider are missing<br><a href=\'" . WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders\' class=\'button\'>Add Service Provider</a>";
		}
	}

	$data = [    
		'view'=>'building_profile',
	];
	$building_profile = $ots->execute('admin','get-record',$data);
	$building_profile = json_decode($building_profile);
?>

<!-- <div class="page-title">Edit Form</div> -->
<div class="main-container">
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="">
		<form method="post" action="<?php echo WEB_ROOT;?>/property-management/save-record?display=plain"  id="edit_equipment" enctype="multipart/form-data">
		<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/property-management/view-equipment/<?= $args[0]?>/View' >
		<input type="hidden" name='table'  id='id' value= 'equipments'>
		<input type="hidden" name='view_table'  id='id' value= 'view_equipments'>
		<input type="hidden" value="<?php echo $args[0] ?? '';?>" name="id">
		<label class="required-field mt-4">* Please Fill in the required fields</label>

		<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="equipment_name" value="<?php echo $equipment ? $equipment['equipment_name'] : '';?>" required <?=($providers)?'' :'disabled'?>>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Category <span class="text-danger">*</span></label>
						<select class="form-control form-select category" name="category" required <?=($providers)?'' :'disabled'?>>
							<option value="0"><---select from list---></option>
							<option value="Mechanical" <?= ($equipment['category']=='Mechanical')?'selected':'';?>>Mechanical</option>
							<option value="Electrical" <?= ($equipment['category']=='Electrical')?'selected':'';?>>Electrical</option>
							<option value="Fire Protection" <?= ($equipment['category']=='Fire Protection')?'selected':'';?>>Fire Protection</option>
							<option value="Plumbing & Sanitary" <?= ($equipment['category']=='Plumbing & Sanitary')?'selected':'';?>>Plumbing & Sanitary</option>
							<option value="Civil" <?= ($equipment['category']=='Civil')?'selected':'';?>>Civil</option>
							<option value="Structural" <?= ($equipment['category']=='Structural')?'selected':'';?>>Structural</option>
						</select>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Type <span class="text-danger">*</span></label>
						<select class="form-control form-select type" name="type" required <?=($providers)?'' :'disabled'?>>
						</select>
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
								if($equipment['location'] == "Basement {$i}"){
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
									if($equipment['location'] == "{$i}st floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}st floor' $selected>".$i."st floor</option>";
								}
								else if ($j == 2 && $k != 12) {
									if($equipment['location'] == "{$i}nd floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}nd floor' $selected>".$i."nd floor</option>";
								}
								else if ($j == 3 && $k != 13) {
									if($equipment['location'] == "{$i}rd floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}rd floor' $selected>".$i."rd floor</option>";
								}
								else{
									if($equipment['location'] == "{$i}th floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}th floor' $selected>".$i."th floor</option>";
								}
							}
						?>
						</select>
						<!-- <input type="text" class="form-control" name="location" value="<?php echo $equipment['location'];?>" required > -->
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					
						<label for="" class="text-required">Area Served <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="area_served" value="<?php echo $equipment['area_served'];?>" required <?=($providers)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Brand <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="brand" value="<?php echo $equipment['brand'];?>" required <?=($providers)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Model <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="model" value="<?php echo $equipment['model'];?>" required <?=($providers)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Serial # <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="serial_number" value="<?php echo $equipment['serial_number'];?>" required <?=($providers)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Capacity <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="capacity" value="<?php echo $equipment['capacity'];?>" required <?=($providers)?'' :'disabled'?>> 
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					
						<label for="" class="text-required">Date Installed <span class="text-danger">*</span></label>
						<input type="date" name='date_installed' id='datepicker1' class='form-control' value="<?php echo $equipment['date_installed'];?>" required <?=($providers)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					
						<label for="" class="text-required">Asset # </label>
						<input type="text" class="form-control" name="asset_number" value="<?php echo $equipment['asset_number'];?>" >
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					
						<label for="" class="text-required">Critical Equipment <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="critical_equipment">
							<option value="0" <?= ($equipment['critical_equipment']==0)?'selected':'';?>>No</option>
							<option value="1" <?= ($equipment['critical_equipment']==0)?'selected':'';?>>Yes</option>
						</select>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">	
					<label for="" class="text-required">Service Provider <span class="text-danger">*</span></label>
					<input name="service_provider" type="hidden" value="<?=$equipment['service_provider'];?>" required>
					<input id="service_provider_id" type="text" class="form-control" value="<?=$provider ? $provider['company'] : '';?>" placeholder="Search Provider" required>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					
						<label for="" class="text-required">Maintenance Frequency <span class="text-danger">*</span></label>
						<select class="form-control" name="maintenance_frequency">
							<option <?= ($equipment['maintenance_frequency']=='Annual')?'selected':'';?>>Annual</option>
							<option <?= ($equipment['maintenance_frequency']=='Semi-Annual')?'selected':'';?>>Semi-Annual</option>
							<option <?= ($equipment['maintenance_frequency']=='Quartely')?'selected':'';?>>Quartely</option>
							<option <?= ($equipment['maintenance_frequency']=='Monthly')?'selected':'';?>>Monthly</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						
						<label for="" class="text-required">Attachments: <span class="text-danger">*</span></label>
						<input type="file" class="form-control" name="file" multiple>
						<label class="text-danger text-required mt-2">Maximum of 2MB</label>
					</div>
				</div>
			</div>
			<div><br></div>
			<div class="btn-group-buttons pull-right">
				<div class="mb-3 float-end">
					<button type="submit" class="btn btn-dark btn-primary px-5">Save</button>
					<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
				</div>
				<br>
			</div>
		</form>
	</div>
</div>
</div>
<br>

<script>
	$(document).ready(function(){
		$("#edit_equipment").off('submit').on('submit',function(e){
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

		$('#datepicker').datepicker({
			format: 'yy-mm-d',
			timepicker: false,
		});


		$(".btn-cancel").off('click').on('click',function(){
			history.back();
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

		if($("select[name=category]").val() == 'Mechanical'){
			$("select[name=type]").append('<option value="Air-conditioning" <?= ($equipment['category']=='Air-conditioning')?'selected':''; ?>>Air-conditioning</option><option value="Elevator" <?= ($equipment['category']=='Elevator')?'selected':''; ?>>Elevator</option><option value="Fire Detection & Alarm System" <?= ($equipment['category']=='Fire Detection & Alarm System')?'selected':''; ?>>Fire Detection & Alarm System</option><option value="Pumps" <?= ($equipment['category']=='Pumps')?'selected':''; ?>>Pumps</option><option value="Generator" <?= ($equipment['category']=='Generator')?'selected':''; ?>>Generator</option><option value="Building Management System" <?= ($equipment['category']=='Building Management System')?'selected':''; ?>>Building Management System</option><option value="CCTV" <?= ($equipment['category']=='CCTV')?'selected':''; ?>>CCTV</option><option value="Pressurization Blower/Fan" <?= ($equipment['category']=='Pressurization Blower/Fan')?'selected':''; ?>>Pressurization Blower/Fan</option><option value="Exhaust Fan" <?= ($equipment['category']=='Exhaust Fan')?'selected':''; ?>>Exhaust Fan</option><option value="Gondola" <?= ($equipment['category']=='Gondola')?'selected':''; ?>>Gondola</option><option value="Others" <?= ($equipment['category']=='Others')?'selected':''; ?>>Others</option>');
		}
		else if($("select[name=category]").val() == 'Electrical'){
			$("select[name=type]").append('<option value="Transformers" <?= ($equipment['category']=='Transformers')?'selected':''; ?>>Transformers</option><option value="UPS" <?= ($equipment['category']=='UPS')?'selected':''; ?>>UPS</option><option value="Automatic Transfer Switch" <?= ($equipment['category']=='Automatic Transfer Switch')?'selected':''; ?>>Automatic Transfer Switch</option><option value="Control Gear" <?= ($equipment['category']=='Control Gear')?'selected':''; ?>>Control Gear</option><option value="Switch Gear" <?= ($equipment['category']=='Switch Gear')?'selected':''; ?>>Switch Gear</option><option value="Capacitor" <?= ($equipment['category']=='Capacitor')?'selected':''; ?>>Capacitor</option><option value="Breakers/Panel Boards" <?= ($equipment['category']=='Breakers/Panel Boards')?'selected':''; ?>>Breakers/Panel Boards</option><option value="Meters" <?= ($equipment['category']=='Meters')?'selected':''; ?>>Meters</option><option value="Others" <?= ($equipment['category']=='Others')?'selected':''; ?>>Others</option>');
		}
		else if($("select[name=category]").val() == 'Fire Protection'){
		$("select[name=type]").append('<option value="Sprinklers" <?= ($equipment['category']=='Sprinklers')?'selected':''; ?>>Sprinklers</option><option value="Smoke Detectors" <?= ($equipment['category']=='Smoke Detectors')?'selected':''; ?>>Smoke Detectors</option><option value="Manual Pull Stations" <?= ($equipment['category']=='Manual Pull Stations')?'selected':''; ?>>Manual Pull Stations</option><option value="Fire Alarm" <?= ($equipment['category']=='Fire Alarm')?'selected':''; ?>>Fire Alarm</option><option value="FDAS Panel" <?= ($equipment['category']=='FDAS Panel')?'selected':''; ?>>FDAS Panel</option><option value="Others" <?= ($equipment['category']=='Others')?'selected':''; ?>>Others</option>');
		}
		else{
		$("select[name=type]").append('<option value="N/A">N/A</option>');
		}

		$("select[name=category]").on('change', function() {
			$("select[name=type").find('option').remove();
			if($("select[name=category]").val() == 'Mechanical'){
				$("select[name=type]").append('<option value="Air-conditioning" <?= ($equipment['category']=='Air-conditioning')?'selected':''; ?>>Air-conditioning</option><option value="Elevator" <?= ($equipment['category']=='Elevator')?'selected':''; ?>>Elevator</option><option value="Fire Detection & Alarm System" <?= ($equipment['category']=='Fire Detection & Alarm System')?'selected':''; ?>>Fire Detection & Alarm System</option><option value="Pumps" <?= ($equipment['category']=='Pumps')?'selected':''; ?>>Pumps</option><option value="Generator" <?= ($equipment['category']=='Generator')?'selected':''; ?>>Generator</option><option value="Building Management System" <?= ($equipment['category']=='Building Management System')?'selected':''; ?>>Building Management System</option><option value="CCTV" <?= ($equipment['category']=='CCTV')?'selected':''; ?>>CCTV</option><option value="Pressurization Blower/Fan" <?= ($equipment['category']=='Pressurization Blower/Fan')?'selected':''; ?>>Pressurization Blower/Fan</option><option value="Exhaust Fan" <?= ($equipment['category']=='Exhaust Fan')?'selected':''; ?>>Exhaust Fan</option><option value="Gondola" <?= ($equipment['category']=='Gondola')?'selected':''; ?>>Gondola</option><option value="Others" <?= ($equipment['category']=='Others')?'selected':''; ?>>Others</option>');
			}
			else if($("select[name=category]").val() == 'Electrical'){
				$("select[name=type]").append('<option value="Transformers" <?= ($equipment['category']=='Transformers')?'selected':''; ?>>Transformers</option><option value="UPS" <?= ($equipment['category']=='UPS')?'selected':''; ?>>UPS</option><option value="Automatic Transfer Switch" <?= ($equipment['category']=='Automatic Transfer Switch')?'selected':''; ?>>Automatic Transfer Switch</option><option value="Control Gear" <?= ($equipment['category']=='Control Gear')?'selected':''; ?>>Control Gear</option><option value="Switch Gear" <?= ($equipment['category']=='Switch Gear')?'selected':''; ?>>Switch Gear</option><option value="Capacitor" <?= ($equipment['category']=='Capacitor')?'selected':''; ?>>Capacitor</option><option value="Breakers/Panel Boards" <?= ($equipment['category']=='Breakers/Panel Boards')?'selected':''; ?>>Breakers/Panel Boards</option><option value="Meters" <?= ($equipment['category']=='Meters')?'selected':''; ?>>Meters</option><option value="Others" <?= ($equipment['category']=='Others')?'selected':''; ?>>Others</option>');
			}
			else if($("select[name=category]").val() == 'Fire Protection'){
			$("select[name=type]").append('<option value="Sprinklers" <?= ($equipment['category']=='Sprinklers')?'selected':''; ?>>Sprinklers</option><option value="Smoke Detectors" <?= ($equipment['category']=='Smoke Detectors')?'selected':''; ?>>Smoke Detectors</option><option value="Manual Pull Stations" <?= ($equipment['category']=='Manual Pull Stations')?'selected':''; ?>>Manual Pull Stations</option><option value="Fire Alarm" <?= ($equipment['category']=='Fire Alarm')?'selected':''; ?>>Fire Alarm</option><option value="FDAS Panel" <?= ($equipment['category']=='FDAS Panel')?'selected':''; ?>>FDAS Panel</option><option value="Others" <?= ($equipment['category']=='Others')?'selected':''; ?>>Others</option>');
			}
			else{
			$("select[name=type]").append('<option value="N/A">N/A</option>');
			}
		});
	});
</script>