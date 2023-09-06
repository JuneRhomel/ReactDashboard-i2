<?php
$module = "contract";
$table = "contract";
$view = "vw_contract";
$fields = rawurlencode(json_encode([
	"Contract Number" => "contract_number",
	"Contract Name" => "contract_name",
	"Resident" => "resident_name",
	"Unit" => "unit_name",
	"Start Date" => "start_date",
	"End Date" => "end_date",
	"Duration" => "duration",
	"Monthly Rate" => "monthly_rate",
	"CUSA" => "cusa",
	"Months Advance" => "months_advance",
	"Months Deposit" => "months_deposit",
	"Payment Schedule" => "payment_schedule",
	"Day Due" => "day_due",
	"Notify Days" => "notify_days",
	"Template" => "template_name",
	"Status" => "status",
]));

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($result);

$result = $ots->execute('module','get-listnew',[ 'table'=>'list_contractduration','field'=>'contractduration' ]);
$list_contractduration = json_decode($result);
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
	<?php $unique_id = $module.time()?>
	var t<?=$unique_id?>;
	$(document).ready(function() {
		// INIT FOR FILTER
		var list_contractduration = [];
		<?php foreach($list_contractduration as $val) { ?>
			list_contractduration.push('<?=$val?>');
		<?php } ?>
		t<?=$unique_id?> = $("#jsdata").JSDataList({
			ajax: {
				url: '<?=WEB_ROOT?>/module/get-records/<?=$view?>?display=plain'
			},
			rowLink: {
				url: '<?=WEB_ROOT?>/<?=$module?>/view/',
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
					href: '<?=WEB_ROOT?>/<?=$module?>/form/',
				},
				<?php } ?>
				<?php if ($role_access->download) { ?> {
					icon: `<span class="material-symbols-outlined">arrow_downward</span>`,
					title: "Download",
					class: "btn-download",
					href: '<?=WEB_ROOT?>/module/download/?display=csv&module=<?=$module?>&table=<?=$table?>&view=<?=$view?>&fields=<?=$fields?>',
					id: "download",
				},
				<?php } ?>{
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
					data: "contract_number",
					label: "Contract No.",
					datatype: "none",
				},
				{
					data: "contract_name",
					label: "Contract Name",
					datatype: "none",
				},
				{
					data: "resident_name",
					label: "Occupant",
					datatype: "none",
				},
				{
					data: "company_name",
					label: "Company Name",
					datatype: "none",
				},
				{
					data: "unit_name",
					label: "Unit ",
					datatype: "none",
				},
				{
					data: "start_date",
					label: "Start Date",
					datatype: "none",
				},
				{
					data: "end_date",
					label: "End Date",
					datatype: "none",
				},
				{
					data: "duration",
					label: "Duration",
					datatype: "select",
					list: list_contractduration,
				},
				{
					data: "monthly_rate",
					label: "Monthly Rate",
					datatype: "none",
				},
				/*{
					data: "template_name",
					label: "Template",
					datatype: "none",
				},*/
				{
					data: "status",
					label: "Status",
					datatype: "none",
				},
				{
					label: "Actions",
					class: 'text-center',
					datatype: 'none',
					searchable: false,
					orderable: false,
					render: function(data, row) {
						lnkUpdate = lnkView = lnkDelete = lnkVoid = lnkPrint = "";
						lnkView = '<a class="me-2" href="<?=WEB_ROOT?>/$module/view/'+row.enc_id+'"><i class="fa-solid fa-eye fa-lg text-info"></i></a>';
						lnkPrint = '<a href="<?=WEB_ROOT."/$module/genpdf?display=plain&id="?>'+row.enc_id+'" target="_blank" title="Print ['+row.contract_name+']"><i class="fa-solid fa-print fa-lg text-success"></i></a>';
						if (row.status=='Active') {							
							<?php if ($role_access->update) { ?> 
							lnkUpdate = '<a href="<?=WEB_ROOT."/$module" ?>/form/'+row.enc_id+'" title="Edit ['+row.contract_name+']" class="me-2"><i class="fa-solid fa-pen fa-lg text-primary"></i></a>';							
							<?php } ?>
							<?php if ($role_access->delete) { ?> 
							lnkDelete = '<a del_url="<?=WEB_ROOT."/module/delete/$module/$table"?>/'+row.enc_id+'" class="me-2" onclick="show_delete_modal(this)" role_access="<?=$role_access->delete ?>" title="Delete ['+row.contract_name+']" rec_id="'+row.id+'"><i class="fa-solid fa-trash fa-lg text-danger"></i></a>';
							<?php } ?>
							<?php if ($role_access->void) { ?> 
							lnkVoid = '<a title="Void ['+row.contract_name+'"><button type="button" class="btn btn-link p-0 me-2" onclick="update_status(\'contract\',\''+row.enc_id+'\',\'status\',\'Voided\',\'<?=WEB_ROOT?>\')"><i class="fa-solid fa-ban fa-lg text-warning"></i></button></a>&nbsp;';
							<?php } ?>
						}
						return lnkView + lnkUpdate + lnkDelete + lnkVoid + lnkPrint;						
					}					
				},
			],
			order: [ [0, 'desc'] ],
		});

		$('.filter').on('click', function() {
			$(".dropdown-menu").toggle();
		});

		
	});
</script>