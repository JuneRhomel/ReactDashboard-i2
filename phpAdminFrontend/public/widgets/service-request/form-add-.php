<?php
	// echo $location = null;
	
	// $data = [
	// 	'permit_id'=>$args[0]
	// ];
	// $permit_result = $ots->execute('contracts','get-permits',$data);
	// $permit = json_decode($permit_result);
	
?>
<!-- <a href='<?= WEB_ROOT ?>/contracts/edit-permit/<?= $args[0] ?>/Edit'  class='btn btn-primary'>Edit</a> -->
<div class="page-title float-right"><?= $args[1] ;?> Tenant Registration</div>

<div class=" rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="tr-add" class="bg-white" enctype="multipart/form-data">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/tenant-registration?submenuid=tenant_registration'>
			<input type="hidden" name='table'  id='id' value= 'tenant'>
			<input type="hidden" name='view_table'  id='id' value= 'view_tenant'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">

                            <label for="" class="text-required">Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class='form-select'>
                                <option value="unit owner">Unit Owner</option>
                                <option value="tenant">Tenant</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            
                            <label for="" class="text-required">First Name <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='first_name' value='' required>
                        </div>
                    </div>


                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            
                            <label for="" class="text-required">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='last_name' value='' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            
                            <label for="" class="text-required">Unit <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='unit_id' value='' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Contact # <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='contact' value='' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Email Address <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='email' value='' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Username <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='username' value='' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Password <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='password' value='' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class='form-select'>
                                <option value="approved">Approved</option>
                            </select>
                        </div>
                    </div>

                    
             </div>
			<div class="row">
                <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            
                            <label class="text-required">Photo  <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="file" id="photo_file" accept="image/*" multiple>
                        </div>
                    </div>
                 
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            
                            <label class="text-required">Contract  <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="file" multiple>
                        </div>
                    </div>
            </div>

			<div class="btn-group-form pull-right mt-4">
               
				<div class="mb-3 float-end">
				<button type="submit" class="btn btn-dark btn-primary px-5">Submit</button>
				<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
			</div>
			</div>
				<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
		</form>
	</div>
<script>
	$(document).ready(function(){
		$("#tr-add").off('submit').on('submit',function(e){
			e.preventDefault();
			var file=$("#photo_file").val().replace(/C:\\fakepath\\/i, '').split(".");
			if(file[1] == 'jpeg' || file[1] == 'jpg' || file[1] == 'png' || file[1] == 'gif'){
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
			}else{
				Swal.fire({
					text: "Photo selected isn't acceptable, try  again",
					icon: 'warning'
				})
			}
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