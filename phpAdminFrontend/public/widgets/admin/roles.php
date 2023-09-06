<?php
$title = "Roles";
$module = "admin";
$table = "roles";
$view = "roles";
?>
<div class="main-container">
	<div class="page-title"></div>

	<div class="d-flex justify-content-between mb-2">
		<div class="d-flex align-items-end">
			<label class="text-label-result px-3 mb-0" id="search-result">
			</label>
		</div>

	</div>

	<div class="container-table bg-gray">
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
	<script>
		<?php $unique_id = $module . time(); ?>
		var t<?= $unique_id; ?>;
		$(document).ready(function() {


			t<?= $unique_id; ?> = $("#jsdata").JSDataList({

				ajax: {
					url: "<?= WEB_ROOT . "/module/get-list/{$view}?display=plain" ?>"
				},
				rowClass: 'hover:bg-gray-100',
				titleClass: 'text-rentaPageTitle',
				filterBoxID: 'dropdownmenufilter',
				buttons: [{
					icon: `<span class="material-symbols-outlined">add</span>`,
					title: " Create New",
					class: "btn-add btn-blue",
					id: "edit",
				}],
				columns: [{
						data: "id",
						label: "ID #",
						class: '',
						render: function(data, row) {
							return row.data_id
							// return '<input class="d-none d-lg-block" type="checkbox" id="'+ row.id +'" name="check_box" table="roles" view_table="roles"  reload="<?= WEB_ROOT; ?>/admin/roles?submenuid=roles">'+
							// '<a href="<?= WEB_ROOT; ?>/admin/view-roles/' + row.id  + '/View" target="_self">' + row.data_id +'</a>';
						}
					},
					{
						data: "created_by_full_name",
						label: "Created By",
						class: ' '
					},
					{
						data: "role_name",
						label: "Name",
						class: ' '
					},
					{
						data: "description",
						label: "Description",
						class: ' '
					},
					{
						data: null,
						label: "Action",
						class: "text-left",
						class: '',
						render: function(data, row) {
							{
								return '<a class="btn btn-sm btn-view" title="View ID ' + row.data_id + '" href="<?= WEB_ROOT ?>/admin/view-roles/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> ' +
									' <a class="btn btn-sm text-primary btn-delete" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="' + row.data_id + '" del_url="<?= WEB_ROOT ?>/admin/delete-record/' + row.id + '?display=plain&table=roles&redirect=/admin/roles?submenuid=roles"><i class="bi bi-trash-fill"></i></a>' +
									'<a class="btn btn-sm" href="<?= WEB_ROOT ?>/admin/role_permissions/' + row.id + '/View"><i class="fa-solid fa-unlock text-primary"></i></a> ';
							}
						}
					}
				],
			});

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
			$(".btn-add").off('click').on('click', function() {
				window.location.href = '<?php echo WEB_ROOT; ?>/admin/form-add-roles';
			});

			$('.bi-caret-up-fill').hide();
		});
	</script>