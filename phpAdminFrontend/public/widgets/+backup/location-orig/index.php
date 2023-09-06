<?php 
$title = "Location";
$module = "location";
$table = "locations";
$view = "vw_locations"; 
$filters = [ array('field'=>'location_use','label'=>'Use','filterval'=>array('Residential','Commercial')) ];
$fields = rawurlencode(json_encode([ "ID"=>"id","Location Name"=>"location_name","Location"=>"parent_location_name","Use"=>"location_use","Floor Area"=>"floor_area","Status"=>"location_status" ]));
?>
<div class="page-title"><?=$title?></div>
<div class="bg-white p-2 rounded">
	<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add">Add <?=$title?> <i class="bi bi-plus-circle"></i></button>
	<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-download">Download <i class="bi bi-download"></i></button>
	<div class="row">
		<div class="col-2">
			<label>Search</label>
			<input type="text" class="form-control" placeholder="Search" id="searchbox">
		</div>
		<div class="col-2">
			<label>Filter By</label>
			<select id="filterby" class="form-control form-select">
			<?php foreach ($filters as $val) { ?>
				<option value="<?=$val['field']?>"><?=$val['label']?></option>
			<?php } ?>
			</select>
		</div>
		<div class="col-2">
			<label>Filter Text</label>
			<select id="filtertxt" class="form-control form-select">
			<?php foreach ($filters[0]['filterval'] as $val) { ?>
				<option value="<?=$val?>"><?=$val?></option>
			<?php } ?>
			</select>
		</div>
		<div class="col-2">			
			<button class="btn btn-sm btn-warning mt-4 btn-filter">Filter</button>
			<button class="btn btn-sm btn-secondary mt-4 btn-reset">Reset</button>
		</div>
		<div class="col-3">
			<label>Status</label>
			<div>
				<button class="btn btn-primary btn-filter-status" data-location_status="Vacant" type="button">Vacant</button>
				<button class="btn btn-secondary btn-filter-status" data-location_status="Not For Rent" type="button">Not For Rent</button>
				<button class="btn btn-secondary btn-filter-status" data-location_status="Occupied" type="button">Occupied</button>
			</div>
		</div>
	</div>
</div>

<div id="jsdata"></div>

<script>
	<?php $unique_id = $module . time();?>
	var t<?=$unique_id;?>;

	$(document).ready(function(){
		$(".btn-add").off('click').on('click',function(){
			window.location.href = "<?=WEB_ROOT."/$module/form";?>";
		});

		$(".btn-download").on('click',function(){
			location = "<?=WEB_ROOT;?>/module/download/?display=csv&module=<?=$module?>&table=<?=$table?>&view=<?=$view?>&fields=<?=$fields?>";
		});

		$("#filterby").on('change',function(){
			getFilter();
		});

		$(".btn-filter").on('click',function(){
			filterby = $("#filterby option:selected").val();
			filtertxt = $("#filtertxt").val();
			t<?=$unique_id;?>.options.colFilter[filterby] = filtertxt;
			t<?=$unique_id;?>.ajax.reload();
		});
		
		$(".btn-reset").on('click',function(){
			filterby = $("#filterby option:selected").val();
			$("#filtertxt").val('');
			delete t<?=$unique_id;?>.options.colFilter[filterby];
			t<?=$unique_id;?>.ajax.reload();
		});

		t<?=$unique_id;?> = $("#jsdata").JSDataList({
			pageLength: 10,
			searchBoxID: 'searchbox',
			prefix: '<?=$table?>',
			ajax: {
				url: "<?=WEB_ROOT."/module/get-list/{$view}?display=plain"?>"
			},
			columns:[
				{
					data: "rec_id",
					label: "ID",
					class: 'col-1',
				},
				{
					data: "location_name",
					label: "Location Name",
					class: 'col-2',
				},
				{
					data: "parent_location_name",
					label: "Location",
					class: 'col-2'
				},
				{
					data: "location_type",
					label: "Type",
					class: 'col-2'
				},
				{
					data: "location_use",
					label: "Use",
					class: 'col-1'
				},
				{
					data: "floor_area",
					label: "Floor Area (sqm)",
					class: 'col-1'
				},
				{
					data: "location_status",
					label: "Status",
					class: 'col-1'
				},				
				{
					data: null,
					label: "Action",
					class: "text-left",
					class: 'col-2',
					render: function(data,row){
						return '<a class="btn btn-sm btn-success btn-view" title="View ID ' + row.rec_id + '" href="<?=WEB_ROOT?>/<?=$module?>/view/' + row.id + '"><i class="bi bi-eye"></i></a> '+'<a class="btn btn-sm btn-primary btn-edit" title="Edit ID ' + row.tenant_id + '" href="<?=WEB_ROOT?>/<?=$module?>/form/' + row.id + '"><i class="bi bi-pen"></i></a> '+'<a class="btn btn-sm btn-danger btn-delete" title="Delete ID ' + row.rec_id + '" href="<?=WEB_ROOT?>/module/delete/<?=$module?>/<?=$table?>/' + row.id + '"><i class="bi bi-trash"></i></a>';
					},
					orderable: false
				},
			],
			order:[[0,'desc']],
			colFilter: {'location_status':'Vacant'}
		});

		$(".btn-filter-status").on('click',function(){
			t<?=$unique_id;?>.options.colFilter = {'location_status':$(this).data('location_status')};
			t<?=$unique_id;?>.ajax.reload();

			$(".btn-filter-status").not($(this)).removeClass('btn-primary').addClass('btn-secondary');
			$(this).addClass('btn-primary').removeClass('btn-secondary');
		});
	});
</script>