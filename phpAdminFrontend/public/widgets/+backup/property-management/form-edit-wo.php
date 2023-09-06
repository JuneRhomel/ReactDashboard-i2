<?php
	$equipment = null;
	if(count($args))
	{
		$data = [
			'id'=>$args[0],
			'view'=>'view_wo'
		];
		$wo_result = $ots->execute('property-management','get-record',$data);
		$wo = json_decode($wo_result,true);
	}
	//_id == means not encrypted
	$data= [
		'_id'=>$wo['service_provider_id'],
		'view'=>'service_providers'
	];
	$provider = $ots->execute('property-management','get-record',$data);
	$wo_provider = json_decode($provider);

	$data= [
		'_id'=>$wo['equipment_id'],
		'view'=>'equipments'
	];
	$equipment = $ots->execute('property-management','get-record',$data);
	$wo_equipment = json_decode($equipment);


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
		'_id'=>$wo['assigned_personnel_id'],
		'view'=>'building_personnel'
	];
	$personnel = $ots->execute('property-management','get-record',$data);
	$wo_personnel = json_decode($personnel);

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

<!-- <div class="page-title"><?php echo count($args) ? 'Edit' : 'Edit';?> Form</div> -->
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white rounded-sm">
		<form method="post" action="<?php echo WEB_ROOT;?>/property-management/save-record?display=plain" class="bg-white" id="form-wo-edit">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/property-management/view-wo/<?=$args[0]?>/View' >
			<input type="hidden" name='table'  id='id' value= 'wo'>
			<input type="hidden" name='stage_table'  id='id' value= 'stages'>
			<input type="hidden" name='view_table'  id='id' value= 'view_wo'>
			<!-- <input type="hidden" name='update_table'  id='id' value= 'wo_updates'> -->
			<input type="hidden" name='service_provider_id'  id='service_provider_id' value='0'>

			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
				
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Equipment <span class="text-danger">*</span></label>
						<input name="equipment_id" type="hidden" value="<?=$wo['equipment_id'];?>" required>
						<input id="equipment_id" type="text" class="form-control" value="<?=$wo_equipment->equipment_name;?>" placeholder="Search Equipment.." required>
					</div>
				</div>
			</div>
                
				<div class="row forms">

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Work Order Type <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="wo_type" required>
							<option <?= ($wo['wo_type']=='PM')?'selected':'';?>>PM</option>
                            <option <?= ($wo['wo_type']=='CM')?'selected':'';?>>CM</option>
						</select>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
                        <label for="" class="text-required">Category <span class="text-danger">*</span></label>
                        <select class="form-control form-select" name="category_id">
							<option value="Mechanical" <?= ($wo['category_id']=='Mechanical')?'selected':'';?>>Mechanical</option>
							<option value="Electrical" <?= ($wo['category_id']=='Electrical')?'selected':'';?>>Electrical</option>
							<option value="Fire Protection" <?= ($wo['category_id']=='Fire Protection')?'selected':'';?>>Fire Protection</option>
							<option value="Plumbing Sanitary" <?= ($wo['category_id']=='Plumbing Sanitary')?'selected':'';?>>Plumbing & Sanitary</option>
							<option value="Civil" <?= ($wo['category_id']=='Civil')?'selected':'';?>>Civil</option>
							<option value="Structural" <?= ($wo['category_id']=='Structural')?'selected':'';?>>Structural</option>
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
								if($wo['location'] == "Basement {$i}"){
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
									if($wo['location'] == "{$i}st floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}st floor' $selected>".$i."st floor</option>";
								}
								else if ($j == 2 && $k != 12) {
									if($wo['location'] == "{$i}nd floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}nd floor' $selected>".$i."nd floor</option>";
								}
								else if ($j == 3 && $k != 13) {
									if($wo['location'] == "{$i}rd floor"){
										$selected = 'selected';
									}else{
										$selected = '';
									}

									echo "<option value='{$i}rd floor' $selected>".$i."rd floor</option>";
								}
								else{
									if($wo['location'] == "{$i}th floor"){
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

                <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
                        <label for="" class="text-required">Scope of Work/Issue <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="scope_of_work" value="<?= $wo['scope_of_work'];?>" required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					
                        <label for="" class="text-required">Assigned Building Personnel <span class="text-danger">*</span></label>
						<input name="assigned_personnel_id" type="hidden" value="<?=$wo['assigned_personnel_id'];?>" required>
						<input id="assigned_personnel_id" type="text" class="form-control" value="<?=$wo_personnel->employee_name;?>" placeholder="Search Building Personnel"  required>
					</div>
				</div>
				
                <!-- <div class="col-12 col-sm-4 my-4">	
					<label for="" class="text-required">Service Provider <span class="text-danger">*</span></label>
					<input name="service_provider_id" type="hidden" value="<?=$wo['service_provider_id'];?>" required>
					<input id="service_provider_id" type="text" class="form-control" value="<?=$wo_provider->company;?>" placeholder="Search Provider" autocomplete="off" required>
				</div> -->

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						
                        <label for="" class="text-required">Priority Level <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="priority_level" required>
                            <option value='1' <?=($wo['priority_level']=='P1')?'selected':'';?> >Priority 1</option>
                            <option value='2' <?=($wo['priority_level']=='P2')?'selected':'';?> >Priority 2</option>
							<option value='3' <?=($wo['priority_level']=='P3')?'selected':'';?> >Priority 3</option>
                            <option value='4' <?=($wo['priority_level']=='P4')?'selected':'';?> >Priority 4</option>
							<option value='5' <?=($wo['priority_level']=='P5')?'selected':'';?> >Priority 5</option>
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
                        <label for="" class="text-required">Breakdown <span class="text-danger">*</span></label>
                        <select class="form-control form-select" name="breakdown">
                            <option <?= ($wo['breakdown']=="Breakdown 1")?'selected':'';?>>Breakdown 1</option>
                            <option <?=  ($wo['breakdown']=="Breakdown 2")?'selected':'';?>>Breakdown 2</option>
                        </select>
                    </div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<label for="" class="text-required">Critical Equipment <span class="text-danger">*</span></label>
						<select name="critical" id="critical" class='form-select'>
							<option value="No" <?= ($cm['critical']=="No")?'selected':'';?>>No</option>
							<option value="Yes" <?= ($cm['critical']=="Yes")?'selected':'';?>>Yes</option>
						</select>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
                    
                        <label for="" class="text-required">Target Date <span class="text-danger">*</span></label>
						<input type="date" class="form-control" name='wo_start_date' value="<?= date("Y-m-d",strtotime($wo['wo_start_date']));?>"/>
                    </div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						
                        <label for="" class="text-required">Amount <span class="text-danger">*</span></label>
						<input type="number" class="form-control" name="amount" value="<?= $wo['amount'];?>" required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						
						<label for="" class="text-required">Attachments:</label>
						<input type="file" class="form-control" name="file" multiple>
					</div>
				</div>

			</div>
			<div class="btn-group-buttons pull-right">
				<div class="mb-3 float-end" style="padding: 5px;">
					<button type="submit" class="btn btn-dark btn-primary px-5 btn-save">Save</button>
					<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
				</div>
			</div>
				<input type="hidden" value="<?php echo $args[0] ?? '';?>" name="id">
			
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".btn-cancel").off('click').on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/property-management/workorder?submenuid=workorder';
		});

		$("#form-wo-edit").on('submit',function(e){
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
	});
</script>