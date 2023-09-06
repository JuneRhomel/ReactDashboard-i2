<?php
$title = "Utilities Billing & Rates";
$module = "tenant";
$table = "billing_and_rates";
$view = "view_billing_and_rates";


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
$data = [
	'role_id' => $user->role_type,
	'table' => 'billing_and_rates',
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

		<div class="page-title"><?= $title ?></div>
		<div class="gap-4 my-5 align-items-center py-4 billing-rates" style="border-bottom: 1px solid #B4B4B4;">
			<label for="" class="text-required mb-2">Choose month to filter.</label>
			<div class="row">
				<div class="col-12 col-sm-3 col-lg-3 col-xl-3">
					<div class="form-group">
						<label for="" class="text-required">Month</label>
						<select name="month_select" id='month_select' class='form-select' onchange="update_billing_table($('.ut.active1').attr('utility-type'))">
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
						<select name="" class="form-select" id="year_dropdown" onchange="update_billing_table($('.ut.active1').attr('utility-type'))" required>
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
						<button type="submit" class="btn btn-dark btn-primary px-5">Show</button>
					</div>
				</div>
			</div>
		</div>
		<?php p_r($_SESSION['error']);
		unset($_SESSION['error']) ?>
		<div class="modal" tabindex="-1" role="dialog" id='bill-and-rates-modal'>
			<div class="modal-dialog  modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add <span class='modal-utility'></span> Reading for <span class='modal-month'></span></h5>
						<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#bill-and-rates-modal").modal("hide")' aria-label="Close">

						</button>
					</div>
					<div class="modal-body">
						<form action="<?= WEB_ROOT; ?>/utilities/save-record?display=plain" method='post' id='form-billing-and-rates' enctype="multipart/form-data">
							<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/utilities/utilities-billing-rates?submenuid=utilitiesbillingrates'>
							<input type="hidden" name='error_redirect' id='redirect' value='<?= WEB_ROOT ?>/utilities/utilities-billing-rates?submenuid=utilitiesbillingrates'>
							<input type="hidden" name='table' id='id' value='billing_and_rates'>
							<input type="hidden" name='view_table' id='id' value='view_billing_and_rates'>
							<input type="hidden" name='update_table' id='id' value='billing_and_rate_updates'>
							<input type="hidden" name='utility_type' id='utility_type' value='Electricity'>
							<input type="hidden" name='single_data_only' value='true'>
							<input type="hidden" name='months' id='month' value='<?= date('m') ?>'>
							<input type="hidden" name='year' id='year' value='<?= (date('Y') - 1) ?>'>
							<table class="table table-data table-bordered">
								<tr>
									<th>Mother Meter</th>
									<td><input name='mother_meter' class='form-control' value='GL-100' readonly></td>
								</tr>
								<tr>
									<th>Billing Amount</th>
									<td><input type='number' id='bill_amount' min="0" name='bill_amount' class='form-control' style="background-color: #FFF385; box-shadow: 0pt 3pt 6pt #00000029; border-radius: 5pt 5pt 5pt 5pt; max-width: 100%; max-height: 100%" required></td>
								</tr>
								<tr>
									<th class='uom'>Kwhr Consumption</th>
									<td><input type='number' id='consumption' name='consumption' class='form-control' style="background-color: #FFF385; box-shadow: 0pt 3pt 6pt #00000029; border-radius: 5pt 5pt 5pt 5pt; max-width: 100%; max-height: 100%" required></td>
								</tr>
								<tr>
									<th>Your Rate This Month</th>
									<td class='billing-rates-th'><span id='rate'></span></td>
								</tr>
								<tr>
									<th>Billing</th>
									<td><input type="file" name="file[]" id="file" class='form-control' multiple></td>
								</tr>
								<tr>
									<th></th>
									<td>
										<div class='float-end'><button class='btn btn-primary save-utilities-billing'>Save</button></div>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<div class="modal-footer">

					</div>
				</div>
			</div>

		</div>

		<div class="d-flex">
			<div class="d-flex">
				<button class="btn ut electricity-btn active1" onclick="update_billing_table('Electricity')" utility-type='Electricity' uom='Kilowatt-hour (KwHR)'>Electricity</button>
				<button class="btn ut water-btn" utility-type='Water' onclick="update_billing_table('Water')" uom='Cubic Meter (CuM)'>Water</button>
			</div>
			<div class="d-flex flex-row-reverse my-1" style="width: 100%;">
				<?php if ($role_access->update == true) : ?>
					<a class='btn btn-sm btn-primary float-end btn-view-form px-5 edit-bill-rates ' onclick="$('#bill-and-rates-modal').modal('show')">Edit</a>
				<?php endif; ?>
			</div>
		</div>
		<div class="bg-white mb-4 pb-2 px-2 pt-0 rounded">

			<table class="table table-data table-bordered electricity-table border-table">
				<tr>
					<th>Mother Meter</th>
					<td><input name='mother_meter' class='form-control' value='GL-100' readonly></td>
				</tr>
				<tr>
					<th>Billing Amount</th>
					<td class='billing-th' style="background-color: #FFF385"></td>
				</tr>
				<tr>
					<th>Kwhr Consumption</th>
					<td class='billing-consumption-th' style="background-color: #FFF385"></td>
				</tr>
				<tr>
					<th>Your Rate This Month</th>
					<td class='billing-rates-th'></td>
				</tr>
				<tr>
					<th>Billing</th>
					<td><a href='<?= $attachment->attachment_url ?>'><?= $attachment->filename ?></a></td>
				</tr>
			</table>
			<table class="table table-data table-bordered water-table border-table">
				<tr>
					<th>Mother Meter</th>
					<td><input name='mother_meter' class='form-control' value='GL-100' readonly></td>
				</tr>
				<tr>
					<th>Billing Amount</th>
					<td class='billing-th' style="background-color: #FFF385"></td>
				</tr>
				<tr>
					<th>CuM Consumption</th>
					<td class='billing-consumption-th' style="background-color: #FFF385"></td>
				</tr>
				<tr>
					<th>Your Rate This Month</th>
					<td class='billing-rates-th'></td>
				</tr>
				<tr>
					<th>Billing</th>
					<td><a href='<?= $attachment->attachment_url ?>'><?= $attachment->filename ?></a></td>
				</tr>
			</table>
		</div>

		<div class="d-flex mb-2">
			<div class="d-flex align-items-end">
				<label class="text-label-result px-3 mb-0" id="search-result">
				</label>
			</div>
		</div>

		<div class="container-table ">
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

			<div class="table-tab">
				<div class="d-flex">
					<button class="btn tabs-table">History</button>
					<button class="btn tabs-table">Month</button>
					<button class="btn tabs-table">Year</button>
				</div>

			</div>

			<table id="jsdata"></table>
		</div>

		<div class="d-flex gap-2">
			<div class="bg-white rounded my-4">

				<label class="text-required my-2 px-2" style="font-size: 20px;">KwHr Consumption</label>
				<canvas id="kwhr-consumption-chart" style="position: relative; height:45vh; width: 83vh;"></canvas>
			</div>
			<div class="bg-white rounded my-4">

				<label class="text-required my-2 px-2" style="font-size: 20px;">KwHr Rate</label>
				<div>
					<canvas id="kwhr-rate-chart" style="position: relative; height:45vh; width: 83vh;"></canvas>
				</div>
			</div>

		</div>
	<?php endif; ?>
</div>
<script>
	var xValues = [<?= $consumption_string ?>];
	var yValues = [<?= $consumption_string ?>];
	var unit_of_measurement = '<?= $meter->unit_of_measurement ?>'
	chart = new Chart("kwhr-consumption-chart", {
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
				data: [15, 6, 13, 15, 17, 2, 12, 15, 2, 8, 11, 12],
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
	chart = new Chart("kwhr-rate-chart", {
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

	$('.save-utilities-billing').click(function(e) {
		e.preventDefault();
		if ($('#bill_amount').val() === '' || $('#consumption').val() === '') {
			showModalRequired();
		} else {
			hideModalRequired();
			$("#form-billing-and-rates").submit();
		}
	});

	$("#form-billing-and-rates").on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).prop('action'),
			type: 'POST',
			dataType: 'JSON',
			data: new FormData($(this)[0]),
			contentType: false,
			processData: false,
			beforeSend: function() {},
			success: function(data) {
				if (data.success == 1) {
					show_success_reading($('input[name=redirect]').val());
				}
			},
			complete: function() {

			},
			error: function(jqXHR, textStatus, errorThrown) {

			}
		});
	});


	function update_billing_table(ut = 'Electricity') {
		$('#bill_amount').val(0);
		$('#consumption').val(0);
		$('#rate').val(0);
		$('.billing-th').html('');
		$('.billing-consumption-th').html('');
		$('.billing-rates-th').html('');
		$('#year').val($('#year_dropdown').val());
		$("#utility_type").val(ut);

		var today = new Date();
		var dd = String(today.getDate()).padStart(2, '0');
		var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
		var yyyy = today.getFullYear();

		today = mm + '/' + dd + '/' + yyyy;

		current_year = '';

		current_month = '';

		// get the lates billing from the db according to current year and month// Ajax
		$('#month').val($('#month_select').val());
		$.ajax({
			url: '<?= WEB_ROOT ?>' + '/utilities/get-billing-rates?display=plain',
			type: 'POST',
			data: {
				month: $('#month').val(),
				year: $("#year").val(),
				utility_type: ut
			},
			dataType: 'JSON',
			beforeSend: function() {},
			success: function(data) {
				if (data.success == 1) {
					if ((data.billing_data.rates == 0) || data.billing_data.rates == null) {
						// $('.edit-bill-rates').removeClass('d-none');
					} else {
						// $('.edit-bill-rates').addClass('d-none');
						billing_amount = data.billing_data.bill_amount;
						consumption = data.billing_data.consumption;
						rates = parseFloat(data.billing_data.rates).toFixed(2);
						$('.billing-th').html(billing_amount, 2);
						$('.billing-consumption-th').html(data.billing_data.consumption);
						$('.billing-rates-th').html(rates);

						$('#bill_amount').val(billing_amount);
						$('#consumption').val(consumption);
						$('#rate').val(rates);

					}
				}
			},
			complete: function() {

			},
			error: function(jqXHR, textStatus, errorThrown) {

			}
		})
	}

	update_billing_table();
	<?php $unique_id = $module . time(); ?>
	var t<?= $unique_id; ?>;
	$(document).ready(function() {
		$('.ut').change(function() {
			update_billing_table();

		});
		$('#consumption').keyup(function() {
			rate = (parseInt($('#bill_amount').val()) / parseInt($(this).val()));
			$('#rate').html(rate.toFixed(2));
		});


		$('.edit-bill-rates').click(function() {
			$('.modal-utility').html($('.active1').attr('utility-type'));
			$('.uom').html($('.active1').attr('uom'));
			$('.modal-month').html($('[name=month]').val());
			$('#months').html($('[name=month]').val());
		});

		$(".btn-add").off('click').on('click', function() {

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

		t<?= $unique_id; ?> = $("#jsdata").JSDataList({

			ajax: {
				url: "<?= WEB_ROOT . "/module/get-list/{$view}?display=plain" ?>"
			},
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			addonsclass: "addons-m",
			buttons: [{
					icon: `<span class="material-symbols-outlined">filter_list</span>`,
					title: "Filter",
					class: "filter",
				}

			],
			columns: [{
					data: "rec_id",
					label: "ID",
					class: ''
				},
				{
					data: "months",
					label: "Months",
					class: '',
				},
				{
					data: "billing_period",
					label: "Billing </br> Period",
					class: '',
				},
				{
					data: "bill_amount",
					label: "Bill Amount",
					class: '',
					render: function(data, row) {
						return '₱ ' + Intl.NumberFormat('en-US').format(data);
					}
				},
				{
					data: "consumption",
					label: "Consumption",
					class: '',
				},
				{
					data: "rate",
					label: "Rate",
					class: ''
				},
				{
					data: "created_by",
					label: "Created By",
					class: ''
				},
				{
					data: "created_on",
					label: "Created </br> Date",
					class: ''
				},
				{
					data: null,
					label: "Action",
					class: '',
					render: function(data, row) {
						return '<a class="btn btn-sm text-primary btn-delete" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" rec_id="' + row.rec_id + '" title="Delete ID ' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=billing_and_rates&view_table=view_billing_and_rates&redirect=/utilities/utilities-billing-rates?submenuid=utilitiesbillingrates"><i class="bi bi-trash-fill"></i></a>';
					},
					orderable: false
				}
			],
			order: [
				[4, 'asc']
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

		$(".water-table").hide();

		$('.water-btn').on('click', function(e) {
			$(".water-table").show();
			$(".electricity-table").hide();
			$(".electricity-btn").removeClass('active1');
			$(".water-btn").addClass('active1');

		});

		$('.electricity-btn').on('click', function(e) {
			$(".water-table").hide();
			$(".electricity-table").show();
			$(".electricity-btn").addClass('active1');
			$(".water-btn").removeClass('active1');

		});
	});
</script>