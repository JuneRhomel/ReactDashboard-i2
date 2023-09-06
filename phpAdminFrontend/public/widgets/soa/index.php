<?php
$module = "soa";
$table = "soa";
$view = "vw_soa";
$fields = rawurlencode(json_encode([
	"Resident Name" => "resident_name",
	"Month" => "month_of",
	"Year" => "year_of",
	"Balance" => "balance",
	"Charge Amount" => "charge_amount",
	"Electricity" => "electricity",
	"Water" => "water",
	"Current Charges" => "current_charges",
	"Amount Due" => "amount_due",
	"Notes" => "notes",
	"Status" => "status",
]));

$result = $ots->execute('form', 'get-role-access', ['table'=>$table]);
$role_access = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table'=>'list_soastatus', 'field'=>'soastatus']);
$list_soastatus = json_decode($result);
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
	function getMonthName(monthNumber) {
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
      return months[monthNumber - 1];
	}

	<?php $unique_id = $module . time() ?>
	var t<?= $unique_id ?>;

	$(document).ready(function() {
		// INIT FOR FILTER
		var list_soastatus = [];
		<?php foreach ($list_soastatus as $val) { ?>
			list_soastatus.push('<?= $val ?>');
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
			columns: [{
					data: "id",
					visible: false,
				},
				{
					data: "company_name",
					label: "Company Name",
					datatype: "none",
				},
				{
					data: "month_of",
					label: "Month",
					datatype: "none",
					render: function(data, row) {
						return getMonthName(row.month_of);
					}
				},
				{
					data: "year_of",
					label: "Year",
					datatype: "none",
				},
				{
					data: "balance",
					label: "Balance",
					datatype: "none",
				},
				{
					data: "charge_amount",
					label: "Charge Amount",
					datatype: "none",
				},
				{
					data: "electricity",
					label: "Electricity",
					datatype: "none",
				},
				{
					data: "water",
					label: "Water",
					datatype: "none",
				},
				{
					data: "current_charges",
					label: "Current Charges",
					datatype: "none",
				},
				{
					data: "amount_due",
					label: "Amount Due",
					datatype: "none",
				},
				{
					data: "status",
					label: "Status",
					datatype: 'select',
					list: list_soastatus
				},
				{
					label: "Actions",
					class: 'text-center w-15',
					datatype: 'none',
					searchable: false,
					orderable: false,
					render: function(data, row) {
						ret = "";
						<?php if ($role_access->paynow) : ?> 
						if (row.status!='Paid' && row.posted==0) {
							ret = ret + `<a href="<?= WEB_ROOT . "/$module/pay/" ?>${row.enc_id}" title="Pay [${row.resident_name}]"><i class="fa-solid fa-hand-holding-dollar fa-lg text-secondary"></i></a>&emsp;`;
						}
						<?php endif; ?>
						ret = ret + `
						<a href="<?= WEB_ROOT . "/$module/view/" ?>${row.enc_id}" title="View [${row.resident_name}]"><i class="fa-solid fa-eye fa-lg text-info"></i></a>&emsp;
						<?php if ($role_access->update) : ?> 
						<a href="<?= WEB_ROOT . "/$module/form/" ?>${row.enc_id}" title="Edit [${row.resident_name}]"><i class="fa-solid fa-pen fa-lg text-primary"></i></a>&emsp;
						<?php endif; ?>
						<?php if ($role_access->delete) : ?> 
						<a del_url="<?= WEB_ROOT . "/module/delete/$module/$table" ?>/${row.enc_id}" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" 
							title="Delete [${row.fullname}]" rec_id="${row.id}"><i class="fa-solid fa-trash fa-lg text-danger"></i></a>
						<?php endif; ?>
						<?php if ($role_access->print) : ?> 
						<a href="<?= WEB_ROOT . "/$module/genpdf?display=plain&id="?>${row.enc_id}" target="_blank" title="Print [${row.resident_name}]"><i class="fa-solid fa-print fa-lg text-warning"></i></a>
						<?php endif; ?>`
						return ret;
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