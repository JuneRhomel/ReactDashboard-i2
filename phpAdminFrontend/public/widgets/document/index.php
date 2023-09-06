<?php 
$title = "Document";
$module = "document";  
$table = "documents";
$view = "view_documents"; 
$fields = rawurlencode(json_encode([ "ID"=>"id","Title"=>"title" ]));
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
					data: "title",
					label: "title",
					class: 'col-5'
				},
				{
					data: null,
					label: "Action",
					class: "text-left",
					render: function(data,row){
						return '<a class="btn btn-sm btn-primary btn-edit" title="Edit ID ' + row.rec_id + '" href="<?=WEB_ROOT?>/document/form/' + row.id + '"><i class="bi bi-pen"></i></a> '+'<a class="btn btn-sm btn-danger btn-delete" title="Delete ID ' + row.rec_id + '" href="<?=WEB_ROOT?>/module/delete/<?=$module?>/<?=$table?>/' + row.id + '"><i class="bi bi-trash"></i></a>';
					},
					orderable: false
				}
			]
		});
	});
</script>