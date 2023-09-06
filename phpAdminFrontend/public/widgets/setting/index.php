<?php
$equipment = null;

$settings = json_decode($ots->execute('setting', 'get-settings', []), true);

//users
$data = [
	'view' => 'users'
];
$user = $ots->execute('property-management', 'get-record', $data);
$user = json_decode($user);

//get profile
$data = [
	'view' => 'attachments',
	'desc' => $user->user_name
];
$file = $ots->execute('setting', 'get-record', $data);
$file = json_decode($file);

//PERMISSIONS
//get user role
$data = [
	'view' => 'users'
];
$user = $ots->execute('property-management', 'get-record', $data);
$user = json_decode($user);


$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);
// var_dump($result);

// $result = $ots->execute('module','get-listnew',[ 'table'=>'list_contractduration','field'=>'contractduration' ]);
// $list_contractduration = json_decode($result);

//check if has access
$data = [
	'role_id' => $user->role_type,
	'table' => 'settings',
	'view' => '_role_rights'

];
$role_access = $ots->execute('form', 'get-role-access', $data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>
<div class="main-container">
	<?php if ($role_access->read != true) : ?>
		<div class="card mx-auto" style="max-width: 30rem;">
			<div class="card-header bg-danger">
				Unauthorized access
			</div>
			<div class="card-body text-center">
				You are not allowed to access this resource. Please check with system administrator.
			</div>
		</div>
	<?php else : ?>
		<div class="d-flex gap-2">
			<div class="" style="width:100px;height:100px">
				<img src="<?= $file->attachment_url; ?>" alt="" class="rounded shadow" style="width:100%;height:100%">
			</div>

			<div>
				<div>
					<label class="text-required">Profile Picture</label>
				</div>

				<div>
					<?php if ($role_access->change_profile == true) : ?>
						<button class='btn btn-lg btn-primary my-2' onclick="show_modal_photo(this)">Change Photo</button>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<form action="<?= WEB_ROOT ?>/setting/save?display=plain" method='post' id="tr-add" class="">
			<div class="row forms" style="border-bottom: solid 1px rgb(180,180,180, .3);">
				<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/setting?menuid=setting&submenuid='>
				<input type="hidden" name='process' value='update_record'>
				<input type="hidden" name='id' value="<?= $user->id; ?>">

				<!-- <div class="col-12 col-sm-4 my-4">
				<div class="form-group">
					<label for="" class="text-required">First Name</label>
					<input type="text" class="form-control" name="first_name" value="">
				</div>
			</div> -->

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Name</label>
						<input type="text" class="form-control" name="full_name" value="<?= $user->full_name; ?>">
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Username</label>
						<input type="text" class="form-control" name="user_name" value="<?= $user->user_name; ?>" readonly>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Email</label>
						<input type="email" class="form-control" name="email" value="<?= $user->user_name; ?>" readonly>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Birthdate</label>
						<input type="date" class="form-control" value="">
					</div>
				</div>

				<div class="col-sm-4 my-4 role-select">

					<label for="" class="text-required">Role</label>
					<select class="form-control form-select" value="">
						<option value="1">Role 1</option>
						<option value="2">Role 2</option>
						<option value="3">Role 3</option>
					</select>

				</div>

				<div class="col-sm-1 my-4 role-add">
					<br>
					<button type="button" class="btn btn-add-role" style="background-color: #FFFFFF; color: #282828; outline: none; border: solid 2px rgb(180,180,180, .3);;"><i class="bi bi-plus-lg"></i>
					</button>

				</div>

				<div><br></div>
				<div class="btn-group-buttons">
					<div class="col-12 mb-3 gap-2 grp-btn">
						<div class="btn-settings">
							<?php if ($role_access->update == true) : ?>
								<button type="submit" class="btn btn-dark btn-primary settings-save d-block px-5">Save</button>
							<?php endif; ?>
						</div>
						<div class="btn-settings">
							<button type="button" class="btn btn-light btn-cancel settings-cancel d-block px-5">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<br>
		<form action="<?= WEB_ROOT ?>/setting/save?display=plain" method='post' id="tr-add" class="">
			<div class="row forms" style="border-bottom: solid 1px rgb(180,180,180, .3);">
				<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/setting?menuid=setting&submenuid='>
				<input type="hidden" name='process' value='change_pass'>
				<input type="hidden" name='id' value="<?= $user->id; ?>">

				<div class="title">
					<label class="text-required">Change Password</label>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Old Password</label>
						<input type="password" class="form-control" name="old_password" value="">
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">New Password</label>
						<input type="password" class="form-control" name="new_password" value="">
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Confirm New Password</label>
						<input type="password" class="form-control" name="confirm_password" value="">
					</div>
				</div>

				<div><br></div>
				<div class="btn-group-buttons">
					<div class="col-12 mb-3 gap-2 grp-btn">
						<div class="btn-settings">
							<?php if ($role_access->change_pass == true) : ?>
								<button type="submit" class="btn btn-dark btn-primary settings-save px-5">Save</button>
							<?php endif; ?>
						</div>
						<div class="btn-settings">
							<button type="button" class="btn btn-light btn-cancel settings-cancel px-5">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php
		// $data = $ots->execute('property-management','work-items',['interval'=>'today']);
		// var_dump($data);
		?>
</div>
<script>
	const currentDate = new Date();

	// Get the month, year, and day
	const monthLong = currentDate.toLocaleString('default', {
		month: 'long'
	});
	const year = currentDate.getFullYear();
	const day = currentDate.getDate();

	// Set the innerHTML of the element with ID "month-year"
	document.getElementById("month-day-year").innerHTML = `${monthLong} ${day}, ${year}`;
</script>


<div class="modal" tabindex="-1" role="dialog" id='upload_profile'>
	<div class="modal-dialog  modal-dialog-centered" role="document">
		<div class="modal-content px-1 pb-4 pt-2">
			<div class="modal-header justify-content-end pb-0" style="border-bottom: 0px;">
				<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#upload_profile").modal("hide")' aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<div class="modal-body pt-0">
				<h3 class="modal-title text-primary align-center text-center mb-3">Upload</h3>
				<form action="<?= WEB_ROOT ?>/setting/save?display=plain" method='post' id='form-upload-profile' enctype="multipart/form-data">
					<input type="hidden" name='process' value='upload_profile'>
					<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/setting?menuid=setting&submenuid='>
					<input type="hidden" name='id' value="<?= $user->id; ?>">
					<input type="hidden" name='description' value="<?= $user->user_name; ?>">

					<div class="col-12 my-4">
						<label class="text-required">Attachments <span class="text-danger">*</span></label><br>
						<input type="file" name="file[]" id="file" class='upload_file' multiple>
					</div>

					<div class="d-flex justify-content-center gap-4 w-100">
						<button type='submit' class='btn btn-primary px-5 save-image'>Submit</button>
						<a class='btn btn-light btn-cancel px-5' onclick='$("#upload").modal("hide")'>Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<script>
	// if (window.matchMedia("(max-width: 600px)").matches) {
	//   $(".btn-settings").addClass("col-12");
	//   $(".d-flex.mb-3.justify-content-end.gap-2.grp-btn").removeClass("mb-3 justify-content-end gap-2 grp-btn").addClass("col-12 flex-wrap");
	// }
	var dateObj = new Date();
	var day = dateObj.getUTCDate();
	var monthShort = dateObj.toLocaleString('en-US', {
		month: 'short'
	});
	var monthLong = dateObj.toLocaleString('en-US', {
		month: 'long',
		year: 'numeric'
	});
	document.getElementById("date-today").innerHTML = day;
	document.getElementById("month-today").innerHTML = monthShort;
	document.getElementById("month-year").innerHTML = monthLong;

	$('.today-btn').on('click', function(e) {
		$(".today-btn").addClass('active-length');
		$(".weekly-btn").removeClass('active-length');
		$(".monthly-btn").removeClass('active-length');
	});

	$('.save-image').on('click', function(e) {
		show_success_modal_upload($('input[name=redirect]').val());
	})

	$('.weekly-btn').on('click', function(e) {
		$(".weekly-btn").addClass('active-length');
		$(".today-btn").removeClass('active-length');
		$(".monthly-btn").removeClass('active-length');
	});

	$('.monthly-btn').on('click', function(e) {
		$(".monthly-btn").addClass('active-length');
		$(".today-btn").removeClass('active-length');
		$(".weekly-btn").removeClass('active-length');
	});

	$(document).ready(function() {
		$("#tr-add").off('submit').on('submit', function(e) {
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
					} else {
						//ERROR DISPLAY HERE
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});
		});

		$('#form-upload-profile').submit(function(e) {
			e.preventDefault();
			console.log(new FormData($(this)[0]));
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				dataType: 'JSON',
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					$("#upload_profile").modal("hide")
					console.log(data);
					// if(data.success == 1){
					// 	show_success_modal($('input[name=redirect]').val());
					// }else{
					// 	//ERROR DISPLAY HERE
					// }
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});

		});

	});

	function show_modal_photo() {
		$('#upload_profile').modal('show');
	}
</script>