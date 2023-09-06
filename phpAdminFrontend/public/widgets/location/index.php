<?php
$module = "location";
$table = "location";
$view = "vw_location";
$fields = rawurlencode(json_encode([
	// "ID" => "id",

	"Location Name" => "location_name",
	"Location Type" => "location_type",
	"Location Use" => "floor_area",
	"Status" => "status",
	"Parent Location" => "parent_location_name",
]));

$result = $ots->execute('form', 'get-role-access', ['table'=>$table]);
$role_access = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_locationtype','condition'=>$type_condition,'field'=>'locationtype' ]);
$list_locationtype = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_locationuse','condition'=>"ownership like '%{$ownership}%'",'field'=>'locationuse' ]);
$list_locationuse = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_locationstatus','condition'=>"ownership like '%{$ownership}%'",'field'=>'locationstatus' ]);
$list_locationstatus = json_decode($result);
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
	<?php $unique_id = $module . time() ?>
	var t<?= $unique_id ?>;

	$(document).ready(function() {
		// INIT FOR FILTER
		var list_locationtype = [];
		<?php foreach ($list_locationtype as $val) { ?>
			list_locationtype.push('<?= $val ?>');
		<?php } ?>
		var list_locationuse = [];
		<?php foreach ($list_locationuse as $val) { ?>
			list_locationuse.push('<?= $val ?>');
		<?php } ?>
		var list_locationstatus = [];
		<?php foreach ($list_locationstatus as $val) { ?>
			list_locationstatus.push('<?= $val ?>');
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
				<?php if ($role_access->create) : ?> {
						"icon": "<span class='material-symbols-outlined'>add</span>",
						"title": "Create New",
						"class": "btn-add btn-blue",
						"id": "upload",
						"href": '<?= WEB_ROOT ?>/<?= $module ?>/form/'
					},
				<?php endif; ?>
				<?php if ($role_access->download) : ?> {
						icon: `<span class="material-symbols-outlined">arrow_downward</span>`,
						title: "Download",
						class: "btn-download",
						href: '<?= WEB_ROOT ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>',
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
					visible: false,
				},
				{
					data: "location_name",
					label: "Location <br> Name",
					class: '',
					datatype: 'none'
				},
				{
					data: "location_type",
					label: "Location <br> Type",
					class: '',
					datatype: 'select',
					list: list_locationtype
				},
				{
					data: "location_use",
					label: "Location Use",
					class: '',
					datatype: 'select',
					list: list_locationuse
				},
				{
					data: "parent_location_name",
					label: "Parent <br> Location",
					class: '',
					datatype: 'none',
				},
				{
					data: "floor_area",
					label: "Floor <br> Area",
					class: '',
					datatype: 'none'
				},
				{
					data: "status",
					label: "Status",
					class: '',
					datatype: 'select',
					list: list_locationstatus
				},
				{
					label: "Actions",
					class: 'text-center',
					datatype: 'none',
					searchable: false,
					orderable: false,
					render: function(data, row) {
						return `
						<a href="<?= WEB_ROOT . "/$module/view/" ?>${row.enc_id}" title="View [${row.location_name}]"><i class="fa-solid fa-eye fa-lg text-info"></i></a>&emsp;
						<?php if ($role_access->update) : ?> 
						<a href="<?= WEB_ROOT . "/$module/form/" ?>${row.enc_id}" title="Edit [${row.location_name}]"  role_access="<?= $role_access->update ?>" ><i class="fa-solid fa-pen fa-lg text-primary"></i></a>&emsp;
						<?php endif; ?>
						<?php if ($role_access->delete) : ?> 
						<a del_url="<?= WEB_ROOT . "/module/delete/$module/$table" ?>/${row.enc_id}" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" 
							title="Delete [${row.location_name}]" rec_id="${row.id}"><i class="fa-solid fa-trash fa-lg text-danger"></i></a>
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