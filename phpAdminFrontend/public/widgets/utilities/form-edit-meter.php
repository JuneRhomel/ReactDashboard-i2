<?php
	$data = [
		'id'=>$args[0],
        'view'=>'view_meters'
	];

	$meter = $ots->execute('utilities','get-record',$data);
	$meter = json_decode($meter);
    // p_r($meter);
	
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
		<form method="post" action="<?=WEB_ROOT;?>/utilities/save-record?display=plain" id="edit-meter" class="bg-white" disabled>
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/utilities/view-meters/' >
			<input type="hidden" name='error_redirect'  id='redirect' value= '<?= WEB_ROOT?>/utilities/form-add-meter' >
			<input type="hidden" name='table'  id='id' value= 'meters'>
			<input type="hidden" name='view_table'  id='id' value= 'view_meters'>
            <input type="hidden" name='id'  id='id' value= '<?php echo $args[0]?>'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>
			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Meter Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="meter_name" required value="<?php echo $meter ? $meter->meter_name : '';?>" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<label for="" class="text-required">Utility Type <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="utility_type"  required >
							<option value="Electrical" <?= ($meter->utility_type== 'Electrical')? 'selected':'' ?>>Electrical</option>
							<option value="Water" <?= ($meter->utility_type== 'Water')? 'selected':'' ?>>Water</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<label for="" class="text-required">Unit of Measurement <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="unit_of_measurement" required>
							<option value="Kilowatt-hour (KwHR)" <?= ($meter->unit_of_measurement== 'Kilowatt-hour (KwHR)')? 'selected':'' ?>>Kilowatt-hour (KwHR)</option>
							<option value="Cubic Meter (CuM)" <?= ($meter->unit_of_measurement== 'Cubic Meter (CuM)')? 'selected':'' ?>>Cubic Meter (CuM)</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<label for="" class="text-required">Meter Type <span class="text-danger">*</span></label>
						<select class="form-control form-select" name="meter_type" required>
							<option value="Mother Meter" <?= ($meter->unit_of_measurement== 'Mother Meter')? 'selected':'' ?>>Mother Meter</option>
							<option value="Submeter" <?= ($meter->unit_of_measurement== 'Submeter')? 'selected':'' ?>>Submeter</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
                    <div class="form-group">
						<label for="" class="text-required">Serial Number <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="serial_number" required value="<?php echo $meter ? $meter->serial_number : '';?>" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Meter Location <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="meter_location" required value="<?php echo $meter ? $meter->meter_location : '';?>" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Unit <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="unit" required value="<?= $meter->unit ?>" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Meter Use <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="meter_use" required value="<?= $meter->meter_use ?>" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">	
						<label for="" class="text-required">Tenant <span class="text-danger">*</span></label>
						<input name="tenant" type="hidden" value="<?=$meter->tenant ?? '0'?>" required>
						<input id="tenant" type="text"  class="form-control" value="<?= $meter->owner_name ?>" placeholder="Search Provider" required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Tenant Type <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="tenant_type" required value="<?= $meter->tenant_type ?>" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Below Threshold</label>
						<input type="number" class="form-control" name="below_threshold" value="<?= $meter->below_threshold ?>" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Max Threshold</label>
						<input type="number" class="form-control" name="max_threshold" value="<?= $meter->max_threshold?>" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Max Digit</label>
						<input type="number" class="form-control" name="max_digit" value="<?= $meter->max_digit ?>" required <?=($tenants)?'' :'disabled'?>>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Multiplier</label>
						<input type="number" class="form-control" name="multiplier" value="<?= $meter->multiplier ?>" required <?=($tenants)?'' :'disabled'?>>
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
		$("#edit-meter").on('submit',function(e){
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

		$(".btn-cancel").off('click').on('click',function(){
			history.back();
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
						view: 'view_tenant',
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