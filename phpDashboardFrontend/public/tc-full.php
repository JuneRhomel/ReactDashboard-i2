<?php
include_once("../library.php");
$units = json_decode(apiSend('location','get-unit-list',[]),true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Inventi Condo</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
	<link rel="stylesheet" href="custom.css?v=<?=time()?>" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body style="background-color: #f4f4f4">
	<div class="container d-flex align-items-center justify-content-center" style="height:200px; background: url(resources/images/login-bg.jpg); background-size:cover; background-position:center center;">
		<div class="row">
			<div class="mb-3 font-30 text-white">Forgot Password</div>
		</div>
	</div>
	<div class="container py-4">
		<div class="bg-white p-4">			
			<form id="frm" method="post" action="forgot-password-send.php">
				<div class="form-group">
					<label for="">Please enter your registered email</label>
					<input name="email" class="form-control" required>
					<input name="reseturl" type="hidden" value="https://portal.ots-sandbox.intuition.ph/forgot-password-reset.php">
				</div>
				<div class="row mt-5" style="padding: 0 15px">
	                <div class="col-6">
	                    <button type="button" class="btn btn-secondary w-100" onclick="location='index.php'">Cancel</button>
	                </div>
	                <div class="col-6">
	                    <button type="submit" class="btn btn-primary pt-2 w-100 form-control">Submit</button>
	                </div>
	            </div>
			</form>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
<script>
$(document).ready(function(){
    $("#frm").on('submit',function(e){
        e.preventDefault();                  
        swal("Verification email sent!", { icon: "success" });
        this.submit()
    });
});
</script>