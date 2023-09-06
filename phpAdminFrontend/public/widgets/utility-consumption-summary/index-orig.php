<?php
$title = "Utilities Consumption";
$module = "report";
$table = "billing_and_rates";
$view = "view_billing_and_rates";
$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
$data = [
	'month' => date('m'),
	'year' => date('Y'),
	'utility_type' => 'Electricity'
];


$electric_consumption = $ots->execute('utilities', 'get-electric-consumption', $data);
$electric_consumption = json_decode($electric_consumption, true);
// p_r($electric_consumption);


//PERMISSIONS
//get user role
$data = [
	'view' => 'users'
];
$user = $ots->execute('property-management', 'get-record', $data);
$user = json_decode($user);

//check if has access
$data = [
	'role_id' => $user->role_type,
	'table' => 'utilities_report',
	'view' => 'role_rights'

];
$role_access = $ots->execute('form', 'get-role-access', $data);
$role_access = json_decode($role_access);
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
		<div style="border-bottom: 1px solid rgb(180,180,180, .3)">
			<label class="text-required my-4" style="font-size: 20px;">Electric Consumption</label>
			<div class="report-chart">
				<table class="table  text-center" style="box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);">
					<thead class="header-design" style="border-bottom: 1px solid #FFFFFF">
						<tr>
							<th style="width:auto">Month</th>
							<th colspan="2" style="width:auto">KWHR Consumption</th>
							<th colspan="2" style="width:auto">Variance</th>
							<th colspan="2" style="width:auto">Electric Billing</th>
							<th colspan="2" style="width:auto">Variance</th>
							<th colspan="2" style="width:auto">Meralco Rate</th>
							<th colspan="2" style="width:auto">Variance</th>
						</tr>
					</thead>
					<thead class="header-design">
						<tr>
							<th style="width:auto"></th>
							<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?></th>

							<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] ?></th>

							<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?> vs <?= $electric_consumption['data']['year'] ?></th>
							<th scope="col" style="width:auto">%</th>
							<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?></th>

							<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] ?></th>

							<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?> vs <?= $electric_consumption['data']['year'] ?></th>
							<th scope="col" style="width:auto">%</th>
							<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?></th>
							<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] ?></th>
							<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?> vs <?= $electric_consumption['data']['year'] ?></th>
							<th scope="col" style="width:auto">%</th>
						</tr>
					</thead>

					<?php
					$x = 1;
					$kwhr_prev_year = 0;
					$kwhr = 0;
					$kwhrprevcurr = 0;
					foreach ($months as $month) : ?>
						<?php
						$month_number = $x;

						if ($month_number < 10)
							$month_number = "0" . $x;

						$data = [
							'month' => $month_number,
							'year' => date('Y'),
							'utility_type' => 'Electricity'
						];

						$electric_consumption = $ots->execute('utilities', 'get-electric-consumption', $data);
						$electric_consumption = json_decode($electric_consumption, true);

						$x++;
						$kwhrprevYear = $electric_consumption['kwhr_consumption'][date('Y') - 1];
						$kwhrcurrYear = $electric_consumption['kwhr_consumption'][date('Y')];
						$kwhr_prev_curr = $electric_consumption['kwhr_consumption'][date('Y') - 1] - $electric_consumption['kwhr_consumption'][date('Y')];
						?>
						<tr>
							<td scope="col" style="width:auto" class="text-nowrap"><label class="text-required"><?= $month; ?></td>
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
						</tr>

					<?php endforeach; ?>

					<tr class="tr-ytd">
						<td scope="col" style="width:auto" class="text-nowrap"><label class="text-required">YTD</td>
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
					</tr>
				</table>
			</div>

		</div>
		<div class="bg-white rounded my-4">
			<label class="text-required my-2 px-2" style="font-size: 20px;">Electric Consumption Analysis</label>
			<canvas id="electricity-chart" style="position: relative; height:45vh; width:80vw"></canvas>
		</div>

		<label class="text-required my-4" style="font-size: 20px;">Water Consumption</label>
		<div class="report-chart">
			<table class="table   text-center" style="box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);">
				<thead class="header-design">
					<tr>
						<th style="width:auto">Month</th>
						<th colspan="2" style="width:auto">Cum Consumption</th>
						<th colspan="2" style="width:auto">Variance</th>
						<th colspan="2" style="width:auto">Water Billing</th>
						<th colspan="2" style="width:auto">Variance</th>
						<th colspan="2" style="width:auto">Maynilad Rate</th>
						<th colspan="2" style="width:auto">Variance</th>
					</tr>
				</thead>
				<thead class="header-design">
					<tr>
						<th style="width:auto"></th>
						<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?></th>

						<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] ?></th>

						<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?> vs <?= $electric_consumption['data']['year'] ?></th>
						<th scope="col" style="width:auto">%</th>
						<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?></th>

						<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] ?></th>

						<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?> vs <?= $electric_consumption['data']['year'] ?></th>
						<th scope="col" style="width:auto">%</th>
						<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?></th>
						<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] ?></th>
						<th scope="col" style="width:auto"><?= $electric_consumption['data']['year'] - 1 ?> vs <?= $electric_consumption['data']['year'] ?></th>
						<th scope="col" style="width:auto">%</th>
					</tr>
				</thead>

				<?php
				$x = 1;
				foreach ($months as $month) : ?>
					<?php
					$month_number = $x;

					if ($month_number < 10)
						$month_number = "0" . $x;

					$data = [
						'month' => $month_number,
						'year' => date('Y'),
						'utility_type' => 'Water'
					];

					$water_consumption = $ots->execute('utilities', 'get-electric-consumption', $data);
					$water_consumption = json_decode($water_consumption, true);

					$x++;

					?>
					<tr>
						<td scope="col" style="width:auto" class="text-nowrap"><label class="text-required"><?= $month; ?></td>
						<td scope="col" style="width:auto">
							<label class="text-required"><?= $water_consumption['kwhr_consumption'][date('Y') - 1] ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"><?= $water_consumption['kwhr_consumption'][date('Y')] ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"> <?= $water_consumption['kwhr_consumption'][date('Y') - 1] - $water_consumption['kwhr_consumption'][date('Y')] ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"> <?= round((($water_consumption['kwhr_consumption'][date('Y') - 1] - $water_consumption['kwhr_consumption'][date('Y')]) / $water_consumption['kwhr_consumption'][date('Y') - 1]) * 100) ?>%
						</td>

						<td scope="col" style="width:auto">
							<label class="text-required"><?= $water_consumption['electric_billing'][date('Y') - 1] ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"><?= $water_consumption['electric_billing'][date('Y')] ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"> <?= $water_consumption['electric_billing'][date('Y') - 1] - $water_consumption['electric_billing'][date('Y')] ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"> <?= round((($water_consumption['electric_billing'][date('Y') - 1] - $water_consumption['electric_billing'][date('Y')]) / $water_consumption['electric_billing'][date('Y') - 1]) * 100) ?>%
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"><?= round($water_consumption['meralco_rate'][date('Y') - 1]) ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"><?= round($water_consumption['meralco_rate'][date('Y')]) ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"> <?= round($water_consumption['meralco_rate'][date('Y') - 1] - $water_consumption['meralco_rate'][date('Y')]) ?>
						</td>
						<td scope="col" style="width:auto">
							<label class="text-required"> <?= round((($water_consumption['meralco_rate'][date('Y') - 1] - $water_consumption['meralco_rate'][date('Y')]) / $water_consumption['meralco_rate'][date('Y') - 1]) * 100) ?>%
						</td>
					</tr>

				<?php endforeach; ?>

				<tr class="tr-ytd">
					<td scope="col" style="width:auto" class="text-nowrap">YTD</td>
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
				</tr>
			</table>
		</div>

		<div class="d-flex justify-content-center gap-4">

			<div class="bg-white rounded">
				<label class="text-required my-2 px-2" style="font-size: 20px;">Water Consumption Analysis</label>
				<canvas id="water-chart" style="position: relative; height:45vh; width:80vw"></canvas>
			</div>

		</div>
	<?php endif; ?>

</div>
<script>
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

		$(".btn-download").on('click', function() {
			location = "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>";
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

		var xValues = [<?= $consumption_string ?>];
		var yValues = [<?= $consumption_string ?>];
		var unit_of_measurement = '<?= $meter->unit_of_measurement ?>'
		chart = new Chart("electricity-chart", {
			type: "line",
			data: {
				labels: [
					'Jan <?= date('Y') ?>',
					'Feb <?= date('Y') ?>',
					'Mar <?= date('Y') ?>',
					'Apr <?= date('Y') ?>',
					'May <?= date('Y') ?>',
					'Jun <?= date('Y') ?>',
					'Jul <?= date('Y') ?>',
					'Aug <?= date('Y') ?>',
					'Sep <?= date('Y') ?>',
					'Oct <?= date('Y') ?>',
					'Nov <?= date('Y') ?>',
					'Dec <?= date('Y') ?>',
				],
				datasets: [{
					// backgroundColor: "rgba(0,0,0,1.0)",
					label: unit_of_measurement,

					backgroundColor: "rgb(0, 105, 197)",
					data: yValues,
				}]
			},
			options: {
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						fontSize: 100

					}],
					xAxes: [{
						fontSize: 20
					}]
				},

			}
		});

		var xValues = [<?= $consumption_string ?>];
		var yValues = [<?= $consumption_string ?>];
		var unit_of_measurement = '<?= $meter->unit_of_measurement ?>'
		chart = new Chart("water-chart", {
			type: "line",
			data: {
				labels: [
					'Jan <?= date('Y') ?>',
					'Feb <?= date('Y') ?>',
					'Mar <?= date('Y') ?>',
					'Apr <?= date('Y') ?>',
					'May <?= date('Y') ?>',
					'Jun <?= date('Y') ?>',
					'Jul <?= date('Y') ?>',
					'Aug <?= date('Y') ?>',
					'Sep <?= date('Y') ?>',
					'Oct <?= date('Y') ?>',
					'Nov <?= date('Y') ?>',
					'Dec <?= date('Y') ?>',
				],
				datasets: [{
					// backgroundColor: "rgba(0,0,0,1.0)",
					label: unit_of_measurement,
					backgroundColor: "rgba(187, 223, 252, 0.4)",
					borderColor: "rgba(187, 223, 252)",
					pointHitRadius: "3",
					pointBorderWidth: "3",
					data: [5, 10, 3, 5, 7, 12, 22, 5, 12, 13, 17, 2],
				}]
			},
			options: {
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						fontSize: 100

					}],
					xAxes: [{
						fontSize: 20
					}]
				},

			}
		});

		// t<?= $unique_id; ?> = $("#jsdata").JSDataList({
		// 	pageLength: 10,
		// 	searchBoxID: 'searchbox',
		// 	prefix: 'gatepass',
		// 	ajax: {
		// 		url: "<?= WEB_ROOT . "/module/get-list/{$view}?display=plain" ?>"
		// 	},
		// 	onDataChanged:function(){
		// 		$('.permit-expired').closest('.row-list').addClass('bg-danger text-light');

		// 		$('.permit-notify').closest('.row-list').addClass('bg-warning');

		// 		$('.permit-notify').closest('.row-list').addClass('light-blue-bg');

		// 	},
		// 	columns:[
		// 		{
		// 			data: null,
		// 			label: "Months",
		// 			class: 'col-1',
		// 			render: function(data,row){
		// 			}
		// 		},
		// 		{
		// 			data: "created_by_full_name",
		// 			label: "Created By",
		// 			class: 'col-1'
		// 		},
		// 		{
		// 			data: "wo_type",
		// 			label: "Type of Word Order",
		// 			class: 'col-1',
		// 		},
		// 		{
		// 			data: "equipment_name",
		// 			label: "Equipment",
		// 			class: 'col-1'
		// 		},
		// 		{
		// 			data: "priority_level",
		// 			label: "Priority",
		// 			class: 'col-1',
		// 		},
		// 		{
		// 			data: "service_providers_name",
		// 			label: "Service Provider",
		// 			class: 'col-1'
		// 		},
		// 		{
		// 			data: "date_scheduled",
		// 			label: "Date Scheduled",
		// 			class: 'col-1',
		// 		},
		// 		{
		// 			data: "stage",
		// 			label: "Status",
		// 			class: 'col-1',
		// 		},
		// 		{
		// 			data: "stage",
		// 			label: "Stage",
		// 			class: 'col-1',
		// 		},
		// 		{
		// 			data: null,
		// 			label: "Date Completed",
		// 			class: 'col-1',
		// 		},
		// 		{
		// 			data: null,
		// 			label: "With SLA",
		// 			class: 'col-1',
		// 		},
		// 		{
		// 			data: null,
		// 			label: "Actions",
		// 			class: 'col-1 d-flex align-items-center',
		// 			render: function(data,row){
		// 				return '<a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/property-management/view-wo/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> '+
		// 				'<a class="btn btn-sm btn-danger btn-delete" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="'+row.rec_id+'" del_url="<?= WEB_ROOT ?>/property-management/delete-record/' + row.id + '?display=plain&table=work_order&view_table=view_work_order&redirect=/report/wo-summary?submenuid=ws"><i class="bi bi-trash"></i></a>';
		// 			},
		// 			orderable: false
		// 		}
		// 	],
		// 	order: [[0,'asc']],
		// 	// colFilter: {'status':'Active'}
		// });

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

		$(".btn-filter-status").on('click', function() {
			t<?= $unique_id; ?>.options.colFilter = {
				'status': $(this).html()
			};
			t<?= $unique_id; ?>.ajax.reload();

			$(".btn-filter-status").not($(this)).removeClass('btn-primary').addClass('btn-secondary');
			$(this).addClass('btn-primary').removeClass('btn-secondary');
		});

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
</script>