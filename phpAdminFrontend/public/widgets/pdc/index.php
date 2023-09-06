<?php
$module = "pdc";
$table = "pdcs";
$view = "vw_pdcs";

$fields = rawurlencode(json_encode([
	"ID" => "id",
	"Full Name" => "fullname",
	"Unit" => "location_name",
	"Check No" => "check_no",
	"Check Date" => "check_date",
	"Check Amount" => "check_amount",
	"Status" => "status",
]));

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_pdcstatus','field'=>'status' ]);
$list_status = json_decode($result);

$result = $ots->execute('form', 'get-role-access', ['table' => $table,]);
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
		// INIT FOR FILTER
		var list_pdcs = [];
		<?php foreach ($list_pdcs as $val) { ?>
			list_pdcs.push('<?= $val ?>');
		<?php } ?>
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
						id: "careate",
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
				<?php } ?> {
					icon: `<span class="material-symbols-outlined">filter_list</span>`,
					title: "Filter",
					class: "filter",
				}
			],
			columns: [

				{
					data: "id",
					label: "ID",
					class: '',
					datatype: 'none'
				},
				{
					data: "fullname",
					label: "Name",
					class: '',
					datatype: 'none'
				},
				{
					data: "location_name",
					label: "Unit",
					class: '',
					datatype: 'none'
				},
				{
					data: "check_date",
					label: "Date",
					class: '',
					datatype: 'none',
					list: list_pdcs
				},
				{
					data: "check_no",
					label: "Check Number",
					class: '',
					datatype: 'none',
				},
				{
					data: "check_amount",
					label: "Amount",
					class: '',
					datatype: 'none'
				},
				{
					data: "status",
					label: "Stage",
					class: '',
					datatype: 'select',
					list: ['Received','Cleared','Bounced']
				},
				{
					label: "Actions",
					class: 'text-center',
					datatype: 'none',
					searchable: false,
					orderable: false,
					render: function(data, row) {
                        console.log(row)
						return `
						<a href="<?= WEB_ROOT . "/$module/view/" ?>${row.enc_id}" title="View [${row.fullname}]"><i class="fa-solid fa-eye fa-lg text-info"></i></a>&emsp;
						<?php if ($role_access->update) : ?> 
						<a href="<?= WEB_ROOT . "/$module/form/" ?>${row.enc_id}" title="Edit [${row.fullname}]"><i class="fa-solid fa-pen fa-lg text-primary"></i></a>&emsp;
						<?php endif; ?>
						<?php if ($role_access->delete) : ?> 
						<a del_url="<?= WEB_ROOT . "/module/delete/$module/$table" ?>/${row.enc_id}" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" 
							title="Delete [${row.fullname}]" rec_id="${row.id}"><i class="fa-solid fa-trash fa-lg text-danger"></i></a>
							<?php endif; ?>`
					}
				},
			],
			order: [
				[0, 'desc']
			],
		});

		$('.filter').on('click', function() {
			$(".dropdown-menu").toggle();
		});
	});
</script>