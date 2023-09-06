<?php
$title = "Preventive Maintenance";
$module = "propertymanagement";
$table = "pm";
$view = "view_pm2";
$fields = rawurlencode(json_encode([
	"ID" => "rec_id",
	"Created By" => "created_by",
	"Equipment" => "equipment_id",
	"Priority" => "priority_level",
	"Service Provider" => "service_providers_name",
	"Date Start" => "pm_start_date_only",
	"Time Schedule" => "pm_start_time_only",
	"Notify" => "notify_days_before_next_schedule",
	"Critical" => "critical",

]));


/*$let = "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?=$module?>&table=<?=$table?>&view=<?=$view?>&fields=<?=$fields?>"; */



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
	'table' => 'pm',
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
			<!-- <div>
			<?php if ($role_access->create == true) : ?>
				<button class="btn btn-sm btn-add">+ Create New</i></button>
				<?php endif; ?>
			</div> -->
		</div>
		<!-- <div class="d-flex">
			<button class="btn tabs-table all-btn active1">All</button>
			<button class="btn tabs-table weekly-btn">Weekly</button>
			<button class="btn tabs-table monthly-btn">Monthly</button>
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
<?php endif; ?>
<style>
	.table-renew {
		width: 100%
	}

	.table-renew td {
		padding: 0px 30px;
	}
</style>
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
								<b>Effectivity Date</b>
								<input type="date" name='effectivity_date' class="form-control" placeholder="choose">
							</td>
							<td>
								<b>Expiration Date</b>
								<input type="date" name='expiration_date' class="form-control" placeholder="choose">
							</td>
						</tr>
						<tr>
							<td>
								<b>Permit #</b>
								<input type="text" name='contract_number' class="form-control" placeholder="choose">
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
		// renew
		$('#form-renew').submit(function(e) {
			data = $(this).serialize();
			e.preventDefault();
			$.post({
				url: '<?= WEB_ROOT ?>/contracts/renew-contracts?display=plain',
				data: data,
				success: function(result) {
					result = JSON.parse(result);
					if (result.success == 1) {
						location.reload();
					}
				}
			});

		});

		$('.btn-import').on('click', function() {
			// window.location.href = '<?= WEB_ROOT; ?>/admin/import-pm?submenuid=import_equipments';
		});



		$('.dashboard-calendar').calendar({

			enableMonthChange: true,
			showTodayButton: false,
			prevButton: '<i class="bi bi-chevron-left" style="font-size: 15px;  font-weight: 600"></i>',
			nextButton: '<i class="bi bi-chevron-right" style="font-size: 15px; font-weight: 600"></i>',
			SelectedDay: selectDate,
			onClickDate: function(date) {
				// var todayDate = new Date(date).toLocaleString().slice(0, 10);
				var date = new Date(date);
				var year = date.toLocaleString("default", {
					year: "numeric"
				});
				var month = date.toLocaleString("default", {
					month: "2-digit"
				});
				var day = date.toLocaleString("default", {
					day: "2-digit"
				});
				var formattedDate = year + "-" + month + "-" + day;
				$('.filters-date').val(formattedDate);
				$('.btn-filter-now').trigger('click');
				$('#dropdownmenufilter').hide();

				// $("#jsdata").html(formattedDate);
				// $.ajax({
				// 	url: "<?= WEB_ROOT . "/dashboard/get-pm-sched-calendar?display=plain" ?>",
				// 	type: 'POST',
				// 	data: JSON.stringify({date: formattedDate}),
				// 	success: function(data) {
				// 		// $('#jsdata').html(data);
				// 	},
				// 	});

			}
		});

		// $(".btn-add").off('click').on('click',function(){
		// 	window.location.href = "<?= WEB_ROOT ?>/property-management/form-add-pm";
		// });

		// $(".btn-download").on('click',function(){
		// 	location = "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>";
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
				url: '<?= WEB_ROOT ?>/module/get-list/<?= $view ?>?display=plain'
			},
			rowLink: {
				url: '<?= WEB_ROOT ?>/property-management/view-pm/',
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
					href: "<?= WEB_ROOT ?>/property-management/form-add-pm",
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
						href: "<?= WEB_ROOT ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>",
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
					class: 'table-id',
					datatype: "none",
					// render: function(data, row) {
					// 	return '<input type="checkbox" id="' + row.id + '" class="checkbox-icon" name="check_box" table="pm" view_table="views_pm"  reload="<?= WEB_ROOT; ?>/property-management/pm?submenuid=pm">' +
					// 		'<a href="<?= WEB_ROOT; ?>/property-management/view-pm/' + row.id + '/View" target="_self">PM_' + data + '</a>';
					// }
				},
				{
					data: "created_by_full_name",
					label: "Created By",
					class: '',
					datatype: "none",
					searchable: false
				},
				{
					data: "equipment_name",
					label: "Equipment",
					
					datatype: "none",
					// render: function (data, row) {

					// 	return '<div class="data-box-l">' + data + '</div>'
					// }
				},
				{
					data: "priority_level",
					label: "Priority",
					class: 'w-15',
					datatype: 'select',
					list: ['1|Priority 1', '2|Priority 2', '3|Priority 3', '4|Priority 4', '5|Priority 5'],
					// render: function(data, row) {
					// 	console.log(row)
					// 	return 'Priority ' + data;
					// }
				},
				{
					data: "service_providers_name",
					label: "Service  Provider",
					class: 'w-15',
					datatype: "none",

				},
				{
					data: "pm_start_date_only",
					label: "Date  &  Time Scheduled",
					class: '',
					datatype: 'date',
					render:function(data, row){
						return data + " "+ row.pm_start_time_only;
					}
				},
				{
					data: "critical",
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
					data: "notify_days_before_next_schedule",
					label: "Days to Notify",
					class: '',
					datatype: "none",
					render: function (data,row){
							return '<div class="data-box-n">' + data + '</div>'
					}
				},
				{
					data: null,
					label: "Action",
					class: '',
					render: function(data, row) {
						return '<a class="btn btn-sm text-primary btn-delete-icon" onclick="show_delete_modal(this)" title="Are you sure?" role_access="<?= $role_access->delete ?>" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/property-management/delete-record/' + row.id + '?display=plain&table=pm&view_table=view_pm&redirect=/property-management/pm?submenuid=pm"><i class="bi bi-trash-fill"></i></a>'
					},
					orderable: false
				},
			],
			order: [
				[5, 'asc']
			],
			// colFilter: {'status':'Active'}
		});
		$('.btn-delete-filter').on('click', function() {
			var table = $('input[name="check_box"]').attr('table');
			var view_table = $('input[name="check_box"]').attr('view_table');
			var redirect = $('input[name="check_box"]').attr('reload');

			var ids = [];
			$('input[name="check_box"]:checked').each(function() {
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
		$(document).on("click", '.checkbox-icon', function(evt) {
			evt.stopPropagation();
		});

		$(document).on("click", ".row-id", function() {
			// var data = table.row(this).data();
			var id = $(this).data("id");
			window.location.href = "<?= WEB_ROOT ?>/property-management/view-pm/" + id + "/View";
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

		$('.all-btn').on('click', function(e) {
			$(".all-btn").addClass('active1');
			$(".weekly-btn").removeClass('active1');
			$(".monthly-btn").removeClass('active1');

		});

		$('.weekly-btn').on('click', function(e) {
			$(".weekly-btn").addClass('active1');
			$(".all-btn").removeClass('active1');
			$(".monthly-btn").removeClass('active1');
		});

		$('.monthly-btn').on('click', function(e) {
			$(".monthly-btn").addClass('active1');
			$(".weekly-btn").removeClass('active1');
			$(".all-btn").removeClass('active1');

		});
	});
</script>