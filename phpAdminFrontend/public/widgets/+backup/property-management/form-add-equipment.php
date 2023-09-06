<?php
$equipment = null;
if (count($args)) {
	$equipment_result = $ots->execute('equipment', 'get-equipment', ['equipmentid' => $args[0]]);
	$equipment = json_decode($equipment_result, true);
}
$equipment_types_result =  $ots->execute('equipment', 'get-equipment-types');
$equipment_types = json_decode($equipment_types_result);

$data = [
	'view' => 'service_providers_view'
];
$providers = $ots->execute('property-management', 'get-records', $data);
$providers = json_decode($providers);

$missing = null;
$next_url = WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders";

if ($providers == null) {
	$missing = 1;
	$title = 'Data are mising';
	$next_url = WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders";
	$html = "Service Provider are missing";
} else {
	if ($providers == null) {
		$missing = 1;
		$title = 'Data are mising';
		$next_url = WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders";
		$html = "Service Provider are missing<br><a href=\'" . WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders\' class=\'button\'>Add Service Provider</a>";
	}
}

$data = [
	'view' => 'building_profile',
];
$building_profile = $ots->execute('admin', 'get-record', $data);
$building_profile = json_decode($building_profile);
?>

<!-- <div class="page-title"><?php echo count($args) ? 'Edit' : 'Add'; ?> Form</div> -->
<div class="main-container">

	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<?php
		if (!$providers) {
		?>
			<script>
				Swal.fire({
					title: 'Service Provider data is missing',
					isDismissed: false,
					confirmButtonText: 'Yes',
					html: 'Do want to add now???',
					allowOutsideClick: false
				}).then((result) => {
					/* Read more about isConfirmed, isDenied below */
					if (result.isConfirmed) {
						window.location.href = "<?= WEB_ROOT ?>/property-management/form-add-serviceprovider?";
					}
				})
			</script>
		<?php
		}
		?>
		<div class=" rounded-sm <?= ($providers) ? '' : 'opacity-25' ?>">
			<form method="post" action="<?= WEB_ROOT; ?>/property-management/save-record?display=plain" id="add_equipment"  disabled enctype="multipart/form-data">
				<input type="hidden" name='redirect' id='redirect' value="<?= WEB_ROOT ?>/property-management/view-equipment/<?= $args[0] ?>/View">
				<input type="hidden" name='table' id='id' value='equipments'>
				<input type="hidden" name='view_table' id='id' value='view_equipments'>
				<label class="required-field mt-4">* Please Fill in the required fields</label>
				<div class="row forms">
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<input type="text" placeholder="Type here" class="form-control" name="equipment_name" value="<?php echo $equipment ? $equipment['equipment_name'] : ''; ?>" required <?= ($providers) ? '' : 'disabled' ?>>
							<label for="" class="text-required">Name <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box ">
							<select class="form-control form-select category" name="category" required <?= ($providers) ? '' : 'disabled' ?>>
								<option value="" selected disabled>Select from list</option>
								<option value="Mechanical">Mechanical</option>
								<option value="Electrical">Electrical</option>
								<option value="Fire Protection">Fire Protection</option>
								<option value="Plumbing & Sanitary">Plumbing & Sanitary</option>
								<option value="Civil">Civil</option>
								<option value="Structural">Structural</option>
							</select>
							<label for="" class="text-required">Category <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<select class="form-control form-select type" name="type" required <?= ($providers) ? '' : 'disabled' ?>>
								<option value="" selected disabled>Select from Category</option>
							</select>
							<label for="" class="text-required">Type <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<!-- <input type="text" placeholder="Type here" class="form-control" name="location"> -->
							<select name="location" class='form-control' id='location' required>
								<?php
								//belowground
								for ($i = 1; $i <= $building_profile->below_ground; $i++) {
									echo "<option value='Basement {$i}'>Basement " . $i . "</option>";
								}
	
								//aboveground
								for ($i = 1; $i <= $building_profile->ground_above; $i++) {
									$j = $i % 10;
									$k = $i % 100;
									if ($j == 1 && $k != 11) {
										echo "<option value='{$i}st floor'>" . $i . "st floor</option>";
									} else if ($j == 2 && $k != 12) {
										echo "<option value='{$i}nd floor'>" . $i . "nd floor</option>";
									} else if ($j == 3 && $k != 13) {
										echo "<option value='{$i}rd floor'>" . $i . "rd floor</option>";
									} else {
										echo "<option value='{$i}th floor'>" . $i . "th floor</option>";
									}
								}
								?>
							</select>
							<label for="" class="text-required">Location <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
	
							<input type="text" placeholder="Type here" class="form-control" name="area_served" value="<?php echo $equipment ? $equipment['equipment_name'] : ''; ?>" required <?= ($providers) ? '' : 'disabled' ?>>
							<label for="" class="text-required">Area Served <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<input type="text" placeholder="Type here" class="form-control" name="brand" value="" required <?= ($providers) ? '' : 'disabled' ?>>
							<label for="" class="text-required">Brand <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<input type="text" placeholder="Type here" class="form-control" name="model" value="" required <?= ($providers) ? '' : 'disabled' ?>>
							<label for="" class="text-required">Model <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<input type="text" placeholder="Type here" class="form-control" name="serial_number" value="" required <?= ($providers) ? '' : 'disabled' ?>>
							<label for="" class="text-required">Serial # <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
							<label for="" class="text-required">Capacity <span class="text-danger">*</span></label>
							<input type="text" placeholder="Type here" class="form-control" name="capacity" value="" required <?= ($providers) ? '' : 'disabled' ?>>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
	
							<input type="date" name='date_installed' id='datepicker1' class='form-control' value='<?= $contract->days_to_notify ?>' required <?= ($providers) ? '' : 'disabled' ?>>
							<label for="" class="text-required">Date Installed <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
	
							<input type="text" placeholder="Type here" class="form-control" name="asset_number" value="">
							<label for="" class="text-required">Asset #</label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
	
							<select class="form-control form-select" name="critical_equipment">
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
							<label for="" class="text-required">Critical Equipment <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
	
							<input name="service_provider" type="hidden" value="<?= $record ? ($record['unit_id']) ?? '0' : '0'; ?>" required>
							<input id="service_provider_id" type="text" placeholder="Type here" class="form-control" value="<?= $record ? $record['unit_name'] : ''; ?>" placeholder="Search Provider" required>
							<label for="" class="text-required">Service Provider <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
	
							<select class="form-control form-select" name="maintenance_frequency">
								<option>Annual</option>
								<option>Semi-Annual</option>
								<option>Quartely</option>
								<option>Monthly</option>
							</select>
							<label for="" class="text-required">Maintenance Frequency <span class="text-danger">*</span></label>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-3">
						<div class="form-group input-box">
	
							
							<input type="file" name="file[]" id="file" class='form-control' multiple>
						</div>
						<!-- <label class="text-danger text-required mt-2">Maximum of 2MB</label> -->
					</div>
				</div>
				<div><br></div>
				<div class="btn-group-buttons pull-right">
					<div class="mb-3 d-flex gap-3 justify-content-end">
						<button type="submit" class="main-btn">Save</button>
						<button type="button" class="main-cancel btn-cancel">Cancel</button>
					</div>
				</div>
				<br>
				<input type="hidden" value="<?php echo $args[0] ?? ''; ?>" name="id">
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		// $("input[name=date_installed]").datetimepicker({
		// 	'format':'Y-m-d',
		// 	'timepicker':false,
		// 	'minDate':"1"
		// });
		// $('input[name=date_installed]').change(function(){
		// 	console.log($(this).val());
		// });

		$("#add_equipment").off('submit').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				dataType: 'JSON',
				data: new FormData($(this)[0]),
				contentType: false,
				processData: false,
				beforeSend: function() {},
				success: function(data) {
					if (data.success == 1) {
						redirect = "<?= WEB_ROOT ?>/property-management/view-equipment/" + data.id + "/View"
						show_success_modal(redirect);
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});
		});

		$("#form-equipment").off('submit').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function() {},
				success: function(data) {
					if (data.success == 1) {
						$(".notification-success-message").html(data.description);
						$(".notification-success").fadeIn('slow');
						<?php if (!$equipment) : ?>
							$("#form-equipment")[0].reset();
						<?php endif; ?>
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});
		});

		$(".btn-cancel").off('click').on('click', function() {
			Swal.fire({
				text: "This information will be deleted once you exit, are you sure you want to exit?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes',
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					window.location.href = '<?php echo WEB_ROOT; ?>/property-management/equipment?submenuid=equipment';
				}
			})
			// window.location.href = '<?php echo WEB_ROOT; ?>/property-management/pm';
		});

		$("input[id=service_provider_id]").autocomplete({
			autoSelect: true,
			autoFocus: true,
			search: function(event, ui) {
				$('.spinner').show();
			},
			response: function(event, ui) {
				$('.spinner').hide();
			},
			source: function(request, response) {
				$.ajax({
					url: '<?= WEB_ROOT; ?>/property-management/get-records?display=plain',
					dataType: "json",
					type: 'post',
					data: {
						view: 'service_providers_view',
						auto_complete: true,
						term: request.term,
						filter: ''
					},
					success: function(data) {
						response(data);
					}
				});
			},
			minLength: 2,
			select: function(event, ui) {
				$(event.target).prev().val(ui.item.value);
				$(event.target).val(ui.item.label);
				return false;
			},
			change: function(event, ui) {
				if (ui.item == null) {
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
		if ($("select[name=category]").val() == 'Mechanical') {
			$("select[name=type]").append('<option value="Air-conditioning">Air-conditioning</option><option value="Elevator">Elevator</option><option value="Fire Detection & Alarm System">Fire Detection & Alarm System</option><option value="Pumps">Pumps</option><option value="Generator">Generator</option><option value="Building Management System">Building Management System</option><option value="CCTV">CCTV</option><option value="Pressurization Blower/Fan">Pressurization Blower/Fan</option><option value="Exhaust Fan">Exhaust Fan</option><option value="Gondola">Gondola</option><option value="Others">Others</option>');
		} else if ($("select[name=category]").val() == 'Electrical') {
			$("select[name=type]").append('<option value="Transformers">Transformers</option><option value="UPS">UPS</option><option value="Automatic Transfer Switch">Automatic Transfer Switch</option><option value="Control Gear">Control Gear</option><option value="Switch Gear">Switch Gear</option><option value="Capacitor">Capacitor</option><option value="Breakers/Panel Boards">Breakers/Panel Boards</option><option value="Meters">Meters</option><option value="Others">Others</option>');
		} else if ($("select[name=category]").val() == 'Fire Protection') {
			$("select[name=type]").append('<option value="Sprinklers">Sprinklers</option><option value="Smoke Detectors">Smoke Detectors</option><option value="Manual Pull Stations">Manual Pull Stations</option><option value="Fire Alarm">Fire Alarm</option><option value="FDAS Panel">FDAS Panel</option><option value="Others">Others</option>');
		} else {
			$("select[name=type]").append('<option value="N/A">N/A</option>');
		}
	});
</script>