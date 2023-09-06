<?php
$module = "visitorpass";
$table = "visitorpass";
$view = "vw_visitor_pass";
$fields = rawurlencode(json_encode([
	"ID" => "id",
	"Resident Name" => "fullname",
	"Unit" => "location_name",
	"Departure Date" => "departure_date",
	"Departure Time" => "departure_time",
	"Arrival Date" => "arrival_date",
	"Arrival Time" => "arrival_time",
	"Status" => "status",
]));

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
	<?php $unique_id = $module . time() ?>
	var t<?= $unique_id ?>;
	const approval_status = (status, i) => {
		let data = {};
		if (status === 'approve') {
			data = {
				id: i,
				approve: '1',
				table: 'visitorpass'
			};
		} else {
			data = {
				id: i,
				approve: '2',
				table: 'visitorpass'
			};
		}
		$.ajax({
			url: '<?= WEB_ROOT; ?>/servicerequest/save?display=plain',
			type: 'POST',
			data: data,
			dataType: 'JSON',
			success: function(data) {
				popup({
                        data: data,
                        reload_time: 2000,
                        redirect: "<?= WEB_ROOT . "/$module/" ?>"
                    })
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	};
	$(document).ready(function() {
		// INIT FOR FILTER

		t<?= $unique_id ?> = $("#jsdata").JSDataList({
			ajax: {
				url: '<?= WEB_ROOT ?>/module/get-records/<?= $view ?>?display=plain'
			},
			rowLink: {
				url: '<?= WEB_ROOT ?>/<?= $module ?>/view/',
				key: 'enc_id',
			},
			<?php if($_GET['filter']){ ?>
			colFilter: "status =  'pending'",
			<?php } ?>
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
					label: "Request #",
					datatype: 'none',
					class: 'w-10',
				},

				{
					data: "fullname",
					label: "Resident <br> Name",
					class: '',
					datatype: 'none'
				},
				{
					data: "location_name",
					label: "Unit",
					class: '',
					datatype: 'none',
				},
				{
					data: "arrival_date",
					label: "Arrival <br> Date",
					class: '',
					datatype: 'none'
				},
				{
					data: "arrival_time",
					label: "Arrival <br> Time",
					class: 'w-10',
					datatype: 'none'
				},
				{
					data: "departure_date",
					label: "Departure <br> Date",
					class: 'w-10',
					datatype: 'none'
				},
				{
					data: "departure_time",
					label: "Departure <br> Time.",
					class: 'w-10',
					datatype: 'none'
				},				
				{
					data: "status",
					label: "Approval",
					class: 'w-10',
					datatype: 'select',
					list: ['Approved', 'Disapproved', 'Pending'],

					render: function(data, row) {
						// console.log(row)
						if (data) {
							if (data === 'Approved') {
								return '<div class="m-auto  data-box-y">' + data + '</div>';

							} else if (data === 'Disapproved') {
								return '<div class="m-auto data-box-n">' + data + '</div>';
							} else {
								return `<div class='d-flex gap-1'>
							<button class="main-btn-s " onclick="approval_status('approve','${row.enc_id}')">Approve</button> 
							<button class="main-btn-outline-s " onclick="approval_status('deny','${row.enc_id}')">Disapproved</button>
						</div>`;
							}
						}
					},

					// orderable: [
					// 	[0, 'desc']
					// ],
				},
				{
					label: "Actions",
					class: 'text-center w-10',
					datatype: 'none',
					searchable: false,
					orderable: false,
					render: function(data, row) {

						return `
						<a href="<?= WEB_ROOT . "/$module/view/" ?>${row.enc_id}" title="View [${row.fullname}]"><i class="fa-solid fa-eye fa-lg text-info"></i></a>&emsp;
						<?php if ($role_access->update) : ?> 
							${row.status != "Approved" && row.status != "Disapproved"? '<a href="<?= WEB_ROOT . "/$module/form/" ?>'+ row.enc_id +'" title="Edit [' + row.fullname +']"><i class="fa-solid fa-pen fa-lg text-primary"></i></a>&emsp;' :" "}
						<?php endif; ?>
						<?php if ($role_access->delete) : ?> 
							${row.status != "Approved" && row.status != "Disapproved"? '<a del_url="<?= WEB_ROOT . "/module/delete/$module/$table" ?>/'+row.enc_id+'" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" title="Delete ['+row.fullname+']" rec_id="'+row.id+'"><i class="fa-solid fa-trash fa-lg text-danger"></i></a>':""}
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