<?php 
$title = "Move In / Out";
$module = "tenant";
$table = "moveinout";
$view = "view_tenant_movements"; 
$arrStages = array('New','Processing','Acknowledged','Pending','Closed');
$fields = rawurlencode(json_encode([ "ID"=>"id","Name of
Owner"=>"owner_name","Name of
Tenant"=>"tenant_name","Location"=>"location_name","Type"=>"move_type","date"=>"move_date","Stage"=>"status","Created"=>"from_unixtime(created_on)
created_date" ])); ?>
<div class="page-title"><?=$title?></div>
<div class="bg-white px-2 py-4 rounded mb-4">
	<!-- <button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add">Add <?=$title?> <i class="bi bi-plus-circle"></i></button> -->
	<button
		class="btn btn-md float-end mt-3 me-3 btn-download d-flex align-items-center"
		style="gap: 4px"
	>
		<div>Download</div>
		<i class="fi fi-rr-download d-flex align-items-center"></i>
	</button>
	<div class="row">
		<div class="col-2">
			<label class="mb-1">Search</label>
			<input
				type="text"
				class="form-control"
				placeholder="Search"
				id="searchbox"
			/>
		</div>
		<div class="col-2">
			<label class="mb-1">Filter by Stage</label>
			<select id="filter-stage" class="form-control form-select">
				<option value="" selected>All</option>
				<?php foreach ($arrStages as $val) { ?>
				<option value="<?=$val?>"><?=$val?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-2">
			<label class="mb-1">Filter by Status</label>
			<select id="filter-status" class="form-control form-select">
				<option value="" selected>All</option>
				<option value="1">Open</option>
				<option value="0">Closed</option>
			</select>
		</div>
		<div class="col-2">
			<button class="btn btn-sm btn-primary mt-4 btn-filter">Filter</button>
			<button class="btn btn-sm mt-4 btn-reset">Reset</button>
		</div>
		<!-- <div class="col-2">
			<label>Status</label>
			<div>
				<button
					class="btn btn-primary btn-filter-status"
					data-closed="0"
					type="button"
				>
					Open
				</button>
				<button
					class="btn btn-secondary btn-filter-status"
					data-closed="1"
					type="button"
				>
					Closed
				</button>
			</div>
		</div> -->
	</div>
</div>

<div id="jsdata"></div>

<script>
	<?php $unique_id = 'movement' . time();?>
	var t<?php echo $unique_id;?>;
	$(document).ready(function(){
		$(".btn-add").off('click').on('click',function(){
			window.location.href = '<?=WEB_ROOT;?>/tenant/form';
		});

		$(".btn-download").on('click',function(){
			location = "<?=WEB_ROOT;?>/module/download/?display=csv&module=<?=$module?>&table=<?=$table?>&view=<?=$view?>&fields=<?=$fields?>";
		});

		$("#filterby").on('change',function(){
			getFilter();
		});

		$(".btn-filter").on('click',function(){
			valStage = $("#filter-stage").val();
			valStatus = $("#filter-status").val();
			if (valStage!="")
				t<?=$unique_id;?>.options.colFilter['status'] = valStage;
			else
				delete t<?=$unique_id;?>.options.colFilter['status'];
			if (valStatus!="")
				t<?=$unique_id;?>.options.colFilter['closed'] = valStatus;
			else
				delete t<?=$unique_id;?>.options.colFilter['closed'];
			t<?=$unique_id;?>.ajax.reload();
		});

		$(".btn-reset").on('click',function(){
			$("#filter-stage").val('');
			$("#filter-status").val('');
			delete t<?=$unique_id;?>.options.colFilter['status'];
			delete t<?=$unique_id;?>.options.colFilter['closed'];
			t<?=$unique_id;?>.ajax.reload();
		});

		t<?php echo $unique_id;?> = $("#jsdata").JSDataList({
			pageLength: 25,
			searchBoxID: 'searchbox',
			prefix: 'movement',
			ajax: {
				url: '<?php echo WEB_ROOT;?>/tenant/get-moveinout-list?display=plain'
			},
			columns:[
				{
					data: "movement_id",
					label: "ID",
					class: 'col-1'
				},
				{
					data: "owner_name",
					label: "Name of Owner",
					class: 'col-2',
					render: function(data,row){
						return '<a href="<?=WEB_ROOT;?>/tenant/form-resident/' + row.enc_owner_id + '/View" target="_blank">' + data +'</a>';
					}
				},
				{
					data: "tenant_name",
					label: "Name of tenant",
					class: 'col-2',
					render: function(data,row){
						return '<a href="<?=WEB_ROOT;?>/tenant/form-resident/' + row.enc_tenant_id + '/View" target="_blank">' + data +'</a>';
					}
				},
				{
					data: "location_name",
					label: "Location",
					class: 'col-1',
					render: function(data,row){
						return '<a href="<?=WEB_ROOT;?>/location/view/' + row.enc_loc_id + '?menuid=propman" target="_blank">' + data +'</a>';
					}
				},
				{
					data: "move_type",
					label: "Type",
					class: 'col-1'
				},
				{
					data: "move_date",
					label: "Date",
					class: 'col-1'
				},
				{
					data: "status",
					label: "Stage",
					class: 'col-1'
				},
				{
					data: "closed",
					label: "Status",
					class: 'col-1',
					render: function(data,row){
						return (data==1) ? "Open" : "Closed";
					}
				},
				{
					data: "created_on",
					label: "Created",
					class: 'col-1',
					render: function(data,row){
						return time2date(data);
					}
				},
				{
					data: null,
					label: "Action",
					class: "col-1",
					render: function(data,row){
						return '<a class="btn btn-sm btn-primary btn-edit" title="Edit ID ' + row.movement_id + '" href="<?=WEB_ROOT?>/tenant/view-movement/' + row.id + '"><i class="bi bi-pen"></i></a> '+'<a class="btn btn-sm btn-danger btn-delete" title="Delete ID ' + row.movement_id + '" href="<?=WEB_ROOT?>/tenant/delete-movement/' + row.id + '"><i class="bi bi-trash"></i></a>';
					},
					orderable: false
				}
			],
			order: [[0,'desc']],
			// colFilter: {'closed':0}
		});

		$(".btn-filter-status").on('click',function(){
			t<?php echo $unique_id;?>.options.colFilter = {'closed':$(this).data('closed')};
			t<?php echo $unique_id;?>.ajax.reload();

			$(".btn-filter-status").not($(this)).removeClass('btn-primary').addClass('btn-secondary');
			$(this).addClass('btn-primary').removeClass('btn-secondary');
		});
	});
</script>
