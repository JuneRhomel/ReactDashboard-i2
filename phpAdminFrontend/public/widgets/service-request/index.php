<?php

$title = "Service Request";
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
$fields = rawurlencode(json_encode(["ID" => "id", "Requestor Name" => "requestor_name", "Unit" => "unit", "Description" => "description"]));

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
	'table' => 'sr',
	'view' => 'role_rights'

];
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
		<div class="main-content">
			<!-- Navigation -->

			<!--  -->

			<div class="d-flex justify-content-between mb-2">
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
						<button class="w-12 btn tabs-table all-btn active1" onclick="request_type('all')">All</button>
						<button class="w-12 btn tabs-table ur-btn" onclick="request_type('unit-repair')">Unit Repair</button>
						<button class="w-12 btn tabs-table gp-btn" onclick="request_type('gate-pass')">Gate Pass</button>
						<button class="w-12 btn tabs-table vp-btn" onclick="request_type('visitor-pass')">Visitor's Pass</button>
						<button class="w-12 btn tabs-table res-btn" onclick="request_type('reservation')">Reservation</button>
						<button class="w-12 btn tabs-table mi-btn" onclick="request_type('move-in')">Move-in</button>
						<button class="w-12 btn tabs-table mo-btn" onclick="request_type('move-out')">Move-out</button>
						<button class="w-12 btn tabs-table wo-btn" onclick="request_type('work-permit')">Work Permit</button>
					</div>

				</div>
				<table id="jsdata"></table>

			</div>
		</div>


		<div class="modal modal-service-request" tabindex="-1" role="dialog" id='sr'>
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content" style="border-radius: 10px 10px 10px 10px;">
					<div class="modal-header" style="border-bottom: none;">
						<div class="d-flex justify-content-center flex-wrap" style="width: 100%">
							<h5 class="modal-title mb-1" style="color: #1C5196">Create New Service Request</h5>
							<label class="text-required">Choose Service Request Category</label>
						</div>
						<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" onclick='$("#sr").modal("hide")'>
							<span aria-hidden="true"></span>
						</button>
					</div>
					<div class="modal-body pt-0">
						<div class="d-flex justify-content-center gap-4">
							<div>
								<div class="d-flex align-items-center my-2 gap-2">
									<input type="radio" id="service-request" name="service-request" value="unit-repair">
									<label for="unit-repair">Unit Repair</label>
								</div>
								<div class="d-flex align-items-center my-2 gap-2">
									<input type="radio" id="service-request" name="service-request" value="gate-pass">
									<label for="gate-pass">Gate Pass</label>
								</div>
								<div class="d-flex align-items-center my-2 gap-2">
									<input type="radio" id="service-request" name="service-request" value="visitor-pass">
									<label for="visitor-pass">Visitor's Pass</label>
								</div>
								<div class="d-flex align-items-center my-2 gap-2">
									<input type="radio" id="service-request" name="service-request" value="reservation">
									<label for="visitor-pass">Reservation</label>
								</div>
							</div>

							<div>
								<div class="d-flex align-items-center my-2 gap-2">
									<input type="radio" id="service-request" name="service-request" value="move-in">
									<label for="move-in">Move-In</label>
								</div>
								<div class="d-flex align-items-center my-2 gap-2">
									<input type="radio" id="service-request" name="service-request" value="move-out">
									<label for="move-out">Move-Out</label>
								</div>
								<div class="d-flex align-items-center my-2 gap-2">
									<input type="radio" id="service-request" name="service-request" value="work-permit">
									<label for="work-permit">Work Permit</label>
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-center">
							<button class="btn btn-sm btn-primary mt-3 me-3 px-5 proceed" style="font-weight: 600">Proceed </i></button>
							<button class="btn btn-light btn-cancel btn-primary mt-3 me-3 px-5 cancel" style="background-color: transparent; color: #1C5196">Cancel </i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
<?php endif; ?>
<script>
	var filter;



	$(".cancel").on("click", function() {
		$(".modal-service-request").modal('hide');
	});

	function show_renew_modal(button_data) {
		id = $(button_data).attr('id');
		$('#renew').modal('show');
		$('#renew .modal-title').html($(button_data).attr('title'));
		$('#renew .modal-body input#renew_id').val(id);
	}


	<?php $unique_id = $module . time(); ?>
	var t<?= $unique_id; ?>;
	$(document).ready(function() {
		$('#form-renew').submit(function(e) {
			data = $(this).serialize();
			e.preventDefault();
			$.post({
				url: '<?= WEB_ROOT ?>/contracts/renew-permits?display=plain',
				data: data,
				success: function(result) {
					result = JSON.parse(result);
					if (result.success == 1) {
						location.reload();
					}
				}
			});

		});

		// $(".new").on('click',function(){
		// $(".modal-service-request").modal('show');
		// });


		$(".btn-add").off('click').on('click', function() {
			$(".modal-service-request").modal('show');
		});

		$(".close").off('click').on('click', function() {
			$(".modal-service-request").modal('hide');
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

		<?php if (isset($_GET['filter'])) : ?>
			filter = {
				<?= $_GET['filter']; ?>: "<?= $_GET['value']; ?>"
			};
		<?php endif; ?>


		t<?= $unique_id; ?> = $("#jsdata").JSDataList({
			prefix: 'gatepass',
			ajax: {
				url: "<?= WEB_ROOT . "/module/get-list/{$view}?display=plain" ?>"
			},
			// rowLink: {
			// 	url: '<?= WEB_ROOT; ?>/property-management/view-unit-repair/',
			// 	params: [{
			// 		"key": "id",
			// 		"value": "encryptedid"
			// 	}],
			// },
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			addonsclass: "addons-m",
			buttons: [{
					icon: `<span class="material-symbols-outlined">add</span>`,
					title: "Create New",
					class: " btn-blue proceed",
					id: "edit",
					// href: "<?= WEB_ROOT ?>/property-management/form-add-equipment",
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
					data: "rec_id",
					label: "Ticket #",
					class: 'w-10',
					datatype: "none",
				},
				{
					data: 'approve',
					label: "Status",
					class: 'table-id',
					datatype: "select",
					list: ["Open", "Approved"],
					render: function(data, row) {
						if (row.approve == 0) {
							return "Open"
							if (row.sr_type == 'unit-repair') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="unit_repair" view_table="view_unit_repair" reload="<?= WEB_ROOT; ?>/service-request/> Open';
							} else if (row.sr_type == 'gate-pass') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="gate_pass" view_table="view_gate_pass" reload="<?= WEB_ROOT; ?>/service-request/> Open';
							} else if (row.sr_type == 'visitor-pass') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="visitor_pass" view_table="view_visitor_pass" reload="<?= WEB_ROOT; ?>/service-request/> Open';
							} else if (row.sr_type == 'reservation') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="reservation" view_table="view_reservation" reload="<?= WEB_ROOT; ?>/service-request/> Open';
							} else if (row.sr_type == 'move-in') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="move_in" view_table="view_move_in" reload="<?= WEB_ROOT; ?>/service-request/> Open';
							} else if (row.sr_type == 'move-out') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="move_out" view_table="view_move_out" reload="<?= WEB_ROOT; ?>/service-request/> Open';
							} else if (row.sr_type == 'work-permit') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="work_permit" view_table="view_work_permit" reload="<?= WEB_ROOT; ?>/service-request/> Open';
							}
						} else {
							return "Approved"
							if (row.sr_type == 'unit-repair') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="unit_repair" view_table="view_unit_repair" reload="<?= WEB_ROOT; ?>/service-request/> Approved';
							} else if (row.sr_type == 'gate-pass') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="gate_pass" view_table="view_gate_pass" reload="<?= WEB_ROOT; ?>/service-request/> Approved';
							} else if (row.sr_type == 'visitor-pass') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="visitor_pass" view_table="view_visitor_pass" reload="<?= WEB_ROOT; ?>/service-request/> Approved';
							} else if (row.sr_type == 'reservation') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="reservation" view_table="view_reservation" reload="<?= WEB_ROOT; ?>/service-request/> Approved';
							} else if (row.sr_type == 'move-in') {
								return '<input class="d-nonetext-center  d-lg-block" type="checkbox" id="' + row.id + '" name="check_box" table="move_in" view_table="view_move_in" reload="<?= WEB_ROOT; ?>/service-request/> Approved';
							} else if (row.sr_type == 'move-out') {
								return '<input class="k" type="checkbox" id="' + row.id + '" name="check_box" table="move_out" view_table="view_move_out" reload="<?= WEB_ROOT; ?>/service-request/> Approved';
							} else if (row.sr_type == 'work-permit') {
								return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="work_permit" view_table="view_work_permit" reload="<?= WEB_ROOT; ?>/service-request/> Approved';
							}
						}
					}
				},
				{
					data: "requestor_name",
					label: "Requestor",
					class: '',
					datatype: "none",
					render: function(data, row) {
						name = row.tenant_name;

						if (row.sr_type == 'unit-repair') {
							return '<a href="<?= WEB_ROOT; ?>/service-request/view-unit-repair/' + row.id + '/View" target="_self">' + name + '</a>';
						} else if (row.sr_type == 'gate-pass') {
							return '<a href="<?= WEB_ROOT; ?>/service-request/view-gate-pass/' + row.id + '/View" target="_self">' + name + '</a>';
						} else if (row.sr_type == 'visitor-pass') {
							return '<a href="<?= WEB_ROOT; ?>/service-request/view-visitor-pass/' + row.id + '/View" target="_self">' + name + '</a>';
						} else if (row.sr_type == 'reservation') {
							return '<a href="<?= WEB_ROOT; ?>/service-request/view-reservation/' + row.id + '/View" target="_self">' + name + '</a>';
						} else if (row.sr_type == 'move-in') {
							return '<a href="<?= WEB_ROOT; ?>/service-request/view-move-in/' + row.id + '/View" target="_self">' + name + '</a>';
						} else if (row.sr_type == 'move-out') {
							return '<a href="<?= WEB_ROOT; ?>/service-request/view-move-out/' + row.id + '/View" target="_self">' + name + '</a>';
						} else if (row.sr_type == 'work-permit') {
							return '<a href="<?= WEB_ROOT; ?>/service-request/view-work-permit/' + row.id + '/View" target="_self">' + name + '</a>';
						} else {
							return name;
						}
					}
				},
				{
					data: "created_on",
					label: "Date",
					class: '',
					datatype: "none",
					render: function(data, row) {
						var d = new Date(data * 1000);
						var c = new Date();
						var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
						return months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
					},
				},
				{
					data: "unit",
					label: "Unit #",
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
					data: "priority_level",
					label: "Priority",
					class: '',
					datatype: 'select',
					list: ['1|Priority', '2|Priority', '3|Priority ', '4|Priority', '5|Priority'],
					render: function(data, row) {
						return data ? "Priority " + data : " "
					}
				},
				// {
				// 	data: "approve",
				// 	visible: false,
				// },
				{
					data: null,
					label: "Action",
					class: "text-left",
					class: '',

					render: function(data, row) {

						if (row.approve == 0) {
							style = '';
						} else {

							style = 'display:none';
						}

						if (row.sr_type == 'unit-repair') {
							return '<a class="btn btn-sm text-primary btn-delete-icon" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=unit_repair&view_table=view_unit_repair&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash-fill"></i></a>' +
								' ' + ' <a class="btn btn-sm btn-primary btn-approved" style="' + style + '" data-id=' + row.rec_id + ' data-approved="1" data-type="unit-repair" href="#">Approve</a> ' +
								' <a class="btn btn-sm btn-outline-primary btn-deny"  style="' + style + '" data-id=' + row.rec_id + ' data-approved="0" data-type="unit-repair" href="#">Deny</a>';
						} else if (row.sr_type == 'gate-pass') {
							return ' <a class="btn btn-sm text-primary btn-delete-icon" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=gate_pass&view_table=view_gate_pass&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash-fill"></i></a>' +
								' ' + ' <a class="btn btn-sm btn-primary btn-approved" style="' + style + '" data-id=' + row.rec_id + ' data-approved="1" data-type="gate-pass" href="#">Approve</a> ' +
								' <a class="btn btn-sm btn-outline-primary btn-deny" style="' + style + '"  data-id=' + row.rec_id + ' data-approved="0" data-type="gate-pass" href="#">Deny</a>';
						} else if (row.sr_type == 'visitor-pass') {
							return ' <a class="btn btn-sm text-primary btn-delete-icon" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=visitor_pass&view_table=view_visitor_pass&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash-fill"></i></a>' +
								' ' + ' <a class="btn btn-sm btn-primary btn-approved" style="' + style + '" data-id=' + row.rec_id + ' data-approved="1" data-type="visitor-pass" href="#">Approve</a>' +
								' <a class="btn btn-sm btn-outline-primary btn-deny"  style="' + style + '" data-id=' + row.rec_id + ' data-approved="0" data-type="visitor-pass" href="#">Deny</a>';
						} else if (row.sr_type == 'reservation') {
							return ' <a class="btn btn-sm text-primary btn-delete-icon" onclick="show_delete_modal(this)"  role_access="<?= $role_access->delete ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=reservation&view_table=view_reservation&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash-fill"></i></a>' +
								' ' + ' <a class="btn btn-sm btn-primary btn-approved" style="' + style + '" data-id=' + row.rec_id + ' data-approved="1" data-type="reservation" href="#">Approve</a> ' +
								' <a class="btn btn-sm btn-outline-primary btn-deny" style="' + style + '"  data-id=' + row.rec_id + ' data-approved="0" data-type="reservation" href="#">Deny</a>';
						} else if (row.sr_type == 'move-in') {
							return ' <a class="btn btn-sm text-primary btn-delete-icon" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=move_in&view_table=view_move_in&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash-fill"></i></a>' +
								' ' + ' <a class="btn btn-sm btn-primary btn-approved" style="' + style + '" data-id=' + row.rec_id + ' data-approved="1" data-type="move-in" href="#">Approve</a> ' +
								' <a class="btn btn-sm btn-outline-primary btn-deny"  style="' + style + '" data-id=' + row.rec_id + ' data-approved="0" data-type="move-in" href="#">Deny</a>';
						} else if (row.sr_type == 'move-out') {
							return ' <a class="btn btn-sm text-primary btn-delete-icon" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=move_out&view_table=view_move_out&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash-fill"></i></a>' +
								' ' + ' <a class="btn btn-sm btn-primary btn-approved" style="' + style + '" data-id=' + row.rec_id + ' data-approved="1" data-type="move-out" href="#">Approve</a> ' +
								' <a class="btn btn-sm btn-outline-primary btn-deny" style="' + style + '" data-id=' + row.rec_id + ' data-approved="0" data-type="move-out" href="#">Deny</a>';
						} else if (row.sr_type == 'work-permit') {
							return ' <a class="btn btn-sm text-primary btn-delete-icon" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=work_permit&view_table=view_work_permit&redirect=/tenant/service-request?submenuid=service_request"><i class="bi bi-trash-fill"></i></a>' +
								' ' + ' <a class="btn btn-sm btn-primary btn-approved" style="' + style + '" data-id=' + row.rec_id + ' data-approved="1" data-type="work-permit" href="#">Approve</a> ' +
								' <a class="btn btn-sm btn-outline-primary btn-deny" style="' + style + '" data-id=' + row.rec_id + ' data-approved="0" data-type="work-permit" href="#">Deny</a>';
						}
					},
					orderable: false
				}
			],
			order: [
				[4, 'asc']
			],
			colFilter: (filter) ? filter : {}
		});

		$(document).on("click", ".row-id", function() {
			// var data = table.row(this).data();
			var id = $(this).data("id");
			var sr_type = $(this).data("type");

			if (sr_type == 'unit-repair') {
				window.location.href = "<?= WEB_ROOT ?>/tenant/view-unit-repair/" + id + "/View";
			} else if (sr_type == 'gate-pass') {
				window.location.href = "<?= WEB_ROOT ?>/tenant/view-gate-pass/" + id + "/View";
			} else if (sr_type == 'visitor-pass') {
				window.location.href = "<?= WEB_ROOT ?>/tenant/view-visitor-pass/" + id + "/View";
			} else if (sr_type == 'reservation') {
				window.location.href = "<?= WEB_ROOT ?>/tenant/view-reservation/" + id + "/View";
			} else if (sr_type == 'move-in') {
				window.location.href = "<?= WEB_ROOT ?>/tenant/view-move-in/" + id + "/View";
			} else if (sr_type == 'move-out') {
				window.location.href = "<?= WEB_ROOT ?>/tenant/view-move-out/" + id + "/View";

			} else if (sr_type == 'work-permit') {
				window.location.href = "<?= WEB_ROOT ?>/tenant/view-work-permit/" + id + "/View";
			} else {
				sr_type;
			}
			// console.log(sr_type);
			// alert('div clicked')
		});

		$(document).on("click", '.btn-delete-icon', function(evt) {
			evt.stopPropagation();
		});

		$(document).on("click", '.btn-approved', function(evt) {
			evt.stopPropagation();
		});

		$(document).on("click", '.btn-deny', function(evt) {
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


		$(document).on('click', '.btn-approved,.btn-deny', function(e) {
			e.preventDefault();

			id = $(this).attr("data-id");
			approved = $(this).attr("data-approved");
			type = $(this).attr("data-type");
			$.ajax({
				url: "<?= WEB_ROOT . "/tenant/request-approval?display=plain" ?>",
				type: 'POST',
				data: {
					id: id,
					approve: approved,
					sr_type: type
				},
				dataType: 'JSON',
				beforeSend: function() {},
				success: function(data) {
					if (data.success == 1) {
						// showSuccessMessage(data.description,function(){
						// 	window.location.reload();
						// });
						t<?= $unique_id; ?>.ajax.reload();
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

	});
	request_type();

	function request_type(request_type = 'all') {
		type = request_type;
		if (request_type == 'all') {
			$(".all-btn").addClass('active1');
			$(".ur-btn,.gp-btn,.vp-btn,.res-btn,.mi-btn,.mo-btn,.wo-btn").removeClass('active1');
			type = 'all';
		} else if (request_type == 'unit-repair') {
			$(".ur-btn").addClass('active1');
			$(".all-btn,.gp-btn,.vp-btn,.res-btn,.mi-btn,.mo-btn,.wo-btn").removeClass('active1');
			type = 'unit-repair';
		} else if (request_type == 'gate-pass') {
			$(".gp-btn").addClass('active1');
			$(".all-btn,.ur-btn,.vp-btn,.res-btn,.mi-btn,.mo-btn,.wo-btn").removeClass('active1');
			type = 'gate-pass';
		} else if (request_type == 'visitor-pass') {
			$(".vp-btn").addClass('active1');
			$(".all-btn,.ur-btn,.gp-btn,.res-btn,.mi-btn,.mo-btn,.wo-btn").removeClass('active1');
			type = 'visitor-pass';
		} else if (request_type == 'reservation') {
			$(".res-btn").addClass('active1');
			$(".all-btn,.ur-btn,.gp-btn,.vp-btn,.mi-btn,.mo-btn,.wo-btn").removeClass('active1');
			type = 'reservation';
		} else if (request_type == 'move-in') {
			$(".mi-btn").addClass('active1');
			$(".all-btn,.ur-btn,.gp-btn,.vp-btn,.res-btn ,.mo-btn,.wo-btn").removeClass('active1');
			type = 'move-in';
		} else if (request_type == 'move-out') {
			$(".mo-btn").addClass('active1');
			$(".all-btn,.ur-btn,.gp-btn,.vp-btn,.res-btn,.mi-btn ,.wo-btn").removeClass('active1');
			type = 'move-out';
		} else if (request_type == 'work-permit') {
			$(".wo-btn").addClass('active1');
			$(".all-btn,.ur-btn,.gp-btn,.vp-btn,.res-btn,.mi-btn,.mo-btn").removeClass('active1');
			type = 'work-permit';
		}
		filterby = 'sr_type';
		console.log(filterby);
		filtertxt = type;
		t<?= $unique_id; ?>.options.colFilter[filterby] = filtertxt;
		t<?= $unique_id; ?>.ajax.reload();


	}
	$(function() {

		$(".proceed").click(function() {
			var value = $("input[name$='service-request']:checked").val();
			if (value == 'unit-repair') {
				window.location.assign("<?= WEB_ROOT ?>/service-request/form-add-unit-repair");
			} else if (value == 'gate-pass') {
				window.location.assign("<?= WEB_ROOT ?>/service-request/form-add-gate-pass");
			} else if (value == 'visitor-pass') {
				window.location.assign("<?= WEB_ROOT ?>/service-request/form-add-visitor-pass");
			} else if (value == 'reservation') {
				window.location.assign("<?= WEB_ROOT ?>/service-request/form-add-reservation");
			} else if (value == 'move-in') {
				window.location.assign("<?= WEB_ROOT ?>/service-request/form-add-move-in");
			} else if (value == 'move-out') {
				window.location.assign("<?= WEB_ROOT ?>/service-request/form-add-move-out");
			} else if (value == 'work-permit') {
				window.location.assign("<?= WEB_ROOT ?>/service-request/form-add-work-permit");
			}
		});
	});
</script>