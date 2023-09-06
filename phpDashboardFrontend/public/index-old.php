<?php
session_start();
if(isset($_SESSION['tenant']))
{
	header("location: home.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Inventi Condo</title>
		<link rel="shortcut icon" href="resources/images/Inventi_Icon-Blue.png">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
		<link rel="stylesheet" href="custom.css?v=<?=time()?>" />

		<link rel="stylesheet" href="assets/fonts/icomoon/style.css">

		<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="assets/css/house-rules_new.css">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="resources/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		
		<!-- Style -->
		<link rel="stylesheet" href="resources/css/styles.css">
		<script src="assets/js/jquery-3.3.1.min.js"></script>
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/main.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

		
	</head>
	<body style="background-color: #f4f4f4; height: 100vh;">
		<!-- nav -->
		<div class="container d-flex align-items-center justify-content-center" style="height:300px; background: url(resources/images/login.jpg); background-size:cover; background-position:center center;">
		<div class="text-center">
		<img src="resources/images/logowhite.png" class="img-fluid w-50" alt="">
		</div>
		</div>
		
	   <div class="container">
	   <div class="py-5 bg-white rounded" style="margin-top: -25px; border-top: 8px solid #234E9560;">
			<div class="container">
				<div class="mb-3 text-left font-weight-bold font-30 clrDarkblue">Login</div>
			</div>
			<div class="container">
				<form method="post" action="otp.php">
					<?php if(isset($_GET['error'])):?>Error:
						<div class="text-danger p-2"><?php echo $_GET['error'];?></div>
					<?php endif;?>

					<?php if(isset($_GET['success'])):?>
						<div class="text-success p-2"><?php echo $_GET['success'];?></div>
					<?php endif;?>
				<div class="mb-2">
					<div class="mb-2 font-16 clrDarkblue">Email Address</div>
					<div>
						<input type="email" class="form-control" name="email" id="exampleInputEmail1" required/>
					</div>
				</div>
				<div class="mb-2">
					<div class="mb-2 font-16 clrDarkblue">Password</div>
					<div>
						<input type="password" class="form-control" name="password" />
					</div>
				</div>
				<div class="row mt-5">
					<!-- <div class="col-6">
						<button class="btn btn-outline font-16 w-100 d-block" onclicka="location='otp-mobile.php'" name="bymobile">OTP Mobile</button>
					</div> -->
					<div class="col-12">
						<button class="btn btn-primary d-block w-100" onclicka="location='otp-email.php'" name="byemail">Send OTP to Email</button>
					</div>
				</div>
				</form>

				<div class="text-left mt-5 clrDarkBlue d-flex">
					<div>
						Don't have an account? <a href="register.php" class="clrBlue ml-2">Register</a>  |  
						<a href="forgot-password.php" class="clrBlue">Forgot Password?</a>
					</div>
				</div>
			</div>
		</div>
	   </div>
		<!-- bottom tabs -->
		<div class="container">
		<div style="padding-top: 70px;">
			<div class="row m-0 d-flex justify-content-center align-items-center">
				<div><a href="#" target="_blank">Terms of Use</a></div>
				<div><img class="mx-3" style="border-right: 2px solid #dfdfdf; height: 30px;"></img></div>
				<div>Privacy Policy</div>
				<!-- <div class="col p-0" style="border-radius: 6px">
					<div class="col-12 d-flex align-items-center">
						<div class="mx-auto mt-auto">
							<b style="font-color:#34495E; opacity:60%">P O W E R E D&nbsp;&nbsp;&nbsp;&nbsp;B Y</b>
						</div>
					</div>
					<div class="col-12 d-flex mt-2">
						<div class="mx-auto mb-auto">
							<img class="mx-auto" src="resources/images/Inventi_Horizontal-Blue-01.png" alt="" width="100" />
						</div>
					</div>
				</div> -->
			</div>
		</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
	</body>
</html>