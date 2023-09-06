<?php
	 $data = [
		'id'=>$args[0],
        'view'=>'news'
	];
	$tenant = $ots->execute('tenant','get-record',$data);
	$news = json_decode($tenant);
	
?>
<div class="page-title float-right"><?= $args[1] ;?> News and Announcement</div>

<div class="bg-white rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="tl-edit" class="bg-white" enctype="multipart/form-data">
		<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/news-announcements?submenuid=news-announcements'>
			<input type="hidden" name='table'  id='id' value= 'news'>
			<!-- <input type="hidden" name='view_table'  id='id' value= 'view_tenant'> -->
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            <label for="" class="text-required">Title <span class="text-danger">*</span></label>
							<input type="text" class='form-control' name='title' value='<?= $news->title ?>' required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 col-sm-6 my-6">
                        <div class="form-group">
                            <label for="" class="text-required">Content<span class="text-danger">*</span></label>
							<textarea class="form-control" name="content" required rows=10><?= $news->content ?></textarea>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 my-6">
                        <div class="form-group">
                            <label class="text-required">Thumbnail  <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="file[]" id="thumbnail" accept="image/*" multiple>
                        </div>
                    </div>
            </div>
			<div class="btn-group-form pull-right mt-4">
               
				<div class="mb-3 float-end">
				<button type="submit" class="btn btn-dark btn-primary px-5">Save</button>
				<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
			</div>
			</div>
				<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
		</form>
	</div>
<script>
	$(document).ready(function(){
		$("#tl-edit").off('submit').on('submit',function(e){
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
						show_success_modal($('input[name=redirect]').val());
					}	
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});


		$('#datepicker').datepicker({
			format: 'yy-mm-d',
			timepicker: false,
			minDate: '+1D',
		});

		$('#datepicker1').datepicker({
			format: 'yy-mm-d',
			timepicker: false,
			minDate: '+1D',
		});


		$(".btn-cancel").off('click').on('click',function(){
			//loadPage('<?=WEB_ROOT;?>/location');
			history.back();
		});

		$("input[id=parent_location]").autocomplete({
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

		$("select[name=location_type]").on('change',function(){
			if($(this).val().toLowerCase() == 'property')
			{
				$(".location-container").addClass('d-none');
				$("input[name=parent_location]").val('');
				$("#parent_location_id").val(0);
			}else{
				$(".location-container").removeClass('d-none');
			}
		});
	});
</script>