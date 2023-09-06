<?php
$title = "Service Request Summary";
$module = "tenant";
$table = "service_request";
$view = "view_service_request";

$filters = [
	array(
		'field' => 'renewable',
		'label' => 'Renewable',
		'filterval' => array(
			'yes',
			'no'
		)
	)
];
$fields = rawurlencode(json_encode(["ID" => "id", "Contracts Name" => "contract_name", "Contract_number" => "contract_number"]));

//PERMISSIONS
//get user role
$data = [
	'view' => 'users'
];
$user = $ots->execute('property-management', 'get-record', $data);
$user = json_decode($user);

//check if has access
$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);
// var_dump($role_access);
?>
<div class="main-container">
	<?php if ($role_access->read != true) : ?>
		<div class="card mx-auto" style="max-width: 30rem;">
			<div class="card-header bg-danger">
				Unauthorized access
			</div>
			<div class="card-body text-center">
				You are not allowed to access this resource. Please check with system administrator.
			</div>
		</div>
	<?php else : ?>
		
		<div class="gap-4 my-5 align-items-center py-4 billing-rates" style="border-top: 1px solid #B4B4B4; border-bottom: 1px solid #B4B4B4;">
			<label for="" class="text-required mb-2">Choose month to filter all workorders.</label>
			<div class="row">
				<div class="col-12 col-sm-3 col-lg-3 col-xl-3">
					<div class="form-group">
						<label for="" class="text-required">Month</label>
						<select name="month_select" id='month_select' class='form-select'>
							<option value="01" <?= (date('m') == '01') ? 'selected' : '' ?>>January</option>
							<option value="02" <?= (date('m') == '02') ? 'selected' : '' ?>>February</option>
							<option value="03" <?= (date('m') == '03') ? 'selected' : '' ?>>March</option>
							<option value="04" <?= (date('m') == '04') ? 'selected' : '' ?>>April</option>
							<option value="05" <?= (date('m') == '05') ? 'selected' : '' ?>>May</option>
							<option value="06" <?= (date('m') == '06') ? 'selected' : '' ?>>June</option>
							<option value="07" <?= (date('m') == '07') ? 'selected' : '' ?>>July</option>
							<option value="08" <?= (date('m') == '08') ? 'selected' : '' ?>>August</option>
							<option value="09" <?= (date('m') == '09') ? 'selected' : '' ?>>September</option>
							<option value="10" <?= (date('m') == '10') ? 'selected' : '' ?>>October</option>
							<option value="11" <?= (date('m') == '11') ? 'selected' : '' ?>>November</option>
							<option value="12" <?= (date('m') == '12') ? 'selected' : '' ?>>December</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-sm-3 col-lg-3 col-xl-3">

					<div class="form-group">
						<label for="" class="text-required">Year</label>
						<select name="" class="form-select" id="year_dropdown" required>
							<option value="">--Please Select Year--</option>
							<?php
							$firstYear = (int)date('Y') - 2;
							$lastYear = (int)date('Y');
							for ($i = $firstYear; $i <= $lastYear; $i++) { ?>
								<option value="<?= $i ?>" <?= ($i == date('Y')) ? 'selected' : '' ?>><?= $i ?></option>;
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-12 col-sm-4 mt-3">
					<div class="form-group">
						<button type="submit" class="btn btn-dark btn-primary px-5">Enter</button>
					</div>
				</div>
			</div>
		</div>

		<!-- <div class="d-flex justify-content-between mb-2">
			<div class="d-flex align-items-end">
				<label class="text-label-result px-3 mb-0" id="search-result">

				</label>
			</div>
		</div> -->

		<div class="d-flex">
			<button class="btn tabs-table all-btn active1" onclick="status('all')">All</button>
			<button class="btn tabs-table open-btn" onclick="status('open')">Open</button>
			<!-- <button class="btn tabs-table aging-btn">Aging</button> -->
			<button class="btn tabs-table closed-btn" onclick="status('closed')">Closed</button>
		</div>
		<div class=" pb-2 px-2 pt-0 rounded">
			<!-- <button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-download">Download <i class="bi bi-download"></i></button> -->
			<div class="d-flex flex-wrap align-items-center justify-content-between py-2">
			</div>

			<div class="container-table" style="background-color:#F6F6F6">
				<div class="dropdown-menu-filter dropdown-menu " style="width: 22%" id="dropdownmenufilter">
					<div class="dropdown-menu-filter-fields"></div>

					<div class="btn-group-buttons mt-3">
						<div class="d-flex justify-content-between  mb-3 gap-2" style="padding: 5px;">

							<button class="btn-close-now btn btn-light btn-cancel">Close</button>
							<div>
								<button class="btn-reset-now btn-cancel btn mx-2">Reset</button>
								<button type="button" class="btn btn-dark btn-primary btn-filter-now px-5">Filter</button>
							</div>
						</div>
					</div>
				</div>
				<table id="jsdata"></table>
			</div>
		</div>

		<div class="mt-5" style="border-top: 1px solid rgb(180,180,180, .3); border-bottom: 1px solid rgb(180,180,180, .3)">
			<label class="text-required my-4" style="font-size: 20px;">Ticket Summary</label>
			<div class="gap-4 align-items-center mb-5">
				<label for="" class="text-required mb-2">Date</label>
				<div class="row">
					<div class="col-12 col-lg-3 col-xl-3">

						<div class="form-group">
							<label for="" class="text-required">From</label>
							<input type="date" class="form-control" id="from">
						</div>
					</div>
					<div class="col-12 col-lg-3 col-xl-3">
						<div class="form-group">
							<label for="" class="text-required">To</label>
							<input type="date" class="form-control" id="to">
						</div>
					</div>
					<div class="col-12 col-lg-3 col-xl-3 mt-3">
						<div class="form-group">

							<button type="submit" class="btn btn-dark btn-primary px-5">Show</button>
						</div>
					</div>
				</div>
			</div>
			<div class="report-chart">
				<table class="table " style="box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);">
					<thead class="header-design" style="border-bottom: 1px solid #FFFFFF">
						<tr class="text-center">
							<th style="width:auto">Category</th>
							<th colspan="3" style="width:auto">October 1</th>
							<th colspan="3" style="width:auto">October 2</th>
							<th colspan="3" style="width:auto">October 3</th>
							<th colspan="3" style="width:auto">October 4</th>
							<th colspan="3" style="width:auto">Overall Total</th>
						</tr>
					</thead>
					<thead class="header-design">
						<tr>
							<th style="width:auto"></th>
							<th scope="col" style="width:auto">Open</th>
							<th scope="col" style="width:auto">Aging</th>
							<th scope="col" style="width:auto">Closed</th>

							<th scope="col" style="width:auto">Open</th>
							<th scope="col" style="width:auto">Aging</th>
							<th scope="col" style="width:auto">Closed</th>

							<th scope="col" style="width:auto">Open</th>
							<th scope="col" style="width:auto">Aging</th>
							<th scope="col" style="width:auto">Closed</th>

							<th scope="col" style="width:auto">Open</th>
							<th scope="col" style="width:auto">Aging</th>
							<th scope="col" style="width:auto">Closed</th>

							<th scope="col" style="width:auto">Open</th>
							<th scope="col" style="width:auto">Aging</th>
							<th scope="col" style="width:auto">Closed</th>
						</tr>
					</thead>

					<?php foreach ($categories as $category) : ?>
						<tr>
							<td scope="col" style="width:auto" class="text-nowrap"><input type="checkbox"> <label class="text-required"><?= $category; ?></td>
							<td scope="col" style="width:auto">
								<label class="text-required">
									<?= $kwhrprevYear ?>
									<?php
									$kwhr_prev_year = $kwhr_prev_year + $kwhrprevYear;
									?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required">
									<?= $kwhrcurrYear ?>
									<?php
									$kwhr = $kwhr + $kwhrcurrYear;
									?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required">
									<?= $kwhr_prev_curr ?>
									<?php
									$kwhrprevcurr = $kwhrprevcurr + $kwhr_prev_curr;
									?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"> <?= round((($electric_consumption['kwhr_consumption'][date('Y') - 1] - $electric_consumption['kwhr_consumption'][date('Y')]) / $electric_consumption['kwhr_consumption'][date('Y') - 1]) * 100) ?>%
							</td>

							<td scope="col" style="width:auto">
								<label class="text-required"><?= $electric_consumption['electric_billing'][date('Y') - 1] ?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"><?= $electric_consumption['electric_billing'][date('Y')] ?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"> <?= $electric_consumption['electric_billing'][date('Y') - 1] - $electric_consumption['electric_billing'][date('Y')] ?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"><label class="text-required"> <?= round((($electric_consumption['electric_billing'][date('Y') - 1] - $electric_consumption['electric_billing'][date('Y')]) / $electric_consumption['electric_billing'][date('Y') - 1]) * 100) ?>%
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"><?= round($electric_consumption['meralco_rate'][date('Y') - 1]) ?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"><?= round($electric_consumption['meralco_rate'][date('Y')]) ?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"> <?= round($electric_consumption['meralco_rate'][date('Y') - 1] - $electric_consumption['meralco_rate'][date('Y')]) ?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"> <?= round((($electric_consumption['meralco_rate'][date('Y') - 1] - $electric_consumption['meralco_rate'][date('Y')]) / $electric_consumption['meralco_rate'][date('Y') - 1]) * 100) ?>%
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"><?= round($electric_consumption['meralco_rate'][date('Y')]) ?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"> <?= round($electric_consumption['meralco_rate'][date('Y') - 1] - $electric_consumption['meralco_rate'][date('Y')]) ?>
							</td>
							<td scope="col" style="width:auto">
								<label class="text-required"> <?= round((($electric_consumption['meralco_rate'][date('Y') - 1] - $electric_consumption['meralco_rate'][date('Y')]) / $electric_consumption['meralco_rate'][date('Y') - 1]) * 100) ?>%
							</td>
						</tr>

					<?php endforeach; ?>

					<tr class="tr-ytd">
						<td scope="col" style="width:auto" class="text-nowrap"><label class="text-required">Total</td>
						<td scope="col" style="width:auto">
							<label class="text-required"><?= $kwhr_prev_year ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"><?= $kwhr ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"> <?= $kwhrcurrYear ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required" style="color: #1C5196"> <?= ($collected / $collectibles) * 100 ?>%
						</td>

						<td scope="col" style="width:auto">
							<?php $collectible = 1000000; ?>
							<?php echo '1,000,000'; ?>
							<?php $collectibles += $collectible; ?>
						</td>
						<td scope="col" style="width:auto">
							<?php foreach ($bills as $bill) : ?>
								<?php if ($bill->month == date('m', strtotime($month)) && $bill->year == '2022') : ?>
									<?php $amount = $bill->assoc + $bill->elec + $bill->water; ?>
									<?= number_format($amount, 2); ?>
									<?php $unpaid += $amount; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required" style="color: #1C5196"> <?= ($collected / $collectibles) * 100 ?>%
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required" style="color: #1C5196"> <?= ($collected / $collectibles) * 100 ?>%
						</td>
						<td scope="col" style="width:auto">
							<?php foreach ($bills as $bill) : ?>
								<?php if ($bill->month == date('m', strtotime($month)) && $bill->year == '2022') : ?>
									<?php $amount = $bill->assoc + $bill->elec + $bill->water; ?>
									<?= number_format($amount, 2); ?>
									<?php $unpaid += $amount; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required" style="color: #1C5196"> <?= ($collected / $collectibles) * 100 ?>%
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required" style="color: #1C5196"> <?= ($collected / $collectibles) * 100 ?>%
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required" style="color: #1C5196"> <?= ($collected / $collectibles) * 100 ?>%
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required" style="color: #1C5196"> <?= ($collected / $collectibles) * 100 ?>%
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required" style="color: #1C5196"> <?= ($collected / $collectibles) * 100 ?>%
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required" style="color: #1C5196"> <?= ($collected / $collectibles) * 100 ?>%
						</td>
					</tr>
				</table>
			</div>

		</div>

		<div class="row align-items-stretch mt-5 ">
			<div class="col-12 col-sm-12 col-lg-6 ">
				<div class="dashboard-item ">
					<div class="dashboard-footer" style="color:#34495E;text-align:left"><span class="fa fa-dashboard"></span>
						<label class="text-required" style="font-size: 20px;">Work Order Ticket Summary</label>
					</div>
					<div class="text-center" style="width:100%">
						<canvas id="work-order-chart"></canvas>
					</div>
					<div class="dashboard-footer text-center" style="color:#34495E;text-align:left"><span class="fa fa-dashboard"></span>
						<label class="text-required" style="font-size: 15px;">Months</label>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-12 col-lg-6">
				<div class="dashboard-item" style="height:400px">

					<div class="dashboard-footer" style="color:#34495E;text-align:left"><span class="fa fa-dashboard"></span> <label class="text-required" style="font-size: 20px;">SLA Score</label></div>
					<div class="row">
						<div class="col-4">
							<div class="d-flex flex-column">
								<div class="d-flex gap-2 mt-5">
									<div class="">
										<span><i class="bi bi-circle-fill" style="color:#6098E2"></i></span>
									</div>
									<div>
										<label style="color:#1C5196">TOTAL NUMBER OF TICKETS</label>
										<p>8 Tickets</p>
									</div>
								</div>
								<div class="d-flex gap-2">
									<div class="">
										<span><i class="bi bi-circle-fill" style="color:#19AF91"></i></span>
									</div>
									<div>
										<label style="color:#1C5196">OPEN</label>
										<p>7</p>
									</div>
								</div>
								<div class="d-flex gap-2">
									<div class="">
										<span><i class="bi bi-circle-fill" style="color:#FFF385"></i></span>
									</div>
									<div>
										<label style="color:#1C5196">CLOSED</label>
										<p>1</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-8">
							<div class="" id="donut_single" style="width:350px;height:300px;padding:0!important"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
	google.charts.load('current', {
		'packages': ['corechart']
	});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

		var data = google.visualization.arrayToDataTable([
			['Effort', 'Amount given'],
			['My all', 90],
			['My all', 10],
			['My all', 10],
		]);

		var options = {
			pieHole: 0.5,
			pieSliceTextStyle: {
				color: 'black',
			},
			legend: 'none'
		};

		var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
		chart.draw(data, options);
	}

	var ctx = document.getElementById('work-order-chart').getContext('2d');
	var workOrderChart = new Chart(ctx, {
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
	// function show_renew_modal(button_data){
	// 	id = $(button_data).attr('id');
	// 	$('#renew').modal('show');
	// 	$('#renew .modal-title').html($(button_data).attr('title'));
	// 	$('#renew .modal-body input#renew_id').val(id);
	// }

	<?php $unique_id = $module . time(); ?>
	var t<?= $unique_id; ?>;
	$(document).ready(function() {
		$('#form-renew').submit(function(e) {

			e.preventDefault();
			$.post({
				url: '<?= WEB_ROOT ?>/tenant/renew-permits?display=plain',
				data: {
					input: 12
				},
				success: function(result) {
					result = JSON.parse(result);
					if (result.success == 1) {
						location.reload();
					}
				}
			});

		});


		$("#filterby").on('change', function() {
			getFilter();
		});

		$(".btn-filter").on('click', function() {
			filterby = $("#filterby option:selected").val();
			filtertxt = $("#filtertxt").val();
			t<?= $unique_id; ?>.options.colFilter[filterby] = filtertxt;
			t<?= $unique_id; ?>.ajax.reload();
		});

		$(".btn-reset").on('click', function() {
			filterby = $("#filterby option:selected").val();
			$("#filtertxt").val('');
			delete t<?= $unique_id; ?>.options.colFilter[filterby];
			t<?= $unique_id; ?>.ajax.reload();
		});

		t<?= $unique_id; ?> = $("#jsdata").JSDataList({
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			ajax: {
				url: "<?= WEB_ROOT . "/module/get-list/{$view}?display=plain" ?>"
			},
			buttons: [
				// {
				// 	icon: `<span class="material-symbols-outlined">add</span>`,
				// 	title: " Create New",
				// 	class: "btn-add btn-blue",
				// 	id: "edit",
				// },
				// {
				// 	icon: `<span class="material-symbols-outlined">delete</span>`,
				// 	title: "Delete",
				// 	class: "btn-delete-filter",
				// 	id: "delete",
				// },
				{
					icon: `<span class="material-symbols-outlined">arrow_downward</span>`,
					title: "Download",
					class: "btn-download",
					href: "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>",
					id: "download",
				},
				{
					icon: `<span class="material-symbols-outlined">filter_list</span>`,
					title: "Filter",
					class: "filter",
				}
			],
			columns: [{
					data: "rec_id",
					label: "Ticket #",
					class: 'w-10',
					datatype: "none",
					// render: function(data,row){
					// 	if(row.sr_type == 'unit-repair'){
					// 		return '<input type="checkbox" class="checkbox-icon " id="'+ row.id +'" name="check_box" table="unit_repair" view_table="view_unit_repair" reload="<?= WEB_ROOT; ?>/service-request/sr-summary?submenuid=ss">' + data;							
					// 	}else if(row.sr_type == 'gate-pass'){
					// 		return '<input type="checkbox" class="checkbox-icon " id="'+ row.id +'" name="check_box" table="gate_pass" view_table="view_gate_pass" reload="<?= WEB_ROOT; ?>/service-request/sr-summary?submenuid=ss">' + data;														
					// 	}else if(row.sr_type ==  'visitor-pass'){
					// 		return '<input type="checkbox" class="checkbox-icon " id="'+ row.id +'" name="check_box" table="visitor_pass" view_table="view_visitor_pass" reload="<?= WEB_ROOT; ?>/service-request/sr-summary?submenuid=ss">' + data;							
					// 	}else if(row.sr_type == 'reservation'){
					// 		return '<input type="checkbox" class="checkbox-icon " id="'+ row.id +'" name="check_box" table="reservation" view_table="view_reservation" reload="<?= WEB_ROOT; ?>/service-request/sr-summary?submenuid=ss">' + data;							
					// 	}else if(row.sr_type == 'move-in'){
					// 		return '<input type="checkbox" class="checkbox-icon " id="'+ row.id +'" name="check_box" table="move_in" view_table="view_move_in" reload="<?= WEB_ROOT; ?>/service-request/sr-summary?submenuid=ss">' + data;							
					// 	}else if(row.sr_type == 'move-out'){
					// 		return '<input type="checkbox" class="checkbox-icon " id="'+ row.id +'" name="check_box" table="move_out" view_table="view_move_out" reload="<?= WEB_ROOT; ?>/service-request/sr-summary?submenuid=ss">' + data;
					// 	}else if(row.sr_type == 'work-permit'){
					// 		return '<input type="checkbox" class="checkbox-icon " id="'+ row.id +'" name="check_box" table="work_permit" view_table="view_work_permit" reload="<?= WEB_ROOT; ?>/service-request/sr-summary?submenuid=ss">' + data;							
					// 	}
					// }
				},
				{
					data: "created_on",
					label: "Date",
					class: 'w-10',
					render: function(data, row) {
						var d = new Date(data * 1000);
						var c = new Date();
						var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
						return months[d.getMonth()] + ' ' + d.getDate() + (d.getFullYear() != c.getFullYear() ? ' ' + d.getFullYear() : '') + ', ' + (d.getHours() > 12 ? d.getHours() - 12 : d.getHours()) + ':' + (d.getMinutes() < 10 ? '0' : '') + d.getMinutes() + ' ' + (d.getHours() < 12 ? 'AM' : 'PM');
					},
					searchable: true,
					datatype: 'date'
				},
				{
					data: "requestor_name",
					label: "Requestor",
					class: '',
					datatype: "none",
				},
				{
					data: "unit",
					label: "Unit",
					class: '',
					datatype: "none",
				},
				{
					data: "description",
					label: "Issue/Description",
					class: '',
					datatype: "none",
				},
				{
					data: null,
					label: "Priority </br> Level",
					class: '',
					datatype: 'select',
					list: ['1|Priority', '2|Priority', '3|Priority ', '4|Priority', '5|Priority'],

				},
				{
					data: "approve",
					label: "Status",
					class: '',
					datatype: 'select',
					list: ['0|Closed', '1|Open'],
					render: function(data, row) {
						if (data == 1) {
							return 'Open';
						} else {
							return 'Closed';
						}
					}
				},
				{
					data: null,
					label: "Date Completed",
					class: ' text-break',
					datatype: "none",
				},
				{
					data: null,
					label: "Within </br> SLA",
					class: '',
					datatype: "none",
				},
				{
					data: null,
					label: "Action",
					class: "text-left",
					class: '',

					render: function(data, row) {
						if (row.sr_type == 'unit-repair') {
							return '<a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/tenant/view-unit-repair/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> ' +
								'<a class="btn btn-sm text-primary btn-delete" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=unit_repair&view_table=view_unit_repair&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash"></i></a>';

						} else if (row.sr_type == 'gate-pass') {
							return '<a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/tenant/view-gate-pass/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> ' +
								'<a class="btn btn-sm text-primary btn-delete" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=gate_pass&view_table=view_gate_pass&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash"></i></a>';

						} else if (row.sr_type == 'visitor-pass') {
							return '<a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/tenant/view-visitor-pass/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> ' +
								'<a class="btn btn-sm text-primary btn-delete" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=visitor_pass&view_table=view_visitor_pass&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash"></i></a>';

						} else if (row.sr_type == 'reservation') {
							return '<a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/tenant/view-reservation/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> ' +
								'<a class="btn btn-sm text-primary btn-delete" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=reservation&view_table=view_reservation&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash"></i></a>';

						} else if (row.sr_type == 'move-in') {
							return '<a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/tenant/view-move-in/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> ' +
								'<a class="btn btn-sm text-primary btn-delete" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=move_in&view_table=view_move_in&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash"></i></a>';

						} else if (row.sr_type == 'move-out') {
							return '<a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/tenant/view-move-out/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> ' +
								'<a class="btn btn-sm text-primary btn-delete" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=move_out&view_table=view_move_out&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash"></i></a>';

						} else if (row.sr_type == 'work-permit') {
							return '<a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/tenant/view-work-permit/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> ' +
								'<a class="btn btn-sm text-primary btn-delete" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=work_permit&view_table=view_work_permit&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash"></i></a>';
						}
					},
					orderable: false
				}
			],
			order: [
				[0, 'asc']
			],
			// colFilter: {'status':'Active'}
		});

		$(document).on('click', '.btn-approve-gatepass,.btn-disapprove-gatepass', function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).prop('href') + '?display=plain',
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function() {},
				success: function(data) {
					if (data.success == 1) {
						showSuccessMessage(data.description, function() {
							window.location.reload();
						});
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});
		});

		$('.btn-delete-filter').on('click', function() {
			var table = $('input[name="check_box"]').attr('table');
			var view_table = $('input[name="check_box"]').attr('view_table');
			var redirect = $('input[name="check_box"]').attr('reload');

			var ids = [];
			$('input[name="check_box"]').each(function() {
				var $this = $(this);

				if ($this.is(":checked")) {
					ids.push($this.attr("id"));
				}
			});
			if (ids.length != 0) {
				var url = '<?= WEB_ROOT; ?>/property-management/delete-records?display=plain';

				table_delete_records(ids, table, view_table, redirect, url);
			}
		});


		$('.filter').on('click', function() {
			$(".dropdown-menu").toggle();
		});

		$('.btn-status').off('click').on('click', function() {
			$('#collapse-status').collapse('toggle');
		});

		$('#collapse-status').on('hidden.bs.collapse', function() {
			$('#up1').hide();
			$('#down1').show();

		});

		$('#collapse-status').on('show.bs.collapse', function() {
			$('#up1').show();
			$('#down1').hide();

		});

		$('.btn-building').off('click').on('click', function() {
			$('#collapse-building').collapse('toggle');
		});

		$('#collapse-building').on('hidden.bs.collapse', function() {
			$('#up2').hide();
			$('#down2').show();

		});

		$('#collapse-building').on('show.bs.collapse', function() {
			$('#up2').show();
			$('#down2').hide();

		});

		$('.btn-priority-level').off('click').on('click', function() {
			$('#collapse-priority-level').collapse('toggle');
		});

		$('#collapse-priority-level').on('hidden.bs.collapse', function() {
			$('#up3').hide();
			$('#down3').show();

		});

		$('#collapse-priority-level').on('show.bs.collapse', function() {
			$('#up3').show();
			$('#down3').hide();

		});

		$('.btn-stages').off('click').on('click', function() {
			$('#collapse-stages').collapse('toggle');
		});

		$('#collapse-stages').on('hidden.bs.collapse', function() {
			$('#up4').hide();
			$('#down4').show();

		});

		$('#collapse-stages').on('show.bs.collapse', function() {
			$('#up4').show();
			$('#down4').hide();

		});

		$('.bi-caret-up-fill').hide();

		$('.all-btn').on('click', function(e) {
			$(".all-btn").addClass('active1');
			$(".open-btn").removeClass('active1');
			$(".aging-btn").removeClass('active1');
			$(".closed-btn").removeClass('active1');
		});

		$('.open-btn').on('click', function(e) {
			$(".open-btn").addClass('active1');
			$(".all-btn").removeClass('active1');
			$(".aging-btn").removeClass('active1');
			$(".closed-btn").removeClass('active1');
		});

		$('.aging-btn').on('click', function(e) {
			$(".aging-btn").addClass('active1');
			$(".all-btn").removeClass('active1');
			$(".open-btn").removeClass('active1');
			$(".closed-btn").removeClass('active1');
		});

		$('.closed-btn').on('click', function(e) {
			$(".closed-btn").addClass('active1');
			$(".all-btn").removeClass('active1');
			$(".open-btn").removeClass('active1');
			$(".aging-btn").removeClass('active1');
		});

	});

	status();

	function status(status = 'all') {
		type = status;

		if (status == 'all') {
			$(".all-btn").addClass('active1');
			$(".open-btn,.aging-btn,.closed-btn").removeClass('active1');
			type = 'all';
		} else if (status == 'open') {
			$(".open-btn").addClass('active1');
			$(".all-btn,.closed-btn").removeClass('active1');
			type = 1;
		} else if (status == 'closed') {
			$(".closed-btn").addClass('active1');
			$(".open-btn,.aging-btn,.all-btn").removeClass('active1');
			type = 0;
		}
		filterby = 'approve';
		filtertxt = type;

		t<?= $unique_id; ?>.options.colFilter[filterby] = filtertxt;
		t<?= $unique_id; ?>.ajax.reload();


	}
</script>