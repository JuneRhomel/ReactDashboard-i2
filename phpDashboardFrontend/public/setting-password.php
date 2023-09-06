<?php
include("footerheader.php");
fHeader();
global $locinfo;

$password_old = $password_new = $password_confirm = "";
?>
<div class="col-12 d-flex align-items-center justify-content-start mt-4">
    <div class="">
        <a href="setting.php"><i class="fas fa-arrow-left circle"></i></a>
    </div>
    <div class="font-18 ml-2"><a href="setting.php">Back to Setting</a></div>
</div>
<div class="col-12 d-flex align-items-center justify-content-between mt-4 mb-3">
    <div class="title">Change Password</div>
</div>
<form id="frm" name="frm" method="post" enctype="multipart/form-data" action="setting-password-save.php">
	<div class="bg-white">
		<div class="container p-3">
			<form method="post" action="otp.php">
			<?php if(isset($_GET['error'])):?>
				<div class="text-danger p-2"><?php echo $_GET['error'];?></div>
			<?php endif;?>

			<?php if(isset($_GET['success'])):?>
				<div class="text-success p-2"><?php echo $_GET['success'];?></div>
			<?php endif;?>
			<div class="mb-2">
				<div class="mb-2 font-16 clrDarkblue">Current Password</div>
				<div>
					<input name="password_old" type="password" class="form-control" value="<?=$password_old?>" required/>
				</div>
			</div>
			<div class="mb-2">
				<div class="mb-2 font-16 clrDarkblue">New Password</div>
				<div>
					<input name="password_new" type="password" class="form-control" value="<?=$password_new?>" required/>
				</div>
			</div>
			<div class="mb-3">
				<div class="mb-2 font-16 clrDarkblue">Re-enter New Password</div>
				<div>
					<input id="password_confirm" type="password" class="form-control" value="<?=$password_confirm?>" required/>
				</div>
			</div>
			<div class="row my-4">
				<div class="col-6"><button class="btn btn-secondary form-control" type="button" onclick="window.location='setting.php'">Cancel</button></div>
				<div class="col-6"><button class="btn btn-primary form-control pt-1" name="update" type="submit">Update</button></div>
			</div>
			</form>
		</div>
	</div>
</form>
<?=fFooter();?>
<script>
$(document).ready(function(){
    $("#frm").on('submit',function(e){
        e.preventDefault();  

        password_old = $("input[name=password_old]").val();
        password_new = $("input[name=password_new]").val();
        password_confirm = $("#password_confirm").val();
        if (password_new!=password_confirm) {
        	swal('New password and confirm password did not match. Please enter again.');
        } else {

        	$.ajax({
				url: 'setting-password-validate.php',
				type: 'POST',
				data: { 'password_old': password_old, 'password_new': password_new },
				dataType: 'json',
				success: function(data){
					if (data==false) {
						swal('Invalid old password.');
					} else {
						swal({
						    text: "Password updated!",
						    type: "success"
						}).then(function() {
						    window.location = "setting.php";
						});
					}
				},
			});
	    }
    });
});
</script>