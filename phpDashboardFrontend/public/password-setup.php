<?php
require_once("header.php");
include('../../../vhosts/apii2-sandbox.inventiproptech.com/config.php');
include('../../../vhosts/apii2-sandbox.inventiproptech.com/db.php');
include('../../../vhosts/apii2-sandbox.inventiproptech.com/shared.php');
include('../../../vhosts/apii2-sandbox.inventiproptech.com/mailer/mailer.class.php');

// GET OTS DB NAME
$sth = $db->prepare("select concat('otsi2_',id) as account_db from otsi2.accounts where account_code=?");
$sth->execute([decryptData($_GET['acctcode'])]);
$account_db = $sth->fetch()['account_db'];

// var_dump($account_db);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$records = $db->prepare("SELECT * FROM {$account_db}.system_info ");
$records->execute();
$info = $records->fetchAll();

$acctcode = ($_GET['acctcode']) ?? "";
$email = ($_GET['email']) ?? "";
?>
<div>

	<div class="header ">
		<div class="bg-white">
			<div class="d-flex align-items-center px-3">

				<label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Password Setup</label>
			</div>
		</div>
	</div>
</div>
</div>

<div class="main">
	<div style="background-color: #F0F2F5;">
		<div style="padding: 25px;">
			<div>
				<b>Your account is has been approved. Please enter your password</b>
				<form method="post" action="password-setup-save.php" id="form-main-pass">
					<input type="hidden" name="acctcode" value="<?= $acctcode ?>">
					<div class="d-flex flex-column gap-2 flex-wrap bg-white" style="border-radius: 10px; padding: 24px 8px;">

						<div class="form-group">
							<input id="request-form" name="email" type="email" value="<?= $email ?>" readonly required placeholder="text">
							<label id="request-form">Email Address</label>
						</div>
						<div class="form-group">
							<input id="request-form" name="password" type="password" required placeholder="text" >
							<label id="request-form">Password</label>
						</div>
						<div class="form-group">
							<input id="request-form" name="confirm-password" type="password" required placeholder="text" >
							<label id="request-form">Confirm Password</label>
						</div>
						<?php if ($info[0]['ownership'] === 'SO') { ?>
							<div>
								<b>Note: </b><span>This master password is for accessing sensitive documents.</span>
							</div>
							<div class="form-group">
								<input id="request-form" name="master_password" type="password" required placeholder="text">
								<label id="request-form">Master Password</label>
							</div>
						<?php } ?>
						<!-- <div class="form-group" >
								<input class="password" id="request-form" name="password" type="password" required  placeholder="text">
								<label id="request-form">Password</label>
								<i class="bi bi-eye-slash" id="eye-icon"></i>
							</div> -->
						<div class="form-group pt-5 pb-3">
							<button type="submit" class="submit px-5 py-2 w-100" style="height: 50px;" id="registration-buttons">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id='verify-email'>
	<div class="modal-dialog  modal-dialog-centered" role="document">
		<div class="modal-content px-1 pt-2" style="border-radius: 10px;">
			<div class="modal-header justify-content-end pb-0" style="border-bottom: 0px;">
				<!-- <h5 class="modal-title">Upload Documents</h5> -->

			</div>
			<div class="modal-body pt-0 text-center" style="padding-bottom: 20px;">
				<h3 class="modal-title align-center text-center" style="font-size: 15px; font-weight: 600;margin-bottom: 29px;">Your successfully enter your password </h3>
				<label style="font-weight: 100; font-size: 14px;" class="mb-4">For your login, ensure to follow this specific link</label>
				<div class="d-flex gap-4 justify-content-center">
					<div class="form-group w-75 m-0 ">
						<input id="request-form" class="copy_text_input" value="http://portali2.sandbox.inventiproptech.com?acctcode=<?= $acctcode ?>" readonly disabled required placeholder="text">
						<label id="request-form">URL</label>
					</div>
					<a class="copy_text align-items-center copy_text d-flex justify-content-center" style="color: #1c5196;" data-toggle="tooltip" style="font-size: 12px; " title="Copy to Clipboard" href="http://portali2.sandbox.inventiproptech.com?acctcode=<?= $acctcode ?>"><span class="material-icons">
							file_copy
						</span></a>

				</div>
				<div class="col-12 py-3">
					<button class="confirm-email success px-5 py-2 w-100" style="height: 50px;" id="registration-buttons">OK</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id='error'>
	<div class="modal-dialog  modal-dialog-centered" role="document">
		<div class="modal-content px-1 pt-2" style="border-radius: 10px;">
			<div class="modal-header justify-content-end pb-0" style="border-bottom: 0px;">
				<!-- <h5 class="modal-title">Upload Documents</h5> -->
				<button type="button" class="btn-close close-error btn-close-verification" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<div class="modal-body pt-0 text-center" style="padding-bottom: 20px;">
				<h3 class="modal-title align-center text-center" style="font-size: 15px; font-weight: 600;margin-bottom: 29px;">Error</h3>
				<label style="font-weight: 100; font-size: 14px;">Password and Confirm Password do not match.</label>
				<div class="col-12 py-3">
					<button class=" close-error px-5 py-2 w-100" style="height: 50px;" id="registration-buttons">OK</button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


<script>
	$(document).ready(function() {

		$("#form-main-pass").on('submit', function(e) {
			e.preventDefault(); // Prevent default form submission behavior

			// Rest of your AJAX code
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function() {

				},
				success: function(data) {
					if (data.success) {
						$('#verify-email').modal('show');
					} else {
						$('#error').modal('show');
					}
				},
			});
		});
		$('.success').click(function() {
			window.location = 'http://portali2.sandbox.inventiproptech.com?acctcode=<?= $acctcode ?>'
			
		})
		$('.btn-close-verification').on('click', function() {
			$('#verify-email').modal('hide');
		});
		$('.close-error').click(function() {
			$('#error').modal('hide');
		})

		$('.confirm-email').on('click', function() {
			$('#registered').modal('show');
			$('#verify-email').modal('hide');
		});

		$('.log-in').on('click', function() {
			$('#registered').modal('hide');
		});

		$('.btn-close-registered').on('click', function() {
			$('#registered').modal('hide');
		});

		$('.copy_text').click(function(e) {
			e.preventDefault();
			var copyText = $(this).attr('href');
			document.addEventListener('copy', function(e) {
				e.clipboardData.setData('text/plain', copyText);
				e.preventDefault();
			}, true);
			document.execCommand('copy');

		});
	});
</script>