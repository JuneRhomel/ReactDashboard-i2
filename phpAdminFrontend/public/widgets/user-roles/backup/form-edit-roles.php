<?php
$data = [
	'id' => $args[0],
	'view' => '_roles'
];
$roles = $ots->execute('admin', 'get-record', $data);
$role_details = json_decode($roles);

?>
<div class="grid lg:grid-cols-1 grid-cols-1 title main-container">
	<div class="bg-white rounded-sm">
		<form method="post" action="<?php echo WEB_ROOT; ?>/user-roles/save-record?display=plain" class="bg-white" id="form-roles-edit">
			<input type="hidden" name='id' id='id' value='<?php echo $args[0] ?>'>
			<h2 class="text-primary ps-3"><b>Edit User Roles</b></h2>
			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group input-box">
						<label for="" class="text-required">Role Name <span class="text-danger">*</span></label>
						<input name="role_name" type="text" class="form-control" value="<?php echo $role_details->role_name; ?>" required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group input-box">
						<label for="" class="text-required">Role Description</label>
						<input name="description" type="text" value="<?= $role_details->description; ?>" class="form-control">
					</div>
				</div>
			</div>
			<div><br></div>
			<div class="btn-group-buttons pull-right">
				<div class="mb-3 d-flex justify-content-end gap-3" style="padding: 5px;">
					<button type="submit" class="main-btn">Save</button>
					<button type="button" class="main-cancel btn-cancel ">Cancel</button>
				</div>
			</div>
			<br>
			<input type="hidden" value="<?php echo $args[0] ?? ''; ?>" name="id">

		</form>
	</div>
</div>

<script>
	$(document).ready(function() {
		$(".btn-cancel").off('click').on('click', function() {
			window.location.href = '<?= WEB_ROOT; ?>/admin/view-roles/<?= $args[0] ?>/View';
		});

		$("#form-roles-edit").on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function() {},
				success: function(data) {
					if (data.success == 1) {

						toastr.success(data.description, 'User role successfully updated', {
							timeOut: 2000,
							onHidden: function() {
								location = redirect;
							}
						});
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});
		});

	});
</script>