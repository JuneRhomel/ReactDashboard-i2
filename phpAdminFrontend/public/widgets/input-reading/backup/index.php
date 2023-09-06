<?php
$title = "Meter Input Reading";
$module = "tenant";
$table = "meters";
$view = "view_meters";

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
if ($_SESSION['error']) {
	echo "<ul>";
	foreach ($_SESSION['error'] as $in => $val) {
?>
		<li class='alert alert-warning'>Errors on row #<?= ($in + 1) ?> '<?= $val ?>'</li>
<?php
	}
	echo "</ul>";
}
unset($_SESSION['error']);

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
	'table' => 'meter_readings',
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
		<div class="gap-4 my-5 align-items-center py-4" style="border-top: 1px solid #B4B4B4; border-bottom: 1px solid #B4B4B4;">
			<label for="" class="text-required mb-2">Choose month and floor to input new reading</label>
			<div class="row">
				<div class="col-12 col-lg-3 col-xl-3">

					<div class="form-group input-box">
						<select name="month" class='form-select' id='month' onchange="load_input_reading_table($('.active1').attr('utility-type'))">
							"<option value='01' <?= (date('m') == '01') ? 'selected' : '' ?>>January</option>",
							"<option value='02' <?= (date('m') == '02') ? 'selected' : '' ?>>February</option>",
							"<option value='03' <?= (date('m') == '03') ? 'selected' : '' ?>>March</option>",
							"<option value='04' <?= (date('m') == '04') ? 'selected' : '' ?>>April</option>",
							"<option value='05' <?= (date('m') == '05') ? 'selected' : '' ?>>May</option>",
							"<option value='06' <?= (date('m') == '06') ? 'selected' : '' ?>>June</option>",
							"<option value='07' <?= (date('m') == '07') ? 'selected' : '' ?>>July</option>",
							"<option value='08' <?= (date('m') == '08') ? 'selected' : '' ?>>August</option>",
							"<option value='09' <?= (date('m') == '09') ? 'selected' : '' ?>>September</option>",
							"<option value='10' <?= (date('m') == '10') ? 'selected' : '' ?>>October</option>",
							"<option value='11' <?= (date('m') == '11') ? 'selected' : '' ?>>November</option>",
							"<option value='12' <?= (date('m') == '12') ? 'selected' : '' ?>>December</option>",
						</select>
						<label for="" class="text-required">Month</label>
					</div>
				</div>
				<div class="col-12 col-lg-3 col-xl-3">
					<div class="form-group input-box">
						<select name="" class="form-select" id="year" required onchange="load_input_reading_table($('.active1').attr('utility-type'))">
							<option value="">--Please Select Year--</option>
							<?php
							$firstYear = (int)date('Y') - 2;
							$lastYear = (int)date('Y');
							for ($i = $firstYear; $i <= $lastYear; $i++) { ?>
								<option value="<?= $i ?>" <?= ($i == date('Y')) ? 'selected' : '' ?>> <?= $i ?></option>;
								<?php } ?>
							</select>
							<label for="" class="text-required">Year</label>
					</div>
				</div>

			</div>
		</div>

		<div class="d-flex justify-content-between gap-5  mb-5">
			<!-- Electric -->
			<form action="<?= WEB_ROOT; ?>/input-reading/save-record?display=plain" method="post" class="mother-meter-electric mother-meter d-flex flex-column gap-3 w-50">
				<input type="hidden" name='id' id='id_electric'>
				<input type="hidden" name='mother_meter' class='form-control' value='GL-100' readonly>

				<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/input-reading'>
				<input type="hidden" name='error_redirect' id='redirect' value='<?= WEB_ROOT ?>/input-reading'>
				<input type="hidden" name='table' value='billing_and_rates'>

				<input type="hidden" name='view_table' value='view_billing_and_rates'>
				<input type="hidden" name='update_table' value='billing_and_rate_updates'>
				<input type="hidden" name='utility_type' value='Electricity'>
				<input type="hidden" name='single_data_only' value='true'>
				<input type="hidden" name='months' value='<?= date('m') ?>'>
				<input type="hidden" name='year' value='<?= (date('Y') - 1) ?>'>
				<input class="w-100 consumption" name="consumption" id="electric_consumption" placeholder="Enter" type="hidden" required>
				<div>
					<h3 class="d-flex justify-content-between">Electricity Mother Meter: <b id="electric_mother_meter"></b> </h3>
					<h3 class="d-flex justify-content-between">Last Reading:
						<div>
							(<b id="electric_date_last"></b>)
							<b id="electric_last_reading" class="last_reading"> </b> <b> Kwh</b>
						</div>
					</h3>
					<h3 class="d-flex justify-content-between">Last Consumption: <div> <b id="electric_last_consumption"> </b> <b>Kwh</b></div>
					</h3>
				</div>
				<div class="d-flex gap-3 flex-column ">
					<div class="d-flex align-items-center">
						<span class="w-50 lebal-text">Reading Date</span>
						<div class="w-50 input-box form-group ">
							<input class="w-100 date-format" placeholder="" id="reading_date_electric" name="date" type="text" pattern="\d{4}-\d{2}-\d{2}" required>
							<label for="">Choose date</label>
						</div>
					</div>
					<div class="d-flex align-items-center">
						<span class="w-50 lebal-text">Latest Reading</span>
						<div class="w-50 input-box form-group ">
							<input class="w-100 latest_reading" name="reading" id="electric_reading" placeholder="Enter" type="number" required>
							<!-- id="electric_consumption" -->
							<label for="">Input latest reading</label>
						</div>
					</div>
					<i class="err"></i>
					<div class="d-flex align-items-center">
						<span class="w-50 lebal-text">Latest Bill Amount</span>
						<div class="w-50 input-box form-group ">
							<input class="w-100 bill_amount" placeholder="Enter" type="number" name="bill_amount" id="electric_bill_amount" required>
							<label for="">Input latest bill amount</label>
						</div>
					</div>
					<div class="d-flex align-items-center">
						<div>
							<span class="w-50 lebal-text rate-text " id="rate_text_electric">Your current rate is <b>P<span class="rate" id="electric_rates">0</span>/Kwhr</b> </span>
							<input type="hidden" id="electric_rates_input" class="rate_input" name="rate_">

						</div>
					</div>
					<div class="d-flex justify-content-end">

						<button type="submit" class="main-btn" id="btn_electric">Save</button>
					</div>
				</div>
			</form>
			<!-- Water -->
			<form action="<?= WEB_ROOT; ?>/input-reading/save-record?display=plain" method="post" class="mother-meter-water mother-meter d-flex flex-column gap-3 w-50">
				<input type="hidden" name='id' id='id_water'>
				<input type="hidden" name='mother_meter' class='form-control' value='0MM001' readonly>

				<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/input-reading/input-reading?menuid=utilities&submenuid=input-reading'>
				<input type="hidden" name='error_redirect' id='redirect' value='<?= WEB_ROOT ?>/input-reading/input-reading?menuid=utilities&submenuid=input-reading'>
				<input type="hidden" name='table' value='billing_and_rates'>

				<input type="hidden" name='view_table' value='view_billing_and_rates'>
				<input type="hidden" name='update_table' value='billing_and_rate_updates'>
				<input type="hidden" name='utility_type' value='Water'>
				<input type="hidden" name='single_data_only' value='true'>
				<input type="hidden" name='months' value='<?= date('m') ?>'>
				<input type="hidden" name='year' value='<?= (date('Y') - 1) ?>'>
				<input class="w-100 consumption" name="consumption" placeholder="Enter" id="water_consumption" type="hidden" required>
				<div>
					<h3 class="d-flex justify-content-between">Water Mother Meter : <b id="water_mother_meter">MM-0001-00</b> </h3>
					<h3 class="d-flex justify-content-between">Last Reading:
						<div>
							(<b id="water_date_last"></b>)
							<b id="water_last_reading" class="last_reading"> </b> <b> CuM</b>
						</div>
					</h3>
					<h3 class="d-flex justify-content-between">Last Consumption: <div><b id="water_last_consumption"></b> <b>CuM</b></div>
					</h3>
				</div>
				<div class="d-flex gap-3 flex-column ">
					<div class="d-flex align-items-center">
						<span class="w-50 lebal-text">Reading Date</span>
						<div class="w-50 input-box form-group ">
							<input class="w-100 date-format" placeholder="" id="reading_date_water" name="date" type="text" pattern="\d{4}-\d{2}-\d{2}" required>

							<label for="">Choose date</label>
						</div>
					</div>
					<div class="d-flex align-items-center">
						<span class="w-50 lebal-text">Latest Reading</span>
						<div class="w-50 input-box form-group ">
							<input class="w-100 latest_reading" name="reading" placeholder="Enter" id="water_reading" type="number" required>

							<label for="">Input latest reading</label>
						</div>
					</div>
					<i class="err"></i>
					<div class="d-flex align-items-center">
						<span class="w-50 lebal-text">Latest Bill Amount</span>
						<div class="w-50 input-box form-group ">
							<input class="w-100 bill_amount" name="bill_amount" placeholder="Enter" id="water_bill_amount" type="number" required>
							<label for="">Input latest bill amount</label>
						</div>
					</div>
					<div class="d-flex align-items-center">
						<div>
							<span class="w-50 lebal-text rate-text" id='rate_text_water'>Your current rate is <b>P<span class="rate" id="water_rates">0</span>/CuM</b> </span>
							<input type="hidden" id="water_rates_input" class="rate_input" name="rate_">

						</div>
					</div>
					<div class="d-flex justify-content-end">

						<button type="submit" class="main-btn" id="btn_water">Save</button>
					</div>
				</div>
			</form>

		</div>




		<!-- <div class="d-flex align-items-baseline">
		<div class="d-flex" style="width: 74%; height: 50%; border: 1px solid; margin: 0px !important">
			<button class="btn electricity-btn active1" onclick="load_input_reading_table('electrical')" utility-type="electricity" uom="Kilowatt-hour (KwHR)">Electricity</button>
        	<button class="btn water-btn" onclick="load_input_reading_table('water')" utility-type="water" uom="Cubic Meter (CuM)">Water</button>
		</div>    
		<div class="d-flex flex-row-reverse my-1" style="width: 24%; border: 1px solid">
			<button type="submit" class="btn btn-sm ml-auto p-2 mt-3 me-3 my-2 btn-add" form="new-input-reading-form">Input New Reading </button>
    	</div>
	</div> -->
		<div class="d-flex mb-2">
			<div class="d-flex align-items-end">
				<label class="text-label-result px-3 mb-0" id="search-result">
				</label>
			</div>
		</div>
		<div class="d-flex justify-content-between">
			<div>
				<button class="btn tabs-table all-btn active1" onclick="load_input_reading_table('all')">All</button>
				<button class="btn tabs-table electricity-btn " onclick="load_input_reading_table('electrical')" utility-type='electrical' uom='Kilowatt-hour (KwHR)'>Electricity</button>
				<button class="btn tabs-table water-btn" onclick="load_input_reading_table('water')" utility-type='water' uom='Cubic Meter (CuM)'>Water</button>
			</div>
			<div>

			</div>
		</div>


		<form action="<?php WEB_ROOT ?>/input-reading/new-input-reading-save?display=plain" method='post' id='new-input-reading-form'>
			<input type="hidden" id="utility_type" />
			<div class="input-reading-table-1">

			</div>
		</form>
		<!-- <?php if ($role_access->save == true) : ?>
			<button type='submit' class="btn btn-sm ml-auto p-2 mt-3 me-3 my-2 btn-add" id="save-reading" form="new-input-reading-form">Save Reading</button>
		<?php endif; ?> -->
	<?php endif; ?>
</div>
<script>
	//  formatNumber($('.bill_amount').val(),2)


	$('.date-format').on('input', function() {
		var inputValue = $(this).val();
		var datePattern = /^\d{4}-\d{2}-\d{2}$/;

		if (!datePattern.test(inputValue)) {
			this.setCustomValidity('Please enter a date in the format YYYY-MM-DD');
		} else {
			this.setCustomValidity('');
		}
	});

	function compute_consumption(last_reading, reading, consumption_class) {
		// return;
		consumption = parseInt(reading.val() - parseInt(last_reading));
		$('.' + consumption_class).val('');
		$('.span-' + consumption_class).html('');
		reading.siblings('span.er').html('');
		if (consumption < 0) {
			reading.val('');
			reading.focus();
			reading.attr('placeholder', 'Must not be lower than the last reading');
		} else if (reading.val() <= 0) {
			reading.val('');
			reading.focus();
			reading.attr('placeholder', 'Must not be equal to 0');
		} else {
			$('.' + consumption_class).val(consumption);
			$('.span-' + consumption_class).html(consumption);
		}
	}


	$('#save-reading').on('click', function() {
		const inputs = $("input[type='text']");
		let isValid = true;

		inputs.each(function() {
			if (!$(this).val().length) {
				isValid = false;
				return false;
			}
		});

		if (!isValid) {
			showModalRequired();
		} else {
			hideModalRequired();
		}
	});


	const mother_meter = (utility_type) => {
		let year = $('#year').val(); // Specify the desired year
		let month = $('#month').val() - 1; // Specify the desired month (1 for January, 2 for February, and so on)
		// formatDate($(reading_date));
		// Adjust the month and year if necessary
		if (month < 1) {
			month = 12;
			year--;
		} else if (month > 12) {
			month = 1;
			year++;
		}

		const formattedDate = `${year}-${String(month).padStart(2, '0')}`;
		// console.log(formattedDate)
		return new Promise((resolve, reject) => {
			$.post({
				url: "<?php WEB_ROOT ?>/input-reading/get-billing-rates?display=plain",
				data: {
					utility_type: utility_type.utility_type,
					month: $('#month').val(),
					year: $('#year').val(),
					date: formattedDate
				},
				success: function(data) {
					data = JSON.parse(data);
					success = 1;


					$(utility_type.last_consumption).text(data.previous_reading.consumption);
					$(utility_type.last_reading).html(data.previous_reading.reading);
					$(utility_type.date_last).text(data.previous_reading.date);
					if (!data.previous_reading) {
						$(utility_type.date_last).text('N/A');
						$(utility_type.last_reading).text('N/A');
						$(utility_type.last_consumption).text('N/A');
					}

					if (!data.billing_data) {
						$(utility_type.btn).show()
						$(utility_type.id).val('');

						$(utility_type.bill_amount).prop('readonly', false);
						$(utility_type.reading).prop('readonly', false);
						$(utility_type.mother_meter).text(utility_type.MM_name);
						$(utility_type.reading).val('');
						$(utility_type.reading).val('');
						$(utility_type.bill_amount).val('');
						$(utility_type.rates_text).hide();
						$(utility_type.rates).text('');
						$(utility_type.rate_input).val('');
					}
					if (data.billing_data.date) {
						$(utility_type.btn).hide()
						let date = data.billing_data.date.toString();

						$(utility_type.reading_date).val(date);
						$(utility_type.reading_date).prop('readonly', true);

						$(utility_type.reading_date).prop('readonly', true);
						$(utility_type.bill_amount).prop('readonly', true);
						$(utility_type.reading).prop('readonly', true);
					}

					if (!data.billing_data.date) {
						const now_month = $('#month').val();
						var formattedDate = year + "-" + now_month + "-16";
						$(utility_type.reading_date).val(formattedDate);

					}

					if (data.billing_data) {
						$(utility_type.id).val(data.billing_data.id);
						$(utility_type.mother_meter).text(data.billing_data.mother_meter);
						$(utility_type.reading).val(data.billing_data.reading);
						$(utility_type.bill_amount).val(data.billing_data.bill_amount);
						$(utility_type.reading).val(data.billing_data.reading);
						$(utility_type.rates_text).show();
						$(utility_type.rates).text(parseFloat(data.billing_data.rate_).toFixed(2));
						$(utility_type.rate_input).val(parseFloat(data.billing_data.rate_).toFixed(2));
					}

					resolve(data);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					reject(errorThrown);
				}
			});
		});
	}



	// for The mother_meter electricity and water
	mother_meter({
		id: '#id_electric',
		utility_type: 'electricity',
		mother_meter: '#electric_mother_meter',
		reading_date: '#reading_date_electric',
		consumption: '#electric_consumption',
		bill_amount: '#electric_bill_amount',
		rates: '#electric_rates',
		rates_text: '#rate_text_electric',
		rate_input: "#electric_rates_input",
		btn: "#btn_electric",
		reading: '#electric_reading',
		date: '#reading_date_electric',
		last_reading: '#electric_last_reading',
		date_last: '#electric_date_last',
		last_consumption: '#electric_last_consumption',
		MM_name: 'GL-100',
	})
	mother_meter({
		id: '#id_water',
		utility_type: 'water',
		mother_meter: '#water_mother_meter',
		reading_date: '#reading_date_water',
		consumption: '#water_consumption',
		bill_amount: '#water_bill_amount',
		rates: '#water_rates',
		rates_text: '#rate_text_water',
		rate_input: '#water_rates_input',
		btn: "#btn_water",
		reading: '#water_reading',

		date: '#reading_date_water',

		last_reading: '#water_last_reading',
		date_last: '#water_date_last',
		last_consumption: '#water_last_consumption',
		MM_name: '0MM001',
	})


	const runRateCalculation = () => {
		$('.mother-meter').each(function() {
			const mother_meter = $(this);
			const latest_reading = mother_meter.find('.latest_reading');
			const last_reading = mother_meter.find('.last_reading').text();
			const consumption_input = mother_meter.find('.consumption');
			// const consumption = last_reading - parseFloat(latest_reading.val());
			// consumption_input.val(consumption);

			const bill_amount = mother_meter.find('.bill_amount');
			const rate = mother_meter.find('.rate');
			const rate_text = mother_meter.find('.rate-text');
			const rate_input = mother_meter.find('.rate_input');
			const err = mother_meter.find('.err');

			const rateCalculation = function() {
				
				if (last_reading === "N/A") {
					consumption_input.val(latest_reading.val());
					err.text('Consumption: ' + latest_reading.val());
					rate_text.show();
					err.css('color', '#0F1108')
					rate.text(bill_rate);
					rate_input.val(bill_rate);
				} else {
					if (Number(latest_reading.val()) >= last_reading) {
						const new_consumption = latest_reading.val() - last_reading;
						consumption_input.val(new_consumption);
						const bill_rate = (bill_amount.val() / new_consumption).toFixed(2);
						err.show();
						err.text('Consumption: ' + new_consumption);
						rate_text.show();
						err.css('color', '#0F1108')
						rate.text(bill_rate);
						rate_input.val(bill_rate);
					} else {
						// Handle the case when latest_reading is falsy (empty or not provided)
						err.show();
						err.text('Must be higher than ' + last_reading);
						err.css('color', '#923416')
						consumption_input.val('');
						rate_text.hide();
						rate.text('');
						rate_input.val('');
					}

				}
			};

			latest_reading.on('input', function() {
				rateCalculation();
			});
			bill_amount.on('input', function() {
				rateCalculation();
			})
		});
	};

	// Run the code after a 20-millisecond delay
	setTimeout(runRateCalculation, 100);






	$("#new-input-reading-form").submit(function(e) {
		e.preventDefault();
		var utility = $("#utility_type").val();
		Swal.fire({
			title: "Great!",
			text: "Save reading successfully",
			confirmButtonText: "Okay",
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				$.post({
					url: $(this).attr('action'),
					data: $(this).serialize(),
					success: function(result) {
						if (utility == "water") {
							load_input_reading_table(utility);
						} else {
							load_input_reading_table();
						}
					}
				});
			}
		});
	});





	const save_mother_meter = (e) => {
		$(e).on('submit', function(e) {
			e.preventDefault();
			var form = $(this);
			var formData = new FormData(form[0]);

			// Get additional data from outside the form
			var month = $('#month').val();
			var year = $('#year').val();

			// Append additional data to the FormData object
			formData.append('months', month);
			formData.append('year', year);
			// console.log(formData)
			$.ajax({
				url: form.prop('action'),
				type: 'POST',
				dataType: 'JSON',
				data: formData,
				contentType: false,
				processData: false,
				beforeSend: function() {},
				success: function(data) {
					// console.log(data)
					if (data.success == 1) {
						show_success_reading($('input[name=redirect]').val());
					}
				},
				complete: function() {},
				error: function(err) {
					alert(err)
				},
			});
		});
	}
	save_mother_meter('.mother-meter-electric');
	save_mother_meter('.mother-meter-water');

	load_input_reading_table();


	function load_input_reading_table(utility_type = 'all') {
		$('.err').hide();
		utility = '';
		if (utility_type == 'all') {
			utility = utility_type;
			$("#utility_type").val(utility_type);
		} else if (utility_type == 'electrical') {
			utility = 'electricity';
			$("#utility_type").val('electricity');
		} else {
			utility = utility_type;
			$("#utility_type").val(utility_type);
		}
		$.post({
			url: "<?php WEB_ROOT ?>/input-reading/get-billing-rates?display=plain",
			data: {

				month: $('#month').val(),
				year: $('#year').val()
			},
			success: function(data) {
				data = JSON.parse(data);
			}
		});
		// for The mother_meter electricity and water
		mother_meter({
			id: '#id_electric',
			utility_type: 'electricity',
			mother_meter: '#electric_mother_meter',
			reading_date: '#reading_date_electric',
			consumption: '#electric_consumption',
			bill_amount: '#electric_bill_amount',
			rates: '#electric_rates',
			rates_text: '#rate_text_electric',
			rate_input: "#electric_rates_input",
			btn: "#btn_electric",
			reading: '#electric_reading',
			date: '#reading_date_electric',
			last_reading: '#electric_last_reading',
			date_last: '#electric_date_last',
			last_consumption: '#electric_last_consumption',
			MM_name: 'GL-100',
		})
		mother_meter({
			id: '#id_water',
			utility_type: 'water',
			mother_meter: '#water_mother_meter',
			reading_date: '#reading_date_water',
			consumption: '#water_consumption',
			bill_amount: '#water_bill_amount',
			rates: '#water_rates',
			rates_text: '#rate_text_water',
			rate_input: '#water_rates_input',
			btn: "#btn_water",
			reading: '#water_reading',

			date: '#reading_date_water',

			last_reading: '#water_last_reading',
			date_last: '#water_date_last',
			last_consumption: '#water_last_consumption',
			MM_name: '0MM001',
		})

		$(".input-reading-table-1").empty();
		$.post({
			url: "<?php WEB_ROOT ?>/input-reading/new-input-reading?display=plain",
			data: {
				utility_type: utility_type,
				month: $('#month').val(),
				year: $('#year').val()
			},
			success: function(result) {
				$(".input-reading-table-1").html(result);

				setTimeout(runRateCalculation, 10);
			}
		});

	}

	<?php $unique_id = $module . time(); ?>
	var t<?= $unique_id; ?>;


	// $(".btn-download").on('click', function() {
	// 	location = "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>";
	// });

	// $("#filterby").on('change', function() {
	// 	getFilter();
	// });

	// $(".btn-filter").on('click', function() {
	// 	filterby = $("#filterby option:selected").val();
	// 	filtertxt = $("#filtertxt").val();
	// 	t<?= $unique_id; ?>.options.colFilter[filterby] = filtertxt;
	// 	t<?= $unique_id; ?>.ajax.reload();
	// });

	// $(".btn-reset").on('click', function() {
	// 	filterby = $("#filterby option:selected").val();
	// 	$("#filtertxt").val('');
	// 	delete t<?= $unique_id; ?>.options.colFilter[filterby];
	// 	t<?= $unique_id; ?>.ajax.reload();
	// });


	$(document).on('click', '.btn-edit-reading', function(e) {
		$(this).closest('tr').find('.meter_reading').attr('disabled', false);
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

		$(".all-btn").removeClass('active1');
		$(".electricity-btn").removeClass('active1');
		$(".water-btn").addClass('active1');
	});
	$('.all-btn').on('click', function(e) {
		$(".all-btn").addClass('active1');
		$(".water-table").hide();
		$(".water-btn").removeClass('active1');
		$(".electricity-table").hide();
		$(".electricity-btn").removeClass('active1');
	});


	$('.electricity-btn').on('click', function(e) {
		$(".water-table").hide();
		$(".electricity-table").show();

		$(".all-btn").removeClass('active1');
		$(".electricity-btn").addClass('active1');
		$(".water-btn").removeClass('active1');

	});
</script>