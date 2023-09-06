<?php
$title = "Equipment Library";
$module = "equipment";
$table = "equipments";
$view = "vw_equipments";
// var_dump($_SESSION);

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
$fields = rawurlencode(json_encode(["ID" => "id", "Equipment Name" => "equipment_name", "Category" => "category", "Type" => "type", "Location" => "location"]));
$data = [
	'view' => 'service_providers_view'
];
$providers = $ots->execute('property-management', 'get-records', $data);
$providers = json_decode($providers);

if (!$providers) {
?>
	<script>
		Swal.fire({
			title: 'Service Provider data is missing',
			isDismissed: false,
			confirmButtonText: 'Yes',
			html: 'Do want to add now???',
			allowOutsideClick: false
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				window.location.href = "<?= WEB_ROOT ?>/property-management/form-add-serviceprovider?";
			}
		})
	</script>
<?php
}

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
	'table' => 'equipments',
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

		<div class="d-flex justify-content-between mb-2">
			<div class="d-flex align-items-end">
				<label class="text-label-result px-3 mb-0" id="search-result">

				</label>
			</div>
			<div>

			</div>
		</div>
		<div class=" pb-2 px-2 pt-0 rounded">
			<!-- <button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-download">Download <i class="bi bi-download"></i></button> -->

			<!-- <div class="col-3">
				<label>Status</label>
				<div>
					<button class="btn btn-primary btn-filter-status" type="button">Pending</button>
					<button class="btn btn-secondary btn-filter-status" type="button">Approved</button>
					<button class="btn btn-secondary btn-filter-status" type="button">Disapproved</button>
				</div>
			</div> -->




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

		// $(".btn-add").off('click').on('click', function() {
		// 	window.location.href = "<?= WEB_ROOT ?>/property-management/form-add-equipment";
		// });

		// $(".btn-download").on('click', function() {
		// 	location = "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $table ?>&fields=<?= $fields ?>";
		// });

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
				url: '<?= WEB_ROOT . "/module/get-list/{$view}?display=plain" ?>'
			},
			rowLink: {
				url: '<?= WEB_ROOT; ?>/property-management/view-equipment/',
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
					href: "<?= WEB_ROOT ?>/property-management/form-add-equipment",
				},
				// <?php if ($role_access->delete == true) : ?> {
				// 		icon: `<span class="material-symbols-outlined">delete</span>`,
				// 		title: "Delete",
				// 		class: "btn-delete-filter",
				// 		id: "delete",
				// 	},
				// <?php endif; ?>

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



			onDataChanged: function() {
				$('.permit-expired').closest('.row-list').addClass('bg-danger text-light');

				$('.permit-notify').closest('.row-list').addClass('bg-warning');
			},
			columns: [{
					data: "equipment_name",
					label: "Equipment Name",
					class: 'table-id w-10',
					datatype: "none",
					// render: function(data, row) {

					// 	return '<input type="checkbox"  class="checkbox-icon " id="' + row.id + '" name="check_box" table="equipments" view_table="view_equipments"  reload="<?= WEB_ROOT; ?>/property-management/equipment?submenuid=equipment">' + row.equipment_name
					// }
				},
				{
					data: "category",
					label: "Category",
					class: 'table-id',
					render: function(data, row) {
						class_name = ''
						//replaced by arnel 12/26 to shorten code
						class_name = data ? data.replace(' ', '').replace('&', '_').toLowerCase() : '';
						return "<div class='" + class_name + "'>" + data + "</div>";
					},
					datatype: 'select',
					list: ['Mechanical', 'Electrical', 'Fire Protection', 'Plumbing & Sanitary', 'Civil', 'Structural'],
					render: function(data, row) {
						return '<div class="data-box">' + data + '</div>';

					}
				},
				{
					data: "type",
					label: "Type",
					class: 'text-center text-capitalize ',
					render: function(data, row) {
						return '<div class="data-box">' + data + '</div>';
					},
					datatype: "select",
					list: [types]
				},
				{
					data: "location",
					label: "Location",
					class: '',
					datatype: "none",
					render: function(data, row) {
						return '<div class="">' + data + '</div>';
					}
				},
				{
					data: "date_installed",
					label: "Date Installed",
					class: 'w-10',
					datatype: 'none',
				},

				// {
				// 	data: "date_today",
				// 	label: "Date Today",
				// 	class: 'col-1',
				// 	render: function(data,row){
				// 		var dateObj = new Date();
				// 		var month = dateObj.getUTCMonth() + 1; //months from 1-12
				// 		var day = dateObj.getUTCDate();
				// 		var year = dateObj.getUTCFullYear();

				// 		return newdate = year + "-" + month + "-" + day;

				// 	},
				// },

				{
					data: "age",
					label: "Age",
					class: '',
					datatype: "none",
				},
				{
					data: "critical_equipment",
					label: "Critical",
					class: '',
					datatype: 'select',
					list: ['No', 'Yes'],
					render: function (data,row){
						if (data == 'Yes'){
						return '<div class="data-box-y">' + data + '</div>';
						}
						else{
							return '<div class="data-box-n">' + data + '</div>';
						}
					}
				},
				{
					data: "uptime",
					label: "Uptime",
					class: '',
					datatype: "none",
					searchable: false
				},
				{
					data: null,
					label: "Action",
					class: '',
					render: function(data, row) {
						return '<a class="btn btn-sm text-primary btn-delete-icon" onclick="show_delete_modal(this)" title="Are you sure?" role_access="<?= $role_access->delete ?>" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/property-management/delete-record/' + row.id + '?display=plain&table=equipments&view_table=view_equipments&redirect=/property-management/equipment?submenuid=equipment"><i class="bi bi-trash-fill"></i></a>'
					},
					orderable: false
				},
			],
			order: [
				[4, 'asc']
			],
			// colFilter: {'status':'Active'}
		});

		// eye icon path ito pang-recover if ever maging need ulit
		// '<a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?= WEB_ROOT ?>/property-management/view-equipment/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> '+

		var types = [];

		$(document).on("click", "#category", function() {
			var mechanicalChecked = $(".Mechanical:checked").length > 0;
			var electricalChecked = $(".Electrical:checked").length > 0;
			var fireChecked = $(".Fire:checked").length > 0;

			types = [];

			if (mechanicalChecked) {
				types.push("Air-conditioning", "Elevator", "Fire Detection & Alarm System", "Pumps", "Generator", "Building Management System", "CCTV", "Pressurization Blower/ Fan", "Exhaust Fan", "Gondola");
			}

			if (electricalChecked) {
				types.push("Transformers", "UPS", "Automatic Transfer Switch", "Control Gear", "Switch Gear", "Capacitor", "Breakers/Panel Boards", "Meter");
			}

			if (fireChecked) {
				types.push("Sprinkler", "Smoke Detectors", "Manual Pull Stations", "Fire Alarm", "FDAS Panel");
			}

			var checkboxesHtml = "";

			types.forEach(function(type) {
				checkboxesHtml += '<div><input type="checkbox" class="form-check-input my-2 filters-select" name="type[]" value="' + type + '"> ' + type + '</div>';
			});

			if (types.length > 0) {
				$(".type").html(checkboxesHtml);
			} else {
				$(".type").html("");
			}
		});



		// $(document).on("click", "#category" , function () {
		// 	if($("#category:checked").val() == 'Mechanical'){
		// 		$(".type").html('<p>aircon</p>');
		// 	}
		// 	else if($("#category:checked").val() == 'Electrical'){
		// 		$(".type").html('<p>electricity</p>');
		// 	}
		// 	else{
		// 		$(".type").html('');
		// 	}

		// });

		$(document).on("click", ".row-id", function() {
			// var data = table.row(this).data();
			var id = $(this).data("id");
			window.location.href = "<?= WEB_ROOT ?>/property-management/view-equipment/" + id + "/View";
			// console.log(data);
			// alert('div clicked')
		});

		$(document).on("click", '.btn-delete-icon', function(evt) {
			evt.stopPropagation();
		});

		$(document).on("click", '.checkbox-icon', function(evt) {
			evt.stopPropagation();
		});

		// let totalCount;
		// $(document).on('change', function(){
		// 	$.ajax({
		// 		url:"<?= WEB_ROOT . "/module/get-list/{$view}?display=plain" ?>",
		// 		type: 'GET',
		// 		data: $(this).serialize(),
		// 		dataType: 'JSON',
		// 		success: function(data) {
		// 				var totalCount = data.totalCount; // get the total count from the response
		// 			}
		// 		});
		// });

		// $('#search-result').text('Result(' + recordsFiltered + ')');

		// $('#search-input').on('input', function() {
		// const searchTerm = $(this).val();

		// $.ajax({
		// 	url: '<?= WEB_ROOT . "/module/get-list/{$view}?display=plain" ?>',
		// 	type: 'GET',
		// 	data: data,
		// 	success: function(data) {
		// 	let totalCount = 0;
		// 	$('#search-result').text(`Result(${totalCount})`);
		// 	}
		// });
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

		$('.btn-import').on('click', function() {
			window.location.href = '<?= WEB_ROOT; ?>/admin/import-equipments?submenuid=import_equipments';
		});

		$('.btn-delete-filter').on('click', function() {
			var table = $('input[name="check_box"]').attr('table');
			var view_table = $('input[name="check_box"]').attr('view_table');
			var redirect = $('input[name="check_box"]').attr('reload');

			var ids = [];
			$('input[name="check_box"]:checked').each(function() {
				var $this = $(this);
				ids.push($this.attr("id"));
			});

			if (ids.length > 0) {
				var url = '<?= WEB_ROOT; ?>/property-management/delete-records?display=plain';

				table_delete_records(ids, table, view_table, redirect, url);
			}
		});

		$('.filter').on('click', function() {
			$(".dropdown-menu-filter").toggle();
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