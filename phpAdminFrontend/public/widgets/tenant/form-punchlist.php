<?php
	$location_id = (isset($_REQUEST['location_id'])) ? $_REQUEST['location_id'] : 0;
	$punchlist = null;
	if(count($args))
	{
		$punchlist_result = $ots->execute('punchlist','get-punchlist',['punchlistid'=>$args[0]]);
		$punchlist = json_decode($punchlist_result,true);
	}
	$units =  json_decode($ots->execute('location','get-unit-list-restricted',[]),true);
?>

<div class="page-title"><?=count($args) ? 'Edit' : 'Add';?> Punch List</div>
<div class="col-12 col-sm-6 bg-white p-3">
	<form method="post" action="<?=WEB_ROOT;?>/tenant/save-punchlist?display=plain" class="bg-white" id="punchlist-form" enctype="multipart/form-data">
		<div class="form-group mb-2">
			<label for="" class="text-required">Name of Owner</label>
			<input type="text" style="opacity:0;width:0px;height:0px" name="tenant_id" value="<?=$punchlist ? $punchlist['tenant_id'] : '0';?>" required>
			<input type="text" class="form-control" id="tenant_id" value="<?=$punchlist ? $punchlist['tenant_name'] : '';?>" required>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Unit</label>
			<select name="location_id" id="location_id" class="form-control">
				<?php foreach($units as $unit):?>
					<option value="<?=$unit['id'];?>" <?=(($punchlist && $punchlist['location_id']==$unit['id']) || $unit['id']==$location_id) ? 'selected' : '';?>><?=$unit['location_name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Remarks</label>
			<textarea class="form-control" name="details" rows="5"></textarea>
		</div>

		<div class="form-group mb-2">
			<label for="" class="text-required">Attachments</label>
			<input type="file" class="form-control" name="file[]" value="" multiple>
		</div>
		<button type="button" class="btn btn-light btn-cancel" <?=($location_id!=0) ? "onclick='window.close();'" : ""?>>Cancel</button>
		<button class="btn btn-primary">Submit</button>
		<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
	</form>
</div>

<script>
	$(document).ready(function(){
		$(".date").datetimepicker({'format':'Y-m-d','timepicker':false});

		$("#punchlist-form").off('submit').on('submit',function(e){
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
						$(".notification-success-message").html(data.description);
						$(".notification-success").fadeIn('slow');	
						//$("#punchlist-form")[0].reset();
						window.location.href = '<?=WEB_ROOT;?>/tenant/punchlists';
					}	
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});

		$(".btn-cancel").off('click').on('click',function(){
			//loadPage('<?=WEB_ROOT;?>/form');
			window.location.href = '<?=WEB_ROOT;?>/tenant/punchlists';
		});

		$("input[id=tenant_id]").autocomplete({
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
					url: '<?=WEB_ROOT;?>/tenant/searchowners?display=plain',
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
				$("#location_id").val(ui.item.location_id).change();

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
