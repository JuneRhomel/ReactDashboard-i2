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

	$providers = get_providers($ots);
	$equipments = get_equipments($ots);
	$personnels = get_personnel($ots);
	$tenants = get_tenants($ots);
?>
<?php
if(!$providers){
	?>
	<div class="alert alert-warning" role="alert">
		Missing Service Provider Data! To Add Provider, <a href= "<?= WEB_ROOT ?>/property-management/serviceprovider?submenuid=serviceproviders">  Click Here</a> or <a href='<?= WEB_ROOT?>/admin/import-service-providers?submenuid=import_service_provider'> Import Here </a>
	</div>
	<?php
}
if(!$equipments){
	?>
	<div class="alert alert-warning" role="alert">
		Missing Equipments Data!  To Add Equipments,  <a href= "<?= WEB_ROOT ?>/property-management/equipment?submenuid=equipment">Click Here</a> or <a href='<?= WEB_ROOT?>/admin/import-equipments?submenuid=import_equipments'> or Import Here </a>
	</div>
	<?php
}
if(!$personnels){
	?>
	<div class="alert alert-warning" role="alert">
		Missing Building Personnel Data! To Add Personnel, <a href= "<?= WEB_ROOT ?>/property-management/equipment?submenuid=equipment"> Click Here</a> or <a href='<?= WEB_ROOT?>/admin/import-personel?submenuid=import_personel'> or Import Here </a>
	</div>
	<?php
}
if(!$tenants){
	?>
	<div class="alert alert-warning" role="alert">
		Missing Tenant Data! To Add Tentant,  <a href= "<?= WEB_ROOT ?>/property-management/equipment?submenuid=equipment"> Click Here</a> or <a href='<?= WEB_ROOT?>/admin/import-tenants?submenuid=import_tenants'> or Import Here </a>
	</div>
	<?php
}
 ?>
<div class="dashboard">
	<!-- ryan -->
	<div class="row align-items-stretch">
		<div class="col-12 col-lg-6 col-xl-6">
			<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
			<div class="col-12 col-lg-6 col-xl-6 mb-2 dashboard-item w-100">
				<div>hello</div>
			</div>
			<div class="col-12 col-lg-6 col-xl-6 mb-2 dashboard-item w-100">
				<div>hello</div>
			</div>
			<div class="col-12 col-lg-6 col-xl-6 mb-2 dashboard-item w-100">
				<div>hello</div>
			</div>
			<div class="col-12 col-lg-6 col-xl-6 mb-2 dashboard-item w-100">
				<div>hello</div>
			</div>
			</div>
		</div>
		<div class="col-12 col-lg-6 col-xl-6">
		<div class="dashboard-item">
				<div class="d-flex justify-content-start flex-wrap" style="width: 100%">
					<div class="col-12">
						<label class="text-required" id ="month-year" style="font-size: 25px;"></label>	
					</div>
					<div>
						<label class="text-required text-primary" style="font-size: 15px;">WORK ITEMS</label>
					</div>
				</div>
				<div class="d-flex gap-3">
					<div class="d-block">
						<button class="btn px-4 my-3 today-btn btn-calendar active-length">Today</button>
						<button class="btn px-3 my-3 weekly-btn btn-calendar">Weekly</button>
						<button class="btn px-3 my-3 monthly-btn btn-calendar">Monthly</button>
					</div>
					<div class="d-block mt-2">
						<label class="text-required date-calendar text-primary" id="date-today" style="font-size: 35px;"> </label>
						<label class="text-required month-calendar text-primary" id="month-today" style="font-size: 10px;"> </label>
					</div>
					<div class="col-12 col-lg-4 col-xl-4 mt-3">
						<div>
							<div>
								<label class="text-required">Check open work order</label>
							</div>
							<div>
								<label class="text-required px-3 time-calendar">10:00 AM - 12:00 PM</label>
							</div>
							<hr class="my-2" style="opacity: .10;"/>
							<div>
								<label class="text-required">Check BM verification</label>
							</div>
							<div>
								<label class="text-required px-3 time-calendar">1:00 PM - 2:00 PM</label>
							</div>
							<hr class="my-2" style="opacity: .10;"/>
							<div>
								<label class="text-required">Check aging work orders</label>
							</div>
							<div>
								<label class="text-required px-3 time-calendar">3:00 PM - 3:45 PM</label>
							</div>
							<hr class="my-2" style="opacity: .10;"/>
							<div>
								<label class="text-required">Check SR for approval</label>
							</div>
							<div>
								<label class="text-required px-3 time-calendar">4:00 PM - 5:00 PM</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ryan -->
	<div class="row">
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
		<div class="col-12 col-sm-3" style="width: 50%">
			<div class="dashboard-item">
				<div class="d-flex justify-content-start flex-wrap" style="width: 100%">
					<div class="col-12">
						<label class="text-required" id ="month-year" style="font-size: 25px;"></label>	
					</div>
					<div>
						<label class="text-required text-primary" style="font-size: 15px;">WORK ITEMS</label>
					</div>
				</div>
				<div class="d-flex gap-3">
					<div class="d-block">
						<button class="btn px-4 my-3 today-btn btn-calendar active-length">Today</button>
						<button class="btn px-3 my-3 weekly-btn btn-calendar">Weekly</button>
						<button class="btn px-3 my-3 monthly-btn btn-calendar">Monthly</button>
					</div>
					<div class="d-block mt-2">
						<label class="text-required date-calendar text-primary" id="date-today" style="font-size: 35px;"> </label>
						<label class="text-required month-calendar text-primary" id="month-today" style="font-size: 10px;"> </label>
					</div>
					<div class="col-12 col-lg-4 col-xl-4 mt-3">
						<div>
							<div>
								<label class="text-required">Check open work order</label>
							</div>
							<div>
								<label class="text-required px-3 time-calendar">10:00 AM - 12:00 PM</label>
							</div>
							<hr class="my-2" style="opacity: .10;"/>
							<div>
								<label class="text-required">Check BM verification</label>
							</div>
							<div>
								<label class="text-required px-3 time-calendar">1:00 PM - 2:00 PM</label>
							</div>
							<hr class="my-2" style="opacity: .10;"/>
							<div>
								<label class="text-required">Check aging work orders</label>
							</div>
							<div>
								<label class="text-required px-3 time-calendar">3:00 PM - 3:45 PM</label>
							</div>
							<hr class="my-2" style="opacity: .10;"/>
							<div>
								<label class="text-required">Check SR for approval</label>
							</div>
							<div>
								<label class="text-required px-3 time-calendar">4:00 PM - 5:00 PM</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-12 col-sm-3">
			<div class="dashboard-item">
				<div class="dashboard-content" style="color:#34495E;font-size:2em;text-align:center">
					<a href="/tenant/turnovers?submenuid=turnover"><?=number_format($turnovers['cnt'],0);?></a>
				</div>
				<div class="dashboard-footer" style="color:#34495E;text-align:center"><span class="fa fa-dashboard"></span> Turnovers</div>
				<canvas id="dashboardChart" width="400" height="400"></canvas>
			</div>
		</div>
		<div class="col-12 col-sm-3">
			<div class="dashboard-item">
				<div class="dashboard-content" style="color:#34495E;font-size:2em;text-align:center">
					<a href="/tenant/punchlists?submenuid=punchlist"><?=number_format($punchlists['cnt'],0);?></a>
				</div>
				<div class="dashboard-footer" style="color:#34495E;text-align:center"><span class="fa fa-dashboard"></span>  Punch List</div>
			</div>
		</div>
		<div class="col-12 col-sm-3">
			<div class="dashboard-item">
				<div class="dashboard-content" style="color:#34495E;font-size:2em;text-align:center">
					<a href="/tenant/movements?submenuid=moveio"><?=number_format($movements['cnt'],0);?></a>
				</div>
				<div class="dashboard-footer" style="color:#34495E;text-align:center"><span class="fa fa-dashboard"></span>  Movement</div>
			</div>
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-12 col-sm-3">
			<div class="dashboard-item">
				<div class="dashboard-content" style="color:#34495E;font-size:2em;text-align:center">
					<a href="/gatepass?submenuid=gatepass"><?=number_format($gatepasses['cnt'],0);?></a>
				</div>
				<div class="dashboard-footer" style="color:#34495E;text-align:center"><span class="fa fa-dashboard"></span> Gate Pass</div>
			</div>
		</div>
		<div class="col-12 col-sm-3">
			<div class="dashboard-item">
				<div class="dashboard-content" style="color:#34495E;font-size:2em;text-align:center">
					<a href="/servicerequest?submenuid=servicerequest"><?=number_format($servicerequests['cnt'],0);?></a>
				</div>
				<div class="dashboard-footer" style="color:#34495E;text-align:center"><span class="fa fa-dashboard"></span>  Service Request</div>
			</div>
		</div>
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
						<?php foreach($gatepass as $pass):?>
							<tr>
								<td><?=$pass['category'];?></td>
								<td><?=$pass['arrival_date'];?></td>
								<td><?=$pass['item_description'];?></td>
								<td><?=$pass['tenant_name'];?></td>
							</tr>
						<?php endforeach;?>
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
						<?php foreach($servicerequests as $servicerequest):?>
							<tr>
								<td><?=$servicerequest['sr_type'];?></td>
								<td><?=$servicerequest['details'];?></td>
								<td><?=$servicerequest['tenant_name'];?></td>
								<td><?=$servicerequest['location_name'];?></td>
								<td><?=$servicerequest['status'];?></td>
							</tr>
						<?php endforeach;?>
					</table>
				</div>
			</div>
		</div> -->
	</div>
</div>
<script>

var dateObj = new Date();
var day = dateObj.getUTCDate();
var monthShort = dateObj.toLocaleString('en-US', { month: 'short' });
var monthLong = dateObj.toLocaleString('en-US', { month: 'long', year: 'numeric' });
document.getElementById("date-today").innerHTML = day;
document.getElementById("month-today").innerHTML = monthShort;
document.getElementById("month-year").innerHTML = monthLong;

		$('.today-btn').on('click', function(e) {
			$(".today-btn").addClass('active-length');
            $(".weekly-btn").removeClass('active-length');
            $(".monthly-btn").removeClass('active-length');
		});

        $('.weekly-btn').on('click', function(e) {
			$(".weekly-btn").addClass('active-length');
            $(".today-btn").removeClass('active-length');
            $(".monthly-btn").removeClass('active-length');
		});

		$('.monthly-btn').on('click', function(e) {
			$(".monthly-btn").addClass('active-length');
            $(".today-btn").removeClass('active-length');
            $(".weekly-btn").removeClass('active-length');
		});

		var ctx = document.getElementById("dashboardChart");
    var dashboardChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Red", "Orange", "Green"],
            datasets: [{
                label: '# of Votes',
                data: [33, 33, 33],
                backgroundColor: [
                    'rgba(231, 76, 60, 1)',
                    'rgba(255, 164, 46, 1)',
                    'rgba(46, 204, 113, 1)'
                ],
                borderColor: [
                    'rgba(255, 255, 255 ,1)',
                    'rgba(255, 255, 255 ,1)',
                    'rgba(255, 255, 255 ,1)'
                ],
                borderWidth: 5
            }]

        },
        options: {
            rotation: 1 * Math.PI,
            circumference: 1 * Math.PI,
            legend: {
                display: false
            },
            tooltip: {
                enabled: false
            },
            cutoutPercentage: 95
        }
    });

var ctx = document.getElementById('water-bar-chart').getContext('2d');
var waterbarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November'],
        datasets: [{
            label: "2020",
            data: [12, 19, 3, 5, 2, 3, 2, 5, 17, 15, 13],
            backgroundColor: [
                'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
				'rgba(25, 175, 145)',
				'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
				'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
				'rgba(25, 175, 145)',
            ],
        }, {
            label: "2021",
            data: [2, 9, 13, 15, 12, 13, 12, 15, 7, 5, 17],
            backgroundColor: [
                'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
				'rgba(255, 243, 133)',
				'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
				'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
				'rgba(255, 243, 133)',
            ],
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var ctx = document.getElementById('electricity-bar-chart').getContext('2d');
var electricitybarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November'],
        datasets: [{
            label: "2020",
            data: [9, 9, 13, 15, 12, 13, 10, 3, 12, 8, 6],
            backgroundColor: [
                'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
				'rgba(25, 175, 145)',
				'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
				'rgba(25, 175, 145)',
                'rgba(25, 175, 145)',
				'rgba(25, 175, 145)',
            ],
        }, {
            label: "2021",
            data: [17, 3, 5, 12, 8, 4, 5, 17, 12, 9, 12],
            backgroundColor: [
                'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
				'rgba(255, 243, 133)',
				'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
				'rgba(255, 243, 133)',
                'rgba(255, 243, 133)',
				'rgba(255, 243, 133)',
            ],
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
