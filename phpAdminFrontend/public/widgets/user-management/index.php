<?php
$title = "User Management";
$module = "user-management";
$table = "_users";
$view = "vw_users";
$role_view = "_roles";


$result = $ots->execute('admin', 'get-role', ['view' => $role_view]);
$roles = json_decode($result)->data;
// var_dump($roles);
// foreach($roles as $i) {
// 	echo $i;
// }


$result =  $ots->execute('module', 'get-listnew', ['table' => '_users']);
$list_residenttype = json_decode($result);
// var_dump(md5('12345'));
// var_dump( md5('12345') == md5($list_residenttype[2]->password));


// var_dump(md5($list_residenttype[0]));
$result = $ots->execute('form', 'get-role-access', ['table' => $table,]);
$role_access = json_decode($result);
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
	<?php endif; ?>
</div>

<script>
	$('.select-role').hide();
	const access = (i, e) => {
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
			buttons: [
				<?php if ($role_access->create) { ?> {
						icon: `<span class="material-symbols-outlined">add</span>`,
						title: " Create New",
						class: "btn-add btn-blue",
						id: "careate",
						href: '<?= WEB_ROOT ?>/<?= $module ?>/form/',
					},
				<?php } ?>
			],
			columns: [{
					data: "email",
					label: "Email",
					class: '',
					// render: function(data, row) {
					//     console.log(row)
					// 	return row.data_id
					// 	return '<input class="d-none d-lg-block" type="checkbox" id="'+ row.id +'" name="check_box" table="roles" view_table="roles"  reload="<?= WEB_ROOT; ?>/admin/roles?submenuid=roles">'+
					// 	'<a href="<?= WEB_ROOT; ?>/admin/view-roles/' + row.id  + '/View" target="_self">' + row.data_id +'</a>';
					// }
				},
				{
					data: "firstname",
					label: "Firstname",
					class: ' '
				},
				{
					data: "lastname",
					label: "Lastname",
					class: ' '
				},
				{
					data: "role_name",
					label: "Role",
					class: 'capitalize'
				},
				{
					data: "is_active",
					label: "Status",
					class: ' ',
					orderable: false,
					render: function(data, row) {

						if (data === "1") {
							return 'Active'
						}
						return "Inactive"

					}
				},
				{
					data: null,
					label: "Action",
					class: "text-left",
					class: 'w-15',
					orderable: false,
					render: function(data, row) {
						console.log(row)
						// return '<a href="<?= WEB_ROOT ?>/user-management/view-roles/' + row.enc_id + '/View" title="View ID ' + row.data_id + '""><i class="fa-solid fa-eye fa-lg text-info"></i></a>'+

						return `
						${row.role_type != 1 && row.role_type != 2? `
						<?php if ($role_access->update) { ?> 
						<a href="<?= WEB_ROOT . '/' . $module ?>/form/${row.enc_id}" title="Edit [Lobby]" class="mx-3"><i class="fa-solid fa-pen fa-lg text-primary"></i></a>
						<?php } ?>

						<?php if ($role_access->access) { ?> 
						<button onclick="access(${row.id}, '${row.role_type}')" class="btn btn-sm btn-primary pay-button">Access</button>
						<?php } ?>
						<?php if ($role_access->delete) { ?> 
							<a class="mx-3" del_url="<?= WEB_ROOT . "/user-management/delete/$module/$table" ?>/${row.enc_id}" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>"
								title="Delete [${row.firstname}${row.lastname}]" rec_id="${row.id}"><i class="fa-solid fa-trash fa-lg text-danger"></i></a>
						<?php } ?>
						 ` : ''}`;


					}
				}
			],
			order: [
				[1, 'desc']
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
				success: function(res) {
					const data = JSON.parse(res)
					console.log(data)

					popup({
						data: data,
						reload_time: 2000,
						redirect: location.href
					})

				},
				error: function(xhr, status, error) {
					// Handle the error response
					console.log(error);
				}
			});
		});







		$('.close').click(function() {
			$('.select-role').hide();
		});

	});
</script>