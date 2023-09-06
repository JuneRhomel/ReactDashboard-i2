<?php
$title = "News and Announcement";
$module = "tenant";
$table = "news";
$view = "news";

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
$fields = rawurlencode(json_encode(
	[
		"ID" => "id",
		"Title" => "title",
		// "Contact" => "contact",
		// "Email" => "email"
	]
));

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
	'table' => 'news',
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
		<div class="d-flex justify-content-between mb-2">
			<div class="d-flex align-items-end">
				<label class="text-label-result px-3 mb-0" id="search-result">
				</label>
			</div>

		</div>
		<!-- <div class="d-flex">
			<button class="btn tabs-table all-btn active1">All</button>
			<button class="btn tabs-table pending-btn">Pending</button>
			<button class="btn tabs-table approve-btn">Approve</button>
			<button class="btn tabs-table denied-btn">Denied</button>
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
<script>
	// function show_renew_modal(button_data){
	// 	id = $(button_data).attr('id');
	// 	$('#renew').modal('show');
	// 	$('#renew .modal-title').html($(button_data).attr('title'));
	// 	$('#renew .modal-body input#renew_id').val(id);
	// }


	<?php $unique_id = $module . time(); ?>
	var t<?= $unique_id; ?>;
	$(document).ready(function() {
		$('#form-renew').submit(function(e) {
			data = $(this).serialize();
			e.preventDefault();
			$.post({
				// url:'<?= WEB_ROOT ?>/tenant/renew-permits?display=plain',
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
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			buttons: [{
					icon: `<span class="material-symbols-outlined">add</span>`,
					title: "Create New",
					class: "btn-add btn-blue",
					id: "edit",
				},
				<?php if ($role_access->delete == true) : ?> {
						icon: `<span class="material-symbols-outlined">delete</span>`,
						title: "Delete",
						class: "btn-delete-filter",
						id: "delete",
					},
				<?php endif; ?>
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
					render: function(data, row) {
						return row.data_id;
						//return '<input type="checkbox" id="' + row.id + '" name="check_box" table="tenant" view_table="view_tenant" reload="<?= WEB_ROOT; ?>/tenant/tenant-registration?submenuid=tenant_registration"> ' + row.data_id;
					}
				},
				// {
				// 	data: "created_on",
				// 	label: "Date",
				// 	class: 'col-lg-2 col-1 col-md-6 col-sm-6 text-center',
				// 	render: function(data, row) {
				//         var d = new Date(data * 1000);
				//         var c = new Date();
				//         var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
				//         return months[d.getMonth()] + ' ' + d.getDate() +', ' + d.getFullYear();
				//     },
				// },
				{
					data: 'title',
					label: "Title",
					class: ''
				},
				{
					data: "contact",
					label: "Contact",
					class: ''
				},
				{
					data: "email",
					label: "Email",
					class: ''
				},
				{
					data: null,
					label: "Action",
					class: '',
					render: function(data, row) {
						console.log(row)
						if (row.status == 0) {
							return '<a class="btn btn-sm text-primary btn-delete" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" rec_id="' + row.data_id + '" title="Delete ID ' + row.data_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=news&view_table=news&redirect=/tenant/news-announcements?submenuid=news_announcements"><i class="bi bi-trash-fill"></i></a>' +
								'<a class="btn btn-sm btn-primary btn-deposit" onclick="show_update_modal(this)" role_access="<?= $role_access->publishing ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/save-update/' + row.id + '?display=plain&table=news&redirect=/tenant/news-announcements?submenuid=news_announcements&status=1">Publish</a>';
						} else {
							return '<a class="btn btn-sm text-primary btn-delete" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" rec_id="' + row.data_id + '" title="Delete ID ' + row.data_id + '" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=news&view_table=news&redirect=/tenant/news-announcements?submenuid=news_announcements"><i class="bi bi-trash-fill"></i></a>' +
								'<a class="btn btn-sm btn-primary btn-deposit" onclick="show_update_modal(this)" role_access="<?= $role_access->publishing ?>" title="Are you sure?" rec_id="' + row.rec_id + '" del_url="<?= WEB_ROOT ?>/tenant/save-update/' + row.id + '?display=plain&table=news&redirect=/tenant/news-announcements?submenuid=news_announcements&status=0">Unpublish</a>';
						}
					},
					orderable: false
				}
			],
			// colFilter: {'status':'Active'}
		});

		$(document).on("click", ".row-id", function() {
			// var data = table.row(this).data();
			var id = $(this).data("id");
			window.location.href = "<?= WEB_ROOT ?>/tenant/view-building-directory/" + id + "/View";
			// console.log(data);
			// alert('div clicked')
		});


		$(".btn-add").off('click').on('click', function() {
			window.location.href = "<?= WEB_ROOT . "/tenant/"; ?>form-add-building-directory";
		});
		$(document).on("click", '.btn-delete', function(evt) {
			evt.stopPropagation();
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

		$(".btn-filter-status").on('click', function() {
			t<?= $unique_id; ?>.options.colFilter = {
				'status': $(this).html()
			};
			t<?= $unique_id; ?>.ajax.reload();

			$(".btn-filter-status").not($(this)).removeClass('btn-primary').addClass('btn-secondary');
			$(this).addClass('btn-primary').removeClass('btn-secondary');
		});

		$('.all-btn').on('click', function(e) {
			$(".all-btn").addClass('active1');
			$(".pending-btn").removeClass('active1');
			$(".approve-btn").removeClass('active1');
			$(".denied-btn").removeClass('active1');

		});

		$('.pending-btn').on('click', function(e) {
			$(".pending-btn").addClass('active1');
			$(".all-btn").removeClass('active1');
			$(".approve-btn").removeClass('active1');
			$(".denied-btn").removeClass('active1');
		});

		$('.approve-btn').on('click', function(e) {
			$(".approve-btn").addClass('active1');
			$(".pending-btn").removeClass('active1');
			$(".all-btn").removeClass('active1');
			$(".denied-btn").removeClass('active1');

		});

		$('.denied-btn').on('click', function(e) {
			$(".denied-btn").addClass('active1');
			$(".pending-btn").removeClass('active1');
			$(".all-btn").removeClass('active1');
			$(".approve-btn").removeClass('active1');

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