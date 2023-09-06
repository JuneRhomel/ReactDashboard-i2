<?php
	 $data = [
		'id'=>$args[0],
        'view'=>'view_pdcs'
	];
	$pdc = $ots->execute('tenant','get-record',$data);
	$pdc = json_decode($pdc);
	
?>
<div class="page-title float-right"><?= $args[1] ;?> PDC Tracker</div>

<div class="bg-white rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="tr-edit" class="bg-white" enctype="multipart/form-data">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/form-edit-pdc/<?= $args[0]; ?>/Edit'>
			<input type="hidden" name='table' value= 'pdcs'>
			<input type="hidden" name='view_table' value= 'view_pdcs'>
			<input type="hidden" name="id" value="<?=$args[0] ?? '';?>">
			<input type="hidden" name="rec_id" value="<?=$pdc->rec_id ?? '';?>">


			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Check Date </label>
						<input type="date" class="form-control" name="check_date" value="<?php echo date('Y-m-d');?>" required>
					</div>
				</div>
			</div>
			
			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Check Number <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='check_number' value='<?= $pdc->check_number ?>' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Amount<span class="text-danger">*</span></label>
						<input type="number" class='form-control' name='check_amount' value='<?= $pdc->check_amount ?>' required>
					</div>
				</div>
				
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Unit <span class="text-danger">*</span></label>
						<select name="unit" id="unit" class='form-select'>
							<option value="unit owner" <?= ($pdc->unit=='unit owner') ? 'selected' : '';?> >Unit Owner</option>
							<option value="tenant" <?= ($pdc->unit=='tenant') ? 'selected' : '';?> >Tenant</option>
						</select>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Sequence Number <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='sequence_number' value='<?= $pdc->sequence_number ?>' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Total PDC Count <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='total_pdc_count' value='<?= $pdc->total_pdc_count ?>' required>
					</div>
				</div>
        	</div>

			<div class="btn-group-form pull-right mt-4">
               
				<div class="mb-3 float-end">
				<button type="submit" class="btn btn-dark btn-primary px-5">Save</button>
				<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
			</div>
			</div>
		</form>
	</div>
<script>
	$(document).ready(function(){
		$("#tr-edit").off('submit').on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				dataType: 'JSON',
				data: new FormData($(this)[0]),
				contentType: false,
				processData: false,
				beforeSend: function(){
				},
				success: function(data){
					// console.log(data);
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
			Swal.fire({
					text: "This information will be deleted once you exit, are you sure you want to exit?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes',
				}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					window.location.href = '<?php echo WEB_ROOT;?>/tenant/tenant-registration?submenuid=tenant_registration';
				}
			})
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