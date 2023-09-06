<?php
// $revenue_result = $ots->execute('billing','get-month-revenue',[]);
// $revenue = json_decode($revenue_result,true);

// $unpaid_result = $ots->execute('billing','get-unpaid',[]);
// $unpaid = json_decode($unpaid_result,true);

// $overdue_result = $ots->execute('billing','get-overdue',[]);
// $overdue = json_decode($overdue_result,true);

// $gatepass_result = $ots->execute('gatepass','get-open-gatepasses',[]);
// $gatepass = json_decode($gatepass_result,true);

// $servicerequest_result = $ots->execute('servicerequest','get-open-servicerequests',[]);
// $servicerequests = json_decode($servicerequest_result,true);

// $turnovers = json_decode($ots->execute('module','get-count',[ "view"=>"view_tenant_turnovers" ]),true);
// $punchlists = json_decode($ots->execute('module','get-count',[ "view"=>"view_tenant_punchlists" ]),true);
// $movements = json_decode($ots->execute('module','get-count',[ "view"=>"view_tenant_movements" ]),true);
// $gatepasses = json_decode($ots->execute('module','get-count',[ "view"=>"view_gatepass" ]),true);
// $servicerequests = json_decode($ots->execute('module','get-count',[ "view"=>"view_servicerequests" ]),true);

//$providers = get_providers($ots);
//$equipments = get_equipments($ots);
//$personnels = get_personnel($ots);
//$tenants = get_tenants($ots);
?>
<div class="main-container">
	<?php
	if (!$providers) {
	?>
		<!-- <div class="alert clearfix alert1 alert-warning alert-dismissible fade show" role="alert">
			Missing Service Provider Data! To Add Provider, <a href="<?= WEB_ROOT ?>/property-management/serviceprovider?submenuid=serviceproviders"> Click Here</a> or <a href='<?= WEB_ROOT ?>/admin/import-service-providers?submenuid=import_service_provider'> Import Here </a>
			<div style="float:right" class="border">
				<button class="btn btn-sm" onclick="hidealert('alert1')"><i class="bi bi-x-lg"></i></button>
			</div>
		</div> -->
	<?php
	}
	if (!$equipments) {
	?>
		<!-- <div class="alert clearfix alert-warning alert2 alert-dismissible fade show" role="alert">
			Missing Equipments Data! To Add Equipments, <a href="<?= WEB_ROOT ?>/property-management/equipment?submenuid=equipment">Click Here</a> or <a href='<?= WEB_ROOT ?>/admin/import-equipments?submenuid=import_equipments'> or Import Here </a>
			<div style="float:right" class="border">
				<button class="btn btn-sm" onclick="hidealert('alert2')"><i class="bi bi-x-lg"></i></button>
			</div>
		</div> -->
	<?php
	}
	if (!$personnels) {
	?>
		<!-- <div class="alert clearfix alert-warning alert3 alert-dismissible fade show" role="alert">
			Missing Building Personnel Data! To Add Personnel, <a href="<?= WEB_ROOT ?>/property-management/equipment?submenuid=equipment"> Click Here</a> or <a href='<?= WEB_ROOT ?>/admin/import-personel?submenuid=import_personel'> or Import Here </a>
			<div style="float:right" class="border">
				<button class="btn btn-sm" onclick="hidealert('alert3')"><i class="bi bi-x-lg"></i></button>
			</div>
		</div> -->
	<?php
	}
	if (!$tenants) {
	?>
		<!-- <div class="alert clearfix alert-warning alert4 alert-dismissible fade show" role="alert">
			Missing Tenant Data! To Add Tentant, <a href="<?= WEB_ROOT ?>/property-management/equipment?submenuid=equipment"> Click Here</a> or <a href='<?= WEB_ROOT ?>/admin/import-tenants?submenuid=import_tenants'> or Import Here </a>
			<div style="float:right" class="border">
				<button class="btn btn-sm" onclick="hidealert('alert4')"><i class="bi bi-x-lg"></i></button>
			</div>
		</div> -->
	<?php
	}


	?>
	<div class="dashboard">
		<!-- ryan -->
		<div class="d-flex flex-column flex-lg-row w-100 gap-4">
			<?php include(__DIR__ . "/tenant-requests-dashboard.php"); ?>
			<?php include(__DIR__ . "/service-requests.php"); ?>

		</div>
		<!-- <div class=" mt-3">
			<?php include(__DIR__ . "/equipment-uptime.php"); ?>
		</div> -->
		<div class="row align-items-stretch mt-3 ">
			<div class="col-12 col-sm-12 col-lg-6 dashboard-widget-left">
				<div class="dashboard-item ">
					<?php include(__DIR__ . "/monthly-collection.php"); ?>
				</div>
			</div>
			<div class="col-12 col-sm-3 col-lg-6 dashboard-widget-right">
				<div class="dashboard-item">
					<?php include(__DIR__ . "/ytd-collection.php"); ?>
				</div>
			</div>
		</div>

		<!-- <div class="row align-items-stretch mt-3 ">
			<div class="col-12 col-sm-12 col-lg-6 pb-2 dashboard-widget-left">
				<div class="dashboard-item" style="height:auto">
					<?php //include(__DIR__ . "/kpi-indicator-left.php"); ?>
				</div>
			</div>
			<div class="col-12 col-sm-3 col-lg-6 pb-2 dashboard-widget-right">
				<div class="dashboard-item" style="height:auto">
					<?php //include(__DIR__ . "/kpi-indicator-right.php"); ?>
				</div>
			</div>
		</div> -->

		<div class="row align-items-stretch mt-3 ">
			<div class="col-12 col-sm-12 col-lg-6 dashboard-widget-left">
				<div class="dashboard-item ">
					<?php include(__DIR__ . "/water-monitoring.php"); ?>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-lg-6 dashboard-widget-right">
				<div class="dashboard-item">
					<?php include(__DIR__ . "/elect-monitoring.php"); ?>
				</div>
			</div>
			<div class="col-12 mt-3">
					<?php include(__DIR__ . "/news-announcement.php"); ?>
			</div>
		</div>
		<!-- ryan -->
		<!-- <div class="row mt-5">
		<div class="col-12 col-sm-3">
			<div class="dashboard-item">
				<div class="d-flex">
					<div class="dashboard-footer" style="color:#34495E;text-align:center"><span class="fa fa-dashboard"></span> <label class="text-required" style="font-size: 20px;">Water Monitoring</label></div>
				</div>
				<canvas id="water-bar-chart" width="100%" height="100%"></canvas>
			</div>
		</div>
		<div class="col-12 col-sm-3">
			<div class="dashboard-item" width="100%">
				<div class="d-flex">
					<div class="dashboard-footer" style="color:#34495E;text-align:center"><span class="fa fa-dashboard"></span><label class="text-required" style="font-size: 20px;">Electricity Monitoring</label></div>
				</div>
				<canvas id="electricity-bar-chart" width="100%" height="100%"></canvas>
			</div>
		</div>
	</div> -->
		<!-- <div class="row mt-5">
		<div class="col-12 col-sm-3">
			<div class="dashboard-item">
				<div class="dashboard-content" style="color:#34495E;font-size:2em;text-align:center"> -->
		<!-- <a href="/tenant/turnovers?submenuid=turnover"><?= number_format($turnovers['cnt'], 0); ?></a> -->
		<!-- </div>
				<div class="dashboard-footer" style="color:#34495E;text-align:center"><span class="fa fa-dashboard"></span> Turnovers</div>
				<div class="d-flex">
                    <div class="mt-4" style="height:12vh; width:7vw">
                        <canvas id="service-request"></canvas>
                    </div>
                    <div class="mt-4" style="height:12vh; width:7vw">
                        <canvas id="equipment-availability"></canvas>
                    </div>
                    <div class="mt-4" style="height:12vh; width:7vw">
                        <canvas id="collections-efficiency"></canvas>
                    </div>
				</div>
			</div>
		</div> -->
		<!-- <div class="col-12 col-sm-3">
			<div class="dashboard-item">
				<div class="d-flex">
                    <div class="mt-4" style="height:12vh; width:6vw">
                        <canvas id="contracts"></canvas>
                    </div>
                    <div class="mt-4" style="height:12vh; width:6vw">
                        <canvas id="operational-expenditure"></canvas>
                    </div>
                    <div class="mt-4" style="height:12vh; width:6vw">
                        <canvas id="legal-regulatory"></canvas>
                    </div>
				</div>
			</div>
		</div> -->
		<!-- <div class="col-12 col-sm-3">
			<div class="dashboard-item">
				<div class="dashboard-content" style="color:#34495E;font-size:2em;text-align:center">
					<a href="/tenant/movements?submenuid=moveio"><?= number_format($movements['cnt'], 0); ?></a>
				</div>
				<div class="dashboard-footer" style="color:#34495E;text-align:center"><span class="fa fa-dashboard"></span>  Movement</div>
			</div>
		</div> -->
	</div>

	<!-- <div class="row mt-5">
		<div class="col-6">
			<div class="dashboard-item">
				<div class="dashboard-title" style="text-align:left">Gate Pass</div>
				<div class="dashboard-contenta" style="text-align:left">
					<table class="table">
						<thead>
							<tr>
								<th>Category</th>
								<th>Date</th>
								<th>Description</th>
								<th>Tenant</th>
							</tr>
						</thead>
						<?php foreach ($gatepass as $pass) : ?>
							<tr>
								<td><?= $pass['category']; ?></td>
								<td><?= $pass['arrival_date']; ?></td>
								<td><?= $pass['item_description']; ?></td>
								<td><?= $pass['tenant_name']; ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="dashboard-item">
				<div class="dashboard-title" style="text-align:left">Service Requests</div>
				<div class="dashboard-contenta" style="text-align:left">
					<table class="table">
						<thead>
							<tr>
								<th>Category</th>
								<th>Description</th>
								<th>Tenant</th>
								<th>Location</th>
								<th>Status</th>
							</tr>
						</thead>
						<?php foreach ($servicerequests as $servicerequest) : ?>
							<tr>
								<td><?= $servicerequest['sr_type']; ?></td>
								<td><?= $servicerequest['details']; ?></td>
								<td><?= $servicerequest['tenant_name']; ?></td>
								<td><?= $servicerequest['location_name']; ?></td>
								<td><?= $servicerequest['status']; ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
		</div> -->
</div>
</div>
</div>
<script>

	// var dateObj = new Date();
	// var day = dateObj.getUTCDate();
	// var monthShort = dateObj.toLocaleString('en-US', {
	// 	month: 'short'
	// });
	// var monthLong = dateObj.toLocaleString('en-US', {
	// 	month: 'long',
	// 	year: 'numeric'
	// });
	// document.getElementById("date-today").innerHTML = day;
	// document.getElementById("month-today").innerHTML = monthShort;
	// document.getElementById("month-year").innerHTML = monthLong;

	// $('.today-btn').on('click', function(e) {
	// 	$(".today-btn").addClass('active-length');
	// 	$(".weekly-btn").removeClass('active-length');
	// 	$(".monthly-btn").removeClass('active-length');
	// });

	// $('.weekly-btn').on('click', function(e) {
	// 	$(".weekly-btn").addClass('active-length');
	// 	$(".today-btn").removeClass('active-length');
	// 	$(".monthly-btn").removeClass('active-length');
	// });

	// $('.monthly-btn').on('click', function(e) {
	// 	$(".monthly-btn").addClass('active-length');
	// 	$(".today-btn").removeClass('active-length');
	// 	$(".weekly-btn").removeClass('active-length');
	// });


	// $(document).ready(function() {
	// 	$('#myalert').on('click', function() {
	// 		alert('test');
	// 	});
	// });

	// function hidealert(alertclass) {
	// 	$('.' + alertclass).hide();
	// }
</script>