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

$records = $db->prepare("SELECT * FROM {$account_db}.vw_location WHERE status = 'Vacant' AND location_type = 'Unit' AND deleted_on = 0");
$records->execute();
$unit = $records->fetchAll();


$records = $db->prepare("SELECT * FROM {$account_db}.system_info ");
$records->execute();
$info = $records->fetchAll();

// var_dump($info[0]);

$acctcode = ($_GET['acctcode']) ?? "";
$email = ($_GET['email']) ?? "";
?>
<style>
	input#registration,
	textarea {
		color: black;
		font-size: 18px;
		padding: 20px 5px 5px 10px;
		display: block;
		width: 100%;
		border: none;
		border-radius: 10px;
		border: 1px solid #c6c6c6;
	}

	input#registration:hover {
		border: 3px solid #1C5196;
	}

	input#registration:focus,
	textarea:focus {
		outline: none;
		border: 3px solid #1C5196;
	}

	input#registration:focus~label#registration,
	input#registration:valid~label,
	textarea:focus~label#registration,
	textarea:valid~label#registration {
		top: 3px;
		font-size: 12px;
		color: #1C5196;
		left: 11px;
	}

	input#registration:focus~.bar:before,
	textarea:focus~.bar:before {
		width: 100%;
	}

	input#registration[type="password"] {
		letter-spacing: 0.3em;
	}

	.group {
		position: relative;
	}

	label#registration {
		color: #c6c6c6;
		font-size: 16px;
		font-weight: normal;
		position: absolute;
		pointer-events: none;
		left: 15px;
		top: 11px;
		transition: 300ms ease all;
		padding: 2px 15px;
	}

	i#eye-icon {
		color: #c6c6c6;
		font-size: 16px;
		font-weight: normal;
		position: absolute;
		left: 16px;
		top: 0;
		transition: 300ms ease all;
		padding: 2px 15px;

	}

	.upload_file {
		width: 100%;
		border: 1px solid #c6c6c6;
		padding: 10px;
		border-radius: 10px
	}

	input.registration_upload {
		color: #1c5196;
		border-radius: 5px;
		padding: 16px;
	}

	input.registration_upload[type="file"]::file-selector-button {
		background-color: #1c5196;
		border-radius: 5px;
		color: white;
		padding: 5px 10px;
		border: none;
	}

	.close-btn-register {
		border: 1px solid #1c5196;
		color: #1c5196;
	}

	.close-btn-register:hover {
		color: #1c5196;
	}
</style>

<body>
	<div class="header ">
		<div class="bg-white">
			<div class="d-flex align-items-center px-3">
				<button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
				<label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Registration</label>
			</div>
		</div>
	</div>
	</div>
	</div>

	<div class="main">
		<div style="background-color: #F0F2F5;">
			<div style="padding: 25px;">
				<div>
					<form method="post" action="register-save.php" id="form-main">
						<input id="request-form" name="acctcode" type="hidden" value="<?= $acctcode ?>" required placeholder="text">
						<input id="request-form" name="ownership" type="hidden" value="<?= $info[0]['ownership'] ?>" required placeholder="text">
						<input id="request-form" name="property_type" type="hidden" value="<?= $info[0]['property_type'] ?>" required placeholder="text">
						<?php if ($info[0]['ownership'] === 'HOA') { ?>
							<?php if (isset($_GET['from'])) { ?>
								<input id="request-form" name="type" type="hidden" value="Tenant" required placeholder="text">
								<input id="request-form" name="created_by" type="hidden" value="<?= $_GET['from']?>" required placeholder="text">
								<input id="request-form" name="unit_id" type="hidden" value="<?=$_GET['unit_id'] ?>" required placeholder="text">
								<?php } else { ?>
									<input id="request-form" name="type" type="hidden" value="Unit Owner" required placeholder="text">

								<?php } ?>
						<?php } ?>
						<div class="d-flex flex-column gap-2 flex-wrap bg-white" style="border-radius: 10px; padding: 24px 8px;">

							<div class="form-group">
								<input id="request-form" name="email" type="text" value="<?= $email ?>" required placeholder="text">
								<label id="request-form">Email Address <span class="text-danger">*</span></label>
							</div>
							<div class="form-group">
								<input id="request-form" name="first_name" type="text" required placeholder="text">
								<label id="request-form">First Name <span class="text-danger">*</span></label>
							</div>
							<div class="form-group">
								<input id="request-form" name="last_name" type="text" required placeholder="text">
								<label id="request-form">Last Name <span class="text-danger">*</span></label>
							</div>
							<div class="form-group">
								<input id="request-form" name="contact_no" type="text" required placeholder="text">
								<label id="request-form">Mobile Number <span class="text-danger">*</span></label>
							</div>
							<div class="form-group">
								<input id="request-form" name="address" type="text" required placeholder="text">
								<label id="request-form">Address <span class="text-danger">*</span></label>
							</div>
							<?php if ($info[0]['property_type'] === 'Commercial') { ?>
								<div class="form-group">
									<input id="request-form" name="company_name" type="text" required placeholder="text">
									<label id="request-form">Company <span class="text-danger">*</span></label>
								</div>
							<?php } ?>

							<!-- <div class="form-group" >
							<input class="password" id="request-form" name="password" type="password" required  placeholder="text">
							<label id="request-form">Password</label>
							<i class="bi bi-eye-slash" id="eye-icon"></i>
						</div> -->
							<div class="form-group pt-5 pb-3">
								<button class="submit px-5 py-2 w-100" style="height: 50px;" id="registration-buttons">Submit</button>
								<!-- <button class="close-btn-register px-5 py-2	 btn w-100 d-block mt-3" type="button" onclick="location='index.php'">Do it later</button> -->
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
					<button type="button" class="btn-close btn-close-verification" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true"></span>
					</button>
				</div>
				<div class="modal-body pt-0 text-center" style="padding-bottom: 20px;">
					<h3 class="modal-title align-center text-center" style="font-weight: 600;margin-bottom: 29px;"></h3>
					<label class="description_m"></label>
					<div class="col-12 py-3">
						<button class="confirm-email px-5 py-2 w-100" style="height: 50px;" id="registration-buttons">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

</html>
<script>
	// $('.bi-eye-slash').on('click', function() {
	// 	var x = $('.password');
	// 	if (x.attr('type') === 'password') {
	// 		x.attr('type', 'text');
	// 		$('#eye-icon').addClass('bi bi-eye-fill');
	// 		$('#eye-icon').removeClass('bi bi-eye-slash');
	// 	} else {
	// 		x.attr('type', 'password');
	// 		$('#eye-icon').removeClass('bi bi-eye-fill');
	// 		$('#eye-icon').addClass('bi bi-eye-slash');
	// 	}

	// });


	$("#form-main").off('submit').on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).prop('action'),
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			success: function(data) {
				if (data.success == 1) {
					$(".modal-title").text(data.title)
					$(".description_m").text(data.description)
					$('#verify-email').modal('show');
					$('.confirm-email').show();

				} else {
					$(".modal-title").text(data.title)
					$(".description_m").text(data.description)
					$('#verify-email').modal('show');
					$('.confirm-email').hide()
				}
			},
		});
	});

	$('.btn-close-verification').on('click', function() {
		$('#verify-email').modal('hide');
	});

	$('.confirm-email').on('click', function() {
		window.location = '<?=WEB_ROOT ?>/?acctcode=<?= $acctcode ?>'
	});

	$('.log-in').on('click', function() {
		$('#registered').modal('hide');
	});

	$('.btn-close-registered').on('click', function() {
		$('#registered').modal('hide');
	});

	$('.log-in').on('click', function() {
		window.location.href = '<?=WEB_ROOT ?>/index.php';
	});
	$('.back-button-sr').on('click', function() {
		window.location.href = '<?=WEB_ROOT ?>';
	});
</script>