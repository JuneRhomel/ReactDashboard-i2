<?php
	$location = null;
	if(count($args))
	{
		$data = [
			'id'=>$args[0],
			'view'=>'service_providers_view'
		];

		$sp_result = $ots->execute('property-management','get-record',$data);
		$s_provider = json_decode($sp_result,true);
	}
?>
<style>
*{
    margin: 0;
    padding: 0;
}
.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}

</style>

<!-- <div class="page-title"><?=count($args) ? 'Edit' : 'Edit';?> Form</div> -->
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white rounded-sm">
		<form method="post" action="<?=WEB_ROOT;?>/property-management/save-record?display=plain" id="save-service-provider" class="bg-white">
			<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/property-management/view-service-provider/<?= $args[0]?>/View' >
			<input type="hidden" name='table'  id='id' value= 'service_providers'>
			<input type="hidden" name='view_table'  id='id' value= 'service_providers_view'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
						<label for="" class="text-required">Company <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="company" value="<?= $s_provider['company'];?>" required>
						</div>
					</div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Contact Person <span class="text-danger">*</span></label>
							<input type="text" class='form-control' name='contact_person' value="<?= $s_provider['contact_person'];?>" required>
							
						</div>
					</div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Username <span class="text-danger">*</span></label>
							<input type="text" class='form-control' name='username' value="<?= $s_provider['username'];?>" required>
						</div>
					</div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
						
							<label for="" class="text-required">Email <span class="text-danger">*</span></label>
							<input type="email" class="form-control" name="email" value="<?= $s_provider['email'];?>" required>
						</div>
					</div>
					
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
						
						<label for="" class="text-required">Contact Number  <span class="text-danger">*</span></label>
							<input type="text" name='contact_number' value="<?= $s_provider['contact_number'];?>" required class='form-control'>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12 col-sm-8 my-4">
						<div class="form-group">
							<label for="" class="text-required">Company Address <span class="text-danger">*</span></label>
							<input type="text" name='company_address' class='form-control' value="<?= $s_provider['company_address'];?>" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
						
							<label for="" class="text-required">Scope Of Service <span class="text-danger">*</span></label>
							<input type="text" class='form-control' name='scope_of_service' value="<?= $s_provider['scope_of_service'];?>" required>
						</div>
					</div>
					
					<div class="col-4">
						<div class="col-4">
							<label class="text-required">Vendor Score</label>
						</div> 
						<div class="col-12">
							<div class="form-group rate">
								
								
								<input type="radio" id="star5" name="vendor_score" value="5" <?php echo ($s_provider['vendor_score'] == '5') ? 'checked' : ''; ?>/>
								<label for="star5" title="text">5 stars</label>
								<input type="radio" id="star4" name="vendor_score" value="4" <?php echo ($s_provider['vendor_score'] == '4') ? 'checked' : ''; ?>/>
								<label for="star4" title="text">4 stars</label>
								<input type="radio" id="star3" name="vendor_score" value="3" <?php echo ($s_provider['vendor_score'] == '3') ? 'checked' : ''; ?>/>
								<label for="star3" title="text">3 stars</label>
								<input type="radio" id="star2" name="vendor_score" value="2" <?php echo ($s_provider['vendor_score'] == '2') ? 'checked' : ''; ?>/>
								<label for="star2" title="text">2 stars</label>
								<input type="radio" id="star1" name="vendor_score" value="1" <?php echo ($s_provider['vendor_score'] == '1') ? 'checked' : ''; ?>/>
								<label for="star1" title="text">1 star</label>
							</div>
						</div>
					
					</div>

				</div>
				
				<div class="btn-group-buttons pull-right">
				<div class="mb-3 float-end">
					<button type="submit" class="btn btn-dark btn-primary px-5">Save</button>
					<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
				</div>
			</div>
				
				
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$("#save-service-provider").off('submit').on('submit',function(e){
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

		$(".btn-cancel").off('click').on('click',function(){
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