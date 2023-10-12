<?php
session_start();
include('../library.php');
function fHeader() {
  global $rootpath;

  $tenant = initSession('tenant');
  if ($tenant=="")
    header("location:index.php");

  $locinfo = getLocInfo();
  $unit = $locinfo['location_name'];
  $api = apiSend('tenant','me',[ 'unit_id'=>$locinfo['location_id'] ]);
  $user = json_decode($api,true);

  // COUNT UNREAD NOTIFS
  $api = apiSend('tenant','get-notifications',[ 'unread'=>1 ]);
  $notifs = json_decode($api,true);
  $ct = count($notifs);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-straight/css/uicons-regular-straight.css'>
    
  </head>
  <body>
    <!-- header -->
    <aside class="sidebar">
		<div class="toggle">
		  <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
				<span></span>
			  </a>
		</div>
		<div class="side-inner">
  
		  <div class="profile border position-relative" style="background-image:
				linear-gradient(to bottom, rgba(255, 255, 255, 0.27), rgba(28, 81, 150, 1)),
				url('assets/images/sidebar_header_img.png');
				background-size: cover;
				color: white;
				height: 192px;
				mix-blend-mode: multiply;
				padding: 20px;">

				<div class="logo position-absolute" style="bottom:10px">
						<img src="assets/images/inventi_white_logo.png" alt="" width="129px">
				</div>
		  </div>  
		  
		  <div class="nav-menu">
			<ul>
			  <li class="active"><a href="#"><span class="icon-home mr-3"></span>Home</a></li>
			  <li><a href="http://portali2.sandbox.inventiproptech.com/billing_new.php"><span class="icon-search2 mr-3"></span>Billing</a></li>
			  <li><a href="http://portali2.sandbox.inventiproptech.com/service-request_new.php"><span class="icon-notifications mr-3"></span>My Requests</a></li>
			  <li class="border-bottom"><a href="#"><span class="icon-location-arrow mr-3 "></span>News and Announcement</a></li>
			
			  <li><a href="http://portali2.sandbox.inventiproptech.com/house-rules_new.php"><span class="icon-pie-chart mr-3"></span>House Rules</a></li>
			  <li class="border-bottom"><a href="http://portali2.sandbox.inventiproptech.com/building-directory_new.php"><span class="icon-sign-out mr-3"></span>Building Directory</a></li>	
			  <li ><a href="http://portali2.sandbox.inventiproptech.com/my-profile_new.php"><span class="icon-sign-out mr-3"></span>My Profile</a> </li>
			  <li>
				<div class="d-flex border">
					<div class="ml-3" style="padding: 0;">
						<span class="fi fi-us fis rounded" ></span> &nbsp; English
					</div>
					<div>
					</div>
				 </div> 
			 </li>
			</ul>
		  </div>
		</div>
		
	  </aside>
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </body>
</html>
<?php
  if ($tenant=="") {
    //echo "<script>swal('Information','Session expired, please login again'); location='/';</script>";
  }
} // end of Footer
?>