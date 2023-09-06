<?php
include("footerheader.php");
fHeader();

/*$requests = [
  ["id"=>"1", "module"=>"GATE PASS", "sr_type"=>"Delivery", "details"=>"3 visitors", "status"=>"New"],
  ["id"=>"2", "module"=>"SERVICE REQUEST", "sr_type"=>"Maintenance", "details"=>"pls allow foodpanda delivery", "status"=>"Pending"],
  ["id"=>"3", "module"=>"RESERVATION", "sr_type"=>"Swimming Pool", "details"=>"for birthday party", "status"=>"Closed"],
];*/

$bills = [
  ["id"=>"1", "monthyear"=>"Apr 2022", "refno"=>"24324-0003", "status"=>"Payment Verified"],
  ["id"=>"2", "monthyear"=>"Mar 2022", "refno"=>"24324-0002", "status"=>"Payment Pending"],
  ["id"=>"3", "monthyear"=>"Feb 2022", "refno"=>"24324-0001", "status"=>"Payment Verified"],
];

$payments = json_decode(apiSend('billing','get-bill-payments',[]),true);

/*$news = [
  ["id"=>"1", "title"=>"Fire Drill", "date"=>"21 March 2022", "img"=>"resources/images/imgNews.png"],
  ["id"=>"2", "title"=>"Building Maintenance", "date"=>"22 March 2022", "img"=>"resources/images/imgNews2.png"],
  ["id"=>"3", "title"=>"Annual General Meeting", "date"=>"23 March 2022", "img"=>"resources/images/imgNews3.png"],
];*/

$faqs = [
   ["title"=>"How to Book Amenity", "faq"=>"1. Log in to Tenant Portal<br>
2. Click on 'Amenity Booking' on the side navigation. (Note: If this option is unavailable for you, it may not appear in the side navigation. Please contact property management.)<br>
3. Click on the 'Create Booking' tab, select the amenity, date and click on 'Book Now'<br>
4. Review the details of your booking and click on 'Book Now'<br>
Now you have completed booking an amenity"],
   ["title"=>"How to use Quick Service Request", "faq"=>"You create a service request record to document a service requirement. A service request record is a mechanism to track initial service contacts. Resolving a service request involves capturing relevant information from the party making the request and determining what, if any, further action is needed. If resolving the service request involves creating an incident, problem, or work order, you can create it directly from the service request. You can also relate existing records to the service request."],
   ["title"=>"How do I pay my bill", "faq"=>"1. Clicking billing icon.<br>2. Select the billing you want to pay.<br>3. Click Pay button"],
];

$api = apiSend('news','getlist',[]);
$news = json_decode($api,true);
//vdump($news);

$api = apiSend('servicerequest','getlist');
$requests = json_decode($api,true);
?>

<!-- request form -->
<!--body style="font-size:11px"-->


	<!-- registration -->
	<div class="container">
		<div class="d-flex align-items-center justify-content-between mt-4">
			<div>
				<div class="title">Registration</div>
			</div>
			<div>
				<a href="registration.php"><i class="fas fa-arrow-right circle"></i></a>
			</div>
		</div>
		<div class="row">
			<div class="col-3 mt-3">
				<div>
					<a href="visitor.php">
						<center>
							<img class="mx-auto mb-2" src="resources/images/icoVisitor.png" alt="" width="50" />
							<span class="btn-label font-14">Visitor</span>
						</center>
					</a>
				</div>
			</div>
			<div class="col-3 mt-3">
				<div>
					<a href="tenant.php">
						<center>
							<img class="mx-auto mb-2" src="resources/images/icoEmployee.png" alt="" width="50" />
							<span class="btn-label">Tenant</span>
						</center>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!-- request forms -->
	<div class="container mt-4">
		<div class="d-flex align-items-center justify-content-between mb-1">
			<div>
				<div class="title">Forms</div>
			</div>
		</div>
		<div class="row">
			<div class="col-3 mt-3">
				<div>
					<a href="gatepass.php">
						<center>
							<img class="mx-auto mb-2" src="resources/images/icoGatePass.png" alt="" width="50" />
							<span class="btn-label">Gate Pass</span>
						</center>
					</a>
				</div>
			</div>
			<div class="col-3 mt-3">
				<div>
					<a href="servicerequest.php">
						<center>
							<img class="mx-auto mb-2" src="resources/images/icoServiceRequest.png" alt="" width="50" />
							<span class="btn-label">Service Request</span>
						</center>
					</a>
				</div>
			</div>
			<div class="col-3 mt-3">
				<div>
					<a href="reservation.php">
						<center>
							<img class="mx-auto mb-2" src="resources/images/icoReservation.png" alt="" width="50" />
							<span class="btn-label">Reservation</span>
						</center>
					</a>
				</div>
			</div>
			<div class="col-3 mt-3">
				<div>
					<a href="movein.php">
						<center>
							<img class="mx-auto mb-2" src="resources/images/icoMoveInOut.png" alt="" width="50" />
							<span class="btn-label" style="width:100px; margin-left:-10px">Move In</span>
						</center>
					</a>
				</div>
			</div>
			<div class="col-3 mt-3">
				<div>
					<a href="moveout.php">
						<center>
							<img class="mx-auto mb-2" src="resources/images/icoMoveInOut.png" alt="" width="50" />
							<span class="btn-label" style="width:100px; margin-left:-10px">Move Out</span>
						</center>
					</a>
				</div>
			</div>
			<div class="col-3 mt-3">
				<div>
					<a href="forms.php">
						<center>
							<img class="mx-auto mb-2" src="resources/images/icoForms.png" alt="" width="50" />
							<span class="btn-label">Forms</span>
						</center>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!-- recent requests -->
	<div class="container mt-5">
		<div class="d-flex align-items-center justify-content-between mb-3">
			<div>
				<div class="title">Recent Requests</div>
			</div>
			<div>
				<a href="myrequests.php"><i class="fas fa-arrow-right circle"></i></a>
			</div>
		</div>
		<div id="divCarousel" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators"> 
				<?php foreach ($requests as $key=>$val) { ?> 
				<li data-target="#divCarousel" data-slide-to="<?=$key?>" class="<?=($key==0) ? "active" : ""?>"></li> 
				<?php } ?> 
			</ol>
			<div class="carousel-inner">
				<?php 
				foreach ($requests as $key=>$val) { 
					$val['module'] = "Service Request";
				?> 
				<div class="carousel-item<?=($key==0) ? " active d-block" : ""?>" style="background-color:transparent;">
					<div>
						<div class="clrBlack m-1 p-3 pb-0 bg-white rounded" style="height:auto;">
							<div class="badge badge-pill badge-secondary float-right badge-label"> <?=$val['status']?> </div>
							<div class="d-flex flex-column">
								<b class="font-14 clrDarkBlue"> <?=$val['module']?> </b>
								<small> <?=$val['sr_type']?> </small>
							</div>
							<div>
								<p class="clrDarkBlue mt-3"> <?=$val['details']?> </p>
								<a href="myrequests-view.php?id=<?=$val['id']?>&form=<?=$val['module']?>">
									<button type="button" class="btn btn-info btn-sm">View Details</button>
								</a>
							</div>
						</div>
					</div>
				</div> 
				<?php } ?> 
			</div>
			<!-- <a class="carousel-control-prev" href="#divCarousel" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#divCarousel" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a> -->
		</div>
	</div>
	<!-- reservations -->
	<?php
	$api = apiSend('amenity','getlist',[]);
	$list = json_decode($api,true);
	?>
	<div class="container mt-5">
		<div class="d-flex align-items-center justify-content-between mb-2">
			<div>
				<div class="title">Reservations</div>
			</div>
			<div>
				<a href="reservation.php"><i class="fas fa-arrow-right circle"></i></a>
			</div>
		</div>
		<div class="row">
			<?php foreach ($list as $key=>$val) { ?>             
			<div class="col-6 mt-3">
				<a href="reservation-detail.php?id=<?=$val['id']?>">
					<img src="<?=$val['picture_url']?>" class="rounded img-fluid" style="min-height: 150px;">
					<div class="img-label"><?=$val['amenity_name']?></div>
				</a>
			</div>
			<?php } ?>
		</div>
	</div>
	<!-- recent bills payment -->
	<?php
	$api = apiSend('billing','getlist',[]);
	$list = json_decode($api,true);
	// var_dump($list);
	?>
	<div class="container mt-5">
		<div class="d-flex align-items-center justify-content-between mb-4">
			<div>
				<div class="title">Recent Bills Payment</div>
			</div>
			<div>
				<a href="billing.php"><i class="fas fa-arrow-right circle"></i></a>
			</div>
		</div> 
		<?php 
		foreach ($list as $key=>$val) { 
			if ($key==3) break;
		?>
		<div class="bg-white w-100 mb-2 rounded">
			<div class="d-flex align-items-center justify-content-between p-3">
				<div>
					<div class="d-flex">
						<div class="label-mthyr0">
							<?= date("M", mktime(0, 0, 0, $val['month'], 10))." ".$val['year']; ?>
						</div>
						<div class="ml-3 subtitle"><?=$val['amount_due']?> </div>
					</div>
				</div>
				<div class="badge badge-<?=($val['remaining_balance'] <= 0) ? "success" : "danger"?> text-white font-12 float-right"><?=($val['remaining_balance'] <= 0) ? "Paid" : "Unpaid"?></div>
			</div>
		</div> 
		<?php } ?>
	</div>
	<!-- news and announcements -->
	<div class="container mt-5">
		<div class="d-flex align-items-center justify-content-between mb-4">
			<div>
				<div class="title">News and Announcements</div>
			</div>
			<div>
				<a href="news.php"><i class="fas fa-arrow-right circle"></i></a>
			</div>
		</div> 
		<?php 
		foreach ($news as $key=>$val) { 
			if ($key==0) {
		?>
		<a href="">
			<div class="card">
				<?php if ($val['image_url']) { ?>
				<img class="card-img-top img-fluid" src="<?=$val['image_url']?>" alt="News">
				<?php } ?>
				<div class="card-body">
					<div style="padding-left:10px; border-left:solid 5px #234E95">
					<label class="card-title news-title font-18">
						<a href="news-view.php?id=<?=$val['id']?>" class="font-weight-bold font-18" style="text-decoration: none;"><u><?=$val['title']?></u></a>
					</label>
					<br>
					<label class="font-12"> <?=formatDateUnix($val['created_on'])?> </label>
				</div>
			</div>
		</div> 
		</a>
		<?php 
		} else {
			if ($key==1) echo "<div class='row mt-3'>";
		?> 
		<div class="col-6 d-flex align-items-stretch">
			<div class="card">
				<?php if ($val['image_url']) { ?>
				<img class="card-img-top" src="<?=$val['image_url']?>" alt="News">
				<?php } ?>
				<div class="card-body p-2">
					<label class="card-title news-title">
						<a href="news-view.php?id=<?=$val['id']?>" class="font-weight-bold"><u><?=$val['title']?></u></a>
					</label>					
					<label class=""> <?=formatDateUnix($val['created_on'])?> </label>
				</div>
			</div>
		</div> 
		<?php 
			} // if key
		} // foreach
		echo "</div>";
		?>
	</div>
	<!-- faq -->
	<div class="container mt-5">
		<div class="d-flex align-items-center justify-content-between mb-4">
			<div>
				<div class="title">Frequently Ask Questions</div>
			</div>
			<!-- <div>
				<i class="fas fa-arrow-right circle"></i>
			</div> -->
		</div>
		<div class="accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
			<?php foreach ($faqs as $key=>$val) { ?> 
			<div class="card my-2">
				<div class="card-header" role="tab" id="heading<?=$key?>">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapse<?=$key?>" aria-expanded="true" aria-controls="collapse<?=$key?>" style="text-decoration:none; color:#34495e;">
						<h6 class="mb-0 faq-collapse"> <?=$val['title']?> <i class="fas fa-angle-down rotate-icon" style="float:right"></i></h6>
					</a>
				</div>
				<div id="collapse<?=$key?>" class="collapse<?=($key==0) ? "show" : ""?>" role="tabpanel" aria-labelledby="heading<?=$key?>" data-parent="#accordionEx">
					<div class="card-body font-12 clrDarkblue"> <?=$val['faq']?> </div>
				</div>
			</div>
			<?php } ?> 
		</div>
	</div>
	<!-- powered by -->
	<div class="" style="padding:50px 0 100px">
		<div class="row m-0 d-flex justify-content-center">
			<div class="col p-0" style="border-radius: 6px">
				<div class="col-12 d-flex align-items-center">
					<div class="mx-auto mt-auto">
					<img class="mx-auto" src="resources/images/productmark.png" alt="" width="100" />
					</div>
				</div>
			</div>
		</div>
	</div>
<!--/body--> 
<?=fFooter();?>