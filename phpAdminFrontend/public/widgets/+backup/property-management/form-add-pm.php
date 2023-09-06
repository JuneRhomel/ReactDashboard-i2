<?php
$equipment_types_result =  $ots->execute('equipment', 'get-equipment-types');
$equipment_types = json_decode($equipment_types_result);

$providers = get_providers($ots); //from library/shared.php
// p_r($providers);

$equipments = get_equipments($ots); //from library/shared.php


$missing = null;
$next_url = WEB_ROOT . "/property-management/equipment?submenuid=equipment";

// p_r($equipments);
if ($providers == null && $equipments == null) {
	$missing = 1;
	$title = 'Data are mising';
	$next_url = WEB_ROOT . "/property-management/equipment?submenuid=serviceproviders";
	$html = "Equipments and Service Provider are missing";
} else {
	if ($providers == null) {
		$missing = 1;
		$title = 'Data are mising';
		$next_url = WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders";
		$html = "Service Provider are missing<br><a href=\'" . WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders\' class=\'button\'>Add Service Provider</a>";
	}
	if ($equipments == null) {
		$missing = 1;
		$title = 'Data are mising';
		$next_url = WEB_ROOT . "/property-management/equipment?submenuid=equipment";
		$html = "Equipments are missing<br><a href=\'" . WEB_ROOT . "/property-management/equipment?submenuid=serviceproviders\' class=\'button\'>Add Equipments</a>";
	}
}
?>
<div class="main-container">
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<?php
		if ($missing) {
		?>
			<script>
				Swal.fire({
					title: "<?= $title ?>",
					isDismissed: false,
					confirmButtonText: 'Yes',
					html: '<?= $html ?>',
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
	
		$data = [
			'view' => 'building_profile',
		];
		$building_profile = $ots->execute('admin', 'get-record', $data);
		$building_profile = json_decode($building_profile);
		?>
	
		<div class="bg-white rounded-sm <?= ($providers) ? '' : 'opacity-25' ?>">
			<form method="post" action="<?= WEB_ROOT; ?>/property-management/save-pm?display=plain" class="bg-white" disabled id='pm-form-save' enctype="multipart/form-data">
				<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/property-management/pm'>
				<input type="hidden" name='table' id='id' value='pm'>
				<input type="hidden" name='stage_table' id='id' value='stages'>
				<input type="hidden" name='view_table' id='id' value='view_pm'>
				<input type="hidden" name='update_table' id='id' value='pm_updates'>
				<label class="required-field mt-4">* Please Fill in the required fields</label>
				<div class="row forms">
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group input-box">
							<label for="" class="text-required">Equipment <span class="text-danger">*</span></label>
							<input name="equipment_id" type="hidden" value="<?= $record ? ($record['location_id']) ?? '0' : '0'; ?>" required>
							<input id="equipment_id" type="text" class="form-control" value="<?= $record ? $record['location_name'] : ''; ?>" placeholder="Search Equipment" required>
						</div>
					</div>
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group input-box">
							<label for="" class="text-required">Location <span class="text-danger">*</span></label>
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
							<!-- <input type="text" name='location' class="form-control" required> -->
						</div>
					</div>
				</div>
				<div class="row forms">
					<div class="col-12 col-sm-4  mb-4">
						<div class="form-group input-box">
	
							<label for="" class="text-required">Preventive Maintenance Start Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name='pm_start_date' min="<?= date('Y-m-d') ?>">
	
						</div>
					</div>
					<div class="col-12 col-sm-4  mb-4">
						<div class="form-group input-box">
	
							<label for="" class="text-required">Time <span class="text-danger">*</span></label>
							<input type="time" class="form-control" name='pm_start_time' min='<?= date('h:i') ?>'>
						</div>
					</div>
				</div>
				<div class="row forms">
					<div class="col-4 col-sm-4">
						<div class="form-group input-box">
	
							<label for="" class="text-required">Preventive Maintenance End Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" name='pm_end_date'>
						</div>
					</div>
	
					<div class="col-4 col-sm-4">
						<div class="form-group input-box">
	
							<label for="" class="text-required">Time <span class="text-danger">*</span></label>
							<input type="time" class="form-control" name='pm_end_time'>
						</div>
	
					</div>
					<div class="col-4 col-sm-4">
						<div class="form-group input-box">
	
							<label for="" class="text-required">Frequency <span class="text-danger">*</span></label>
							<select class="form-control form-select" name="frequency">
								<option value='annual'>Annual</option>
								<option value='semi-annual'>Semi-Annual</option>
								<option value='quarterly'>Quarterly</option>
								<option value='monthy'>Monthly</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row forms my-3">
					<div class="col-4 d-flex align-items-center gap-4">
	
						<div>
							<input type="checkbox" name='repeat_notif' id='repeat'>
							<label for="repeat" class="text-required f-16">Repeat</label>
						</div>
	
	
						<label for="notify_days_before_next_schedule " class='f-14 text-required'>Notify</label>
						<div class=" input-box">
							<input type="number" size='2' value="1" name='notify_days_before_next_schedule' class='px-2 form-control' style='width:100px;' required>
							<label for="">Days</label>
						</div>
	
						<label for="" class="text-required f-14"> Days before the next schedule <span class="text-danger">*</span></label>
					</div>
				</div>
				<div class="row forms">
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group input-box">
							<label for="" class="text-required">Priority Level <span class="text-danger">*</span></label>
							<select name="priority_level" id="priority_level" class='form-select'>
								<option value="1">Priority 1</option>
								<option value="2">Priority 2</option>
								<option value="3">Priority 3</option>
								<option value="4">Priority 4</option>
								<option value="5">Priority 5</option>
							</select>
							<!-- <label class="text-danger text-required mt-2 p1-prio active-label">Resolution Time 24 Hours</label>
							<label class="text-danger text-required mt-2 p2-prio">Resolution Time 48 hours</label>
							<label class="text-danger text-required mt-2 p3-prio">Resolution Time 72 hours</label>
							<label class="text-danger text-required mt-2 p4-prio">Resolution Time 96 hours</label>
							<label class="text-danger text-required mt-2 p5-prio">Resolution Time 120 hours</label> -->
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group input-box">
							<label for="" class="text-required">Critical Equipment <span class="text-danger">*</span></label>
							<select name="critical" id="critical" class='form-select'>
								<option value="No">No</option>
								<option value="Yes">Yes</option>
							</select>
						</div>
					</div>
	
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group input-box">
							<input type="file" name="file[]" id="file" class='form-control' multiple>
							<!-- <label class="text-danger text-required mt-2">Maximum of 2MB</label> -->
						</div>
					</div>
				</div>
	
	
				<div class="row">
					<div class="col">
						<h5 class='py-2 heading-text'>Vendor Details</h5>
					</div>
				</div>
				<div class="row forms">
					<div class="col-12 col-sm-4 my-4 input-box">
						<div class="input-box">
							<input name="service_provider_id" type="hidden" value="<?= $record ? ($record['unit_id']) ?? '0' : '0'; ?>" required>
							<input id="service_provider_id" type="text" class="form-control" value="<?= $record ? $record['unit_name'] : ''; ?>" placeholder="Search Provider" required>
							<label for="" class="text-required">Service Provider <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 my-4 ">
						<div class="input-box">
							<input type="text" placeholder="Type Here" class="form-control" id="person_in_charge" value="" required <?= ($providers) ? '' : 'disabled' ?>>
							<label for="" class="text-required">Person In-charge <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 my-4 input-box">
						<div class="input-box">
							<input type="text" placeholder="Type Here" class="form-control" id="email" value="" required <?= ($providers) ? '' : 'disabled' ?>>
							<label for="" class="text-required">Email <span class="text-danger">*</span></label>
						</div>
					</div>
				</div>
				<div class="row forms">
					<div class="col-5 col-sm-4 my-4 input-box">
						<div class="input-box">
							<input type="text" placeholder="Type Here" class="form-control" id="contact_number" value="" required <?= ($providers) ? '' : 'disabled' ?>>
							<label for="" class="text-required">Contact # <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-5 col-sm-4 my-4 ">
						<div class="d-flex gap-2 align-items-center">
							<p class="f-14">Notify</p>
							<div class="input-box ">
								<input type="number" size='2' value="1" name='notify_vendor_before_next_schedule' class='px-2 form-control' style='width:100px;' style="padding: 5px">
								<label for="notify_days_before_next_schedule" class='text-required'>Days</label>
							</div>
							<p for="" class="text-required f-14"> Days before the next schedule </p>
						</div>
					</div>
				</div>
				<div class="row forms my-3">
				</div>
				<div class="btn-group-buttons pull-right">
					<div class="mb-3 d-flex gap-3 justify-content-end" style="padding: 5px;">
						<button type="submit" class="main-btn btn-save" disabled>Save</button>
						<button type="button" class="main-btn btn-preview">Preview</button>
						<button type="button" class="main-cancel btn-cancel ">Cancel</button>
					</div>
					<br>
			</form>
		</div>
	</div>
	<div class="modal" tabindex="-1" role="dialog" id='pm-preview'>
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Pm Preview</h5>
					<button type="button" class="close btn-close" data-dismiss="modal" onclick='$("#pm-preview").modal("hide")' label="Close">
						<span hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
	
				</div>
				<div class="modal-footer">
	
				</div>
			</div>
		</div>
	
	</div>

</div>

<script>
	// $(document).ready(function() {

	//     $('#equipment_id').on('change', function() {
	//         var selectedEquipment = $(this).val(); 

	//         $.ajax({
	//             url: '<?= WEB_ROOT; ?>/property-management/get-records?display=plain', 
	//             method: 'POST', 
	//             dataType: 'json', 
	//             data: {equipment: selectedEquipment}, 
	//             success: function(data) {
	//                 if (data.success) {
	//                     var locationMappings = data.locationMappings;
	//                     $('#location').val(locationMappings[selectedEquipment]);
	//                 }
	//             },
	//             error: function() {
	//                 console.log('Error occurred during AJAX call');
	//             }
	//         });
	//     });
	// });

	$(document).ready(function() {

		var start_date;
		$('input[name=pm_start_date],input[name=pm_start_time]').change(function() {
			$('input[name=pm_end_date]').prop('min', $('input[name=pm_start_date]').val());
			start_date = $('input[name=pm_start_date]').val() + " " + $('input[name=pm_start_time]').val();
			start_date = new Date(start_date).getTime();
		});

		$('input[name=pm_end_time]').change(function() {
			end_date = $('input[name=pm_end_date]').val() + " " + $('input[name=pm_end_time]').val();
			end_date = new Date(end_date).getTime();

			if (end_date < start_date) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'End date must be not be earlier than start date',

				})
				$('input[name=pm_end_time]').val('');
				$('input[name=pm_end_time]').focus();
			}
		});

		$("#pm-form-save").on('submit', function(e) {
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
						show_success_modal($('input[name=redirect]').val());
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
				text: "This ticket will be deleted once you exit, are you sure you want to exit?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes',
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					window.location.href = '<?php echo WEB_ROOT; ?>/property-management/pm?submenuid=pm';
				}
			})
			// window.location.href = '<?php echo WEB_ROOT; ?>/property-management/pm';
		});
		$("input[id=equipment_id]").autocomplete({
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
						view: 'view_equipments',
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
				// console.log(ui);
				$(event.target).prev().val(ui.item.value);
				$(event.target).val(ui.item.label);
				$('input[name="location"]').val(ui.item.location);
				return false;
			},
			change: function(event, ui) {
				if (ui.item == null) {
					$(event.target).prev('input').val(0);
				}
			}
		});

		$(".p2-prio").hide();
		$(".p3-prio").hide();
		$(".p4-prio").hide();
		$(".p5-prio").hide();

		$('select[name=priority_level]').on('click', function(e) {
			if ($(this).val() == '1') {
				$(".p1-prio").show();
				$(".p2-prio").hide();
				$(".p3-prio").hide();
				$(".p4-prio").hide();
				$(".p5-prio").hide();

			} else if ($(this).val() == '2') {
				$(".p2-prio").show();
				$(".p1-prio").hide();
				$(".p3-prio").hide();
				$(".p4-prio").hide();
				$(".p5-prio").hide();

			} else if ($(this).val() == '3') {
				$(".p3-prio").show();
				$(".p1-prio").hide();
				$(".p2-prio").hide();
				$(".p4-prio").hide();
				$(".p5-prio").hide();

			} else if ($(this).val() == '4') {
				$(".p4-prio").show();
				$(".p1-prio").hide();
				$(".p2-prio").hide();
				$(".p3-prio").hide();
				$(".p5-prio").hide();

			} else if ($(this).val() == '5') {
				$(".p5-prio").show();
				$(".p1-prio").hide();
				$(".p2-prio").hide();
				$(".p3-prio").hide();
				$(".p4-prio").hide();

			}
		});

		$(".btn-preview").on('click', function() {
			$.ajax({
				url: '<?= WEB_ROOT; ?>/property-management/pm-schedule-preview?display=plain',
				type: 'POST',
				data: $("#pm-form-save").serialize(),
				dataType: 'HTML',
				beforeSend: function() {},
				success: function(data) {
					$("#pm-preview").modal('show');
					$("#pm-preview .modal-body").html(data);
					$(".btn-save").prop('disabled', false);

				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {
					$(".btn-save").prop('disabled', true);

				}
			});
		});

		$(".dashboard-calendar").hide();

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
				// console.log(ui);
				$(event.target).prev().val(ui.item.value);
				$(event.target).val(ui.item.label);
				$('#person_in_charge').val(ui.item.contact_person);
				$('#email').val(ui.item.email);
				$('#contact_number').val(ui.item.contact_number);
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
		if ($("select[name=category]").val() == 1) {
			$("select[name=type").append('<option value="Air-conditioning">Air-conditioning</option><option value="Elevator">Elevator</option><option value="Fire Detection & Alarm System">Fire Detection & Alarm System</option><option value="Pumps">Pumps</option><option value="Generator">Generator</option><option value="Building Management System">Building Management System</option><option value="CCTV">CCTV</option><option value="Pressurization Blower/Fan">Pressurization Blower/Fan</option><option value="Exhaust Fan">Exhaust Fan</option><option value="Gondola">Gondola</option><option value="Others">Others</option>');
		} else if ($("select[name=category]").val() == 2) {
			$("select[name=type").append('<option value="Transformers">Transformers</option><option value="UPS">UPS</option><option value="Automatic Transfer Switch">Automatic Transfer Switch</option><option value="Control Gear">Control Gear</option><option value="Switch Gear">Switch Gear</option><option value="Capacitor">Capacitor</option><option value="Breakers/Panel Boards">Breakers/Panel Boards</option><option value="Meters">Meters</option><option value="Others">Others</option>');
		} else if ($("select[name=category]").val() == 3) {
			$("select[name=type").append('<option value="Sprinklers">Sprinklers</option><option value="Smoke Detectors">Smoke Detectors</option><option value="Manual Pull Stations">Manual Pull Stations</option><option value="Fire Alarm">Fire Alarm</option><option value="FDAS Panel">FDAS Panel</option><option value="Others">Others</option>');
		} else {
			$("select[name=type").append('<option value="N/A">N/A</option>');
		}
	});
</script>