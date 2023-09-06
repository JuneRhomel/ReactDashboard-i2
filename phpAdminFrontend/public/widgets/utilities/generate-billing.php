<?php
$title = "Generate Billing";
$module = "bills";
$table = "bills";
$view = "view_bills";

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
$data = [
	'view' => 'assoc_dues'
];
$assoc_dues = $ots->execute('utilities', 'get-association-dues', $data);
$assoc_dues = json_decode($assoc_dues);
// var_dump($assoc_dues->assoc_dues);
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
	'table' => 'bills',
	'view' => 'role_rights'

];
$role_access = $ots->execute('form', 'get-role-access', $data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>

<style>
	.aindata-body .datarow>div:not(:first-child) {
		padding-left: 20px !important;
		padding-right: 20px !important;

		/* overflow:auto; */
		position: relative;
	}

	.aindata-body .datarow>div:first-child {
		position: sticky;
		left: 0;
		z-index: 2;

		padding-left: 20px !important;
		padding-right: 20px !important;
	}

	.aindata-header>div:first-child {
		position: sticky;
		left: 0;
		z-index: 2;
		padding-left: 20px !important;
		padding-right: 20px !important;
	}

	.aindata-header>div:not(:first-child) {
		padding-left: 20px !important;
		padding-right: 20px !important;
	}
</style>

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
		<div class="modal" tabindex="-1" role="dialog" id='generate-billing-modal'>
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Do you want to Generate Statement?</h5>
						<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#generate-billing-modal").hide()' aria-label="Close">

						</button>
					</div>
					<div class="modal-body">
						<div class="billing_list_details">
							<table class='table w-40'>
								<tr>
									<td>Total</td>
									<td class='total'></td>
								</tr>
								<tr>
									<td>Zero Water Reading</td>
									<td class='zero-water'></td>
								</tr>
								<tr>
									<td>Zero Electricity Reading</td>
									<td class='zero-electricity'></td>
								</tr>
								<tr>
									<td>Zero Association Dues</td>
									<td class='zero-association-dues'></td>
								</tr>
							</table>
						</div>
						<p>
					</div>
					<div class="modal-footer">
						<button type="button" id='generate-statement' class="btn btn-primary btn-cancel px-5">Generate Statement</button>
					</div>
				</div>
			</div>

		</div>

		<div class="page-title"><?= $title ?></div>
		<div class="d-flex gap-4 my-5 align-items-center billing-rates" style="border-top: 1px solid #B4B4B4;">
			<div class="d-flex gap-4" style="width: 100%">
				<div class="col-12 col-sm-3">
					<label for="" class="text-required">Choose month to filter.</label>
					<br>
					<label for="" class="text-required mt-3">Month</label>
					<select name="month" class='form-select' id='month' onchange="get_assoc_dues()">
						<option value="1" <?= (date('m') == '1') ? 'selected' : '' ?>>January</option>
						<option value="2" <?= (date('m') == '2') ? 'selected' : '' ?>>February</option>
						<option value="3" <?= (date('m') == '3') ? 'selected' : '' ?>>March</option>
						<option value="4" <?= (date('m') == '4') ? 'selected' : '' ?>>April</option>
						<option value="5" <?= (date('m') == '5') ? 'selected' : '' ?>>May</option>
						<option value="6" <?= (date('m') == '6') ? 'selected' : '' ?>>June</option>
						<option value="7" <?= (date('m') == '7') ? 'selected' : '' ?>>July</option>
						<option value="8" <?= (date('m') == '8') ? 'selected' : '' ?>>August</option>
						<option value="9" <?= (date('m') == '9') ? 'selected' : '' ?>>September</option>
						<option value="10" <?= (date('m') == '10') ? 'selected' : '' ?>>October</option>
						<option value="11" <?= (date('m') == '11') ? 'selected' : '' ?>>November</option>
						<option value="12" <?= (date('m') == '12') ? 'selected' : '' ?>>December</option>
					</select>
				</div>

				<div class="col-12 col-sm-3 col-lg-3 col-xl-3 mt-3">
					<div class="form-group">
						<br>
						<label for="" class="text-required">Year</label>
						<select name="" class="form-select" id="year" required onchange="get_assoc_dues()">
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
					<br>
					<br>
					<button type="submit" class="btn btn-dark btn-primary px-5 show-month-year">Show</button>
				</div>
			</div>
			<div class="d-flex flex-row-reverse my-2 gap-2" style="width: 30%;">
				<div class="my-2">
					<br>
					<br>
					<?php if ($role_access->assoc_dues == true) : ?>
						<button type="button" class='btn btn-sm btn-primary float-end btn-view-form px-5' id="btn_edit_assoc" onclick="$('#edit-association-dues-modal').modal('show')">Edit</button>
					<?php endif; ?>
				</div>
				<div class="mx-2 my-2">
					<br>
					<label for="" class="text-required">Association Dues</label>
					<input type="text" class="input_0 form-control" name='dues' id='dues' disabled value='<?= $assoc_dues->assoc_dues ?>'>
				</div>
			</div>
		</div>
		<?php p_r($_SESSION['error']);
		unset($_SESSION['error']) ?>
		<div class="d-flex">

		</div>

		<div class="d-flex mb-2">
			<div class="d-flex align-items-end">
				<label class="text-label-result px-3 mb-0" id="search-result">
				</label>
			</div>
		</div>


		<div class="container-table">

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
		<div class="modal" tabindex="-1" role="dialog" id='edit-association-dues-modal'>
			<div class="modal-dialog  modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit Association Dues</h5>
						<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#edit-association-dues-modal").modal("hide")' aria-label="Close">

						</button>
					</div>
					<div class="modal-body">

						<!-- <h3 class="text-primary align-center">Renew</h3> -->
						<form action="<?= WEB_ROOT ?>/utilities/save-association-dues?display=plain" id='edit-assoc' method='post'>
							<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/utilities/generate-billing?submenuid=generate_billing'>
							<input type="hidden" name='error_redirect' id='redirect' value='<?= WEB_ROOT ?>/utilities/generate-billing?submenuid=generate_billing'>
							<input type="hidden" name='table' id='id' value='bills'>
							<input type="hidden" name='view_table' id='id' value='view_bills'>
							<input type="hidden" name='update_table' id='id' value='bills_update'>
							<input type="hidden" name='utility_type' id='utility_type' value='Electricity'>
							<!-- <input type="hidden" name='months'  id='month' value= '<?= date('m') ?>'>
						<input type="hidden" name='year'  id='year' value= '<?= (date('Y') - 1) ?>'> -->
							<table class="table table-data table-bordered">
								<tr>
									<th>Current Association Dues</th>
									<td><input type="text" class="input_0 form-control" id='dues_modal' disabled value='<?= $assoc_dues->assoc_dues ?>'></td>
								</tr>
								<tr>
									<th>Update Association Dues</th>
									<td><input type='number' id='new_dues' min="0" name=dues' class='form-control' style="background-color: #FFF385; box-shadow: 0pt 3pt 6pt #00000029; border-radius: 5pt 5pt 5pt 5pt; max-width: 100%; max-height: 100%"></td>
								</tr>
								<tr>
									<th></th>
									<td>
										<div class='d-flex justify-content-end'><button type='submit' class='btn btn-sm btn-primary float-end btn-view-form px-5 edit-bill-rates'>Save</button></div>
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
		<div class="btn-group-buttons pull-right">
			<div class="d-flex flex-row-reverse gap-2 my-2">
				<?php if ($role_access->send_out == true) : ?>
					<button type="button" class="btn btn-light btn-cancel px-5">Send Out</button>
				<?php endif; ?>
				<?php if ($role_access->generate == true) : ?>
					<button type="submit" class="btn btn-dark btn-primary px-5" onclick="$('#generate-billing-modal').show()" id='generate-button'>Generate</button>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
</div>
<script>
	<?php $unique_id = $module . time(); ?>
	var t<?= $unique_id; ?>;

	get_assoc_dues();

	function get_assoc_dues() {
		var c_date = <?= date('m') ?>;
		var c_year = <?= date('Y') ?>;
		var last_year = c_year - 1;

		//february and current year
		if (c_date >= 2 && c_year == $('#year').val()) {
			lastmonth = c_date - 1;

			if ($('#month').val() >= lastmonth && $('#month').val() <= c_date) {
				$('#btn_edit_assoc').prop("disabled", false);
			} else {
				$('#btn_edit_assoc').prop("disabled", "disabled");
			}
			//january yung month ng current year
		} else if (c_date == 1 && c_year == $('#year').val()) {
			if ($('#month').val() == c_date && $('#year').val() == c_year) {
				$('#btn_edit_assoc').prop("disabled", false);
			} else {
				$('#btn_edit_assoc').prop("disabled", "disabled");
			}
			//if year not equal to current
		} else if (c_year != $('#year').val()) {
			//if current month ais january of current year
			if ($('#month').val() == 12 && c_date == 1 && $('#year').val() == last_year) {
				$('#btn_edit_assoc').prop("disabled", false);
			} else {
				$('#btn_edit_assoc').prop("disabled", "disabled");
			}
		}

		$.ajax({
			url: "<?= WEB_ROOT ?>/utilities/get-billings?display=plain",
			type: 'POST',
			data: {
				month: $('#month').val(),
				year: $('#year').val()
			},
			dataType: 'JSON',
			success: function(data) {
				// console.log(data);
				if (data.billing_data.billed = "billed") {
					$('#btn_edit_assoc').prop("disabled", "disabled");
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {}
		});

		$('.show-month-year').off('click').on('click', function() {
			$.ajax({
				url: "<?= WEB_ROOT ?>/utilities/update-billing-info?display=plain",
				type: 'POST',
				data: {
					month: $('#month').val(),
					year: $('#year').val()
				},
				dataType: 'JSON',
				success: function(data) {
					// console.log(data);
				},
				error: function(jqXHR, textStatus, errorThrown) {}
			});

			$.ajax({
				url: "<?= WEB_ROOT ?>/utilities/get-association-dues?display=plain",
				type: 'POST',
				data: {
					month: $('#month').val(),
					year: $('#year').val()
				},
				dataType: 'JSON',
				success: function(data) {
					if (data.success == 1) {
						$('#dues').val(data.assoc_dues);
						$('#dues_modal').val(data.assoc_dues);
					}

				},
				complete: function() {
					filterby = 'month';
					filtertxt = $("#month").val();
					t<?= $unique_id; ?>.options.colFilter[filterby] = filtertxt;


					filterby = 'year';
					filtertxt = $("#year").val();
					t<?= $unique_id; ?>.options.colFilter[filterby] = filtertxt;

					t<?= $unique_id; ?>.ajax.reload();
				},
				error: function(jqXHR, textStatus, errorThrown) {}
			});
		});
	}


	$(document).ready(function() {
		$('#generate-statement').click(function() {
			Swal.fire({
				title: 'Do you want to generate?',
				showDenyButton: true,
				showCancelButton: true,
				confirmButtonText: 'Save',
				denyButtonText: `Don't save`,
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					$.ajax({
						url: "<?= WEB_ROOT; ?>/utilities/generate-unbilled-bills?display=plain",
						type: 'POST',
						data: {
							dues: $('#dues').val(),
							month: $('#month').val(),
							year: $('#year').val()
						},
						dataType: 'JSON',
						beforeSend: function() {

						},
						success: function(data) {

							if (data.success == 1) {
								Swal.fire({
									title: 'Successfully Saved!',
									type: 'success',
									showConfirmButton: false,
								});
								// $(".total").html(data.record_count.total);
								// $(".zero-water").html(data.record_count.zero_water_reading);
								// $(".zero-electricity").html(data.record_count.zero_electric_reading);
								// $(".zero-association-dues").html(data.record_count.zero_assoc_dues);
								// showSuccessMessage(data.description,function(){
								window.location.reload();
								// });
							}
						},
						complete: function() {

						},
						error: function(jqXHR, textStatus, errorThrown) {

						}
					});
				} else if (result.isDenied) {
					Swal.fire('Changes are not saved', '', 'info')
				}
			})

		});
		$("#generate-button").click(function() {

			$.ajax({
				url: "<?= WEB_ROOT; ?>/utilities/get-unbilled-bills?display=plain",
				type: 'POST',
				data: {
					dues: $('#dues').val(),
					month: $('#month').val(),
					year: $('#year').val()
				},
				dataType: 'JSON',
				beforeSend: function() {},
				success: function(data) {
					// console.log(data);
					if (data.success == 1) {
						$(".total").html(data.record_count.total);
						$(".zero-water").html(data.record_count.zero_water_reading);
						$(".zero-electricity").html(data.record_count.zero_electric_reading);
						$(".zero-association-dues").html(data.record_count.zero_assoc_dues);
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});
		});


		$('#edit-assoc').submit(function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: {
					dues: $('#new_dues').val(),
					month: $('#month').val(),
					year: $('#year').val()
				},
				dataType: 'JSON',
				beforeSend: function() {},
				success: function(data) {
					if (data.success == 1) {
						show_success_modal($('input[name=redirect]').val());
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});

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
				url: "<?= WEB_ROOT . "/utilities/get-list/{$view}?display=plain" ?>"
			},
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			buttons: [
				// {
				// 	icon: `<span class="material-symbols-outlined">delete</span>`,
				// 	title: "Delete",
				// 	class: "btn-delete-filter",
				// 	id: "delete",
				// }, 
				{
					icon: `<span class="material-symbols-outlined">filter_list</span>`,
					title: "Filter",
					class: "filter",
				}

			],
			columns: [{
					data: "rec_id",
					label: "ID",
					class: 'table-id',
					datatype: "none",
					// render: function(data, row) {
					// 	console.log(row)
					// 	return '<input type="checkbox"  class="checkbox-icon " id="' + row.id + '" name="check_box" table="equipments" view_table="view_equipments"  reload="<?= WEB_ROOT; ?>/property-management/equipment?submenuid=equipment">' +
					// 		data
					// }
				},
				{
					data: 'area',
					label: 'Area',
					class: ' ',
					datatype: "none",
				},
				{
					data: 'tenant_name',
					label: "Name",
					class: '',
					datatype: "none",
				},
				{
					data: 'association_dues',
					label: 'Association </br> Dues',
					class: '',
					datatype: "none",
				},
				{
					data: 'water',
					label: 'Water',
					class: '',
					datatype: "none",
				},
				{
					data: 'electricity',
					label: 'Electricity',
					class: '',
					datatype: "none",
				},

				{
					data: 'total_amount_due',
					label: 'Total </br> Amount Dues',
					class: '',
					datatype: "none",
				},
				{
					data: 'billed',
					label: 'Status',
					class: '',
					datatype: "select",
					list: ['Unbilled']
				},
				{
					data: null,
					label: "Action",
					class: ' ',
					render: function(data, row) {
						return '<a class="btn btn-sm text-primary btn-delete" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" rec_id="' + row.rec_id + '" title="Delete ID ' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=bills&view_table=view_bills&redirect=/utilities/generate-billing?submenuid=generate_billing"><i class="bi bi-trash-fill"></i></a>';
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