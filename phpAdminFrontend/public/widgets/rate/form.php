<?php
$module = "rate";  
$table = "rates";
$view = "view_rates"; 

$record = null;
if(count($args)) {
	$result = $ots->execute('module','get-record',['id'=>$args[0],'view'=>$view]);
	$record = json_decode($result,true);
}
?>
<div class="page-title"><?=count($args) ? 'Edit' : 'Add';?> Rate</div>
<div class="col-12 col-sm-6 bg-white p-3">
	<form method="post" action="<?=WEB_ROOT;?>/module/save?display=plain" class="bg-white" id="frm">
		<div class="form-group mb-2">
			<label for="" class="text-required">Name</label>
			<input type="text" class="form-control" name="rate_name" value="<?=$record ? $record['rate_name'] : '';?>" required>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Code</label>
			<input type="text" class="form-control" name="rate_code" value="<?=$record ? $record['rate_code'] : '';?>" required>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Value</label>
			<input type="text" class="form-control" name="rate_value" value="<?=$record ? $record['rate_value'] : '';?>" required>
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
				data: $(this).serialize(),
				dataType: 'JSON',
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

		$("input[id=parent_rate]").autocomplete({
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
					url: '<?=WEB_ROOT;?>/rate/search?display=plain',
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

		$("select[name=rate_type]").on('change',function(){
			if($(this).val().toLowerCase() == 'property')
			{
				$(".rate-container").addClass('d-none');
				$("input[name=parent_rate]").val('');
				$("#parent_rate_id").val(0);
			}else{
				$(".rate-container").removeClass('d-none');
			}
		});
	});
</script>