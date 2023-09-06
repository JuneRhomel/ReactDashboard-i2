<?php
$module = "send-invite";
$table = "send-invite";

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$user = $ots->execute('property-management', 'get-record', ['view' => 'users']);
$user = json_decode($user);
$email = $user->email;

$account_code = $ots->execute('user-management', 'get-account', ['view' => 'accounts', 'username' => $email]);
$account_code = json_decode($account_code);

// vdump($account_code);
$email = "";
//$email = "alfrigor@gmail.com";
?>
<div class="main-container">
	<div class="">
		<div class="grid lg:grid-cols-1 grid-cols-1 title">
			<div class="rounded-sm">
				<form method="post" action="<?= WEB_ROOT; ?>/<?= $module ?>/send-invite?display=plain" id="form-main">
					<div class="row forms">
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group input-box">
								<input name="email" placeholder="Enter here" type="email" class="form-control" value="<?= $email ?>" required>
								<label>Email</label>
							</div>
						</div>
						<div class="col-12 col-sm-4 mb-6"></div>

						<div class="d-flex gap-3 justify-content-start">
							<button class="main-btn">Send</button>
						</div>
						<input name="id" type="hidden" value="">
						<input name="module" type="hidden" value="<?= $module ?>">
						<input name="table" type="hidden" value="<?= $table ?>">
					</div>
				</form>
			</div>
		</div>
		<div class="mt-5">
			<p>
				<h6><b class="text-primary">LOGIN URL:</b>&emsp;<a href="<?='http://portali2.sandbox.inventiproptech.com/?acctcode='.$account_code[0]->account_enc?>" target="_blank"><u><?='http://portali2.sandbox.inventiproptech.com/?acctcode='.$account_code[0]->account_enc?></u></a></h6>
			</p>
			<h1 class="text-primary"> <b>Scan this QR code to register.</b></h1>
			<div class="d-flex flex-column qr-code">
				<?php
				// echo encryptData($account_code[0]->account);
				genQRcode('http://portali2.sandbox.inventiproptech.com/register.php?acctcode=' . $account_code[0]->account_enc);
				?>

			</div>

		</div>
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
					$('.main-btn').attr('disabled', 'disabled');
				},
				success: function(data) {
					popup({
						data: data,
						reload_time:2000,
						redirect:location.href
					})
					// if (data.success == 1) {
					// 	toastr.success(data.description, 'Information', {
					// 		timeOut: 2000,
					// 		onHidden: function() {
					// 			location = "<?= WEB_ROOT . "/$module/" ?>";
					// 		}
					// 	});
					// } else {
					// 	toastr.warning(data.description, 'Warning', {
					// 		timeOut: 2000,
					// 		onHidden: function() {
					// 			location = "<?= WEB_ROOT . "/$module/" ?>";
					// 		}
					// 	});
					// }
				},
			});
		});
	});
</script>