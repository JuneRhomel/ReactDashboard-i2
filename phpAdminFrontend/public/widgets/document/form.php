<?php
$module = "document";  
$table = "documents";
$view = "view_documents"; 

$record = null;
if(count($args)) {
	$result = $ots->execute('module','get-record',['id'=>$args[0],'view'=>$view]);
	$record = json_decode($result,true);
}
?>
<div class="page-title"><?=count($args) ? 'Edit' : 'Add';?> Document</div>
<div class="col-12 col-sm-6 bg-white p-3">
	<form method="post" action="<?=WEB_ROOT;?>/module/save?display=plain" class="bg-white" id="frm" enctype="multipart/form-data">
		<div class="form-group mb-2">
			<label for="" class="text-required">Title</label>
			<input type="text" class="form-control" name="title" value="<?=$record ? $record['title'] : '';?>" required>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Content</label>
			<textarea class="form-control" name="content" required rows=10><?=$record ? $record['content'] : '';?></textarea>
		</div>
		<div class="form-group mb-2">
			<label for="" class="">File</label>
			<input type="file" class="form-control"  name="file">
			<?php if($record && $record['file_url']):?>
				<a href="<?=$record['file_url'];?>" target="_blank">Download</a>
			<?php endif;?>
		</div>
		<button type="button" class="btn btn-light btn-cancel">Cancel</button>
		<button class="btn btn-primary">Submit</button>
		<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
		<input name="module" type="hidden" value="<?=$module?>">
		<input name="table" type="hidden" value="<?=$table?>">
	</form>
</div>
<script>
	$(document).ready(function(){
		$("#frm").off('submit').on('submit',function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: new FormData($(this)[0]),
				dataType: 'JSON',
				contentType: false,
				processData: false,
				beforeSend: function(){},
				success: function(data){
					if(data.success == 1)
					{
						showSuccessMessage(data.description,function(){
							window.location.href = '<?=WEB_ROOT;?>/<?=$module?>';
						});
					}	
				},
				complete: function(){},
				error: function(jqXHR, textStatus, errorThrown){}
			});
		});

		$(".btn-cancel").off('click').on('click',function(){
			window.location.href = '<?=WEB_ROOT;?>/<?=$module?>';
		});
	});
</script>