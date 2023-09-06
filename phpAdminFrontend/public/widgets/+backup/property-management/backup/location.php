<?php
$title = "";
$menu = "property-management";
$module = "location";
$table = "locations";
$view = "vw_locations";
$fields = rawurlencode(json_encode([
	"ID" => "rec_id",
	"Name" => "location_name",
	"Parent Location" => "parent_location_name",
	"Location Type" => "location_type",
	"Location Use" => "location_use",
	"Floor Area" => "floor_area",
	"Status" => "location_status",
]));
$role_access = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($role_access);
$menuid = "propman";
$submenuid = "locationlibrary";
?>
<div class="main-container">
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
</div>
<script>
	<?php $unique_id = $module.time()?>
	var t<?=$unique_id?>;

	$(document).ready(function() {
		t<?=$unique_id?> = $("#jsdata").JSDataList({
			ajax: {
				url: '<?=WEB_ROOT?>/module/get-records/<?=$view?>?display=plain'
			},
			rowLink: {
				url: '<?=WEB_ROOT?>/<?=$menu?>/<?=$module?>-view/',
				key: 'enc_id',
			},
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			buttons: [{
					icon: `<span class="material-symbols-outlined">add</span>`,
					title: " Create New",
					class: "btn-add btn-blue",
					id: "edit",
					href: '<?=WEB_ROOT?>/<?=$menu?>/<?=$module?>-form/',
				},
				// {
				// 	icon: `<span class="material-symbols-outlined">delete</span>`,
				// 	title: "Delete",
				// 	class: "btn-delete-filter",
				// 	id: "delete",
				// },
				{
					icon: `<span class="material-symbols-outlined">arrow_downward</span>`,
					title: "Download",
					class: "btn-download",
					href: '<?=WEB_ROOT?>/module/download/?display=csv&module=<?=$module?>&table=<?=$table?>&view=<?=$view?>&fields=<?=$fields?>',
					id: "download",
				},
				{
					icon: `<span class="material-symbols-outlined">filter_list</span>`,
					title: "Filter",
					class: "filter",
				}
			],
			columns: [
				{
					data: "id",
					visible: false,
				},
				{
					data: "location_name",
					label: "Name",
					class: '',
					datatype: 'none'
				},
				{
					data: "location_type",
					label: "Location Type",
					class: '',
					datatype: 'select',
					list: ['Unit', 'Floor']
				},			
				{
					data: "parent_location_name",
					label: "Parent Location",
					class: '',
					datatype: 'none'
				},
				{
					data: "location_use",
					label: "Location Use",
					class: '',
					datatype: 'select',
					list: ['Residential', 'Commercial']
				},
				{
					data: "floor_area",
					label: "Floor Area",
					class: '',
					datatype: 'none'
				},
				{
					data: "location_status",
					label: "Status",
					class: '',
					datatype: 'select',
					list: ['Vacant', 'Occupied']
				},
				{
					data: "actions",
					label: "Actions",
					class: 'text-center',
					datatype: 'none',
					render: function(data, row) {
						return `
						<a href="<?=WEB_ROOT."/$menu/$module"?>-form/${row.enc_id}" title="Edit location ${row.location_name}"><i class="fa-solid fa-pen fa-lg text-primary"></i></a>&emsp;
						<a del_url="<?=WEB_ROOT?>/module/delete/<?=$menu?>/<?=$module?>/<?=$table?>/${row.enc_id}" onclick="show_delete_modal(this)" role_access="<?=$role_access->delete?>" title="Delete location ${row.location_name}" rec_id="${row.id}">
							<i class="fa-solid fa-trash fa-lg text-danger"></i></a>`;
					}
				},
			],
			order: [ [0, 'desc'] ],
			/*colFilter: { 'location_status': 'Vacant' }*/
		});

		$(".btn-filter-status").on('click', function() {
			t<?=$unique_id?>.options.colFilter = {
				'location_status': $(this).data('location_status')
			};
			t<?=$unique_id?>.ajax.reload();

			$(".btn-filter-status").not($(this)).removeClass('btn-primary').addClass('btn-secondary');
			$(this).addClass('btn-primary').removeClass('btn-secondary');
		});

		$('.filter').on('click', function() {
			$(".dropdown-menu").toggle();
		});
	});
</script>