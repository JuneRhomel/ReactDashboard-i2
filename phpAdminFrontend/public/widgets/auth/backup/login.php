<?php
$username = "admin@mailinator.com"; $password = "Password#123";
//$username = "alfrigor@gmail.com"; $password = "123";
?>
<div class="d-flex align-items-center justify-content-center" style="background: url(../../images/loginbg.png); background-size:cover; background-position:center center; width: 100%; height: 55vh;">
	<div class="">
		<img src="<?=WEB_ROOT;?>/images/logowhite.png" alt="" style="width: 300px;" >
	</div>
</div>
<div class="container">
	<div class="col-md-4 offset-md-4" style="margin-top: -80px;">
		<div class="rounded p-4" style="background-color: #fff; box-shadow: 0px 0px 2px #dfdfdf;">
		<?php if(($_GET['error'] ?? '') != ''):?>
			<div class="d-flex align-items-center bg-warning text-white rounded p-2 mb-3"><i class="bi bi-exclamation-diamond me-2" style="font-size:25px;"></i> <div><?=$_GET['error'] ?? '';?></div></div>
		<?php endif;?>
		<?php if(($_GET['success'] ?? '') != ''):?>
			<div class="d-flex align-items-center bg-success text-white rounded p-2 mb-3"><i class="bi bi-check-circle me-2" style="font-size:26px;"></i> <div>Your account has been verified.<br>You can login below.</div></div>
		<?php endif;?>
		<form method="post" action="<?=WEB_ROOT;?>/<?=$widgetname;?>/authorize?display=plain">
			<div class="form-group mb-2">
				<label class="form-label">Email</label>
				<input type="text" name="username" class="form-control" placeholder="user@inventi.ph" autocomplete="off" value="<?=$username?>">
			</div>
			<div class="form-group mb-4">
				<label class="form-label">Password</label>
				<input type="password" name="password" class="form-control" placeholder="********" autocomplete="off" value="<?=$password?>">
			</div>
			<div class="col mt-2"><button class="btn btn-primary">Login</button></div>
		</form>
		<hr>
		<div class="d-flex align-items-center">
			<div>
				<a href='http://i2-sandbox.inventiproptech.com/registration/'>Or sign up here</a>&emsp;|&emsp;<a href='http://i2-sandbox.inventiproptech.com/registration/forgot-password.php'>Forgot Password?</a>
			</div>
			<!-- <div class="d-flex" style="margin-left: 10px;">
				<img class="img-login-with" src="<?=WEB_ROOT;?>/images/google-login-icon-24.jpeg">
				<img class="img-login-with" src="<?=WEB_ROOT;?>/images/azure.png" style="margin-left: 5px;">
			</div> -->
		</div>
	</div>
</div>
<!-- <div class="col-sm-7 col-12 d-none d-sm-inline">
	<img src="<?=WEB_ROOT;?>/images/login-image.png" style="max-width:100%">
</div> -->