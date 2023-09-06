<?php
$username = "admin@mailinator.com";
$password = "Password#123";

?>
<div class="d-flex log-in-body bg-body">
	<div class="signup-image ">
		<div class="logo">

		</div>
		<div class="img-container">
			<img src="../../images/login/Frame 2381.png" alt="">
		</div>
	</div>
	<div class="form-signup mt-5">
		<b class="fw-bold fs-3 mt-5 d-block text-black">Sign in</b>
		<div class="h-100">
			<div class="d-flex gap-3 h-75 flex-column justify-content-center">
				<form class="m-auto w-100" method="post" action="<?= WEB_ROOT; ?>/<?= $widgetname; ?>/authorize?display=plain">
					<div class="d-flex flex-column ">
						<div>
							<?php if (($_GET['error'] ?? '') != '') : ?>
								<div class="d-flex align-items-center bg-warning text-white rounded p-2 mb-3"><i class="bi bi-exclamation-diamond me-2" style="font-size:25px;"></i>
									<div><?= $_GET['error'] ?? ''; ?></div>
								</div>
							<?php endif; ?>
							<?php if (($_GET['success'] ?? '') != '') : ?>
								<div class="d-flex align-items-center bg-success text-white rounded p-2 mb-3"><i class="bi bi-check-circle me-2" style="font-size:26px;"></i>
									<div>Your account has been verified.<br>You can login below.</div>
								</div>
							<?php endif; ?>
							<div class="col-12 mb-4">
								<div class="input-box input-h">
									<input name="username" type="text" placeholder="text" value="<?= $username ?>" required>
									<label for="">Username</label>
								</div>
							</div>
							<div class="col-12 mb-4">
								<div class="input-box input-h">
									<input name="password" type="password" placeholder="text" value="<?= $password ?>" required>
									<label for="">Password</label>
								</div>
							</div>
							<div class="text-end my-3">
								<p class="link-login forgot" href='http://i2-sandbox.inventiproptech.com/registration/forgot-password.php'>Forgot Password?</a>

							</div>

							<div class="d-flex justify-content-end">
								<button type="submit" class="main-btn w-100 main-submit">Login</button>
							</div>
							<div class="text-center mt-5">
								Don’t have an account? <a class="link-login" href='http://i2-sandbox.inventiproptech.com/registration/'> Sign Up Here</a>
							</div>
						</div>
					</div>
				</form>

				<div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal ">
		<form id="frm" action="<?= WEB_ROOT; ?>/registration/check-email.php?display=plain" class="ms-3" method="post">
			<div class="close-btn">
				<button type="button" class="bg-transparent x-btn border-0"><img src="../../images/login/x.svg" alt=""></button>
			</div>
			<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
				<path d="M30 6H6C4.35 6 3 7.35 3 9V27C3 28.65 4.35 30 6 30H30C31.65 30 33 28.65 33 27V9C33 7.35 31.65 6 30 6ZM29.4 12.375L19.59 18.51C18.615 19.125 17.385 19.125 16.41 18.51L6.6 12.375C6.225 12.135 6 11.73 6 11.295C6 10.29 7.095 9.69 7.95 10.215L18 16.5L28.05 10.215C28.905 9.69 30 10.29 30 11.295C30 11.73 29.775 12.135 29.4 12.375Z" fill="#1C5196" />
			</svg>
			<h3 class="text-black">Password reset</h3>
			<p class="text-black text-center">Enter your email address to reset your password</p>
			<div class="input-box input-h w-100">
				<input name="email" type="email" class="form-control" placeholder="Enter here" value="" required>
				<label class="">Email</label>

			</div>
			<div class="d-flex w-100 justify-content-end">
				<button type="submit" class="main-btn w-100 main-submit">Submit</button>
			</div>

		</form>
	</div>

	<!-- <div class="d-flex align-items-center justify-content-center" style="background: url(../../images/loginbg.png); background-size:cover; background-position:center center; width: 100%; height: 55vh;">
	<div class="">
		<img src="<?= WEB_ROOT; ?>/images/logowhite.png" alt="" style="width: 300px;">
	</div>
</div>
<div class="container">
	<div class="col-md-4 offset-md-4" style="margin-top: -80px;">
		<div class="rounded p-4" style="background-color: #fff; box-shadow: 0px 0px 2px #dfdfdf;">
			<?php if (($_GET['error'] ?? '') != '') : ?>
				<div class="d-flex align-items-center bg-warning text-white rounded p-2 mb-3"><i class="bi bi-exclamation-diamond me-2" style="font-size:25px;"></i>
					<div><?= $_GET['error'] ?? ''; ?></div>
				</div>
			<?php endif; ?>
			<?php if (($_GET['success'] ?? '') != '') : ?>
				<div class="d-flex align-items-center bg-success text-white rounded p-2 mb-3"><i class="bi bi-check-circle me-2" style="font-size:26px;"></i>
					<div>Your account has been verified.<br>You can login below.</div>
				</div>
			<?php endif; ?>
			<form method="post" action="<?= WEB_ROOT; ?>/<?= $widgetname; ?>/authorize?display=plain">
				<div class="form-group mb-2">
					<label class="form-label">Email</label>
					<input type="text" name="username" class="form-control" placeholder="user@inventi.ph" autocomplete="off" value="<?= $username ?>">
				</div>
				<div class="form-group mb-4">
					<label class="form-label">Password</label>
					<input type="password" name="password" class="form-control" placeholder="********" autocomplete="off" value="<?= $password ?>">
				</div>
				<div class="col mt-2"><button class="btn btn-primary">Login</button></div>
			</form>
			<hr>
			<div class="d-flex align-items-center">
				<div>
					<a href='http://i2-sandbox.inventiproptech.com/registration/'>Or sign up here</a>&emsp;|&emsp;<a href='http://i2-sandbox.inventiproptech.com/registration/forgot-password.php'>Forgot Password?</a>
				</div>
			</div>
		</div>
	</div> -->


	<script>
		$(document).ready(function() {
			$('.modal').hide();
			$('.forgot').click(function() {
				$('.modal').show()
			})
			$('.x-btn').click(function() {
				$('.modal').hide()
			})

			$("#frm").on("submit", function(e) {
				e.preventDefault();
				$.ajax({
					url: $(this).prop('action'),
					type: 'POST',
					data: $(this).serialize(),
					dataType: 'JSON',
					success: function(data) {
						if (data.success) {
							toastr.success('Please check your email for link to change password', 'INFORMATION', {
								timeOut: 3000,
								positionClass: 'toast-top-center',
								onHidden: function() {
									location.reload();
								}
							});
						} else {
							toastr.warning('Sorry, email does not exist.', 'WARNING', {
								timeOut: 3000,
								positionClass: 'toast-top-center',
								onHidden: function() {
									location.reload();
								}
							});
						}
					},
				});
			});
		});
	</script>