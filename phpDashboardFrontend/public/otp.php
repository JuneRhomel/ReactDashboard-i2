<?php
include_once('../library.php');
//$otp = json_decode(apiSend('tenant','getotp',$_POST),true);
//$otp = json_decode(apiSend('tenant','authenticate',$_POST),true);

session_start();

$_SESSION['accountcode'] = decryptData($_POST['acctcode']);
$_SESSION['accountcode_enc'] = $_POST['acctcode'];
//vdumpx($_SESSION['accountcode']);
$authenticate = apiSend('tenant','authenticate',$_POST);
$authenticate_json = json_decode($authenticate,true);
// vdump($authenticate_json);
if($authenticate_json['success'] == 1) {
	$_SESSION['tenant'] = $authenticate_json['data'];
	// vdump($authenticate_json);
	// exit;
	header("location:home.php");
} else {
	echo "<script>location='".WEB_ROOT."/?acctcode=".$_POST['acctcode']."&error=".$authenticate_json["description"] ."';
	</script>";
}

// if($otp['success'] == 0)
// {
// 	header("location: index.php?error={$otp['description']}");
// 	exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
	 <head>
		  <meta charset="UTF-8" />
		  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
		  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		  <title>Login</title>
		  <link rel="shortcut icon" href="resources/images/Inventi_Icon-Blue.png">
		  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
		  <link rel="stylesheet" href="custom.css?v=<?=time()?>" />
	 </head>
	 <body style="background-color: #f4f4f4">
		  <!-- nav -->
		  <div class="container d-flex align-items-center justify-content-center" style="height:300px; background: url(resources/images/login.jpg); background-size:cover; background-position:center center;">
        <div class="text-center">
        <img src="resources/images/inventiwhite.png" class="img-fluid w-50" alt="">
        </div>
        </div>
		  <div class="container">
		  <div  class="py-5 bg-white rounded" style="margin-top: -25px; border-top: 8px solid #234E9560;">
				<form method="post" action="login.php" id="form-login">
				<div class="container">
					 <div class="mb-3 text-left font-weight-bold font-30 clrDarkblue">ONE-TIME PASSWORD</div>
				</div>
				<div class="container">
					 <div class="mb-2">
						  <div class="mb-2 font-16 clrDarkblue text-left">Please enter OTP sent to your email</div>
						  <div class="text-danger login-error"></div>
					 </div>
				</div>
				<div class="container">
					 <div class="mb-2">
						  <div>
								<input type="text" class="form-control" name="otp" value="000000"/>
						  </div>
					 </div>
				</div>
				<div class="container">
					 <div class="row mt-5" style="padding: 0 15px">
						  <div class="col-6">
								<button class="btn btn-outline font-16 w-100 d-block">Resend OTP</button>
						  </div>
						  <div class="col-6 d-block">
								<button class="btn btn-primary px-3 w-100" onclicka="location='dashboard.php'">Login</button>
						  </div>
					 </div>
				</div>
				<input type="hidden" name="email" value="<?php echo $_POST['email'];?>">
				</form>
		  </div>
		  </div>
		  <!-- bottom tabs -->
		  <div class="" style="padding:100px 0">
				<div class="row m-0 d-flex justify-content-center">
				<div>Terms of Use</div>
            <div>
            <img class="mx-3" style="border-right: 2px solid #dfdfdf; height: 30px;"></img>
            </div>
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
		  <!--script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script-->
		  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

		  <script>
				$(document).ready(function(){
					$("#form-login").on('submit',function(e){
						e.preventDefault();

						$.ajax({
							url: $(this).prop('action'),
							type: 'POST',
							data: $(this).serialize(),
							dataType: 'JSON',
							beforeSend: function(){
							},
							success: function(data){
								if(data.success == 1)
								{
									window.location = '<?=WEB_ROOT ?>/home.php';
								}else{
									$(".login-error").html(data.description);
								}
							},
							complete: function(){
								
							},
							error: function(jqXHR, textStatus, errorThrown){
								
							}
						});
					});
				});
		  </script>
	 </body>
</html>