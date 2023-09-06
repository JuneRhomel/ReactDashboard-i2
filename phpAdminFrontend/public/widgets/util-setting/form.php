<?php
$module = "resident";
$table = "resident";
$view = "vw_resident";

$id = $args[0];
if ($id != "") {
	$result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
	$record = json_decode($result);
}

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_residenttype', 'field' => 'residenttype']);
$list_residenttype = json_decode($result);
?>
<div class="main-container">
	<div class="mt-2 mb-4"><label class="data-title"><?= ($id == '') ? 'Add' : 'Edit'; ?> <?= $page_title ?></label> <b class="text-danger">* Required</b></div>
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?= WEB_ROOT; ?>/module/save?display=plain" id="form-main">
				<div class="row forms">
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="first_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->first_name : '' ?>" required>
							<label>First Name <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="last_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>" required>
							<label>Last Name<b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="type" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach ($list_residenttype as $key => $val) { ?>
									<option <?= ($record && $record->type == $val) ? 'selected' : '' ?>><?= $val ?></option>
								<?php } ?>
							</select>
							<label>Resident Type <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="address" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->address : '' ?>" required>
							<label>Address</label> <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="contact_no" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->contact_no : '' ?>" required>
							<label>Contact No. <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="email" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->email : '' ?>" required>
							<label>Email <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

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
					})
				},
			});
		});

		$(".btn-cancel").click(function() {
			location = '<?= WEB_ROOT . "/$module/" ?>';
		});
	});
</script>