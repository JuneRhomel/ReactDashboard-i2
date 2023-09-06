<?php
$title = "Tenant Billing";
$module = "tenant";
$table = "tenant";
$view = "view_soa";
$fields = rawurlencode(json_encode(
	[
		"ID" => "rec_id",
		// "Status" => "created_by",
		// "Date" => "date",
		// "Owner Name" => "tenant_name",
		// "Previous Balance" => "balance_from_previous_formated",
		// "Remaining Balance" => "remaining_balance_formated",
		"Current Charges" => "amount_due",
		"Total Amount Due" => "total_amount_due",

	]
));

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
	'table' => 'soa',
	'view' => 'role_rights'

];
$role_access = $ots->execute('form', 'get-role-access', $data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>
<style>
	/* .aindata-body .datarow > div:not(:first-child) {
	overflow:auto;
	position: relative;
}
.aindata-body .datarow > div:first-child{
position: sticky;
left: 0;
z-index: 2;
}

.aindata-header > div:first-child{
position: sticky;
left: 0;
z-index: 2;
border: 1px solid #FFFFFF;
background-color:#BCE0FD !important;

}
.aindata-header > div:not(:first-child) {
	border: 1px solid #FFFFFF;
	background-color:#BCE0FD !important;
}
.div.aindata-header{
	background-color:#FFFFFF !important;
} */
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

		<div class="modal" tabindex="-1" role="dialog" id='pay-now'>
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content px-1 pb-4 pt-2">
					<div class="modal-header flex-row-reverse pb-0" style="border-bottom: 0px;">
						<!-- <h5 class="modal-title">Payments</h5> -->
						<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#pay-now").modal("hide")' aria-label="Close">
							<span aria-hidden="true" class=''>&nbsp;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?= WEB_ROOT; ?>/tenant/tenant-pay-now?display=plain" method='post' id='form-paynow' enctype="multipart/form-data">
							
							<h3 class="pay-text">Payments</h3>
							<p class="req-text">*Please fill in the required field</p>
							<div class="d-flex flex-wrap justify-content-center align-items-center gap-4">
								<div class="col-12 input-box">
									<input type="text" class="form-control" name="soa_id" id="soa_id">
									<label>SOA Number</label>
								</div>

								<div class="col-12 input-box">
									<input type="text" class="form-control" id="total_amount_due">
									<label>Total Amount</label>
								</div>

								<div class="col-12 input-box">
									<input type="text" class="form-control" name="amount" id="amount">
									<label>Amount</label>
								</div>

								<div class="col-12 input-box">
									<input type="text" class="form-control" name="reference_number" id="amount">
									<label>Reference</label>
								</div>

								<div class="col-12 input-box">
									<select name="type_of_payment" class="form-select" id="">
										<option value="cash">Cash</option>
										<option value="check">Check</option>
									</select>
									<label>Type of payment</label>
								</div>

								<div class="d-flex justify-content-end gap-4 w-100">
									<button type="submit" id='pay-now-button' class="main-btn " onclick='show_success_paynow_modal();'>Submit</button>
									<button class='main-cancel  ' onclick='$("#pay-now").modal("hide")'>Cancel</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>

		<div class="modal" tabindex="-1" role="dialog" id='access-denied'>
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content px-1 pb-4 pt-2">
					<div class="modal-header flex-row-reverse pb-0" style="border-bottom: 0px;">
						<!-- <h5 class="modal-title">Payments</h5> -->
						<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#access-denied").modal("hide")' aria-label="Close">
							<span aria-hidden="true" class=''>&nbsp;</span>
						</button>
					</div>
					<div class="modal-body">
						<h3 class="modal-title text-primary align-center text-center mb-3">Access Denied!</h3>
						<div class="d-flex flex-wrap justify-content-center align-items-center gap-4">
							<div class="d-flex justify-content-center gap-4 w-100">
								<a class='btn btn-light btn-cancel px-5' onclick='$("#access-denied").modal("hide")'>Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal" tabindex="-1" role="dialog" id='view-soa'>
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content px-1 pb-4 pt-2">
					<div class="modal-header flex-row-reverse pb-0" style="border-bottom: 0px;">
						<!-- <h5 class="modal-title">Payments</h5> -->
						<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#view-soa").modal("hide")' aria-label="Close">
							<span aria-hidden="true" class=''>&nbsp;</span>
						</button>
					</div>
					<div class="modal-body">
					</div>
				</div>
			</div>

		</div>
</div>
<?php endif; ?>
<script>
	// function show_renew_modal(button_data){
	// 	id = $(button_data).attr('id');
	// 	$('#renew').modal('show');
	// 	$('#renew .modal-title').html($(button_data).attr('title'));
	// 	$('#renew .modal-body input#renew_id').val(id);
	// }

	get_billing_month();

	function get_billing_month() {
		$('.show-month').off('click').on('click', function() {
			$.ajax({
				url: "<?= WEB_ROOT ?>/tenant/tenant-billing?display=plain",
				type: 'POST',
				data: {
					month: $('#month').val(),
					year: $('#year').val(),
				},
				dataType: 'JSON',
				beforeSend: function(data) {},
				success: function(data) {
					// if(data.success == 1)
					// {
					// 	$('#jsdata').val(data.assoc_dues.dues);
					// }	

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

	function pay_now(button) {
		soa_id = button.attr('soa_id');
		$("#soa_id").val(soa_id);

		total_amount_due = button.attr('total_amount_due');

		$("#total_amount_due").val(total_amount_due);
	}
	<?php $unique_id = $module . time(); ?>
	var t<?= $unique_id; ?>;
	$(document).ready(function() {
		$("#form-paynow").submit(function(e) {
			e.preventDefault();

			$.ajax({
				url: $(this).prop('action'),
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
			// rowLink: {
			// 	url: '<?= WEB_ROOT; ?>/property-management/view-equipment/',
			// 	params : [
			// 		{
			// 			"key":"id",
			// 			"value": "encryptedid"
			// 		}
			// 	],
			// },
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			buttons: [{
					icon: `<span class="material-symbols-outlined">add</span>`,
					title: "Create New",
					class: "btn-add btn-blue",
					id: "edit",

				},
				//
				// <?php if ($role_access->delete == true) : ?> {
				// 	icon: `<span class="material-symbols-outlined">delete</span>`,
				// 		title: "Delete",
				// 		class: "btn-delete-filter",
				// 		id: "delete",
				// 	},
				// <?php endif; ?>
				//
				<?php if ($role_access->download == true) : ?> {
						icon: `<span class="material-symbols-outlined">arrow_downward</span>`,
						title: "Download",
						class: "btn-download",
						href: "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>",
						id: "download",
					},
				<?php endif; ?> {
					icon: `<span class="material-symbols-outlined">filter_list</span>`,
					title: "Filter",
					class: "filter",
				}

			],
			columns: [{
					data: "id",
					label: "ID",
					class: ' table-id',
					datatype: "none",
					render: function(data, row) {
						return row.data_id
						// return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="tenant" view_table="view_soa" reload="<?= WEB_ROOT; ?>/tenant/tenant-billing?submenuid=tenant_billing"> ' + row.data_id;
					}
				},
				{
					data: "remaining_balance",
					label: "Status",
					class: '',
					datatype: "select",
					list: ["0|Paid", "1|Unpaid"],
					render: function(data, row) {
						// console.log(data)
						if (row.remaining_balance_formated <= 0) {
							return '<div class="data-box-y">Paid</div>';
						} else {
							return  '<div class="data-box-n">Unpaid</div>';
						}
					},

				},
				{
					data: 'tenant_name',
					label: "Name",
					class: '',
					datatype: "none",
				},
				{
					data: 'remaining_balance_formated',
					label: "Outstanding </br> Balance",
					class: ' ',
					datatype: "none",
					render: function(data, row) {
						d = parseFloat(data);
						return '₱ ' + d.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
					}

				},
				{
					data: 'amount_due',
					label: "Current </br> Charges",
					class: ' ',
					datatype: "none",
					render: function(data, row) {
						d = parseFloat(data);
						return '₱ ' + d.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
					}
				},
				{
					data: 'total_amount_due',
					label: 'Total </br> Amount Due',
					class: '',
					datatype: "none",
					render: function(data, row) {
						d = parseFloat(data);
						return '₱ ' + d.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
					}
				},
				{
					data: null,
					label: "Billing",
					class: ' ',
					datatype: "none",
					render: function(data, row) {
						return '<a class="view-text" href="<?= WEB_ROOT; ?>/tenant/view-billing/'+row.id+	'">View</a>'
					}

				},
				{
					data: null,
					label: "Action",
					class: '',
					datatype: "none",
					render: function(data, row) {
						if (row.remaining_balance > 0) {
							d = parseFloat(row.total_amount_due);
							amount = d.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
							return '<a class="btn btn-sm btn-primary pay-button" total_amount_due="' + amount + '" onclick="<?= ($role_access->paynow == true) ? "$(\'#pay-now\').modal(\'show\');pay_now($(this))" : "$(\'#access-denied\').modal(\'show\');" ?> " title="Pay ID ' + row.rec_id + '" soa_id= ' + row.rec_id + ' hr="<?= WEB_ROOT ?>/contracts/view-permit/' + row.id + '/View">Pay Now</a> ' +
								'<a class="btn btn-sm text-primary btn-delete" onclick="show_delete_modal(this)" rec_id="' + row.rec_id + '" role_access="<?= $role_access->delete ?>" title="Delete ID ' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=tenant&view_table=view_tenant&redirect=/tenant/tenant-list?submenuid=tenant_list"><i class="bi bi-trash-fill"></i></a>';
						} else {
							return '<a class="btn btn-sm text-primary btn-delete" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" rec_id="' + row.rec_id + '" title="Delete ID ' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=tenant&view_table=view_tenant&redirect=/tenant/tenant-list?submenuid=tenant_list"><i class="bi bi-trash-fill"></i></a>';
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
		$(".btn-add").off('click').on('click', function() {
			window.location.href = "<?= WEB_ROOT . "/tenant/"; ?>form-add-tenant-list";
		});
		$(document).on("click", ".row-id", function() {
			// var data = table.row(this).data();
			var id = $(this).data("id");
			window.location.href = "<?= WEB_ROOT ?>/tenant/view-soa/" + id + "/View";
			// console.log(data);
			// alert('div clicked')
		});

		$(document).on("click", '.btn-delete', function(evt) {
			evt.stopPropagation();
		});

		$(document).on("click", '.btn-download-icon', function(evt) {
			evt.stopPropagation();
		});

		$(document).on("click", '.pay-button', function(evt) {
			evt.stopPropagation();
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


		$('.btn-view-soa').on('click', function(e) {
			e.preventDefault();
			alert('test');
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
	});
</script>