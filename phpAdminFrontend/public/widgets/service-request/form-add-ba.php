<div class="main-container">

	<div class="page-title float-right"><?= $args[1] ;?></div>    
	<div class="">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="form-ba" enctype="multipart/form-data">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/building-application?submenuid=building_application'>
            <input type="hidden" name='redirect'  id='error_redirect' value= '<?= WEB_ROOT?>/tenant/view-ba'>
			<input type="hidden" name='table'  id='id' value= 'documents'>
			<input type="hidden" name='view_table'  id='id' value= 'view_documents'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>
			
			<div class="row forms">
				<div class="col-12 col-sm-4 mt-4">
					<div class="form-group">
						<label class="text-required">Name of Application Form <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="form_name" value="" required>
                    </div>
                </div>
                <div class="col-12 col-sm-4 mt-4">
					<div class="form-group">
						<label for="" class="text-required">Description <span class="text-danger">*</span></label>
                        <textarea class='form-control form-textarea'name="description" id="" cols="30" rows="3"></textarea>
                    </div>
                </div>
				
                <div class="col-12 col-sm-8 my-4">
					<div class="form-group">
						<br>
						<label for="" class="text-required">Attachment: <span class="text-danger">*</span></label>
						<input type="file" class="form-control" name="file[]" multiple required>
					</div>
				</div>
				
				<div class="btn-group-form pull-right">
				<button type="submit" class="btn btn-dark btn-primary px-5">Add</button>
				<!-- <button type="button" class="btn btn-light btn-cancel">Cancel</button> -->
			</div>
			<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
		</form>
	</div>
	</div>
	<script>
		$(document).ready(function(){
			$("#form-ba").off('submit').on('submit',function(e){
				e.preventDefault();
				$.ajax({
					url: $(this).prop('action'),
					type: 'POST',
					dataType: 'JSON',
					data: new FormData($(this)[0]),
					contentType: false,
					processData: false,
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