<?php
$title = "Building Personnel";
$module = "location";
$table = "building_personnel";
$view = "building_personnel_view";

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
$fields = rawurlencode(json_encode(["ID" => "id", "Name" => "employee_name", "Username" => "username", "Email" => "email", "Contact Number" => "contact_number", "Working Schedule" => "working_schedule", "Working Hours" => "working_hours"]));


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
	'table' => 'building_personnel',
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

		<div class="page-title"></div>

		<div class="d-flex justify-content-between mb-2">
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
		<div class="modal" tabindex="-1" role="dialog" id='renew'>
			<div class="modal-dialog  modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Modal title</h5>
						<button type="button" class="close" data-dismiss="modal" onclick='$("#renew").modal("hide")' aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<h3 class="text-primary align-center">Renew</h3>
						<form action="/" method='post' id='form-renew'>
							<input type="hidden" name='renew_id' value='' id='renew_id'>
							<input type="hidden" name='identifier' value='contract_id' id='identifier'>
							<input type="hidden" name='table' value='contracts'>
							<input type="hidden" name='update_table' id='id' value='contract_updates'>
							<table class='table-fluid table-renew'>
								<tr>
									<td>
										<b>Issued Date</b>
										<input type="date" name='issued_date' class="form-control" placeholder="choose">
									</td>
									<td>
										<b>Expiration Date</b>
										<input type="date" name='expiration_date' class="form-control" placeholder="choose">
									</td>
								</tr>
								<tr>
									<td>
										<b>Permit #</b>
										<input type="text" name='permit_number' class="form-control" placeholder="choose">
									</td>
									<td>
										<input type="file" name='file[]' class="form-control" placeholder="choose">
									</td>
								</tr>
								<tr>
									<td>
										<br>
										<button type='submit' class='btn btn-primary button-renew-submit'>Submit</button> &nbsp;
										<a class='btn btn-secondary' onclick='$("#renew").modal("hide")'>Cancel</a>
									</td>
									<td></td>
								</tr>
							</table>
						</form>
					</div>
					<div class="modal-footer">

					</div>
				</div>
			</div>

		</div>
		<div class="modal" tabindex="-1" role="dialog" id='delete'>
			<div class="modal-dialog  modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Modal title</h5>
						<button type="button" class="close" data-dismiss="modal" onclick='$("#renew").modal("hide")' aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<h3 class="text-primary align-center">Renew</h3>
						<form action="/" method='post' id='form-renew'>
							<input type="hidden" name='renew_id' value='' id='renew_id'>
							<input type="hidden" name='identifier' value='contract_id' id='identifier'>
							<input type="hidden" name='table' value='contracts'>
							<input type="hidden" name='update_table' id='id' value='contract_updates'>
							<table class='table-fluid table-renew'>
								<tr>
									<td>
										<b>Issued Date</b>
										<input type="date" name='issued_date' class="form-control" placeholder="choose">
									</td>
									<td>
										<b>Expiration Date</b>
										<input type="date" name='expiration_date' class="form-control" placeholder="choose">
									</td>
								</tr>
								<tr>
									<td>
										<b>Permit #</b>
										<input type="text" name='permit_number' class="form-control" placeholder="choose">
									</td>
									<td>
										<input type="file" name='file[]' class="form-control" placeholder="choose">
									</td>
								</tr>
								<tr>
									<td>
										<br>
										<button type='submit' class='btn btn-primary button-renew-submit'>Submit</button> &nbsp;
										<a class='btn btn-secondary' onclick='$("#renew").modal("hide")'>Cancel</a>
									</td>
									<td></td>
								</tr>
							</table>
						</form>
					</div>
					<div class="modal-footer">

					</div>
				</div>
			</div>
		</div>
</div>
<?php endif; ?>
<script>
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
			rowLink: {
				url: '<?= WEB_ROOT; ?>/property-management/view-building-personnel//',
				params: [{
					"key": "id",
					"value": "encryptedid"
				}],
			},
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			buttons: [{
					icon: `<span class="material-symbols-outlined">add</span>`,
					title: "Create New",
					class: "btn-add btn-blue",
					id: "edit",
					href: "<?= WEB_ROOT ?>/property-management/form-add-personnel",
				},
				//
				// <?php if ($role_access->delete == true) : ?> {
				// 		icon: `<span class="material-symbols-outlined">delete</span>`,
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

			columns: [
				// {
				// 	data: "rec_id",
				// 	label: "Employee #",
				// 	class: 'col-1'
				// },
				{
					data: "employee_number",
					label: "Employee </br> Number",
					class: 'w-10',
					datatype: "none",
					// render: function(data, row) {
					// 	return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="building_personnel" view_table="building_personnel_view" reload="<?= WEB_ROOT; ?>/property-management/building-personnel?submenuid=location">' + data;
					// }
				},
				{
					data: "employee_name",
					label: "Name",
					class: '',
					datatype: "none",
					render: function(data, row) {
						return '<a href="<?= WEB_ROOT; ?>/property-management/view-building-personnel/' + row.id + '/View" target="_self">' + data + '</a>';
					}
				},
				{
					data: "username",
					label: "Username",
					class: '',
					datatype: "none",
				},
				{
					data: "email",
					label: "Email",
					class: '',
					datatype: "none",
				},
				{
					data: "contact_number",
					label: "Contact </br> Number",
					class: '',
					datatype: "none",
				},
				{
					data: "working_schedule",
					label: "Working </br> Schedule",
					class: '',
					datatype: 'select',
					list: ["Monday - Friday", "Saturday - Sunday"],
				},
				{
					data: "working_hours",
					label: "Working </br> Hours",
					class: '',
					datatype: 'select',
					list: ["6:00am - 2:00pm", "8:00am - 5:00pm", "9:00am - 6:00pm", "2:00pm - 10:00pm", "10:00pm - 6:00am"],
				},
				{
					data: null,
					label: "Action",
					class: "text-left",
					class: 'w-10',
					render: function(data,row){
						return '<a class="  btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/property-management/view-building-personnel/' + row.id + '/View"><i class="bi bi-eye"></i></a> '+
						'<a class=" btn-delete" onclick="show_delete_modal(this)" title="Delete ID ' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/property-management/delete-record/' + row.id + '?display=plain&table=building_personnel&view_table=building_personnel_view&redirect=/property-management/building-personnel?submenuid=location"><i class="bi bi-trash"></i></a>';
					},
					orderable: false
				}
				// {
				// 	data: "item_description",
				// 	label: "Item Description",
				// 	class: 'col-2'
				// },
				// {
				// 	data: "personnel_name",
				// 	label: "Personnel Name",
				// 	class: 'col-1'
				// },
				// {
				// 	data: "status",
				// 	label: "Stage",
				// 	class: 'col-1',
				// 	orderable: true
				// },
				// {
				// 	data: null,
				// 	label: "Action",
				// 	class: "text-left",
				// 	class: 'col-2',
				// 	render: function(data,row){
				// 		return '<a class="btn btn-sm btn-primary button-renew"  onclick="show_renew_modal(this)" parent_id='+ row.parent +' id=' + row.rec_id + ' title="Renew ID ' + row.rec_id + '?" href="#">Renew</a> '+
				// 		'<a class="btn btn-sm btn-success btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/property-management/view-building-personnel/' + row.id + '/View"><i class="bi bi-eye"></i></a> '+
				// 		'<a class="btn btn-sm btn-danger btn-delete" onclick="show_delete_modal(this)" title="Delete ID ' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/property-management/delete-record/' + row.id + '?display=plain&table=building_personnel&view_table=building_personnel_view&redirect=/property-management/building-personnel?submenuid=location"><i class="bi bi-trash"></i></a>';
				// 	},
				// 	orderable: false
				// }
				/*{
					data: "status",
					label: "Action",
					class: "text-center",
					class: 'col-2 text-nowrap',
					render: function(data,row){
						var buttons = '';
						if(data == 'Pending')
						{
							buttons += '<a class="btn btn-sm btn-primary btn-approve-gatepass" href="<?= WEB_ROOT; ?>/gatepass/approved/' + row.id + '">Approve</a>';
							buttons += '<a class="ms-1 btn btn-sm btn-primary btn-disapprove-gatepass" href="<?= WEB_ROOT; ?>/gatepass/disapproved/' + row.id + '">Disapprove</a>';
						}
						return buttons;
					},
					orderable: false
				}*/
			],
			order: {
				'employee_number': 'ASC'
			},
			// colFilter: {'status':'Active'}
		});

		$(document).on("click", ".row-id", function() {
			// var data = table.row(this).data();
			var id = $(this).data("id");
			window.location.href = "<?= WEB_ROOT ?>/property-management/view-building-personnel/" + id + "/View";
			// console.log(data);
			// alert('div clicked')
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
	});
</script>