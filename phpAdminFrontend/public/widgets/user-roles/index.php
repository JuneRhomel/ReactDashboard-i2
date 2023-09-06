<?php
$module = "user-roles";
$table = "role";
$view = "_roles";


// $result = $ots->execute('form', 'get-role-access', ['table' => $table]);
// $role_access = json_decode($result);
$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
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
			<table id="jsdata"></table>
		</div>
	<?php endif; ?>
</div>
<script>
	$(document).ready(function() {
		// INIT RESIDENT TYPE FOR FILTER
		var list_role = [];
		<?php foreach ($list_role as $val) { ?>
			list_role.push('<?= $val ?>');
		<?php } ?>
		t<?= $unique_id ?> = $("#jsdata").JSDataList({
			ajax: {
				url: '<?=WEB_ROOT?>/module/get-records/<?= $view ?>?display=plain'
			},
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			buttons: [
				<?php if ($role_access->create) { ?> {
						icon: `<span class="material-symbols-outlined">add</span>`,
						title: " Create New",
						href: '<?=WEB_ROOT?>/<?= $module ?>/form/',
						class: "btn-add btn-blue",
						id: "edit",
					}
				<?php } ?>
			],
			columns: [

				{
					data: "role_name",
					label: "Role",
					class: 'text-capitalize',
				},
				// {
				// 	data: "description",
				// 	label: "Description",
				// 	class: 'text-capitalize',
				// },
				{
					data: "is_active",
					label: "Action",
					class: 'w-20',
					orderable: false,
					render: function(data, row) {
						console.log(row)
						lnkUpdate = lnkView = lnkDelete = link = "";
						if (row.id != 1 && row.id != 2 ) {
							lnkUpdate = '<a href="<?=WEB_ROOT."/$module" ?>/form/'+row.enc_id+'" title="Edit ['+row.role+']"><i class="fa-solid fa-pen fa-lg text-primary"></i></a>';
							lnkView = '<a class="btn access-icon" href="<?=WEB_ROOT?>/user-roles/role_permissions/'+row.enc_id+'/view"><span class="material-icons">admin_panel_settings</span></a>';
							lnkDelete = '<a class="access-icon" del_url="<?=WEB_ROOT."/module/delete/user-roles/$view" ?>/'+row.enc_id+'" onclick="show_delete_modal(this)" role_access="<?=$role_access->delete ?>" title="Delete ['+row.role_name+']" rec_id="'+row.id+'"><i class="fa-solid fa-trash fa-lg text-danger"></i></a>';
						} 			
						<?php if ($role_access->access) { ?> 
						link = link + lnkView;
						<?php } ?>
						<?php if ($role_access->update) { ?> 
						link = link + lnkUpdate;
						<?php } ?>
						<?php if ($role_access->delete) { ?> 
						link = link + lnkDelete;
						<?php } ?>
						return link;
					}
				},
			],
			order: [
				[1, 'desc']
			],
		});

		$('.filter').on('click', function() {
			$(".dropdown-menu").toggle();
		});
	});
</script>