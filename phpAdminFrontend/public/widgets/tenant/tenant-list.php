<?php
$title = "Tenant List";
$module = "tenant_list";
$table = "tenant";
$view = "view_tenant_list";

$filters = [
	array(
		'field' => 'renewable',
		'label' => 'Renewable',
		'filterval' => array(
			'yes',
			'no'
		)
	)
];
$fields = rawurlencode(json_encode(["ID" => "id", "Owner Name" => "owner_name", "Unit" => "unit_id", "Unit Area" => "unit_area", "Owner Number" => "owner_contact", "Owner Email" => "owner_email"]));

//PERMISSIONS
//get user role
$data = [
	'view' => 'users'
];
$user = $ots->execute('property-management', 'get-record', $data);
$user = json_decode($user);

//check if has access
$data = [
	'role_id' => $user->role_type,
	'table' => 'tenant',
	'view' => 'role_rights'
];
$role_access = $ots->execute('form', 'get-role-access', $data);
$role_access = json_decode($role_access);
// var_dump($role_access);
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
			
			<div class="page-title"><?= $title ?></div>
			<div class="d-flex justify-content-between mb-2">
				<div class="d-flex align-items-end">
					<label class="text-label-result px-3 mb-0" id="search-result">
						</label>
					</div>
				</div>
				<div class="container-table">
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
	<?php endif; ?>
	<script>
		<?php $unique_id = $module . time(); ?>
		var t<?= $unique_id; ?>;
		$(document).ready(function() {
			$('#form-renew').submit(function(e) {
				data = $(this).serialize();
				e.preventDefault();
				$.post({
					// url:'<?= WEB_ROOT ?>/tenant/renew-permits?display=plain',
					data: data,
					success: function(result) {
						result = JSON.parse(result);
						if (result.success == 1) {
							location.reload();
						}
					}
				});

		});
		

		$(".btn-import").on('click', function() {
			window.location.href = '<?= WEB_ROOT; ?>/admin/import-tenants?submenuid=import_tenants';
		});

		$(".btn-download").on('click', function() {
			location = "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $table ?>&fields=<?= $fields ?>";
		});

		$("#filterby").on('change', function() {
			getFilter();
		});

		$(".btn-filter").on('click', function() {
			filterby = $("#filterby option:selected").val();
			filtertxt = $("#filtertxt").val();
			t<?= $unique_id; ?>.options.colFilter[filterby] = filtertxt;
			t<?= $unique_id; ?>.ajax.reload();
		});

		$(".btn-reset").on('click', function() {
			filterby = $("#filterby option:selected").val();
			$("#filtertxt").val('');
			delete t<?= $unique_id; ?>.options.colFilter[filterby];
			t<?= $unique_id; ?>.ajax.reload();
		});

		t<?= $unique_id; ?> = $("#jsdata").JSDataList({
			ajax: {
				url: "<?= WEB_ROOT . "/module/get-list/{$view}?display=plain" ?>",
			},
			rowLink: {
				url: '<?= WEB_ROOT; ?>/tenant/view-tenant/',
				params: [{
					"key": "id",
					"value": "encryptedid"
				}],
			},
			rowClass: 'hover:bg-gray-100',
			titleClass: 'text-rentaPageTitle',
			filterBoxID: 'dropdownmenufilter',
			buttons: [{
					icon: `<span class="material-symbols-outlined">add</span>`,
					title: "Create New",
					class: "btn-add btn-blue",
				},
				//
				// <?php if ($role_access->delete == true) : ?> {
				// 		icon: `<span class="material-symbols-outlined">delete</span>`,
				// 		title: "Delete",
				// 		class: "btn-delete-filter",
				// 		id: "delete",
				// 	},
				// <?php endif; ?>
				//
				<?php if ($role_access->download == true) : ?> {
						icon: `<span class="material-symbols-outlined">arrow_downward</span>`,
						title: "Download",
						class: "btn-download",
						href: "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $table ?>&fields=<?= $fields ?>",
						id: "download",
					},
				<?php endif; ?> {
					icon: `<span class="material-symbols-outlined">filter_list</span>`,
					title: "Filter",
					class: "filter",
				}

			],
			columns: [
				{
					data: "first_name",
					label: "First Name",
					class: '',
					render: function(data, row) {
						return data

					}
				},
				{
					data: "last_name",
					label: "Last Name",
					class: '',
					render: function(data, row) {
						return data

					}
				},
				{
					data: "unit_id",
					label: "Unit #",
					class: ''
				},
				{
					data: "owner_contact",
					label: "Contact Number",
					class: ''
				},
				{
					data: "owner_email",
					label: "Owner Email",
					class: 'w-20',
				},
				{
					data: "owner_username",
					label: "Username",
					class: '',
				},
				{
					data: "type",
					label: "Type",
					class: '',
				},
				{
					data: "unit_area",
					label: "Unit Area",
					class: '',
				},
				// {
				// 	data: "owner_username",
				// 	label: "Owner Username",
				// 	class: ''
				// },
				// {
				// 	label: "Type",
				// 	class: ''
				// },
				{
					label: "Billing",
					class: '',
					render: function(data, row) {
						return '<a href="<?= WEB_ROOT; ?>/tenant/view-tenant/' + row.id + '/View" target="_self" class="view-text">View</a>';
					}
				},
				{
					data: null,
					label: "Action",
					class: '',
					render: function(data, row) {
						return '<a class="btn btn-sm text-primary btn-delete" onclick="show_delete_modal(this)" role_access="<?= $role_access->delete ?>" rec_id="' + row.data_id + '" title="Are you sure to delete this record?" del_url="<?= WEB_ROOT ?>/tenant/delete-record/' + row.id + '?display=plain&table=tenant&view_table=view_tenant&redirect=/tenant/tenant-list?submenuid=tenant_list"><i class="bi bi-trash-fill"></i></a>';
					},
					orderable: false
				}
			],
			order: [
				[4, 'asc']
			],
			// colFilter: {'status':'Active'}
		});
		$(".btn-add").off('click').on('click', function() {
			window.location.href = "<?= WEB_ROOT . "/tenant/"; ?>form-add-tenant-list";
		});

		$(document).on("click", ".row-id", function() {
			// var data = table.row(this).data();
			var id = $(this).data("id");
			window.location.href = "<?= WEB_ROOT ?>/tenant/view-tenant/" + id + "/View";
			// console.log(data);
			// alert('div clicked')
		});

		$(document).on("click", '.btn-delete', function(evt) {
			evt.stopPropagation();
		})

		$(document).on('click', '.btn-approve-gatepass,.btn-disapprove-gatepass', function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).prop('href') + '?display=plain',
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function() {},
				success: function(data) {
					if (data.success == 1) {
						showSuccessMessage(data.description, function() {
							window.location.reload();
						});
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});
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

		$('.bi-caret-up-fill').hide();
	});
</script>