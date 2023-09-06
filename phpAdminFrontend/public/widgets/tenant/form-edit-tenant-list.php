<?php
	 $data = [
		'id'=>$args[0],
        'view'=>'view_tenant'
	];
	$tenant = $ots->execute('tenant','get-record',$data);
	$tenant = json_decode($tenant);
	
?>
<!-- <a href='<?= WEB_ROOT ?>/contracts/edit-permit/<?= $args[0] ?>/Edit'  class='btn btn-primary'>Edit</a> -->
<div class="main-container">
<div class="page-title float-right"><?= $args[1] ;?> Tenant List</div>

<div class=" rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="tl-edit"enctype="multipart/form-data">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/tenant-list?submenuid=tenant_list'>
			<input type="hidden" name='table'  id='id' value= 'tenant'>
			<input type="hidden" name='view_table'  id='id' value= 'view_tenant'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
                <h4> Owner Details </h4>
                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
							<label for="" class="text-required">Owner Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="owner_name" value="<?= $tenant->owner_name;?>" required>
                        </div>
                    </div>
                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                            <label for="" class="text-required">Contact <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='owner_contact' value='<?= $tenant->owner_contact;?>' required>
                        </div>
                    </div>

                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                            <label for="" class="text-required">Email <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='owner_email' value='<?= $tenant->owner_email;?>' required>
                        </div>
                    </div>

                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                       
                            <label for="" class="text-required">Username <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='owner_username' value='<?= $tenant->owner_username;?>' required>
                        </div>
                    </div>

                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                       
                            <label for="" class="text-required">Owner Spouse</label>
                            <input type="text" class='form-control' name='owner_spouse' value='<?= $tenant->owner_spouse;?>'>
                        </div>
                    </div>

                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                           
                            <label for="" class="text-required">Owner Spouse Contact#</label>
                            <input type="text" class='form-control' name='owner_spouse_contact' value='<?= $tenant->owner_spouse_contact;?>'>
                        </div>
                    </div>

                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
							<!-- <input type="text" class='form-control' name='unit_id' value='<?= $tenant->unit_id;?>' required> -->
							<select name="" id="" required>
								<option value='<?= $tenant->unit_id?>'><?= $tenant->unit_id?></option>
							</select>
							<label for="" class="text-required">Unit <span class="text-danger">*</span></label>
                        </div>
                    </div>

                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                           
                            <label for="" class="text-required">Unit Area (sqm) <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='unit_area' value='<?= $tenant->unit_area;?>' required>
                        </div>
                    </div>
            </div>
            <div><br></div>
            <div class="row forms">
                <h4> Tenant Details </h4>
                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                        
                            <label for="" class="text-required">Tenant Name </label>
                            <input type="text" class='form-control' name='tenant_name' value='<?= $tenant->tenant_name;?>'>
                        </div>
                    </div>
			
                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                            <label for="" class="text-required">Tenant Contact # <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='tenant_contact' value='<?= $tenant->tenant_contact;?>' required>
                        </div>
                    </div>

                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                            <label for="" class="text-required">Tenant Email Address <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='tenant_email' value='<?= $tenant->tenant_email;?>' required>
                        </div>
                    </div>

                     <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                           
                            <label for="" class="text-required">Tenant Username <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='tenant_username' value='<?= $tenant->tenant_username;?>' required>
                        </div>
                    </div>
			
				<div class="col-12 col-sm-8 my-4 file-box">
						<input type="file" class='form-control' name='file' id="file"  required>
						<label for="file"><span class="material-icons">download</span> Upload</label>
						<span id="file-name">No file chosen</span>
				</div>
			</div>
			<div class="btn-group-form pull-right mt-4">
               
				<div class="mb-3 d-flex justify-content-end gap-3">
				<button type="submit" class="btn main-btn ">Save</button>
				<button type="button" class="btn main-cancel btn-cancel ">Cancel</button>
			</div>
			</div>
				<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#file').on('change', function() {
		var fileName = $(this).val().split('\\').pop();
		$('#file-name').text(fileName || 'No file chosen');
	});
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