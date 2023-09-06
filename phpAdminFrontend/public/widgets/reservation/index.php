<?php 
$title = "Reservation";
$module = "reservation";
$table = "amenity_reservations";
$view = "view_reservations";
$filters = [ array('field'=>'status','label'=>'Stage','filterval'=>array('Pending','Approved','Disapproved')) ];
$fields = rawurlencode(json_encode([ "ID"=>"id","Resident Name"=>"tenant_name","Schedule"=>"schedule","Amenity"=>"amenity_name","Remarks"=>"description","Stage"=>"status" ]));
?>
<div class="page-title"><?=$title?></div>
<div class="bg-white p-2 rounded">
	<!-- <button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add">Add <?=$title?> <i class="bi bi-plus-circle"></i></button> -->
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
				<button class="btn btn-primary btn-filter-status" type="button">Pending</button>
				<button class="btn btn-secondary btn-filter-status" type="button">Approved</button>
				<button class="btn btn-secondary btn-filter-status" type="button">Disapproved</button>
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

		$("#jsdata").JSDataList({
			pageLength: 10,
			searchBoxID: 'searchbox',
			prefix: 'reservation',
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
					data: "tenant_name",
					label: "Resident Name",
					class: 'col-1',
					render: function(data,row){
						return '<a href="<?=WEB_ROOT;?>/tenant/form-resident/' + row.enc_tenant_id + '/View" target="_blank">' + data +'</a>';
					}
				},
				{
					data: "schedule",
					label: "Schedule",
					class: 'col-3'
				},
				{
					data: "amenity_name",
					label: "Amenity",
					class: 'col-2'
				},
				{
					data: "description",
					label: "Remarks",
					class: 'col-3'
				},

				{
					data: "status",
					label: "Stage",
					class: 'col-1',
					orderable: false
				},
				{
					data: null,
					label: "Action",
					class: "text-left",
					class: 'col-1',
					render: function(data,row){
						return '<a class="btn btn-sm btn-success btn-view" title="View ID ' + row.rec_id + '" href="<?=WEB_ROOT?>/<?=$module?>/view/' + row.id + '"><i class="bi bi-eye"></i></a> '+'<a class="btn btn-sm btn-danger btn-delete" title="Delete ID ' + row.rec_id + '" href="<?=WEB_ROOT?>/module/delete/<?=$module?>/<?=$table?>/' + row.id + '"><i class="bi bi-trash"></i></a>';
					},
					orderable: false
				}
			],
			order: [[0,'desc']],
			colFilter:{'status':'Pending'}
		});
	});
</script>