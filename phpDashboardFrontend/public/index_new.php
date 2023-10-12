<?php
session_start();
if(isset($_SESSION['tenant']))
{
	header("location: home.php");
	exit();
}

require_once("header.php");

// //get user role
// $data = [	
// 	'view'=>'users'
// ];
// $user = $ots->execute('property-management','get-record',$data);
// $user = json_decode($user);
// var_dump($user);
?>
	<body>
	<div class="main">
        <div style="background-color: #FFFFFF;">
            <div class="d-flex flex-wrap justify-content-end align-items-center gradient-blueblack px-2 py-5" style="background-image: url(resources/images/login-header.png); background-size: 100% 100%; border-radius: 0px 0px 10px 10px; height: 200px; background-repeat: no-repeat">
				
            </div>
            <div class="px-3 py-3 my-4 mx-4" style="border: 2px solid rgb(213, 215, 217, 0.5); border-radius: 10px;">
                <div>
                    <label style="font-size: 22px; font-weight: 600;">Hello Liza</label>
                </div>
                <div>
                    <label style="color: #1c5196; font-weight: 700; font-size: 24px;">Resident</label>
                </div>
                <div>
                    <label>Sign In To Your Account</label><i class="fa-solid fa-circle-exclamation px-2" style="color:#1c5196;"></i>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-4">
                    <div class="col-12 px-0">
                        <input id="sign_in" name="email" type="text" required>
                        <label id="sign_in">Email Address</label>
                    </div>

                    <div class="col-12 px-0">
                        <input class="password" id="sign_in" name="password" type="password" required>
      					<label id="sign_in">Password</label>
						<i class="bi bi-eye-slash" id="eye-icon"></i>
                    </div>
                </div>

                <div style="padding-top: 40%; padding-bottom: 40%;">
                    <button class="submit px-5 py-2 w-100" style="height: 50px;" id="registration-buttons">Submit</button>
                </div>
                <div class="pb-5 text-center">
                    <label>Don't have an account? <a href="#" style="color:#1c5196; font-weight: 600;"><u>Register Now</u></a></label>
                </div>

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

  $('.submit').on('click', function(){
        window.location.href = '<?=WEB_ROOT ?>/otp_new.php';
    });
</script>

