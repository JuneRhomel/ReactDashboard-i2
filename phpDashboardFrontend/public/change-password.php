<?php
require_once('header.php');
include("footerheader.php");

$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);
// var_dump($user);

$result = apiSend('module', 'get-listnew', ['table' => 'photos', 'condition' => 'reference_id="' . $user->id . '" AND description = "profile-pic"']);
$profile = json_decode($result);
?>

<div class="d-flex">


    <div class="main">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Change Password</label>
        </div>
        <div style="background-color: #F0F2F5;padding: 24px 25px 46px 25px;">
            <form action="change-password-save.php" id="form-main">
                <input type="hidden" name="id" value="<?= $user->id ?>">
                <div style="padding: 24px; background-color: #FFFFFF; border-radius: 5px;">
                    <div class="col-12 px-0">
                        <input id="my-profile" name="old_password" type="password"  required>
                        <label id="my-profile">Old Password</label>
                    </div>
                    <div class="col-12 mt-3 px-0">
                        <input id="my-profile" name="new_password" type="password"  required>
                        <label id="my-profile">New Password</label>
                    </div>
                    <div class="col-12 mt-3 px-0">
                        <input id="my-profile" name="confirm_password" type="password"  required>
                        <label id="my-profile">Confirm Password</label>
                    </div>
                    <div class="btn-container-profile mt-3">
                        <button class="btn-profile-edit submit px-5 py-2 w-100" type="submit" id="registration-buttons">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id='verify-email'>
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content px-1 pt-2" style="border-radius: 10px;">
				<div class="modal-header justify-content-end pb-0" style="border-bottom: 0px;">
					<!-- <h5 class="modal-title">Upload Documents</h5> -->
					<button type="button" class="btn-close btn-close-verification" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true"></span>
					</button>
				</div>
				<div class="modal-body pt-0 text-center" style="padding-bottom: 20px;">
					<h3 class="modal-title align-center text-center" style="font-size: 15px; font-weight: 600;margin-bottom: 29px;">Your successfully change your password </h3>
					<label class="description" style="font-weight: 100; font-size: 14px;">You will automatically logout</label>
					<div class="col-12 py-3">
						<button class="confirm-email out succsess px-5 py-2 w-100" style="height: 50px;" id="registration-buttons">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
    <?php include('menu.php') ?>
</div>

<script>
	$("#form-main").off('submit').on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).prop('action'),
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			success: function(data) {
				if (data.success) {
					$('#verify-email').modal('show');
                    $('.modal-title').text("Your successfully change your password ")
                    $('.description').text("You will automatically logout")
                    
                }else {
                    $('#verify-email').modal('show');
                    $('.modal-title').text(data.description)
                    $('.description').text("Please try again")
                }
			},
		});
	});
	$('.out').click(function() {
		window.location.href ='http://portali2.sandbox.inventiproptech.com/logout.php'; 
	})

    $('.back-button-sr').on('click', function() {
        window.location.href = 'http://portali2.sandbox.inventiproptech.com/my-profile_new.php';
    });

</script>