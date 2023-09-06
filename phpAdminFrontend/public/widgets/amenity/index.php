<?php 
$title = "Amenities";
$module = "amenity";  
$table = "amenities";
$view = "view_amenities"; 
$fields = rawurlencode(json_encode([ "ID"=>"id","Name"=>"amenity_name","Capacity"=>"capacity","Info"=>"amenity_info","Location"=>"location_name","Operating Hours"=>"operating_hours" ]));
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
					data: "amenity_name",
					label: "Name",
					class: 'col-2'
				},
				{
					data: "capacity",
					label: "Capacity",
					class: 'col-1'
				},
				{
					data: "amenity_info",
					label: "Info",
					class: 'col-2'
				},
				{
					data: "location_name",
					label: "Location",
					class: 'col-2'
				},
				{
					data: "operating_hours",
					label: "Operating Hours",
					class: 'col-2'
				},
				{
					data: null,
					label: "Action",
					class: "text-center",
					class: 'col-2',
					render: function(data,row){
						return '<a class="btn btn-sm btn-primary btn-edit" title="Edit ID ' + row.rec_id + '" href="<?=WEB_ROOT?>/amenity/form/' + row.id + '"><i class="bi bi-pen"></i></a> '+'<a class="btn btn-sm btn-danger btn-delete" title="Delete ID ' + row.rec_id + '" href="<?=WEB_ROOT?>/module/delete/<?=$module?>/<?=$table?>/' + row.id + '"><i class="bi bi-trash"></i></a>';
					},
					orderable: false
				}
			]
		});
	});
</script>