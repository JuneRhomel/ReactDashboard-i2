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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
  	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </body>
</html>
<?php
session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$post = $_POST;
if (initFile($_FILES['upload_file'])!="") // call function to init for receipt
	$post['attachments'] = initFile($_FILES['upload_file']); 
//vdump($post);

$api = apiSend('tenant','movement',$post);
$result = json_decode($api,true);
if ($result['success']==0) {
	echo '
	<script>
		$(document).ready(function(){
			swal({
			    title: "Warning",
			    text: "'.str_replace("'","`",$result['description']).'",
			    icon: "warning"
			}).then(function() {
			    history.back();
			});
		});
	</script>';
	//
} else {
	echo '
	<script>
		$(document).ready(function(){
			swal("Record saved!", { icon: "success" });
			location="home.php";
		});
	</script>';
	header("location: home.php");
}

/*$api = apiSend('tenant','getmoveinout',ARR_BLANK);
$api_json = json_decode($api,true);
vdump($api_json);*/
?>