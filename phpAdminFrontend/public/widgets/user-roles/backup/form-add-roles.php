<?php
$module = "role";
// $module = "user-roles";
$table = "role";
$view = "_roles";
?>

<div class="grid lg:grid-cols-1 grid-cols-1 title main-container">

<h2 class="text-primary ps-3"><b>Add User Roles</b></h2>
	<div class="bg-white rounded-sm">
		<form method="post" action="<?php echo WEB_ROOT; ?>/user-roles/save-record?display=plain" class="bg-white" id="form-roles-save" enctype="multipart/form-data">
			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group input-box">
						<label for="" class="text-required">Role Name <span class="text-danger">*</span></label>
						<input name="role_name" id="role_name" type="text" class="form-control" required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group input-box">
						<label for="" class="text-required">Role Description</label>
						<input name="description" id="description" type="text" class="form-control">
					</div>
				</div>
			</div>
			<div class="btn-group-buttons pull-right">
				<div class="mb-3 d-flex justify-content-end gap-3" style="padding: 5px;">
					<button type="submit" class="main-btn btn-save ">Add</button>
					<button type="button" class="main-cancel btn-cancel ">Cancel</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {

		$(".btn-cancel").click(function(){
			window.location.href = '<?php echo WEB_ROOT; ?>/user-roles/';

		})

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

		$("#form-roles-save").on('submit', function(e) {
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

						redirect = (data.loc_id) ? "<?= WEB_ROOT . "/user-roles/view/" ?>" + data.loc_id : "<?= WEB_ROOT . "/user-roles/" ?>";
						toastr.success(data.description, 'Information', {
							timeOut: 100,
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