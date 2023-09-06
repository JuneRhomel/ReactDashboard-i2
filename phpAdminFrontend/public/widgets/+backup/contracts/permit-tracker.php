<?php
$title = "Permit Tracker";
$module = "permitts";
$table = "permits";
$view = "view_permits";

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
$fields = rawurlencode(json_encode(["ID" => "id", "Permit Name" => "permit_name", "Permit Number" => "permit_number", "Status" => "status", "Expiration Date" => "expiration_date", "Renewable" => "renewable"]));

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
	'table' => 'permits',
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
			<div>
				<!-- <?php if ($role_access->create == true) : ?>
					<button class="btn btn-sm btn-add">+ Create New</i></button>
					<?php endif; ?> -->
			</div>
		</div>

		<div class="">
			<!-- <button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-download">Download <i class="bi bi-download"></i></button> -->


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

		<div class="modal" tabindex="-1" role="dialog" id='renew'>
			<div class="modal-dialog  modal-dialog-centered" role="document">
				<div class="modal-content px-1 pb-4 pt-2">
					<div class="modal-header flex-row-reverse pb-0" style="border-bottom: 0px;">
						<!-- <h5 class="modal-title">Modal title</h5> -->
						<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#renew").modal("hide")' aria-label="Close">
							<span aria-hidden="true"></span>
						</button>
					</div>
					<div class="modal-body pt-0">
						<h3 class="modal-title text-primary align-center text-center mb-3">Renew</h3>
						<form action="/" method='post' id='form-renew'>
							<input type="hidden" name='renew_id' value='' id='renew_id'>
							<input type="hidden" name='identifier' value='contract_id' id='identifier'>
							<input type="hidden" name='table' value='contracts'>
							<input type="hidden" name='update_table' id='id' value='contract_updates'>
							<div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
								<div class="col-5 my-2">
									<b>Issued Date</b>
									<input type="date" name='issued_date' class="form-control" placeholder="choose">
								</div>

								<div class="col-5 my-2">
									<b>Expiration Date</b>
									<input type="date" name='expiration_date' class="form-control" placeholder="choose">
								</div>

								<div class="col-5 my-2">
									<b>Permit #</b>
									<input type="text" name='permit_number' class="form-control" placeholder="choose">
								</div>

								<div class="col-5 my-2">
									<b>Attachments</b>
									<input type="file" name='file[]' class="form-control" placeholder="choose">
								</div>

								<div class="d-flex justify-content-center gap-4 w-100">
									<button type='submit' class='btn btn-primary button-renew-submit px-5'>Submit</button> &nbsp;
									<a class='btn btn-light btn-cancel px-5' onclick='$("#renew").modal("hide")'>Cancel</a>
								</div>
							</div>
						</form>
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
	<?php endif; ?>
</div>
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



		$(".btn-import").on('click', function() {
			window.location.href = '<?= WEB_ROOT; ?>/admin/import-permits?submenuid=import_permit';
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
				url: '<?= WEB_ROOT; ?>/contracts/view-permit/',
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
						href: "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $table ?>&fields=<?= $fields ?>",
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
					label: "ID",
					class: '',
					datatype: "none",
					// render: function(data, row) {
					// 	return '<input type="checkbox" id="' + row.id + '" name="check_box" table="permits" view_table="view_permits" reload="<?= WEB_ROOT; ?>/contracts/permit-tracker?submenuid=permittracker"> ' + data;
					// }
				},
				{
					data: "permit_name",
					label: "Permit </br> Name",
					class: 'w-15',
					datatype: "none",
					render: function(data, row) {
						return '<a href="<?= WEB_ROOT; ?>/contracts/view-permit/' + row.id + '/View" target="_self">' + data + '</a>';
					}
				},
				{
					data: "permit_number",
					label: "Permit </br> Number",
					class: 'w-10',
					datatype: "none",

				},
				{
					data: "status",
					label: "Stage",
					class: 'w-10',
					datatype: "select",
					list: ["Active", "Inactive"],
					orderable: true
				},
				{
					data: "renewable",
					label: "Renewable",
					class: 'w-10',
					datatype: "select",
					list: ["Yes", "No"]
				},
				{
					data: "expiration_date",
					label: "Expiration </br> Date",
					class: ' ',
					datatype: "date"
				},
				{
					data: "remaining_days_to_expire",
					label: "Days </br> Before </br> Expiration",
					class: ' ',
					datatype: "none",
					searchable: false,
					render: function(data, row) {
						if (data < 0) {
							return "<span class='permit-expired'>" + data + "</span>";
						} else if (data < row.days_to_notify) {
							return "<span class=' permit-notify'> " + data + "</span>";
						} else {
							return data;
						}


					}
				},
				{
					data: "days_to_notify",
					label: "Days To </br> Notify",
					class: 'w-10',
					datatype: "none",
				},


				// {
				// 	data: "created_by",
				// 	label: "Created By",
				// 	class: 'col-1'
				// },
				// {
				// 	data: "contact_person",
				// 	label: "Contact Person",
				// 	class: 'col-2'
				// },
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
				{
					data: null,
					label: "Action",
					class: 'w-15',
					render: function(data, row) {
						return ' <a href="<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>&id=' + row.id + '" class="btn btn-sm btn-download-icon"><i class="bi bi-download text-primary"></i><a>' +
							'<a class="btn btn-sm text-primary btn-delete" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" rec_id=" ' + row.rec_id + '" title="Delete ID ' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/contracts/delete-permit-contracts/' + row.id + '?display=plain&table=permits&view_table=view_permits"><i class="bi bi-trash"></i></a>' +
							'<a class="btn btn-sm btn-primary button-renew"  onclick="<?= ($role_access->renew == true) ? "show_renew_modal(this)" : "$(\'#access-denied\').modal(\'show\');" ?>" parent_id=' + row.parent + ' id=' + row.rec_id + ' title="Renew ID ' + row.rec_id + '" href="#">Renew</a> ';
					},
					orderable: false
				}
			],
			order: [
				[4, 'asc']
			],
			// colFilter: {'status':'Active'}
		});

		$(document).on("click", ".row-id", function() {
			var id = $(this).data("id");
			window.location.href = "<?= WEB_ROOT ?>/contracts/view-permit/" + id + "/View";

		});

		$(document).on("click", '.btn-delete', function(evt) {
			evt.stopPropagation();
		});

		$(document).on("click", '.button-renew', function(evt) {
			evt.stopPropagation();
		});

		$(document).on("click", '.btn-download-icon', function(evt) {
			evt.stopPropagation();
		});
		$(".btn-add").off('click').on('click', function() {
			window.location.href = "<?= WEB_ROOT . "/contracts/"; ?>form-add-permit";
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