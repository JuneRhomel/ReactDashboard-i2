<?php
include("footerheader.php");
fHeader();
require_once("header.php");
$location_menu = "dashboard";
/*$requests = [
  ["id"=>"1", "module"=>"GATE PASS", "sr_type"=>"Delivery", "details"=>"3 visitors", "status"=>"New"],
  ["id"=>"2", "module"=>"SERVICE REQUEST", "sr_type"=>"Maintenance", "details"=>"pls allow foodpanda delivery", "status"=>"Pending"],
  ["id"=>"3", "module"=>"RESERVATION", "sr_type"=>"Swimming Pool", "details"=>"for birthday party", "status"=>"Closed"],
];*/

$bills = [
	["id" => "1", "monthyear" => "Apr 2022", "refno" => "24324-0003", "status" => "Payment Verified"],
	["id" => "2", "monthyear" => "Mar 2022", "refno" => "24324-0002", "status" => "Payment Pending"],
	["id" => "3", "monthyear" => "Feb 2022", "refno" => "24324-0001", "status" => "Payment Verified"],
];

$payments = json_decode(apiSend('billing', 'get-bill-payments', []), true);

/*$news = [
  ["id"=>"1", "title"=>"Fire Drill", "date"=>"21 March 2022", "img"=>"resources/images/imgNews.png"],
  ["id"=>"2", "title"=>"Building Maintenance", "date"=>"22 March 2022", "img"=>"resources/images/imgNews2.png"],
  ["id"=>"3", "title"=>"Annual General Meeting", "date"=>"23 March 2022", "img"=>"resources/images/imgNews3.png"],
];*/

$faqs = [
	["title" => "How to Book Amenity", "faq" => "1. Log in to Tenant Portal<br>
2. Click on 'Amenity Booking' on the side navigation. (Note: If this option is unavailable for you, it may not appear in the side navigation. Please contact property management.)<br>
3. Click on the 'Create Booking' tab, select the amenity, date and click on 'Book Now'<br>
4. Review the details of your booking and click on 'Book Now'<br>
Now you have completed booking an amenity"],
	["title" => "How to use Quick Service Request", "faq" => "You create a service request record to document a service requirement. A service request record is a mechanism to track initial service contacts. Resolving a service request involves capturing relevant information from the party making the request and determining what, if any, further action is needed. If resolving the service request involves creating an incident, problem, or work order, you can create it directly from the service request. You can also relate existing records to the service request."],
	["title" => "How do I pay my bill", "faq" => "1. Clicking billing icon.<br>2. Select the billing you want to pay.<br>3. Click Pay button"],
];


$result = apiSend('tenant', 'get-user', ['view' => 'users']);
$user = json_decode($result);
//vdumpx($result);

$api = apiSend('news', 'getlist', []);
$news = json_decode($api, true);
//vdumpx($news);


$api = apiSend('servicerequest', 'getlist');
$requests = json_decode($api, true);
$currentTime12HourFormat = date('h:i A');
$currentDate = date('Y-m-d');

$result = apiSend('tenant', 'get-list-sr', [
	'table' => 'vw_visitor_pass',
	'condition' => 'name_id="' . $user->id . '" AND status = "Approved" AND arrival_date = "' . $currentDate . '"',
	'limit' => '1'
]);


$vp = json_decode($result);

// var_dump($vp);



$result = apiSend('module', 'get-listnew', ['table' => 'vp_guest', 'condition' => 'guest_id="' . $vp[0]->id . '"']);
$visitor = json_decode($result);


$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_report_issue', 'condition' => 'name_id="' . $user->id . '"', 'limit' => '2']);
$issue = json_decode($result);
// var_dump('name_id="' . $user->id . '"');
$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_gatepass', 'condition' => 'name_id="' . $user->id . '"', 'limit' => '1']);
$gp = json_decode($result);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_workpermit', 'condition' => 'name_id="' . $user->id . '"', 'limit' => '2']);
$wp = json_decode($result);




$result = apiSend('news', 'getlist', ['table' => 'news']);
$news = json_decode($result);
// var_dump($news);


$result =  apiSend('tenant', 'get-list-sr', ['table' => 'soa', 'condition' => 'resident_id="' . $user->id . '"']);
$paid = json_decode($result);



$result =  apiSend('tenant', 'get-soabal', ['table' => 'soa', 'condition' => 'resident_id="' . $user->id . '"', "limit" => 1]);
$balance = json_decode($result);
// vdump($balance[0]->balance);

$result =  apiSend('tenant', 'get-list', ['table' => 'vw_soa', 'condition' => 'resident_id="' . $user->id . '"', 'limit' => 1]);
$soa = json_decode($result);
$result =  apiSend('module', 'get-listnew', ['table' => 'photos', 'condition' => 'reference_table="soa" and reference_id= "' . $soa[0]->id . '"', 'orderby' => 'id asc']);
$proof = json_decode($result);


?>
<main>
	<!-- header -->
	<div class="d-flex">

		<div class="main">
			<?php include("navigation.php") ?>
			<div class="body py-4 mt-1" style="padding: 0 25px; background-color: #F0F2F5;">
				<label class="w-100 mb-0" style="font-weight: 700; font-size: 29px;">Welcome <?= $user->first_name ?>,</label>
				<?php if ($visitor) { ?>
					<div class="visitor">
						<p class="visitor-today pt-3 mb-0" style="color: #000000; font-size: 20px;">You have visitor today <span></span></p>
						<div class="d-flex justify-content-end w-100" style="margin-bottom: 9px;">
							<button type="button" class="btn-close btn-close-visitor" style="color: #1c5196;">
						</div>

						<div class="card-box">
							<div class="card-container">
								<div>
									<img src="assets/images/visitors-icon.png" alt="">
								</div>
								<div>
									<div>
										<label class="mb-0" style="font-weight: 600; font-size: 22px;"><?= $visitor[0]->guest_name ?></label>
									</div>
									<div>
										<p class="mb-0" style="color: black; font-size: 16px;">Arrival Time: <?= $vp[0]->arrival_time ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

				<?php if($soa) { ?>
					<label class="heading-text mb-0 py-4" style="font-size: 24px;">SOA</label>
				<div class="soa-bill">
					<div class="d-flex justify-content-between align-items-end">
						<div>
							<b style="color:<?= $soa[0]->status === "Paid" ? '#2ECC71' : '#C0392B' ?>;font-size: 17px;"><?= $soa[0]->status ?></b>
							<p><?= date("F", strtotime("2023-" . $soa[0]->month_of . "-01")) . " " . $soa[0]->year_of ?> </label>

							<p>Due Date: <?= date_format(date_create($soa[0]->due_date), "M d, Y"); ?> </p>
						</div>
						<div class="text-end">
							<label>Total Amount Due</label>
							<h3 class="<?=  $soa[0]->status === "Paid" ? 'text-decoration-line-through' : '' ?>"> <?=  $soa[0]->amount_due?formatPrice($soa[0]->amount_due) :0 ?> </h3>
						</div>
					</div>
					<div class="text-end m-2">
						<a href="<?= WEB_ROOT ?>/view-soa.php?id=<?= $soa[0]->enc_id ?>">View Details</a>
					</div>
					
					<div class="d-flex gap-3 justify-content-between">
						<button onclick="soa_pdf('<?= $soa[0]->id ?>')" class="main-btn w-50">
							SOA PDF
						</button>
						<?php if ($proof) { ?>
							<button onclick="view_proof('<?= $proof[0]->attachment_url ?>')" class="border-btn-primary w-50 payment ">
								View Proof of Payment
							</button>
						<?php } else { ?>
							<button onclick="payment_('<?= $soa[0]->enc_id ?>')" class="border-btn-primary w-50 payment ">
								Proof of Payment
							</button>
						<?php } ?>
						<?php if ($soa[0]->status != "Paid" && $soa[0]->status != "Partially Paid" && $soa[0]->status != "For Verification" ) { ?>
							<button onclick="pay_now_('<?= $soa[0]->enc_id ?>')" class="red-btn pay-now w-50">
								Pay now
							</button>
						<?php } ?>
					</div>
				</div>
				<div class="d-flex justify-content-end pt-3">
					<a href="http://portali2.sandbox.inventiproptech.com/billing.php" class="View-more-Link">View more ></a>
				</div>
				<?php } ?>

				<!-- recent bills payment -->
				<?php
				$api = apiSend('billing', 'getlist', []);
				$list = json_decode($api, true);
				// var_dump($list);
				?>
				<?php if ($soa_detail) { ?>
					<label class="heading-text mt-4 mb-0 pb-3" style="font-size: 24px;">My Bills</label>
					<div class="bills-container">
						<?php foreach ($soa_detail  as $item) { ?>
							<div class="card-box">
								<div class="card-container">
									<div>
										<img src="assets/images/bills-icon.png" alt="">
									</div>
									<div>
										<div>
											<label class="mb-0" style="font-weight: 600; font-size: 11px;">
												<?= $item->particular ?>
											</label>
										</div>
										<div>

										</div>
									</div>
								</div>
								<div>
									<label class="mb-0" style="font-weight: 600; font-size: 20px;"><?= $item->amount ?></label>
								</div>

							</div>
						<?php } ?>
					</div>
				<?php } ?>

				<?php if ($issue || $wp) { ?>
					<label class="mt-4 mb-0 pb-3" style="font-size: 24px;">Recent Requests</label>
					<div class="requests-scroll">
						<?php foreach ($issue as $item) { ?>
							<div class="col-9 col-md-4 container mx-0 px-2 py-2" style="background-color: #FFFFFF; border-radius: 5px;">
								<div class="d-flex justify-content-between px-2 pt-3 pb-2">
									<div class="requests-btn   
								<?php if ($item->status === "Open") {
									echo "closed-status";
								} elseif ($item->status === "Closed") {
									echo "open-status";
								} else {
									echo "acknowledged-btn";
								} ?> 
								">
										<?= $item->status ?>
									</div>
									<div>
										<!-- <label style="font-size: 12px;"><?= $item->date_upload ?></label> -->
									</div>
								</div>
								<hr>
								<div class="px-1">
									<div class="d-flex flex-wrap">
										<label class="col-12 px-0 my-0" style="font-weight: 600;">Report Issue</label>
										<label class="col-12 px-0 my-0">Category : <?= $item->issue_name ?></label>
										<label class="mb-5"> Isuue Description: <?= $item->description ?></label>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php foreach ($wp as $item)
							$result = apiSend('module', 'get-listnew', ['table' => 'work_details', 'condition' => 'id="' . $item->work_details_id . '"']);
						$work = json_decode($result); { ?>
							<div class="col-9 col-md-4 container mx-0 px-2 py-2" style="background-color: #FFFFFF; border-radius: 5px;">
								<div class="d-flex justify-content-between px-2 pt-3 pb-2">
									<div class="requests-btn   
								<?php if ($item->status === "Open") {
									echo "closed-status";
								} elseif ($item->status === "Closed") {
									echo "open-status";
								} else {
									echo "acknowledged-btn";
								} ?> 
								">
										<?= $item->status ?>
									</div>
									<div>
										<!-- <label style="font-size: 12px;"><?= $item->date_upload ?></label> -->
									</div>
								</div>
								<hr>
								<div class="px-1">
									<div class="d-flex flex-column flex-wrap">
										<label class="col-12 px-0 my-0" style="font-weight: 600;">Work Permit</label>
										<label class="col-12 px-0 my-0"> Category : <?= $item->category_name ?></label>
										<label class="col-12 px-0 my-0">Name Contractor : <?= $work[0]->name_contractor ?></label>
										<label class="col-12 px-0 my-0">Scope of work : <?= $work[0]->scope_work ?></label>
									</div>
									<!-- 		
								<div class="pb-2">
									<button class=" follow-up-concern">
										Follow up concern
									</button>
								</div> -->
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>

				<label class="mt-4 mb-0 py-3" style="font-size: 20px;">Service Requests</label>
				<div class="row card-sr">
					<a href="http://portali2.sandbox.inventiproptech.com/report-issue.php" class="col-6 col-sm-3 p-1">
						<label for="">Report Issue</label>
						<img class="position-relative img-fluid" src="assets/images/unitrepair.png" alt="" style="border-radius: 5px;">
					</a>
					<a href="http://portali2.sandbox.inventiproptech.com/gatepass.php" class="col-6 col-sm-3 p-1">
						<label for="">Gate Pass</label>
						<img class="position-relative img-fluid" src="assets/images/gatepass.png" alt="" style="border-radius: 5px;">
					</a>
					<a href="http://portali2.sandbox.inventiproptech.com/visitor.php" class="col-6 col-sm-3 p-1">
						<label for="">Visitor Pass</label>
						<img class="position-relative img-fluid" src="assets/images/visitorspass.png" alt="" style="border-radius: 5px;">
					</a>
					<a href="http://portali2.sandbox.inventiproptech.com/work-permit-form_new.php" class="col-6 col-sm-3 p-1">
						<label for="">Work Permit</label>
						<img class="position-relative img-fluid" src="assets/images/workpermit.png" alt="" style="border-radius: 5px;">
					</a>

				</div>


				<div class="pb-5">
					<label class="mt-4 mb-0 py-3" style="font-size: 20px;">News And Announcements</label>

					<?php if ($news) { ?>
						<div class="news-scroll">
							<?php foreach ($news as $item) { ?>
								<div class="col-5 col-sm-3 px-0 m-0" style="background-color: #FFFFFF; border-radius: 10px;">
									<a href="<?= WEB_ROOT ?>/news-view.php?id=<?= $item->enc_id ?>" style="color: black;">
										<div style="height: 77px;">
											<image class="w-100 h-100 object-fit" src="<?= $item->thumbnail ?>" style="border-radius: 10px;"></image>
										</div>
										<div class="px-1 pt-3">
											<div class="d-flex flex-wrap">
												<label class="col-12 px-0 my-0" style="font-weight: 600;"><?= $item->title ?></label>
												<label><?= date("F j, Y", strtotime($item->date)) ?></label>
											</div>
										</div>
									</a>
								</div>
							<?php } ?>
						</div>
					<?php } else { ?>
						<div class="d-flex justify-content-center align-items-center" style="height: 104px">No News Announcement</div>
					<?php }	?>

				</div>

			</div>
		</div>

		<?php include('menu.php') ?>
	</div>
</main>


<script>
    const soa_pdf = (id) => {
        window.open(`<?= WEB_ROOT . "/genpdf.php?display=plain&id=" ?>${id}`,'_blank' )
    }
	const payment_ = (id) => {
		window.location.href = `<?= WEB_ROOT ?>/proof-of-payment.php?id=${id}`;
	}
	const pay_now_ = (id) => {
		window.location.href = `<?= WEB_ROOT ?>/payment-method.php?id=${id}`;
	}
	const view_proof = (url) => {
		// Open the URL in a new tab
		window.open(url, '_blank');
	}

	$('.btn-close-visitor').on('click', function() {
		$('.visitor').hide();
	});

</script>