<?php
$module = "setting";
$table = "settings";
$view = "_user";

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
// var_dump($user->user_name);
$file = $ots->execute('setting', 'get-record', $data);
$file = json_decode($file);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_pdcstatus', 'field' => 'status']);
$list_status = json_decode($result);

$data = [
	'view' => 'users'
];
$user = $ots->execute('property-management', 'get-record', $data);
$user = json_decode($user);


$result = $ots->execute('form', 'get-role-access', ['table' => $table,]);
$role_access = json_decode($result);

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
			<input type="hidden" name='process' value='upload_profile'>
			<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/setting/edit-profile'>
			<input type="hidden" name='id' value="<?= $user->id; ?>">
			<input type="hidden" name='description' value="<?= $user->user_name; ?>" required>

			<div style="width: 100px; height: 100px;">
				<?php if ($file->attachment_url) { ?>
					<img src="<?= $file->attachment_url; ?>" alt="" class="rounded shadow" style="width: 100%; height: 100%">
					<?php } else { ?>
						<img src="http://apii2-sandbox.inventiproptech.com/uploads/profilepic.jpg" alt="" class="rounded shadow" style="width: 100%; height: 100%">
					<?php } ?>
			</div>

			<div class="d-flex flex-column justify-content-around">
				<div>
					<label class="text-required">Profile Picture</label>
				</div>

				<div class="w-100">
					<?php if ($role_access->change_profile == true) : ?>

						<button class="main-btn btn-profile w-auto px-5">
							<span class="material-symbols-outlined">
								download
							</span>
							Upload Profile
						</button>

					<?php endif; ?>
				</div>
			</div>
			<!-- <button>Upload</button> -->
		</div>


		<form action="<?= WEB_ROOT ?>/setting/save?display=plain" method='post' id="tr-add" class="mt-4">
			<div class="row forms w-50">
				<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/setting/edit-profile'>
				<input type="hidden" name='process' value='update_record'>
				<input type="hidden" name='id' value="<?= $user->id; ?>">

				<!-- <div class="col-4 mb-4">
				<div class="form-group input-box">
					<label for="" class="text-required">First Name</label>
					<input type="text" class="form-control" name="first_name" value="">
				</div>
			</div> -->

				<div class="col-6 mb-4">
					<div class="form-group input-box">
						<label for="" class="text-required">First Name</label>
						<input type="text" class="form-control" name="first_name" value="<?= $user->first_name; ?>">
					</div>
				</div>
				<div class="col-6 mb-4">
					<div class="form-group input-box">
						<label for="" class="text-required">Last Name</label>
						<input type="text" class="form-control" name="last_name" value="<?= $user->last_name; ?>">
					</div>
				</div>

				<div class="col-6 mb-4">
					<div class="form-group input-box">
						<label for="" class="text-required">Username</label>
						<input type="text" class="form-control" name="user_name" value="<?= $user->user_name; ?>" readonly required>
					</div>
				</div>

				<div class="col-6 mb-4">
					<div class="form-group input-box">
						<label for="" class="text-required">Email</label>
						<input type="email" class="form-control" name="email" value="<?= $user->user_name; ?>" readonly required>
					</div>
				</div>

				<!-- <div class="col-4 mb-4">
					<div class="form-group input-box">
						<label for="" class="text-required">Birthdate</label>
						<input type="date" class="form-control" value="">
					</div>
				</div> -->



				<div><br></div>
				<div class="btn-group-buttons">
					<div class="col-12 mb-3 gap-2">
						<div class="btn-settings">
							<?php if ($role_access->update == true) : ?>
								<button type="submit" class="main-btn btn-primary settings-save ">Save</button>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</form>
		<br>

</div>

<div class="modal" tabindex="-1" role="dialog" id='upload_profile'>
	<div class="modal-dialog  modal-dialog-centered" role="document">
		<div class="modal-content px-1 pb-4 pt-2">
			<div class="modal-header justify-content-end pb-0" style="border-bottom: 0px;">
				<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#upload_profile").hide()' aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<div class="modal-body pt-0">
				<h3 class="modal-title text-primary align-center text-center mb-3">Upload Profile Picture </h3>
				<form action="<?= WEB_ROOT ?>/setting/save?display=plain" method='post' id='form-upload-profile' enctype="multipart/form-data">
					<input type="hidden" name='process' value='upload_profile'>
					<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/setting/edit-profile'>
					<input type="hidden" name='id' value="<?= $user->id; ?>">
					<input type="hidden" name='description' value="<?= $user->user_name; ?>" required>

					<div class="col-12 my-4 file-box">
						<input type="file" name="file[]" id="upload-photo" class="upload_file d-none" accept="image/*" required>
						<label for="upload-photo" id="file-names" class="text-required w-100">Upload Your Profile Picture</label>
					</div>

					<div class="d-flex justify-content-center gap-4 w-100">
						<button type='submit' class='main-btn save-image'>Submit</button>
						<button type="button" class='main-cancel btn-cancel' onclick='$("#upload_profile").hide()'>Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<template id="complete-signup-modal">
	<swal-html>
		<div class="p-5">
			<div class="text-center ">
				<span class="material-icons" style="color: #28A745;">
					check_circle
				</span>
			</div>
			<h4 class="error-description">Saved!</h4>
			<p style="font-size:15px " class="description">
				You Have Sucsessfully Upadte Your Profile
			</p>
			<div class="d-flex justify-content-center">
				<button class="main-btn w-50 close-swal " onclick="closeSwal();">Ok</button>

			</div>
		</div>
		<swal-param name="allowEscapeKey" value="false" />
</template>
<?php endif; ?>
<script>
	$(document).ready(function() {
		$('.btn-profile').click(function() {
			$('#upload_profile').show()
		})

		function showSignupModal(data) {
			const template = $('#complete-signup-modal');
			const templateContent = template.html();
			Swal.fire({
				html: templateContent,
				showConfirmButton: false,
				allowEscapeKey: false,
				timer: 5000, // Redirect after 5 seconds
				willClose: () => {
					// Perform any necessary actions upon modal closing
					// e.g., redirect to login page if data.success is 1                 
					window.location.href = '/setting/edit-profile';
				}
			});
		}

		function closeSwal() {
			Swal.close();
		}

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
						showSignupModal()
					} else {
						// ERROR DISPLAY HERE
						$('#error-message').text(data.message); // Assuming there is an element with id 'error-message' to display the error
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {
					$('#error-message').text('An error occurred during the request.'); // Display a generic error message
				}
			});


		})

		$('#form-upload-profile').submit(function(e) {
			e.preventDefault();

			var formData = new FormData($(this)[0]);

			// Function to handle image compression
			function compressImage(file, maxSize, callback) {
				var reader = new FileReader();
				reader.onload = function(event) {
					var img = new Image();
					img.onload = function() {
						var canvas = document.createElement('canvas');
						var width = img.width;
						var height = img.height;

						// Check if the image size exceeds the maximum size
						if (file.size > maxSize) {
							var aspectRatio = width / height;
							if (width > height) {
								width = Math.sqrt(maxSize * aspectRatio);
								height = width / aspectRatio;
							} else {
								height = Math.sqrt(maxSize / aspectRatio);
								width = height * aspectRatio;
							}
						}

						canvas.width = width;
						canvas.height = height;

						var ctx = canvas.getContext('2d');
						ctx.drawImage(img, 0, 0, width, height);

						canvas.toBlob(function(blob) {
							callback(blob);
						}, file.type);
					};
					img.src = event.target.result;
				};
				reader.readAsDataURL(file);
			}

			// Get the file input element
			var fileInput = $('#upload-photo')[0];

			// Check if files are selected
			if (fileInput.files.length > 0) {
				var file = fileInput.files[0];
				var maxSize = 1024 * 1024; // 1MB

				// Compress the image
				compressImage(file, maxSize, function(compressedBlob) {
					// Replace the original file with the compressed file in the form data
					formData.set('file[]', compressedBlob, file.name);

					// Send the AJAX request with the compressed image data
					$.ajax({
						url: "<?= WEB_ROOT ?>/setting/save?display=plain",
						type: 'POST',
						dataType: 'JSON',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						success: function(data) {
							if (data.success == 1) {
								toastr.success(data.description, 'Information', {
									timeOut: 100,
									onHidden: function() {
										location = '<?= WEB_ROOT ?>/setting/edit-profile';
									}
								});
							}
						},
						complete: function() {
							// ...
						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log(errorThrown)
						}
					});
				});
			}
		});




		$('#upload-photo').on('change', function() {
			var files = Array.from(this.files);
			var fileNames = files.map(function(file) {
				return file.name;
			});
			$('#file-names').text('File Name: ' + fileNames.join(', '));
		});


	});
</script>