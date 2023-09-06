<?php
$title = "Meter Reading History";
$module = "tenant";
$table = "meters";
$view = "view_meters";
$fields = rawurlencode(json_encode([
	"ID" => "id",
	"Contracts Name" => "contract_name",
	"Contract_number" => "contract_number"
]));

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
	'table' => 'view_meters',
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
		<div class="d-flex gap-4 my-5 align-items-center" style="border-top: 1px solid #B4B4B4; border-bottom: 1px solid #B4B4B4;">

			<div class="col-12 col-sm-3 my-4">
				<label for="" class="text-required">Choose month and floor to input new reading</label>
				<div class="form-group">
					<label for="" class="text-required">Month</label>
					<select name="month" class='form-select' id='month' onchange="load_input_reading_table()">
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
			<div class="col-12 col-sm-3 col-lg-3 col-xl-3 mt-3">
				<div class="form-group">
					<label for="" class="text-required">Year</label>
					<select name="" class="form-select" id="year" required onchange="load_input_reading_table()">
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
			<div class="col-12 col-sm-4 my-4">
				<div class="form-group">
					<br><br>
					<button type="submit" class="btn btn-dark btn-primary px-5">Enter</button>
				</div>
			</div>
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
		<div class="d-flex justify-content-between mb-2">
			<div class="d-flex align-items-end">
				<label class="text-label-result px-3 mb-0" id="search-result">
				</label>
			</div>
		</div>

		<div class="d-flex justify-content-between">
			<div class="d-flex">
				<button class="btn electricity-btn active1" onclick="load_input_reading_table('electrical')" utility-type='electricity' uom='Kilowatt-hour (KwHR)'>Electricity</button>
				<button class="btn water-btn" onclick="load_input_reading_table('water')" utility-type='water' uom='Cubic Meter (CuM)'>Water</button>
			</div>
			<div class="my-1">
				<?php if ($role_access->create == true) : ?>
					<button type='submit' class="btn btn-sm ml-auto p-2 mt-3 me-3 my-2 btn-add" form="new-input-reading-form">Input New Reading </button>
				<?php endif; ?>
			</div>
		</div>
		<div class="bg-white pb-2 px-2 pt-0 rounded">
			<!-- <button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-download">Download <i class="bi bi-download"></i></button> -->
			<div class="d-flex flex-wrap align-items-center justify-content-between py-2" style="border-bottom: 1px solid">

				<div>
					<button type="button" class="btn btn-sm filter">
						Filter
					</button>
					<div class="dropdown-menu-filter dropdown-menu my-5 px-2" style="width: 22%" id="dropdownmenufilter">
						<div class="dropdown-menu-filter-fields">
							<div class="card mb-3">
								<div class="mb-0">
									<button class="d-flex align-items-center justify-content-between btn btn-status w-100">
										<div>Status</div>
										<div><i id="down1" class="bi bi-caret-down-fill"></i><i id="up1" class="bi bi-caret-up-fill"></i></div>
									</button>
								</div>
								<div id="collapse-status" class="collapse">
									<div class="card-body">
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="status-new" id="status-new"></div>
											<div>New</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="status-open" id="status-open"></div>
											<div>Open</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="status-aging" id="status-aging"></div>
											<div>Aging</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="status-closed" id="status-closed"></div>
											<div>Closed</div>
										</div>
									</div>
								</div>
							</div>

							<div class="mb-3">
								<input type="date" name='issued_date' class="form-control" placeholder="date">
							</div>

							<div class="card mb-3">
								<div class="mb-0">
									<button class="d-flex align-items-center justify-content-between btn btn-priority-level w-100">
										<div>Priority Level</div>
										<div><i id="down3" class="bi bi-caret-down-fill"></i><i id="up3" class="bi bi-caret-up-fill"></i></div>
									</button>
								</div>
								<div id="collapse-priority-level" class="collapse">
									<div class="card-body">
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="priority-1" id="priority-1"></div>
											<div>Priority 1</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="priority-2" id="priority-2"></div>
											<div>Priority 2</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="priority-3" id="priority-3"></div>
											<div>Priority 3</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="priority-4" id="priority-4"></div>
											<div>Priority 4</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="priority-5" id="priority-5"></div>
											<div>Priority 5</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card mb-3">
								<div class="mb-0">
									<button class="d-flex align-items-center justify-content-between btn btn-stages w-100">
										<div>Stages</div>
										<div><i id="down4" class="bi bi-caret-down-fill"></i><i id="up4" class="bi bi-caret-up-fill"></i></div>
									</button>
								</div>
								<div id="collapse-stages" class="collapse">
									<div class="card-body">
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="stage-open" id="stage-open"></div>
											<div>Open</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="stage-acknowledged" id="stage-acknowledged"></div>
											<div>Acknowledged</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="stage-work-started" id="stage-work-started"></div>
											<div>Work Started</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="stage-work-completed" id="stage-work-completed"></div>
											<div>Work Completed</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="stage-prop-manager-verification" id="stage-prop-manager-verification"></div>
											<div>Property Manager Verification</div>
										</div>
										<div class="d-flex align-items-center gap-2">
											<div><input type="checkbox" class="form-check-input my-2" name="stage-closed" id="stage-closed"></div>
											<div>Closed</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="btn-group-buttons mt-5">
							<div class="d-flex flex-row-reverse mb-3" style="padding: 5px;">
								<button type="button" class="btn btn-dark btn-primary btn-filter-now px-5" style="border-radius: 20px 20px 20px 20px">Save</button>
							</div>
						</div>
					</div>
					<?php if ($role_access->delete == true) : ?>
						<button class="btn btn-sm btn-delete-filter">Delete</button>
					<?php endif; ?>
					<?php if ($role_access->download == true) : ?>
						<button class="btn btn-sm btn-download">Download</button>
					<?php endif; ?>
					<?php if ($role_access->import == true) : ?>
						<button class="btn btn-sm btn-import">Import</button>
					<?php endif; ?>
				</div>

				<div class="position-relative col-4">
					<input type="search" class="form-control search-box" placeholder="Search" id="searchbox">
					<i class="bi bi-search position-absolute" style="right: 5px; top: 4px; font-size: 17px; color: #B4B4B4;"></i>
				</div>

				<!-- <div class="col-3">
				<label>Status</label>
				<div>
					<button class="btn btn-primary btn-filter-status" type="button">Pending</button>
					<button class="btn btn-secondary btn-filter-status" type="button">Approved</button>
					<button class="btn btn-secondary btn-filter-status" type="button">Disapproved</button>
				</div>
			</div> -->
			</div>


		</div>

		<form action="<?php WEB_ROOT ?>/utilities/new-input-reading-save?display=plain" method='post' id='new-input-reading-form'>
			<input type="hidden" id="utility_type" />
			<div class="input-reading-table-1">

			</div>
		</form>
	<?php endif; ?>
</div>

<script>



	load_input_reading_table();

	function load_input_reading_table(utility_type = 'electrical') {
		utility = '';
		if (utility_type == 'electrical') {
			utility = 'electricity';
		} else {
			utility = utility_type;
		}
		$.post({
			url: "<?php WEB_ROOT ?>/utilities/get-billing-rates?display=plain",
			data: {
				utility_type: utility.charAt(0).toUpperCase() + utility.slice(1),
				month: $('#month').val(),
				year: '<?= date('Y') ?>'
			},
			success: function(result) {
				result = JSON.parse(result);
				if (result.billing_data.rates == null) {
					// alert('no billing has been entered for this month');
				}
			}
		});


		$(".input-reading-table-1").empty();
		$.post({

			url: "<?php WEB_ROOT ?>/utilities/meter-reading-history-table?display=plain",
			data: {
				utility_type: utility_type,
				month: $('#month').val(),
				year: '<?= date('Y') ?>'
			},
			success: function(result) {
				$(".input-reading-table-1").html(result);
			}
		});
	}


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

		// $(".btn-add").off('click').on('click',function(){
		// 	window.location.href = "<?= WEB_ROOT . "/utilities/"; ?>new-input-reading";
		// });

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
			pageLength: 10,
			searchBoxID: 'searchbox',
			filterBoxID: 'dropdownmenufilter',
			prefix: 'mrh',
			ajax: {
				url: "<?= WEB_ROOT . "/utilities/get-list/{$view}?display=plain" ?>"
			},
			onDataChanged: function() {
				$('.permit-expired').closest('.row-list').addClass('bg-danger text-light');

				$('.permit-notify').closest('.row-list').addClass('bg-warning');

				$('.permit-notify').closest('.row-list').addClass('light-blue-bg');

			},
			columns: [{
					data: "meter_name",
					label: "Meter Name/ID",
					class: ''
				},
				{
					data: null,
					label: "Last Reading",
					class: ''

				},
				{
					data: "unit_area",
					label: "New Reading",
					class: '',
				},
				{
					data: "unit_area",
					label: "Consumption",
					class: '',
				},
				{
					data: null,
					label: "Amount",
					class: 'col-1'
				},
				{
					data: null,
					label: "Owner Email",
					class: '',
				},
				// {
				// 	data: "owner_username",
				// 	label: "Owner Username",
				// 	class: ''
				// },
				// {
				// 	label: "Type",
				// 	class: 'col-1'
				// },
				// {
				// 	label: "Billing",
				// 	class: 'col-1'
				// },
				{
					data: null,
					label: "Action",
					class: 'col-1 d-flex align-items-center',
					render: function(data, row) {
						return '<a class="btn btn-sm text-primary btn-delete" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" rec_id="' + row.rec_id + '" title="Delete ID ' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=meters&view_table=view_meters&redirect=/utilities/meter-reading-history?submenuid=meter_reading_history"><i class="bi bi-trash-fill"></i></a>';
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