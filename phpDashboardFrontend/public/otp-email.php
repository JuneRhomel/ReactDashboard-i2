<?php
include_once('../library.php');
$otp = apiSend('tenant','getotp',$_POST);
echo $otp;
$root = ($_SERVER['SERVER_NAME']=="localhost") ? "/ots-condo" : "/";
require_once("header.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
        <link rel="stylesheet" href="custom.css?v=<?=time()?>" />
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    </head>
    <body style="background-color: #f4f4f4">
    <div class="main">
        <div style="background-color: #FFFFFF;">
            <div class="d-flex flex-wrap justify-content-end align-items-center gradient-blueblack px-2 py-5" style="background-image: url(assets/images/login-header.png); border-radius: 0px 0px 10px 10px; height: 200px">
               
            </div>
            <div class="px-3 py-3 my-4 mx-4" style="border: 2px solid rgb(213, 215, 217, 0.5); border-radius: 10px;">
                <div>
                    <label style="font-size: 16px; font-weight: 600; padding-right: 10%">Please enter verification code sent to your email address</label>
                </div>
                <div class="d-flex justify-content-between pt-5">
                    <input class="form-control otp-numbers text-center" style=" width: 40px;" type="tel" maxlength="1" data-index="0">
                    <input class="form-control otp-numbers text-center" style=" width: 40px;" type="tel" maxlength="1" data-index="1">
                    <input class="form-control otp-numbers text-center" style=" width: 40px;" type="tel" maxlength="1" data-index="2">
                    <input class="form-control otp-numbers text-center" style=" width: 40px;" type="tel" maxlength="1" data-index="3">
                    <input class="form-control otp-numbers text-center" style=" width: 40px;" type="tel" maxlength="1" data-index="4">
                    <input class="form-control otp-numbers text-center" style=" width: 40px;" type="tel" maxlength="1" data-index="5">
                </div>
                <div class="button-submit" style="padding-top: 40%; padding-bottom: 40%;">
                    <button class="submit px-5 py-2 w-100"  onclick="location='home_new.php'" id="registration-buttons">Submit</button>
                </div>
                <div class="otp-div pb-5 text-center">
                    <label class="otp-not-received">OTP not received? <a href="#" style="color:#1c5196; font-weight: 600;"><u>Resend</u></a></label>
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
    $('.otp-div').hide();
    $(".submit").html("Verifying").prop('disabled', true);
    $('.button-submit').css('paddingTop', '100%').css('paddingBottom', '0px');
  })

 
const $inp = $(".form-control");

$inp.on({
  paste(ev) { // Handle Pasting
  
    const clip = ev.originalEvent.clipboardData.getData('text').trim();
    // Allow numbers only
    if (!/\d{6}/.test(clip)) return ev.preventDefault(); // Invalid. Exit here
    // Split string to Array or characters
    const s = [...clip];
    // Populate inputs. Focus last input.
    $inp.val(i => s[i]).eq(5).focus(); 
  },
  input(ev) { // Handle typing
    
    const i = $inp.index(this);
    if (this.value) $inp.eq(i + 1).focus();
  },
  keydown(ev) { // Handle Deleting
    
    const i = $inp.index(this);
    if (!this.value && ev.key === "Backspace" && i) $inp.eq(i - 1).focus();
  }
  
});
</script>