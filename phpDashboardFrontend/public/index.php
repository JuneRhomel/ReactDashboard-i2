<?php
session_start();

$acctcode = (isset($_GET['acctcode'])) ? $_GET['acctcode'] : "NjZMRXpiYncrZy9kL2JCT05vc0RFUko4aXlMZ3lGdG0yMnkxRFRhcVRuWT0.cd0f8dc4608fc0dbde44581398a08e62";

if(isset($_SESSION['tenant']))
{
	header("location: home.php");
	exit();
}

require_once("header.php");
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
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
		
	</head>
	<body style="background-color: #f4f4f4; height: 100vh;">
	<div class="main "style="background-color: #FFFFFF;">
        <div class="pb-4" style="background-color: #FFFFFF;">
            <div class="logo-login-container" s>
				<img class="login-background"  src="assets/images/background.png" alt="">
				<img class="login-logo" src="assets/icon/logo.svg" alt="">
            </div>
            <div class="px-3 py-3" style="margin: 24px 24px; border: 2px solid rgb(213, 215, 217, 0.5); border-radius: 10px;  height: 70vh;">
                <div>
                    <label class="m-0" style="font-size: 22px; font-weight: 400;">Hello</label>
                </div>
                <!-- <div>
                    <label class="resident-test" style="color: #1c5196; font-weight: 700; font-size: 24px; margin-bottom: 24px;">Resident</label>
                </div> -->
                <div>
                    <label>Sign In To Your Account</label><i class="fa-solid fa-circle-exclamation px-2" style="color:#1c5196;"></i>
                </div>
				<form method="post" class="w-100" action="otp.php">
					<?php if(isset($_GET['error'])):?>
						<div class="text-danger py-2"><?php echo $_GET['error'];?></div>
					<?php endif;?>

					<?php if(isset($_GET['success'])):?>
						<div class="text-success p-2"><?php echo $_GET['success'];?></div>
					<?php endif;?>
					<div class="d-flex w-100 align-items-center flex-wrap gap-4">
						<div class="col-12 px-0">
							<input id="sign_in" name="email" type="text" required value="admin@mailinator.com">
							<label id="sign_in">Email Address</label>
						</div>

						<div class="col-12 px-0">
							<input class="password" id="sign_in" name="password" type="password" value="12345" >
							<label id="sign_in">Password</label>
							<i class="bi bi-eye-slash" id="eye-icon"></i>
						</div>
						<button class="btn btn-primary d-block w-100" style="height: 50px;" id="registration-buttons" name="byemail">Submit</button>
						<img class="mt-5 mx-auto" src="<?php WEB_ROOT ?>/assets/images/navlogo1.png" alt="">
						<input name="acctcode" type="hidden" value="<?=$acctcode?>">
					</div>

				</form>

            </div>
        </div>
    </div>

</body>
</html>
<script>

$('.bi-eye-slash').on('click', function(){
    var x = $('.password');
	if (x.attr('type')==='password'){
         x.attr('type','text');
		 $('#eye-icon').addClass('bi bi-eye-fill');
		 $('#eye-icon').removeClass('bi bi-eye-slash');
      }else{
         x.attr('type','password');
		 $('#eye-icon').removeClass('bi bi-eye-fill');
		 $('#eye-icon').addClass('bi bi-eye-slash');
      }

  });
  $(".register").click(function(){
	window.location.href = '<?=WEB_ROOT ?>/onboarding-screen.php'
  })
  $('.submit').on('click', function(){
        window.location.href = '<?=WEB_ROOT ?>/otp_new.php';
    });
</script>
	