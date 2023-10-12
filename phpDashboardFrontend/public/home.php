<?php
include("footerheader.php");
fHeader();
require_once("header.php");
$location_menu = "dashboard";
$result = apiSend('module', 'get-list', ['table' => 'system_info']);
$info = json_decode($result)[0];

$result = apiSend('tenant', 'get-user', ['view' => 'users']);
$user = json_decode($result);

$currentTime12HourFormat = date('h:i A');
$currentDate = date('Y-m-d');

$result = apiSend('tenant', 'get-list', [
	'table' => 'vw_visitor_pass',
	'condition' => 'name_id="' . $user->id . '" AND status = "Approved" AND arrival_date = "' . $currentDate . '"',
	'limit' => '1'
]);
$vp = json_decode($result);

$result = apiSend('module', 'get-list', ['table' => 'vp_guest', 'condition' => 'guest_id="' . $vp[0]->id . '"']);
$visitor = json_decode($result);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_report_issue', 'condition' => 'name_id="' . $user->id . '"', 'limit' => '2']);
$issue = json_decode($result);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_gatepass', 'condition' => 'name_id="' . $user->id . '"', 'limit' => '1']);
$gp = json_decode($result);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_workpermit', 'condition' => 'name_id="' . $user->id . '"', 'limit' => '2']);
$wp = json_decode($result);

$result = apiSend('tenant', 'get-list', ['table' => 'news','condition' => 'status="Publish"']);
$news = json_decode($result);

$result =  apiSend('tenant', 'get-list', ['table' => 'vw_soa', 'condition' => 'resident_id="' . $user->id . '"', 'limit' => '1']);
$soa = json_decode($result);

// vdump($soa[0]);
$result =  apiSend('module', 'get-list', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $soa[0]->id . '"', 'orderby' => 'transaction_date DESC', 'limit' => 3]);
$soa_detail = json_decode($result);

$result =  apiSend('module', 'get-listnew', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $soa[0]->id . '" and not (particular like "%SOA Payment%" and status in("Successful","Invalid"))', 'orderby' => 'id asc']);
$balance = json_decode($result);
// vdumpx($balance);
$total = 0;

foreach ($balance as $item) {
	$total = $total +  $item->amount;
}
$total = $soa[0]->amount_due - $total;


$name = $info->property_type == "Commercial" ? $user->company_name : $user->first_name;

?>
<main>
	<!-- header -->
	<div class="d-flex">

		<div class="main">
			<?php include("navigation.php") ?>
			<div class="body py-4 mt-1" style="padding: 0 25px; background-color: #F0F2F5;">
				<label class="w-100 mb-0" style="font-weight: 700; font-size: 29px;">Welcome <?= $name ?>,</label>
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

				<?php if ($soa) { ?>
					<label class="title-section mt-4"> SOA </label>
					<div class="soa-bill">
						<div class="d-flex justify-content-between align-items-end">
							<div>
								<b style="color:<?= $soa[0]->status === "Paid" ? '#2ECC71' : '#C0392B' ?>;font-size: 17px;"><?= $soa[0]->status ?></b>
								<p><?= date("F", strtotime("2023-" . $soa[0]->month_of . "-01")) . " " . $soa[0]->year_of ?> </label>

								<p>Due Date: <?= date_format(date_create($soa[0]->due_date), "M d, Y"); ?> </p>
							</div>
							<div class="text-end">
								<label>Total Amount Due</label>
								<h3 class=""> <?= formatPrice($total) ?> </h3>
							</div>
						</div>
						<div class="text-end m-2">
							<a href="<?= WEB_ROOT ?>/view-soa.php?id=<?= $soa[0]->enc_id ?>">View Details</a>
						</div>

						<div class="d-flex gap-3 justify-content-between">
							<button onclick="soa_pdf('<?= $soa[0]->enc_id ?>')" class="main-btn w-50">
								SOA PDF
							</button>
							<?php if ($total > 0) { ?>
								<button onclick="pay_now_('<?= $soa[0]->enc_id ?>')" class="red-btn pay-now w-50">
									Pay now
								</button>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<!-- recent bills payment -->
				<?php if ($soa) { ?>
					<div>
						<div class="pt-5">
							<div class="d-flex justify-content-between align-items-center">
								<label class="title-section"> Payment Transactions </label>
								<?php if ($soa) { ?><a class="see-all" href="payment-list.php">See all</a><?php } ?>
							</div>
							<div>
								<!-- <a href="#"style="font-weight: 600;color:#1c5196;" >Show all ></a> -->
							</div>
						</div>
						<?php if ($soa) { ?>

							<div class="bills-container">
								<?php
								foreach ($soa  as $details) {
									$result =  apiSend('tenant', 'get-list', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $details->id . '"  and not (particular like "%SOA Payment%" and status = "Successful") and particular not like "Balance%"','limit' => 4]);
									$payment = json_decode($result);
									foreach ($payment as $item) {
	
								?>
										<div class="card-box payment">
											<div class="card-container">

												<div class="<?= $item->status === "Invalid" ? "box-red" : ($item->status === "Successful" ? "box-green" : "box-neutral") ?>  ">
													<?= $item->status  ?>
												</div>
												<div>
													<label class="history-date-billing mb-0" style="font-weight: 600; font-size: 13px;"><?= $item->particular ?></label>
												</div>
												<div>
													<label class="date"><?= date("F j, Y g:i A", strtotime($item->transaction_date)) ?></label>
													<p class="payemnt"><?= $item->payment_type ?></p>
												</div>

											</div>
											<div>
												<p class="billing-price <?= $item->status === "Invalid" ? "invalid" : ($item->status === "Successful" ? "successful" : "neutral") ?>   "> <?= formatPrice($item->amount)  ?></p>
											</div>

										</div>
								<?php }
								}; ?>
							</div>
						<?php } else {
							echo " No Payment Transactions";
						} ?>
					</div>
				<?php } ?>

				<?php if ($issue || $wp) { ?>
					<label class="mt-4 mb-0 pb-3" style="font-size: 24px;"></label>
					<label class="title-section mt-5">Recent Requests</label>
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
							$result = apiSend('module', 'get-list', ['table' => 'work_details', 'condition' => 'id="' . $item->work_details_id . '"']);
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
				<label class="title-section mt-4">Service Requests</label>
				<div class="row card-sr">
					<a href="<?= WEB_ROOT ?>/report-issue.php" class="col-6 col-sm-3 p-1">
						<label for="">Report Issue</label>
						<img class="position-relative img-fluid" src="assets/images/unitrepair.png" alt="" style="border-radius: 5px;">
					</a>
					<a href="<?= WEB_ROOT ?>/gatepass.php" class="col-6 col-sm-3 p-1">
						<label for="">Gate Pass</label>
						<img class="position-relative img-fluid" src="assets/images/gatepass.png" alt="" style="border-radius: 5px;">
					</a>
					<a href="<?= WEB_ROOT ?>/visitor.php" class="col-6 col-sm-3 p-1">
						<label for="">Visitor Pass</label>
						<img class="position-relative img-fluid" src="assets/images/visitorspass.png" alt="" style="border-radius: 5px;">
					</a>
					<a href="<?= WEB_ROOT ?>/work-permit-form_new.php" class="col-6 col-sm-3 p-1">
						<label for="">Work Permit</label>
						<img class="position-relative img-fluid" src="assets/images/workpermit.png" alt="" style="border-radius: 5px;">
					</a>

				</div>


				<div class="pb-5">
					<label class="title-section mt-5">News And Announcements</label>
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
		window.open(`<?= WEB_ROOT . "/genpdf.php?display=plain&id=" ?>${id}`, '_blank')
	}
	const payment_ = (id) => {
		window.location.href = `<?= WEB_ROOT ?>/proof-of-payment.php?id=${id}`;
	}
	const pay_now_ = (id) => {
		window.location.href = `<?= WEB_ROOT ?>/payment-method.php?id=${id}`;
	}

	$('.btn-close-visitor').on('click', function() {
		$('.visitor').hide();
	});
</script>