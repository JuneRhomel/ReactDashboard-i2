<?php
// include("footerheader.php");
// $result =  apiSend('tenant', 'get-notification');
// $vp_approved = json_decode($result);
// var_dump($vp_approved)

$result = apiSend('module', 'get-listnew', ['table' => 'system_info']);
$info = json_decode($result);


$result = apiSend('module', 'get-listnew', ['table' => 'notif', 'condition' => 'occupant_id="' . $user->id . '"']);
$notif = json_decode($result);

// var_dump($notif);

$result = apiSend('module', 'get-listnew', ['table' => 'system_info']);
$system_info = json_decode($result);

// var_dump($system_info);

$data = [
	'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);
?>


<nav class="navigation">
	<div class="d-flex align-items-center gap-3">
		<!-- <span class="material-icons menu-btn-nav">
			menu
		</span> -->
		<!-- <span class="material-icons menu-btn-nav burger">
			menu
		</span> -->
		<div class="menu-logo">
			<img src="assets/icon/logo.png" alt="">
		</div>
	</div>
	<div class="d-flex align-items-center gap-1">
		<div class="add-sr">
			<span class="material-icons add-icon">add_circle</span>
		</div>
		<div class="icon notification ">
			<svg width="20" height="25" viewBox="0 0 20 25" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M9.84615 24.312C11.2 24.312 12.3077 23.2043 12.3077 21.8505H7.38462C7.38462 23.2043 8.49231 24.312 9.84615 24.312ZM17.2308 16.9274V10.7736C17.2308 6.99509 15.2246 3.83201 11.6923 2.99509V2.15817C11.6923 1.13663 10.8677 0.312012 9.84615 0.312012C8.82462 0.312012 8 1.13663 8 2.15817V2.99509C4.48 3.83201 2.46154 6.98278 2.46154 10.7736V16.9274L0 19.3889V20.6197H19.6923V19.3889L17.2308 16.9274ZM14.7692 18.1582H4.92308V10.7736C4.92308 7.72124 6.78154 5.23509 9.84615 5.23509C12.9108 5.23509 14.7692 7.72124 14.7692 10.7736V18.1582Z" fill="#1C5196" />
			</svg>
			<!-- 
			<span class="num">12</span> -->
		</div>
	</div>
	<div class="overlay-nav"></div>
	<nav class="navigation-links">
		<div class="bg-nav">
			<div class="overlay"></div>
			<img class="logo-nav" src="assets/icon/Group 2311.png" alt="">
			<img class="bg-img" src="assets/icon/Rectangle 624 1.png">
		</div>
		<ul>
			<!-- <li><a href="http://portali2.sandbox.inventiproptech.com">Home</a></li>
					<li><a href="http://portali2.sandbox.inventiproptech.com/billing.php">SOA <span>3</span></a></li>
					<li><a href="http://portali2.sandbox.inventiproptech.com/my-requests_new.php">My request <span>3</span></a></li>-->
			<?php
			if ($info[0]->ownership === 'HOA') {
				if ($user->type === "Owner" || $user->type === "Unit Owner") { ?>
					<li><a href="http://portali2.sandbox.inventiproptech.com/occupant.php">Occupant </a></li>
					<li><a href="http://portali2.sandbox.inventiproptech.com/occupant-reg.php">Occupant Regstration</a></li>
					<li><a href="http://portali2.sandbox.inventiproptech.com/send-invite.php">Send Invite</a></li>
			<?php }
			} ?>

			<li><a href="http://portali2.sandbox.inventiproptech.com/my-profile_new.php">My Profile</a></li>
		</ul>
		<!-- <div class="select-lang-container">
						<button id="select-lang-btn" class="lang">
								<img src="assets/icon/image 7.png" alt="">
								<div>English</div> 

							<i class="fa-solid fa-caret-down"></i>
						</button>
						<div class="lang-select">
							<div class="selectedLang active"><img src="assets/icon/image 7.png" alt=""> English</div>
							<div class="selectedLang"><img src="assets/icon/phFlag.png" alt=""> Filipino</div>
						
						</div>
				</div> -->
		<div class="nav-btn">

			<div class="d-flex flex-column gap-3">
				<!-- <button class="main-btn">Take Survey</button> -->
				<button class="neutral-btn out">Logout</button>
			</div>
		</div>
		<div class="pb-4" style="display:flex;align-items: end;justify-content: center;height: 20%;">
			<img src="assets/images/navlogo1.png" alt="">
		</div>
	</nav>
</nav>
<div class="menu-notification">
	<div class="overlay-nav-notif"></div>
	<div id="mySidenav" class="sidenav" style="z-index: 99999">
		<div style="padding: 0 24px">
			<label class="notif-heading">Notifications
				<!-- <span>2</span> -->
			</label>
			<div class="bills-container notif">

				<?php foreach ($notif as $item) { ?>
					<div class="card-box blue">
						<div class="card-container">
							<div>
								<img src="assets/images/visitors-icon.png" alt="">
							</div>
							<div>
								<div>
									<label class="mb-0" style="font-weight: 600; font-size: 22px;"><?= $item->title ?></label>
								</div>
								<div>
									<p class="mb-0"><?= $item->description ?></p>
									<span>5 hrs ago</span>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<!-- <div class="card-box blue">
					<div class="card-container ">
						<div>
							<img src="assets/images/visitors-icon.png" alt="">
						</div>
						<div>
							<div>
								<label class="mb-0" style="font-weight: 600; font-size: 22px;">Due date for January 2023 sOA</label>
							</div>
							<div style="line-height: 15px;">
								<p class="mb-0">3 hrs ago</p>
								<span>5 hrs ago</span>
							</div>
						</div>
					</div>
				</div>

				<div class="card-box orange">
					<div class="card-container ">
						<div>
							<img src="assets/images/visitors-icon.png" alt="">
						</div>
						<div>
							<div>
								<label class="mb-0" style="font-weight: 600; font-size: 22px;">9:00 AM Maintenance</label>
							</div>
							<div>
								<p class="mb-0">Repair Request </p>
								<span>5 hrs ago</span>
							</div>
						</div>
					</div>
				</div> -->

			</div>
		</div>
	</div>
</div>

<script>
	$(".sidenav").show()
	$('.out').click(function() {
		window.location.href = 'http://portali2.sandbox.inventiproptech.com/logout.php';
	})
	$(".notification").click(function() {
		$(".sidenav").addClass("show-notf")
		$(".overlay-nav-notif").show()
	})
	$(".overlay-nav-notif").click(function() {
		$(".sidenav").removeClass("show-notf")
		$(".overlay-nav-notif").hide()
	})

	$("#select-lang-btn").click(function() {
		$(".lang-select").slideToggle();
	})


	$(".overlay-nav").click(function() {
		$(".navigation-links").removeClass("show-nav");
		$(".overlay-nav").hide();
	})
	$(".burger").click(function() {
		$(".navigation-links").addClass("show-nav");
		$(".overlay-nav").show();
	})


	$('.btn-close-visitor').on('click', function() {
		$('.visitor').hide();
	})


	$('.add-sr').on('click', function() {
		window.location.href = 'http://portali2.sandbox.inventiproptech.com/service-request.php';
	})
	$('.pay-now').on('click', function() {
		window.location.href = 'http://portali2.sandbox.inventiproptech.com/billing.php';
	})
	$('.follow-up-concern').on('click', function() {
		window.location.href = 'http://portali2.sandbox.inventiproptech.com/my-requests_new.php';
	})
	$(".selectedLang").click(function() {
		$(".selectedLang").removeClass("active");
		$(this).addClass("active");
		var langName = $(this).text().trim();
		var imgSrc = $(this).find("img").attr('src');
		$("#select-lang-btn > div").text(langName);
		$("#select-lang-btn > img").remove();
		$("#select-lang-btn").prepend(`<img src="${imgSrc}" alt="">`);
		$(".lang-select").slideToggle();
	});
</script>