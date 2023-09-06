<?php
$title = "PDC Tracker";
$module = "pdc";
$table = "pdcs";
$view = "view_pdcs";
// var_dump($return_value);
$fields = rawurlencode(json_encode(["ID" => "id", "Check Number" => "check_number", "Check Date" => "check_date", "Check Ammount" => "check_amount", "Status" => "status", "Unit" => "unit", "Sequence Number" => "sequence_number"]));
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
	'table' => 'pdcs',
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
	<?php endif; ?>
</div>
<script>
	<?php $unique_id = $module . time(); ?>
	var t<?= $unique_id; ?>;
	$(document).ready(function() {


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
				url: '<?= WEB_ROOT; ?>/tenant/view-pdc/',
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
						href: "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>",
						id: "download",
					},
				<?php endif; ?> {
					icon: `<span class="material-symbols-outlined">filter_list</span>`,
					title: "Filter",
					class: "filter",
				}

			],

			// onDataChanged:function(){
			// 	$('.permit-expired').closest('.row-list').addClass('bg-danger text-light');

			// 	$('.permit-notify').closest('.row-list').addClass('bg-warning');
			// },
			columns: [{
					data: "rec_id",
					label: "ID",
					class: 'table-id',
					datatype: "none",
					// render: function(data, row) {

					// 	return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="pdc" view_table="view_pdc"  reload="<?= WEB_ROOT; ?>/tenant/pdc-tracker?submenuid=pdc_tracker">' + '<a href="<?= WEB_ROOT; ?>/tenant/view-pdc/' + row.id + '/View" target="_self">' + data + '</a>';
					// }


				},
				{
					data: "unit",
					label: "Unit",
					class: '',
					datatype: "select",
					list: ["Unit Owner", "Tenant"],
				},
				{
					data: "check_date",
					label: "Date",
					class: '',
					datatype: "date",
				},
				{
					data: "check_number",
					label: "Check Number",
					class: '',
					datatype: "none",

				},
				{
					data: "check_amount",
					label: "Amount",
					class: '',
					datatype: "none",
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
					data: "status",
					label: "Stage",
					class: '',
					datatype: "none",
				},

				{
					data: null,
					label: "Action",
					class: ' ',

					render: function(data, row) {
						if (row.status == 'Received') {
							return '<a class="btn btn-sm btn-primary btn-deposit" onclick="show_update_modal(this)" role_access="<?= $role_access->deposit ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/save-update/' + row.id + '?display=plain&table=pdcs&view_table=view_pdcs&redirect=/tenant/pdc-tracker?submenuid=pdc_tracker&status=Deposited">Deposit</a>';
						} else if (row.status == 'Deposited') {
							return '<a class="btn btn-sm btn-primary btn-deposit" onclick="show_update_modal(this)" role_access="<?= $role_access->cleared ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/save-update/' + row.id + '?display=plain&table=pdcs&view_table=view_pdcs&redirect=/tenant/pdc-tracker?submenuid=pdc_tracker&status=Cleared">Clear</a>';
						} else {
							return ' ';
						}
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
			// var data = table.row(this).data();
			var id = $(this).data("id");
			window.location.href = "<?= WEB_ROOT ?>/tenant/view-pdc/" + id + "/View";
			// console.log(data);
			// alert('div clicked')
		});

		$(".btn-add").off('click').on('click', function() {
			window.location.href = "<?= WEB_ROOT ?>/tenant/form-add-pdc";
		});

		$(document).on("click", '.btn-deposit', function(evt) {
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