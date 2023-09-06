<?php 
$title = "Stages";
$module = "stage";  
$table = "stages";
$view = "view_stages"; 
$filters = [ array('field'=>'stage_type','label'=>'Stage Type','filterval'=>array('Movement','Turnover','Punch List')) ];
$fields = rawurlencode(json_encode([ "ID"=>"id","Stage Type"=>"stage_type","Stage Name"=>"stage_name","Rank"=>"rank","Created"=>"from_unixtime(created_on) created_date" ]));
?>
<div class="page-title"><?=$title?></div>
<div class="bg-white p-2 rounded">
	<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add">Add Record <i class="bi bi-plus-circle"></i></button>
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
			pageLength: 25,
			searchBoxID: 'searchbox',
			ajax: {
				url: "<?=WEB_ROOT."/module/get-list/{$view}?display=plain"?>"
			},
			columns:[
				{
					data: "rec_id",
					label: "ID",
					class: 'col-1'
				},
				{
					data: "stage_type",
					label: "Stage Type",
					class: 'col-2'
				},
				{
					data: "stage_name",
					label: "Stage Name",
					class: 'col-2'
				},
				{
					data: "rank",
					label: "Rank",
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
					data: null,
					label: "Action",
					class: "text-left",
					class: 'col-2',
					render: function(data,row){
						return '<a class="btn btn-sm btn-primary btn-edit" title="Edit ID ' + row.stage_id + '" href="<?=WEB_ROOT?>/<?=$module?>/form/' + row.id + '"><i class="bi bi-pen"></i></a> '+'<a class="btn btn-sm btn-danger btn-delete" title="Delete ID ' + row.stage_id + '" href="<?=WEB_ROOT?>/module/delete/<?=$module?>/<?=$table?>/' + row.id + '"><i class="bi bi-trash"></i></a>';
					},
					orderable: false
				}
			],
			order: [[0,'desc']]
		});
	});
</script>
