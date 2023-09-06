<?php
$module = "meter";
$table = "meter";
$view = "vw_meter";

$id = $args[0];
if ($id != "") {
	$result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
	$record = json_decode($result);
}

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_meterutiltype']);
$list_meterutiltype = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_metertype', 'field' => 'metertype']);
$list_metertype = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'location', 'condition' => 'location_type="Floor"', 'orderby' => 'id']);
$locations = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'location', 'condition' => 'location_type<>"Building" and location_type<>"Floor" and location_type<>"Common Area"', 'orderby' => 'id']);
$units = json_decode($result);
?>
<div class="main-container">
	<div class="mt-2 mb-4"><label class="data-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> <?= $page_title ?></label> <b class="text-danger">* Required</b>&nbsp;<b class="text-warning">^ Unique</b></div>
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?= WEB_ROOT; ?>/module/save?display=plain" id="form-main">
				<div class="row forms">
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="meter_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->meter_name : '' ?>" required>
							<label>Meter Name <b class="text-danger">*</b> <b class="text-warning">^</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="utility_type" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($list_meterutiltype as $key => $val) { ?>
									<option <?= ($record && $record->utility_type == $val->utiltype) ? 'selected' : '' ?> data-uom="<?= $val->uom ?>"><?= $val->utiltype ?></option>
								<?php } ?>
							</select>
							<label>Utility Type <b class="text-danger">*</b> <b class="text-warning">^</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="meter_type" class="form-control form-select" <?= ($record) ? "disabled" : "required" ?>>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($list_metertype as $key => $val) { ?>
									<option <?= ($record && $record->meter_type == $val) ? 'selected' : '' ?>><?= $val ?></option>
								<?php } ?>
							</select>
							<label>Meter Type <b class="text-danger">*</b> <b class="text-warning">^</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="uom" type="text" class="form-control" value="<?= ($record) ? $record->uom : '' ?>" readonly>
							<label>UoM</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="serial_number" type="text" class="form-control" value="<?= ($record) ? $record->serial_number : '' ?>">
							<label>Serial No.</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="location_id" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($locations as $key => $val) { ?>
									<option value="<?= $val->id ?>" <?= ($record && $record->location_id == $val->id) ? 'selected' : '' ?>><?= $val->location_name ?></option>
								<?php } ?>
							</select>
							<label>Location <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="unit_id" class="form-control form-select" <?= ($record && $record->meter_type == "Mother Meter") ? "disabled" : "required" ?>>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($units as $key => $val) { ?>
									<option value="<?= $val->id ?>" <?= ($record && $record->unit_id == $val->id) ? 'selected' : '' ?>><?= $val->location_name ?></option>
								<?php } ?>
							</select>
							<label>Unit <b class="text-danger lbl-required <?= ($record && $record->meter_type == "Mother Meter") ? "d-none" : "" ?>">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="below_threshold" type="number" class="form-control" value="<?= ($record) ? $record->below_threshold : '0' ?>">
							<label>Below Threshold</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="max_threshold" type="number" class="form-control" value="<?= ($record) ? $record->max_threshold : '10000' ?>">
							<label>Max. Threshold</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="max_digit" type="number" class="form-control" value="<?= ($record) ? $record->max_digit : '5' ?>">
							<label>Max. Digit</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="multiplier" type="number" class="form-control" value="<?= ($record) ? $record->multiplier : '1' ?>">
							<label>Multiplier</label>
						</div>
					</div>

					<div class="d-flex gap-3 justify-content-start">
						<button class="main-btn btn">Submit</button>
						<button class="main-cancel btn-cancel btn" type="button">Cancel</button>
					</div>
					<input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>">
					<input name="module" type="hidden" value="<?= $module ?>">
					<input name="table" type="hidden" value="<?= $table ?>">
					<input name="unique" type="hidden" value="meter_name,utility_type,meter_type">
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$("select[name=utility_type]").on('change', function() {
			$("input[name=uom]").val($(this).find(':selected').data('uom'));
		});

		$("select[name=meter_type]").on('change', function() {
			if ($(this).val() == "Mother Meter") {
				$("select[name=unit_id]").prop('required', false);
				$("select[name=unit_id]").attr('disabled', 'disabled');
				$(".lbl-required").addClass("d-none");

			} else {
				$("select[name=unit_id]").prop('required', true);
				$("select[name=unit_id]").attr('disabled', false);
				$(".lbl-required").removeClass("d-none");
			}
		});

		$("#form-main").off('submit').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function() {
					$('.btn').attr('disabled', 'disabled');
				},
				success: function(data) {
					popup({
						data: data,
						reload_time: 2000,
						redirect: "<?= WEB_ROOT . "/$module/" ?>"
					})
				},
			});
		});

		$(".btn-cancel").click(function() {
			location = '<?= WEB_ROOT . "/$module/" ?>';
		});
	});
</script>