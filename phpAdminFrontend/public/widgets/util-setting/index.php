<?php
$module = "util-setting";
$table = "_setting";
$view = "";

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => $table]);
$setting = json_decode($result);
foreach ($setting as $key => $val) {
	$record[$val->setting_name] = $val->setting_value;
}
?>
<div class="main-container">
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?= WEB_ROOT; ?>/module/save?display=plain" id="form-main">
				<div class="row forms">
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="electricity_due_day" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record['electricity_due_day'] : '' ?>" required>
							<label>Electricity Due Day <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="water_due_day" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record['water_due_day'] : '' ?>" required>
							<label>Water Due Day <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="d-flex gap-3 justify-content-start">
						<button class=" main-btn">Save</button>
					</div>
					<input name="id" type="hidden" value="">
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

					popup({
						data: data,
						reload_time: 2000,
					})

				},
			});
		});
	});
</script>