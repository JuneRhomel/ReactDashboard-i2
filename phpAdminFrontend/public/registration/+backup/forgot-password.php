<?php include 'layout/header.php'?>
<script>
    $(document).ready(function(){
        $('title').html('Forgot Password');
    });
</script>
<style>

</style>
<link href='//fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Montserrat:semibold' rel='stylesheet' type='text/css'>
    <div class="row  main-div" style="background-color: #114486">
        <div class="col-lg-4 col-md-12 col-sm-12 forgot-password-backdrop">
            <div>
                <a href="<?=WEB_ROOT;?>/registration/login.php" style="color: #FFFFFF">< Back </a>
            </div>
            <div class="inventi-logo ">
                <img src="assets/inventiLogoWhite.png" alt="">
            </div>
        </div>
        <div class="col-sm-12 inventi-logo-div">
            <div class="inventi-logo text-center">
                <img src="assets/inventiLogoWhite.png" alt="">
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 signup-forms" style="position:relative" >
            <h2 class="text-center welcome" onclick="show_success_modal_resetpass();">Create new password</h2>
            <br>
            
            <form class="justify-left" action='<?php echo WEB_ROOT;?>/auth/authorize?display=plain' id='reset-password' method='post'>
            <input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/registration/login.php' >
                <?php if(($_GET['error'] ?? '') != ''):?>
                    <div class="form-group">
                    <label for="exampleInputPassword1">
                        <div class="text-danger align-center"><i class="bi bi-exclamation-diamond"></i> <?php echo $_GET['error'] ?? '';?></div>
                    </label>
                        
                    </div>
                    
                <?php endif;?>
                <div class="form-group required">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name='password'>
                </div>
                <div class="form-group required">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password" name='confirm_password'>
                </div><br>
                <button type="submit" class="btn btn-primary">Confirm</button>
            </form>
        </div>
    </div>

<!-- Reset Password Modal -->
<template id="reset-modal-success">
	<swal-html>
		<div class="p-5">
			<h4 class="text-primary2">Password Reset Successfully</h4>
			<p class="text-primary2" style="font-size:12px">Awesome, you've successfully updated your password</p>
			<button class="btn btn-sm btn-primary2 w-50 close-swal" onclick="closeSwal();">Login</button>
		</div>
	</swal-html>
	<swal-param name="allowEscapeKey" value="false" />
</template>
<?php include 'layout/footer.php'?>

<script>
	function show_success_modal_resetpass(){
		Swal.fire({
			template: '#reset-modal-success',
			showCloseButton: true,
			showConfirmButton:false,
			width: '580px'
			})
	}
    function closeSwal(){
        window.location.reload();
        swal.close()
    }
    $("#reset-password").on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				dataType: 'JSON',
				data: new FormData($(this)[0]),
				contentType: false,
				processData: false,
				beforeSend: function(){
				},
				success: function(data){
					if(data.success == 1)
					{
						show_success_modal($('input[name=redirect]').val());
					}	
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});
        

</script>