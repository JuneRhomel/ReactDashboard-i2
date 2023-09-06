<?php
include_once("../library.php");
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
				<div class="mb-3 font-30 text-white">Inventi Registration</div>
			</div>
		</div>
		<div class="container py-4">
			<div class="bg-white p-4">
				
				<form method="post" action="register-save.php">
				<div class="form-group">
					<label for="">Type</label>
					<select class="form-control" name="type" required>
						<option>Owner</option>
						<option>Tenant</option>
					</select>
				</div>

				<div class="form-group">
					<label for="">Name</label>
					<input class="form-control" name="name" required>
				</div>

				<div class="form-group">
					<label for="">Email</label>
					<input class="form-control" name="email" required>
				</div>

				<div class="form-group">
					<label for="">Mobile</label>
					<input class="form-control" name="mobile" required>
				</div>

				<div class="form-group">
					<label for="">Unit</label>
					<input class="form-control" name="unit_id" required>
				</div>

				<div class="form-group">
					<label for="">Preferred Password</label>
					<input type="password" class="form-control" name="password" placeholder="******" required>
				</div>

				<div class="form-group">
					<label for="">Re-type Password</label>
					<input type="password" class="form-control" name="password2" placeholder="******" required>
				</div>
				<button class="btn btn-primary d-block w-100">Submit</button>
				<button class="btn w-100 d-block mt-3" type="button" onclick="location='index.php'">Do it later</button>
			</form>
				</div>

			</div>
	</body>
</html>