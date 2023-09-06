<?php
$title = "User Management";
$module = "admin";
$table = "roles";
$view = "vw_user_roles";
$role_view = "_roles";



$result = $ots->execute('admin', 'get-role', ['view' => $role_view]);
$roles = json_decode($result)->data;
// var_dump($roles);
// foreach($roles as $i) {
// 	echo $i;
// }
?>
<div class="main-container">
	<div class="container-table bg-gray">

		<table id="jsdata"></table>
	</div>
	<div class="select-role ">
		<div class="d-flex justify-content-end mt-1">
			<button class="text-end close border-0 bg-transparent">
				<span class="material-icons">
					close
				</span>
			</button>

		</div>
		<form method="post" action="<?php echo WEB_ROOT; ?>/user-management/save-roles?display=plain" id="form-role">
			<h1 class="text-center bold mb-5">Select Role</h1>
			<input type="hidden" id="id" name="user_id">
			<div class=" ">
				<div class="input-box">
					<select name="role_id" id="role_id">
						<?php foreach ($roles as $role) : ?>
							<option value="<?= $role->id ?>"><?= $role->role_name ?></option>
						<?php endforeach ?>
					</select>
					<label class="capitalize bold " style="text-transform: capitalize" for="role">Role</label>
				</div>
			</div>
			<div class="d-flex justify-content-end mt-4">
				<button class="main-btn">Save</button>
			</div>
		</form>
	</div>
</div>

<script>
	<?php $unique_id = $module . time(); ?>
	var t<?= $unique_id; ?>;

	$('.select-role').hide();
	const access = (i,e) => {
		$('.select-role').show();
		$('#id').val(i);
		$('#role_id').val(e);
	}
	$(document).ready(function() {

		// $('.select-role').hide()
		t<?= $unique_id; ?> = $("#jsdata").JSDataList({

			ajax: {
				url: '<?= WEB_ROOT ?>/module/get-records/<?= $view ?>?display=plain'
			},
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			// buttons: [{
			// 	icon: `<span class="material-symbols-outlined">add</span>`,
			// 	title: " Create New",
			// 	class: "btn-add btn-blue",
			// 	id: "edit",
			// }],
			columns: [{
					data: "id",
					label: "ID #",
					class: '',
					// render: function(data, row) {
					//     console.log(row)
					// 	return row.data_id
					// 	return '<input class="d-none d-lg-block" type="checkbox" id="'+ row.id +'" name="check_box" table="roles" view_table="roles"  reload="<?= WEB_ROOT; ?>/admin/roles?submenuid=roles">'+
					// 	'<a href="<?= WEB_ROOT; ?>/admin/view-roles/' + row.id  + '/View" target="_self">' + row.data_id +'</a>';
					// }
				},
				{
					data: "fullname",
					label: "User",
					class: ' '
				},
				{
					data: "role",
					label: "Role",
					class: 'capitalize'
				},
				{
					data: null,
					label: "Action",
					class: "text-left",
					class: '',
					orderable: false,
					render: function(data, row) {
						console.log(row)
						// return '<a href="<?= WEB_ROOT ?>/user-management/view-roles/' + row.enc_id + '/View" title="View ID ' + row.data_id + '""><i class="fa-solid fa-eye fa-lg text-info"></i></a>'+
						// '<a class="btn btn-sm text-primary btn-delete" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="' + row.data_id + '" del_url="<?= WEB_ROOT ?>/admin/delete-record/' + row.id + '?display=plain&table=roles&redirect=/admin/roles?submenuid=roles"><i class="bi bi-trash-fill"></i></a>' +
						return '<button onclick="access(' + row.id + ', \'' + row.role_id + '\')" class="btn btn-sm btn-primary pay-button">Access</button>';

					}
				}
			],
		});


		$('#form-role').submit(function(event) {
			event.preventDefault(); // Prevent default form submission
			var form = $(this);

			// Perform an AJAX POST request
			$.ajax({
				url: form.attr('action'),
				type: 'POST',
				data: form.serialize(), // Serialize form data
				success: function(data) {
					if (JSON.parse(data).success == 1) {

						toastr.success(data.description, 'User role successfully updated', {
							timeOut: 100,
							onHidden: function() {
								location.reload();
							}
						});
					}
				},
				error: function(xhr, status, error) {
					// Handle the error response
					console.log(error);
				}
			});
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
			window.location.href = '<?php echo WEB_ROOT; ?>/user-management/form-add-roles';
		});

		$('.bi-caret-up-fill').hide();


		$('.close').click(function() {
			$('.select-role').hide();
		});

	});
</script>