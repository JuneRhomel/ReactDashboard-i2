<?php
	$equipment = null;
	if(count($args))
	{
		$equipment_result = $ots->execute('equipment','get-equipment',['equipmentid'=>$args[0]]);
		$equipment = json_decode($equipment_result,true);
	}
	$equipment_types_result =  $ots->execute('equipment','get-equipment-types');
	$equipment_types = json_decode($equipment_types_result);
	
	$tenants = get_tenants($ots);

if(!$tenants){
	?>
	<script>
		Swal.fire({
			title: 'Service Provider data is missing',
			isDismissed:false,
			confirmButtonText: 'Yes',
			html:'Do want to add now???',
			allowOutsideClick: false
		}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.isConfirmed) {
			window.location.href = "<?=WEB_ROOT?>/property-management/form-add-serviceprovider?";
		} 
		})
	</script>
	<?php
}

?>

<!-- <div class="page-title"><?php echo count($args) ? 'Edit' : 'Add';?> Form</div> -->
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white rounded-sm <?=($tenants)?'' :'opacity-25'?>">
		<form method="post" action="<?=WEB_ROOT;?>/utilities/save-record?display=plain" id="add-meter" class="bg-white" disabled>
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/utilities/view-meters/' >
			<input type="hidden" name='error_redirect'  id='redirect' value= '<?= WEB_ROOT?>/utilities/form-add-meter' >
			<input type="hidden" name='table'  id='id' value= 'meters'>
			<input type="hidden" name='view_table'  id='id' value= 'view_meters'>
			<!-- <input type="hidden" name='single_data_only' id='single_data_only' value='false'> -->
			<label class="required-field mt-4">* Please Fill in the required fields</label>
			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Meter Name/ID <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="meter_name" required value="<?php echo $equipment ? $equipment['equipment_name'] : '';?>" <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<label for="" class="text-required">Utility Type <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="utility_type" required>
							<option value="Electrical">Electrical</option>
							<option value="Water">Water</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<label for="" class="text-required">Unit of Measurement <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="unit_of_measurement" required>
							<option value="Kilowatt-hour (KwHR)">Kilowatt-hour (KwHR)</option>
							<option value="Cubic Meter (CuM)">Cubic Meter (CuM)</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<label for="" class="text-required">Meter Type <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="meter_type" required>
							<option value="Mother Meter">Mother Meter</option>
							<option value="Submeter">Submeter</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
                    <div class="form-group">
						<label for="" class="text-required">Floor <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="meter_location" value="" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>
				
				<div class="col-12 col-sm-4 my-4">
                    <div class="form-group">
						<label for="" class="text-required">Unit <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="unit" value="" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
                    <div class="form-group">
					<label for="" class="text-required">Use <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="meter_use" required>
							<option value='Residential'>Residential</option>
							<option value='Commercial'>Commercial</option>
							<option value='Parking'>Parking</option>
						</select>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Tenant <span class="text-danger">*</span></label>
						<input name="tenant" type="hidden" value="<?=$record ? ($record['unit_id']) ?? '0' : '0';?>" >
						<input id="tenant" type="text" class="form-control" value="<?=$record ? $record['unit_name'] : '';?>" placeholder="Search Provider" required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Tenant Type <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="tenant_type" required>
							<option value='Residential'>Residential</option>
							<option value='Commercial'>Commercial</option>
							<option value='Office'>Office</option>
						</select>
					</div>
				</div>

				

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Below Threshold</label>
						<input type="number" class="form-control" name="below_threshold" value="" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Above Threshold</label>
						<input type="number" class="form-control" name="below_threshold" value="" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Min Digit</label>
						<input type="number" class="form-control" name="max_digit" value="" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Max Digit</label>
						<input type="number" class="form-control" name="max_digit" value="" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

			</div>
			<div><br></div>
			<div class="btn-group-buttons pull-right">
				<div class="mb-3 float-end">
					<button type="submit" class="btn btn-dark btn-primary px-5">Save</button>
					<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
		
	$(document).ready(function(){
		$("#add-meter").on('submit',function(e){
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
						var redirect = "<?= WEB_ROOT?>/utilities/view-meters/"+data.id;
						show_success_modal(redirect);
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
					window.location.href = '<?php echo WEB_ROOT;?>/utilities/meter-list?submenuid=meter_list';
				}
			})
			// window.location.href = '<?php echo WEB_ROOT;?>/property-management/pm';
		});

		$("input[id=tenant]").autocomplete({
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
						view: 'tenant',
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