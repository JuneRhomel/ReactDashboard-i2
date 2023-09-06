<?php
$module = "pdc";
$table = "pdcs";
$view = "vw_pdcs";

$id = $args[0];
if ($id != "") {
	$result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
	$record = json_decode($result);
}
$loc_id = initObj('loc_id');
if ($loc_id) {
	$parent_condition = "id=" . decryptData($loc_id);
	$type_condition = "locationtype!='Building' and locationtype!='Floor'";
	$record->parent_location_id = decryptData($loc_id);
} else {
	$parent_condition = "location_type!='Building'";
	$type_condition = "locationtype!='Building'";
}

$result =  $ots->execute('module', 'get-listnew', ['table' => 'location', 'condition' => $parent_condition, 'orderby' => 'location_name']);
$parent_locs = json_decode($result);
// var_dump($result);
$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_pdcstatus',]);
$list_status = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'vw_resident']);
$name = json_decode($result);
// foreach ($name as $key => $val) { 
// 	var_dump($val->id);
// 	var_dump($val->fullname);
// }
?>
<div class="main-container">
	<div class="mt-2 mb-4"><label class="data-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> <?= $page_title ?></label> <b class="text-danger">* Required</b></div>
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?= WEB_ROOT; ?>/module/save?display=plain" id="form-main">
				<div class="row forms">
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="resident_id" class="form-control form-select">
								<option value="" selected disabled>Choose</option>
								<?php foreach ($name as $key => $val) { ?>
									<option value="<?= $val->id ?>" <?= ($record && $record->resident_id == $val->id) ? 'selected' : '' ?>><?= $val->fullname ?></option>
								<?php } ?>
							</select>
							<label>Name<b class="text-danger lbl-non-building">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="unit_id" class="form-control form-select">
								<option value="" selected disabled>Choose</option>
								<?php foreach ($parent_locs as $key => $val) {; ?>
									<option value="<?= $val->id ?>" <?= ($record && $record->unit_id == $val->id) ? 'selected' : '' ?>><?= $val->location_name ?></option>
								<?php } ?>
							</select>
							<label>Unit<b class="text-danger lbl-non-building">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>


					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="check_no" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->check_no : '' ?>" required>
							<label>Check Number <b class="text-danger">*</b></label>
						</div>
					</div>


					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="check_amount" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->check_amount : '' ?>" required>
							<label>Check Amount</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="check_date" placeholder="Enter here" type="date" class="form-control" value="<?= ($record) ? $record->check_date : '' ?>" required>
							<label>Check Date <b class="text-danger">*</b></label>
						</div>
					</div>


					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="status_id" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($list_status as $key => $val) { ?>
									<option value="<?= $val->id ?>" <?= ($record && $record->status_id == $val->id) ? 'selected' : '' ?>><?= $val->status ?></option>
								<?php } ?>
							</select>
							<label>Status <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="d-flex gap-3 justify-content-start">
						<button class=" main-btn">Submit</button>
						<button type="button" class="main-cancel btn-cancel">Cancel</button>
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
		$("#form-main").off('submit').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				success: function(data) {
					console.log(data)
					if (data.success == 1) {
						toastr.success(data.description, 'Information', {
							timeOut: 2000,
							onHidden: function() {
								location = "<?= WEB_ROOT . "/$module/" ?>";
							}
						});
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown)
				}
			});
		});

		$(".btn-cancel").click(function() {
			location = '<?= WEB_ROOT . "/$module/" ?>';
		});
	});
</script>