<?php
$module = "personnel";
$table = "personnel";
$view = "vw_personnel";
$fields = rawurlencode(json_encode([
	"ID" => "id",
	"Employee No." => "employee_number",
	"Employee Nname" => "employee_name",
	"Username" => "username",
	"Email" => "email",
	"Contact No." => "contact_number",
	"Home Address" => "home_address",
	"Working Schedule" => "working_schedule",
	"Working Hours" => "working_hours",
	"Emergency Contact Person" => "emergency_contact_person",
	"Relationship" => "relationship",
	"Emergency Contact No." => "emergency_contact_number",
]));

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);
// var_dump($result);
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
		<table id="jsdata"></table>
	</div>
	<?php endif; ?>
</div>
<script>
	<?php $unique_id = $module . time() ?>
	var t<?= $unique_id ?>;

	$(document).ready(function() {
		t<?= $unique_id ?> = $("#jsdata").JSDataList({
			ajax: {
				url: '<?= WEB_ROOT ?>/module/get-records/<?= $view ?>?display=plain'
			},
			rowLink: {
				url: '<?= WEB_ROOT ?>/<?= $module ?>/view/',
				key: 'enc_id',
			},
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			buttons: [
				<?php if ($role_access->create) { ?> {
						icon: `<span class="material-symbols-outlined">add</span>`,
						title: " Create New",
						class: "btn-add btn-blue",
						id: "edit",
						href: '<?= WEB_ROOT ?>/<?= $module ?>/form/',
					},
				<?php } ?>
				<?php if ($role_access->download) { ?> {
						icon: `<span class="material-symbols-outlined">arrow_downward</span>`,
						title: "Download",
						class: "btn-download",
						href: '<?= WEB_ROOT ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>',
						id: "download",
					},
				<?php } ?>
			],
			columns: [{
					data: "id",
					visible: false,
				},
				{
					data: "employee_number",
					label: "Employee No.",
					class: '',
					datatype: 'none',
				},
				{
					data: "employee_name",
					label: "Employee Name",
					class: '',
					datatype: 'none',
				},
				{
					data: "contact_number",
					label: "Contact No.",
					class: '',
					datatype: 'none'
				},
				{
					data: "home_address",
					label: "Home Address",
					class: '',
					datatype: 'none',
				},
				{
					label: "Actions",
					class: 'text-center',
					datatype: 'none',
					searchable: false,
					orderable: false,
					render: function(data, row) {
						return `
						<a href="<?= WEB_ROOT . "/$module/view/" ?>${row.enc_id}" title="View [${row.employee_name}]"><i class="fa-solid fa-eye fa-lg text-info"></i></a>&emsp;
						<?php if ($role_access->update) : ?> 
						<a href="<?= WEB_ROOT . "/$module/form/" ?>${row.enc_id}" title="Edit [${row.employee_name}]"><i class="fa-solid fa-pen fa-lg text-primary"></i></a>&emsp;
						<?php endif; ?>
						<?php if ($role_access->delete) : ?> 
						<a del_url="<?= WEB_ROOT . "/module/delete/$module/$table" ?>/${row.enc_id}" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" 
							title="Delete [${row.employee_name}]" rec_id="${row.id}"><i class="fa-solid fa-trash fa-lg text-danger"></i></a>
							<?php endif; ?>`
					}
				},
			],
			order: [
				[0, 'desc']
			],
		});
	});
</script>