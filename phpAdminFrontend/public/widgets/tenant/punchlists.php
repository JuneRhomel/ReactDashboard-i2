<?php 
$title = "Punch List";
$module = "tenant";
$table = "punchlists";
$view = "view_tenant_punchlists"; 
$arrStages = array('New','Processing','Closed');
$fields = rawurlencode(json_encode([ "ID"=>"id","Name of
Owner"=>"tenant_name","Location"=>"location_name","Remarks"=>"details","Stage"=>"status","Created"=>"from_unixtime(created_on)
created_date" ])); ?>
<div class="page-title"><?=$title?></div>
<div class="bg-white px-2 py-4 rounded mb-4">
	<button
		class="btn btn-md btn-primary float-end mt-3 me-3 btn-add d-flex align-items-center"
		style="gap: 4px"
	>
		Add
		<?=$title?>
		<i class="fi fi-ss-add d-flex align-items-center"></i>
	</button>
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
		<!-- <div class="col-2">
			<label class="mb-1">Filter By</label>
			<select id="filterby" class="form-control form-select">
				<?php foreach ($filters as $val) { ?>
				<option value="<?=$val['field']?>"><?=$val['label']?></option>
				<?php } ?>
			</select>
		</div> -->
		<div class="col-2">
			<label class="mb-1">Filter by Stage</label>
			<select id="filter-type" class="form-control form-select">
				<option value="" selected>All</option>
				<?php foreach ($arrStages as $val) { ?>
				<option value="<?=$val?>"><?=$val?></option>
				<?php } ?>
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
	<?php $unique_id = 'punchlist' . time();?>
	var t<?=$unique_id;?>;

	$(document).ready(function(){
		$(".btn-add-punchlist").off('click').on('click',function(){
			window.location.href = '<?=WEB_ROOT;?>/tenant/form-punchlist';
		});

		$(".btn-download").on('click',function(){
			location = "<?=WEB_ROOT;?>/module/download/?display=csv&module=<?=$module?>&table=<?=$table?>&view=<?=$view?>&fields=<?=$fields?>";
		});

		$("#filterby").on('change',function(){
			getFilter();
		});

		$(".btn-filter").on('click',function(){
			t<?=$unique_id;?>.options.colFilter['status'] = $("#filter-type").val();
			t<?=$unique_id;?>.ajax.reload();
		});

		$(".btn-reset").on('click',function(){
			$("#filter-type").val('');
			delete t<?=$unique_id;?>.options.colFilter['status'];
			t<?=$unique_id;?>.ajax.reload();
		});

		t<?=$unique_id;?> = $("#jsdata").JSDataList({
			pageLength: 25,
			searchBoxID: 'searchbox',
			prefix: 'punchlist',
			ajax: {
				url: '<?=WEB_ROOT;?>/tenant/get-punchlist-list?display=plain'
			},
			columns:[
				{
					data: "punchlist_id",
					label: "ID",
					class: 'col-1'
				},
				{
					data: "tenant_name",
					label: "Name of Owner",
					class: 'col-2',
					render: function(data,row){
						return '<a href="<?=WEB_ROOT;?>/tenant/form-resident/' + row.enc_tenant_id + '/View" target="_blank">' + data +'</a>';
					}
				},
				{
					data: "location_name",
					label: "Location",
					class: 'col-2',
					render: function(data,row){
						return '<a href="<?=WEB_ROOT;?>/location/view/' + row.enc_loc_id + '?menuid=propman" target="_blank">' + data +'</a>';
					}
				},
				{
					data: "details",
					label: "Remarks",
					class: 'col-3'
				},
				{
					data: "status",
					label: "Stage",
					class: 'col-1'
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
					data: "closed",
					label: "Closed",
					class: 'col-1',
					visible: false,
					searchable: false
				},

				{
					data: null,
					label: "Action",
					class: "text-center",
					render: function(data,row){
						return '<a class="btn btn-sm btn-primary btn-edit" title="Edit ID ' + row.punchlist_id + '" href="<?=WEB_ROOT?>/tenant/view-punchlist/' + row.id + '"><i class="bi bi-pen"></i></a> '+'<a class="btn btn-sm btn-danger btn-delete" title="Delete ID ' + row.punchlist_id + '" href="<?=WEB_ROOT?>/tenant/delete-punchlist/' + row.id + '"><i class="bi bi-trash"></i></a>';
					},
					orderable: false
				}
			],
			order:[[0,'desc']],
			// colFilter:{'closed':0}
		});

		$(".btn-filter-status").on('click',function(){
			t<?=$unique_id;?>.options.colFilter = {'closed':$(this).data('closed')};
			t<?=$unique_id;?>.ajax.reload();

			$(".btn-filter-status").not($(this)).removeClass('btn-primary').addClass('btn-secondary');
			$(this).addClass('btn-primary').removeClass('btn-secondary');
		});
	});
</script>
