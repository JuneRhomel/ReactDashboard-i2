<?php
$module = "contract";
$table = "contract";
$view = "vw_contract";

$id = $args[0];
if ($id != "") {
	$result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
	$record = json_decode($result);
	$recarr = (array) $record;
} else {
	$record->status = "Active";
}

if (initObj('resident_id'))
	$record->resident_id = initObj('resident_id');

if (initObj('unit_id'))
	$record->unit_id = initObj('unit_id');

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'vw_resident', 'orderby' => 'fullname']);
$residents = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'location', 'condition' => 'location_type<>"Building" and location_type<>"Floor" and location_type<>"Common Area"', 'orderby' => 'id']);
$units = json_decode($result);

// REMOVE UNIT FROM $UNITS IF WITH EXISTING ACTIVE CONTRACT
$result = $ots->execute('module', 'get-listnew', ['table' => 'vw_contract', 'condition' => 'status="Active"', 'orderby' => 'id']);
$contracts = json_decode($result);
if ($contracts) {
	foreach ($contracts as $contract) {
		foreach ($units as $key => $val) {
			if ($val->id == $contract->unit_id)
				unset($units[$key]);
		}
	}
}

$result = $ots->execute('module', 'get-listnew', ['table' => 'contract_template', 'orderby' => 'template']);
$templates = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_contractduration', 'field' => 'contractduration']);
$list_contractduration = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_contractpaysked', 'field' => 'contractpaysked']);
$list_contractpaysked = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_contractstatus', 'field' => 'contractstatus']);
$list_contractstatus = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'vw_contract_field', 'condition' => 'fieldkind="Custom"', 'orderby' => 'id']);
$custom_fields = json_decode($result);
?>
<div class="main-container">
	<div class="mt-2 mb-4"><label class="data-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> <?= $page_title ?></label> <b class="text-danger">* Required</b></div>
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?= WEB_ROOT; ?>/module/save?display=plain" id="form-main">
				<div class="row forms">
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="contract_number" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->contract_number : "" ?>" required>
							<label>Contract Number <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="contract_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->contract_name : "" ?>" required>
							<label>Contract Name <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="resident_id" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($residents as $key => $val) { ?>
									<option value="<?= $val->id ?>" <?= ($record && $record->resident_id == $val->id) ? 'selected' : '' ?>><?= $val->fullname ?></option>
								<?php } ?>
							</select>
							<label>Occupant <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="company_name" placeholder="" type="text" class="form-control" value="<?= ($record) ? $record->company_name : "" ?>" readonly>
							<label>Company Name</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="unit_id" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($units as $key => $val) { ?>
									<option value="<?= $val->id ?>" <?= ($record && $record->unit_id == $val->id) ? 'selected' : '' ?>><?= $val->location_name ?></option>
								<?php } ?>
							</select>
							<label>Unit <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-8 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="start_date" placeholder="Enter here" type="date" class="form-control" value="<?= ($record) ? $record->start_date : "" ?>" required>
							<label>Start Date <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="end_date" placeholder="Enter here" type="date" class="form-control" value="<?= ($record) ? $record->end_date : "" ?>" required>
							<label>End Date <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="monthly_rate" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->monthly_rate : "" ?>" required>
							<label>Monthly Rate <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="cusa" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->cusa : "" ?>" required>
							<label>CUSA <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="asso_dues" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->asso_dues : "" ?>" required>
							<label>Association Dues <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-8 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="months_advance" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->months_advance : "" ?>" required>
							<label>Months of Advance <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="months_deposit" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->months_deposit : "" ?>" required>
							<label>Months of Deposit <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="duration" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($list_contractduration as $key => $val) { ?>
									<option <?= ($record && $record->duration == $val) ? 'selected' : '' ?>><?= $val ?></option>
								<?php } ?>
							</select>
							<label>Duration <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="payment_schedule" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($list_contractpaysked as $key => $val) { ?>
									<option <?= ($record && $record->payment_schedule == $val) ? 'selected' : '' ?>><?= $val ?></option>
								<?php } ?>
							</select>
							<label>Payment Schedule <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="day_due" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->day_due : "" ?>" required>
							<label>Day Due <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="notify_days" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->notify_days : "" ?>" required>
							<label>Notify Days <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="template_id" class="form-control form-select">
								<option value="" selected disabled>Choose</option>
								<?php foreach ($templates as $key => $val) { ?>
									<option value="<?= $val->id ?>" <?= ($record && $record->template_id == $val->id) ? 'selected' : '' ?>><?= $val->template ?></option>
								<?php } ?>
							</select>
							<label>Template <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="status" class="form-control form-select" required disabled>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($list_contractstatus as $key => $val) { ?>
									<option value="<?= $record->val ?>" <?= ($record && $record->status == $val) ? 'selected' : '' ?>><?= $val ?></option>
								<?php } ?>
							</select>
							<label>Status <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<?php if ($custom_fields) { ?>
						<h6><b>CUSTOM FIELDS</b></h6>
						<?php
						$ct = 1;
						foreach ($custom_fields as $custom_field) {
						?>
							<div class="col-12 col-sm-4 mb-3">
								<div class="form-group input-box">
									<input name="<?= $custom_field->fieldname ?>" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $recarr[$custom_field->fieldname] : "" ?>">
									<label><?= $custom_field->fieldlabel ?></label>
								</div>
							</div>
						<?php
							$ct++;
							if ($ct % 3 == 0)
								echo '<div class="col-12 col-sm-4 mb-3"></div>';
						} // FOREACH 
						?>
					<?php } // IF CUSTOM_FIELDS 
					?>

					<div class="d-flex gap-3 justify-content-start">
						<button class="main-btn btn">Submit</button>
						<button class="main-cancel btn-cancel btn" type="button">Cancel</button>
					</div>
					<input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>">
					<input name="module" type="hidden" value="<?= $module ?>">
					<input name="table" type="hidden" value="<?= $table ?>">
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$("select[name=resident_id]").on('change', function() {
			$.ajax({
				url: '<?= WEB_ROOT . "/module/get-listnew?display=plain" ?>',
				type: 'POST',
				data: {
					table: 'resident',
					condition: 'id=' + $(this).val(),
					field: 'company_name',
					orderby: 'id'
				},
				dataType: 'JSON',
				success: function(data) {
					console.log(data);
					$("input[name=company_name]").val(data);
				},
			});
		});

		$("input[name=end_date]").change(function() {
			if ($("input[name=start_date]").val() === "") {
				popup({
					title: "Please enter start date first.",
					data: {
						success: 0
					},
					reload_time: 3000,
					
				});
				$("input[name=start_date]").focus();
				$(this).val('');
			} else if ($("input[name=end_date]").val() < $("input[name=start_date]").val()) {
				popup({
					title: "End date cannot be before start date. Please change.",
					data: {
						success: 0
					},
					reload_time: 3000,
					
				});
				$("input[name=end_date]").val(''); // Clear the invalid end date
				$("input[name=end_date]").focus();
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