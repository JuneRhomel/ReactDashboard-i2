<?php
	echo $location = null;
	
	$data = [
		'permit_id'=>$args[0]
	];
	$permit_result = $ots->execute('contracts','get-permits',$data);
	$permit = json_decode($permit_result);
	


?>
<!-- <a href='<?= WEB_ROOT ?>/contracts/view-permit/<?= $args[0] ?>/View'  class='btn '>Back</a>
<a href='<?= WEB_ROOT ?>/contracts/edit-permit/<?= $args[0] ?>/Edit'  class='btn btn-primary'>Edit</a> -->
<!-- <div class="page-title float-right">Permit</div> -->

<div class="bg-white rounded-sm">
	<?php $permit->id?>
	<form action="<?= WEB_ROOT ?>/contracts/update-permit-contracts?display=plain" id="permit-edit" method='post'>
        <input type="hidden" name='id'  id='id' value= '<?= $args[0]?>'>
        <input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/contracts/view-permit/<?= $args[0] ?>/View'>
        <input type="hidden" name='table'  id='id' value= 'permits'>
        <input type="hidden" name='view_table'  id='id' value= 'view_permits'>
		<input type="hidden" name='update_table'  id='id' value= 'permit_updates'>
		<label class="required-field mt-4">* Please Fill in the required fields</label>

        <div class="row forms">
				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Date Created </label>
						<input type="text" class="form-control" name="created_on" value="<?php echo date('Y-m-d h:i:s',$permit->created_on);?>" required readonly>
						<input type="hidden" class="form-control" value="<?php echo date('H:00');?>" id="hidden_time">	
					</div>
				</div>
				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Permit Name <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='permit_name' value='<?= $permit->permit_name?>' required>
						
					</div>
				</div>

				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Permit Number <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='permit_number' value='<?= $permit->permit_number?>' required>
					</div>
				</div>

				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Status <span class="text-danger">*</span></label>
						<select name="status" id="status" class='form-select'>
							<option <?= ($permit->status == 'active')? 'selected' : ''?> value="active">Active</option>
							<option <?= ($permit->status == 'inactive')? 'selected' : ''?> value="inactive">Inactive</option>
						</select>
					</div>
				</div>
				
				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Date Issued  <span class="text-danger">*</span></label>
						<input type="date" name='date_issued' value='<?= $permit->date_issued?>' required class='form-control'>
					</div>
				</div>

				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Renewable <span class="text-danger">*</span></label>
						<select name="renewable" id="renewable" class='form-select'>
							<option <?= ($permit->renewable == 'yes')? 'selected' : ''?> value="yes">Yes</option>
							<option <?= ($permit->renewable == 'no')? 'selected' : ''?> value="no">No</option>
						</select>
					</div>
				</div>
				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Expiration Date  <span class="text-danger">*</span></label>
						<input type="date" class='form-control' name='expiration_date' value='<?= $permit->expiration_date?>' required>
					</div>
				</div>
				
				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Days to notify <span class="text-danger">*</span></label>
						<input type="number" name='days_to_notify' class='form-control' value='<?= $permit->days_to_notify?>' required>
					</div>
				</div>

				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Issuing Office <span class="text-danger">*</span></label>
						<input type="text" name='issuing_office' class='form-control' value='<?= $permit->days_to_notify?>' required>
					</div>
				</div>

				<div class="col-12 col-sm-8">
				<div class="col-12 mb-3 my-4">
				<br>
					<label for="" class="text-required">Office Address <span class="text-danger">*</span></label>
					<input type="text" name='office_address' class='form-control' value='<?= $permit->office_address?>' required>
				</div>
				</div>
			
				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Contact Person <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='contact_person' value='<?= $permit->contact_person?>' required>
					</div>
				</div>
				 <div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Office Number <span class="text-danger">*</span></label>
						<input type="text" name='office_number'  class='form-control' value='<?= $permit->contact_person?>' required>
					</div>
				</div>
			
			 <div class="col-12 col-sm-4 my-4">
				<div class="form-group">
					<br>
					<label for="" class="text-required">Attachment: </label>
					<input type="file" class="form-control" name="file" multiple>
				</div>
			</div>
			<div><br></div>
		</div>
		<div><br></div>
			<div class="btn-group-buttons pull-right">
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
		$("#permit-edit").off('submit').on('submit',function(e){
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
			window.location.href = '<?=WEB_ROOT;?>/contracts/contract-tracker?submenuid=contractracker';
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