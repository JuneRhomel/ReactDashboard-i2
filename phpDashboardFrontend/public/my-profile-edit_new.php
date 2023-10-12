<?php
require_once('header.php');
include("footerheader.php");
$module = "resident";
$table = "resident";
$view = "vw_resident";
$data = [
	'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);

$result =  apiSend('module', 'get-record', ['id' => $user->id, 'view' => "vw_resident"]);
$record = json_decode($result);


$result = apiSend('module', 'get-listnew', ['table' => 'system_info']);
$info = json_decode($result);


$result = apiSend('module', 'get-listnew', ['table' => 'photos', 'condition' => 'reference_id="' . $user->id . '" AND description = "profile-pic"']);
$profile = json_decode($result);
$location_menu = 'profile';
?>
<div class="d-flex">


	<div class="main">
		<?php include("navigation.php") ?>

		<div class="d-flex align-items-center px-3">
			<button class="back-button-sr cancel" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
			<label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">My Profile</label>
		</div>
		<div style="padding: 24px 25px 100px 25px;">
			<div class="px-3 py-3 " style="background-color: #FFFFFF; border-radius: 5px;">

				<div class="d-flex profile-box align-items-end gap-2 pl-0">
					<img class="pic" src="<?= $profile ? $profile[0]->attachment_url : './assets/images/profilepic.jpg'  ?>">
				</div>
				<div class="col-12 px-0 mt-3  input-box">
					<input type="file" id="file" name="attachments" class="request-upload" multiple>
					<label for="file" id="file-name" class="file"><span class="material-icons">upload_file</span>Replace Profile Picture</label>
				</div>
				<form action="<?= WEB_ROOT; ?>/setting-myprofile-save.php" id="form-main" method="post" class="d-flex py-2 gap-4 flex-wrap">
					<input name="id" type="hidden" value="<?= $user->id ?>">
					<input name="module" type="hidden" value="<?= $module ?>">
					<input name="table" type="hidden" value="<?= $table ?>">
				

					<div class="col-12 px-0">
						<input id="my-profile" name="first_name" type="text" value="<?= ($record) ? $record->first_name : '' ?>" required>
						<label id="my-profile">First Name</label>
					</div>
					<div class="col-12 px-0">
						<input id="my-profile" name="last_name" type="text" value="<?= ($record) ? $record->last_name : '' ?>" required>
						<label id="my-profile">Last Name</label>
					</div>
					<div class="col-12 px-0">
						<input id="my-profile" name="contact_no" type="text" value="<?= ($record) ? $record->contact_no : '' ?>" required>
						<label id="my-profile">Mobile Number</label>
					</div>
					<!-- <div class="col-12 px-0">
						<input class="password" id="my-profile" name="password" type="password" required>
						<label id="my-profile">Old Password</label>
						<i class="bi bi-eye-slash" id="eye-icon"></i>
					</div> -->
					<div class="btn-container-profile">
						<button class="btn-profile-edit submit px-5 py-2 w-100" type="submit" id="registration-buttons">Submit</button>
						<button class="btn-profile-edit cancel px-5 py-2 w-100" type="button" id="registration-buttons-cancel">Cancel</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	<?php include('menu.php') ?>
</div>
</body>

</html>
<script>
	// $("#form-main").off('submit').on('submit', function(e) {
	// 	e.preventDefault();
	// 	$.ajax({
	// 		url: $(this).prop('action'),
	// 		type: 'POST',
	// 		data: $(this).serialize(),
	// 		dataType: 'JSON',
	// 		success: function(data) {
	// 			if(data.success) {
	// 				window.location.href = '<?=WEB_ROOT ?>/my-profile_new.php';
	// 			}
	// 		},
	// 	});
	// });

	// $('#file').on('change', function() {
	// 	var fileName = this.files[0].name;

	// 	$('#file-name').text(fileName);
	// 	const formData = new FormData();
	// 	<?php if ($profile[0]->id) { ?>
	// 		formData.append('id', <?= $profile[0]->id ?>);
	// 	<?php } ?>
	// 	formData.append('profile', this.files[0]);
	// 	formData.append('filename', fileName);
	// 	formData.append('reference_table', 'resident');
	// 	formData.append('reference_id', <?= $user->id ?>);
	// 	formData.append('description', "profile-pic");

	// 	// console.log(data)

	// 	$.ajax({
	// 		url: '<?=WEB_ROOT ?>/change-profile-pic.php', // Replace this with the actual URL of your backend API endpoint
	// 		type: 'POST', // Use the appropriate HTTP method (POST, GET, etc.) based on your backend implementation
	// 		data: formData,
	// 		processData: false,
	// 		contentType: false,
	// 		success: function(response) {
	// 			// Handle the response from the backend if needed
	// 			const res = JSON.parse(response)
	// 			// console.log(res);
	// 			// $('.pic').attr('src',res.attachments)
	// 		},
	// 		error: function(xhr, status, error) {
	// 			// Handle any errors that occur during the AJAX request
	// 			console.error('Error sending data:', error);
	// 		}
	// 	});
	// });


	// Function to handle form submission
	function handleSubmitForm(e) {
		e.preventDefault();
		handleFileChange(); // Call the function to handle the file change
		$.ajax({
			url: $(this).prop('action'),
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			success: function(data) {
                popup({
                    data: data,
                    reload_time: 2000,
                    redirect:'<?= WEB_ROOT ?>/my-profile_new.php'
                })
			},
		});
	}
	$('#file').on('change', function() {
		var fileName = $('#file')[0].files[0].name; 
		$('#file-name').text(fileName);
	})
	// Function to handle file change
	function handleFileChange() {
		if($('#file').val()) {

			var fileName = $('#file')[0].files[0].name; // Use [0] to access the DOM element
	
			
			const formData = new FormData();
			<?php if ($profile[0]->id) { ?>
				formData.append('id', <?= $profile[0]->id ?>);
			<?php } ?>
			formData.append('profile', $('#file')[0].files[0]); // Use [0] to access the DOM element
			formData.append('filename', fileName);
			formData.append('reference_table', 'resident');
			formData.append('reference_id', <?= $user->id ?>);
			formData.append('description', "profile-pic");
	
			$.ajax({
				url: '<?=WEB_ROOT ?>/change-profile-pic.php',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					const res = JSON.parse(response);
					console.log(res);
					$('.pic').attr('src', res.attachments);
				},
				error: function(xhr, status, error) {
					console.error('Error sending data:', error);
				}
			});
		}
	}

	// Attach the event handlers
	$("#form-main").off('submit').on('submit', handleSubmitForm);

	// $('#file').off('change').on('change', handleFileChange);


	$('.cancel').on('click', function() {
		window.location.href = '<?=WEB_ROOT ?>/my-profile_new.php';
	});
</script>