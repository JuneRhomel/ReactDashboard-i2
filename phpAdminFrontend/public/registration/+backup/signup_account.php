<?php include 'layout/header.php'?>
    <div class="row  main-div">
        <div class="col-lg-5 col-md-12 col-sm-12 status-timeline">
            <div>
                <a href="<?=WEB_ROOT;?>/registration/signup_details.php" style="color: #FFFFFF">< Back </a>
            </div>
            <div class="inventi-logo mt-5">
                <img src="assets/inventiLogoWhite.png" alt="">
            </div>
            <div class="my-4 px-2 flex-wrap d-block">
                <div>
                <label class="text-required" style="color: #FFFFFF; font-size: 25px">Sign up for your OTS</label>
                </div>
                <label class="text-required" style="color: #FFFFFF; font-size: 25px">90-day free trial</label>
            </div>
            <img src="<?php echo MAIN_URL?>/assets/step-2.png" alt="" class='map-image'>

        </div>
        <div class="col-sm-12 inventi-logo-div">
            <div class="inventi-logo text-center">
                <img src="assets/inventiLogoWhite.png" alt="">
            </div>
            

        </div>
        <div class="col-lg-7 col-md-12 col-sm-12 signup-forms">
            <?php 
                session_start();
            ?>
            <h2 class="text-center" onclick="popup_modal('confirmmail');">Your personal details</h2>
            <form class="justify-left" action = "signup_plans.php?title=Credentials" method='get' id='submit_form'>
                <input type="hidden" name="step" value='2'>
                <input type="hidden" name="account_id" value='<?php echo $_GET['account'] ?>'>
                <input type="hidden" name="user_id" value='<?php echo $_GET['user'] ?>'>

                <div class="form-group  align-center">
                    <label for="exampleInputEmail1" class="control">Email</label>
                    <input type="email" class="form-control" 
                        placeholder="email" name='email'>
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                        else.</small> -->
                </div>
                <div class="form-group ">
                    <label for="exampleInputPassword1">Create Password</label>
                    <input type="password"  class="form-control" placeholder="password" name='password' id='password' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control"  placeholder="confirm password" name='confirm_password' id='confirm_password' required>
                </div>

                
                <div class="form-group">
                    <div class="d-flex form-check">
                        <div class="mt-3">
                            <input class="form-check-input" type="checkbox" id="gridCheck" required>
                        </div>
                        <div class="mt-1">
                            <label class="form-check-label" for="gridCheck">
                                I agree to the <a href='#'>terms and conditions</a>
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Continue</button>
            </form>
            <div class='fill-div text-center' >
                <span class='fill-blue '></span>
                <span class='fill-blue '> &nbsp;</span>
                <span class='fill-grey '> &nbsp;</span>
            </div>
        </div>

    </div>










    
<!-- Confirm Email Modal -->
<template id="confirm-email-modal">
	<swal-html>
		<div class="p-5">
			<h4 class="">Please verify your email</h4>
			<p style="font-size:12px">
                You're almost there! We sent an email to <u class="text-primary2">angeli@inventi.ph</u>
                <br>If you don't see it, you may need to check your spam folder.
            </p>
			<button class="btn btn-sm btn-primary2 w-50 close-swal mt-3" onclick="popup_modal('completesignup');">Ok</button>
		</div>
	</swal-html>
	<swal-param name="allowEscapeKey" value="false" />  
</template>

<!-- Sign-Up Complete Modal -->
<template id="complete-signup-modal">
	<swal-html>
		<div class="p-5">
			<h4 class="">Registration completed successfully</h4>
			<p style="font-size:12px">
                You will be automatically redirected to a login page in 5 second, or you can click log in below.
            </p>
			<button class="btn btn-sm btn-primary2 w-50 close-swal mt-3" onclick="closeSwal();">Login</button>
		</div>
	</swal-html>
	<swal-param name="allowEscapeKey" value="false" />  
</template>


<?php include 'layout/footer.php'?>
<script>

function popup_modal(popuptype){
     if(popuptype == 'confirmmail'){
        Swal.fire({
			template: '#confirm-email-modal',
			showCloseButton: true,
			showConfirmButton:false,
			width: '580px'
			})
     }
     else{
        Swal.fire({
			template: '#complete-signup-modal',
			showCloseButton: true,
			showConfirmButton:false,
			width: '580px'
			})
     }
	}
 function closeSwal(){
    window.location.reload();
    swal.close()
}
function login(){
    window.location.href="<?= WEB_ROOT?>/registration/login.php'";
    swal.close()
}
    $(document).ready(function(){
        $('title').html('Details');
        $('#submit_form').submit(function(e){
            
            e.preventDefault();
            
            if($('#password').val() != $('#confirm_password').val()){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    html:"Passwords do not matched",
                    showConfirmButton: false,
                    timer: 10000,
                })
                
                return;
            }
            
            
            $.post({
                url : '<?= WEB_ROOT?>/account/register?display=plain',
                data :$(this).serialize(),
                success:function(data){
                    console.log(data);
                    data = JSON.parse(data);
                    console.log(data.success);
                    if(data.success == 1)
					{
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Success',
                            html:data.description,
                            showConfirmButton: false,
                            timer: 2000,
                        })
						// showSuccessMessage(data.description,function(){
							window.location.href = '<?=WEB_ROOT;?>/registration/signup_plans.php?account=' + data.account_id + '&user=' + data.user_id;
						// });
					}
                    else{
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error',
                            html:data.description,
                            showConfirmButton: false,
                            timer: 2000,
                        })
                        
                    }
                }
            });
        });
    });
    
</script>