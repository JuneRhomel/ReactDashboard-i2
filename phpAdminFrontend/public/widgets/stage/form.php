<?php
$module = "stage";  
$table = "stages";
$view = "view_stages"; 

$record = null;
if(count($args)) {
	$result = $ots->execute('module','get-record',['id'=>$args[0],'view'=>$view]);
	$record = json_decode($result,true);
}
?>
<div class="page-title"><?=count($args) ? 'Edit' : 'Add';?> Stage</div>
<div class="col-12 col-sm-6 bg-white p-3">
	<form method="post" action="<?=WEB_ROOT;?>/module/save?display=plain" class="bg-white" id="frm">
		<div class="form-group mb-2">
			<label for="" class="text-required">Stage Type</label>
			<select name="stage_type" class="form-control form-select" required>
				<option value="Turnover" <?=($record['stage_type']=="Turnover") ? "selected" : ""?>>Turnover</option>
				<option value="Punch List" <?=($record['stage_type']=="Punch List") ? "selected" : ""?>>Punch List</option>
				<option value="Movement" <?=($record['stage_type']=="Movement") ? "selected" : ""?>>Movement</option>
			</select>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Stage Name</label>
			<input name="stage_name" type="text" class="form-control" value="<?=($record) ? $record['stage_name'] : '';?>" required>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Rank</label>
			<input name="rank" type="text" class="form-control" value="<?=($record) ? $record['rank'] : '';?>" required>
		</div>
		<button type="button" class="btn btn-light btn-cancel">Cancel</button>
		<button class="btn btn-primary">Submit</button>
		<input name="id" type="hidden" value="<?=$args[0] ?? '';?>">
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
				beforeSend: function(){},
				success: function(data){
					if (data.success == 1) {
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
			window.location.href = '<?=WEB_ROOT;?>/stage';
		});

		$("input[id=parent_stage]").autocomplete({
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
					url: '<?=WEB_ROOT;?>/stage/search?display=plain',
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
				if (ui.item == null) {
					$(event.target).prev('input').val(0);
				}
			}
		});

		$("select[name=stage_type]").on('change',function(){
			if ($(this).val().toLowerCase() == 'property') {
				$(".stage-container").addClass('d-none');
				$("input[name=parent_stage]").val('');
				$("#parent_stage_id").val(0);
			} else {
				$(".stage-container").removeClass('d-none');
			}
		});
	});
</script>