<?php
$module = "amenity";  
$table = "amenities";
$view = "view_amenities"; 

$record = null;
if(count($args)) {
	$result = $ots->execute('module','get-record',['id'=>$args[0],'view'=>$view]);
	$record = json_decode($result,true);
}
?>
<div class="page-title"><?=count($args) ? 'Edit' : 'Add';?> Amenity</div>
<div class="col-12 col-sm-6 bg-white p-3">
	<form method="post" action="<?=WEB_ROOT;?>/module/save?display=plain" class="bg-white" id="frm" enctype="multipart/form-data">
		<div class="form-group mb-2">
			<label for="" class="text-required">Name</label>
			<input type="text" class="form-control" name="amenity_name" value="<?=$record ? $record['amenity_name'] : '';?>" required>
		</div>

		<div class="form-group mb-2">
			<label for="" class="text-required">Location</label>
			<input value="<?=$record ? $record['location_id'] : '0';?>" type="text" style="width:0px;opacity:0;float:right" class="form-control" name="location_id">
			<input type="text" class="form-control" id="location_id" value="<?=$record ? $record['location_name'] : '';?>">
		</div>

		<div class="form-group mb-2">
			<label for="" class="text-required">Capacity</label>
			<input type="text" class="form-control" name="capacity" value="<?=$record ? $record['capacity'] : '';?>" required>
		</div>

		<div class="form-group mb-2">
			<label for="" class="text-required">Operating Hours</label>
			<input type="text" class="form-control" name="operating_hours" value="<?=$record ? $record['operating_hours'] : '';?>" required>
		</div>

		<div class="form-group mb-2">
			<label for="" class="">Info</label>
			<textarea class="form-control" name="amenity_info" required rows=10><?=$record ? $record['amenity_info'] : '';?></textarea>
		</div>

		<div class="form-group mb-2">
			<label for="" class="">Main Image</label>
			<input type="file" class="form-control"  name="main_image">
			<?php if($record && $record['picture_url']):?>
				<img src="<?=$record['picture_url'];?>" style="max-width:100%">
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
				beforeSend: function(){
				},
				success: function(data){
					if(data.success == 1)
					{
						showSuccessMessage(data.description,function(){
							window.location.href = '<?=WEB_ROOT;?>/<?=$module?>';
						});
					}
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});

		$(".btn-cancel").off('click').on('click',function(){
			window.location.href = '<?=WEB_ROOT;?>/<?=$module?>';
		});	

		$("input[id=location_id]").autocomplete({
			autoSelect : true,
			autoFocus: true,
			search: function(event, ui) { 
				$('.spinner').show();
			},
			response: function(event, ui) {
				$('.spinner').hide();
			},
			source: function( request, response ) {
				$.ajax({
					url: '<?=WEB_ROOT;?>/location/search?display=plain',
					dataType: "json",
					type: 'post',
					data: {
						term: request.term,
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {

				$(event.target).prev().val(ui.item.value);
				$(event.target).val(ui.item.label);

				return false;
			},
			change: function(event, ui){
				if(ui.item == null)
				{
					$(event.target).prev('input').val(0);
				}
			}
		});
	});
</script>