<?php
	$location = null;
	if(count($args))
	{
		$location_result = $ots->execute('location','get-location',['locationid'=>$args[0]]);
		$location = json_decode($location_result,true);
	}
	$location_types_result =  $ots->execute('location','get-location-types');
	$location_types = json_decode($location_types_result);

	$location_uses_result =  $ots->execute('location','get-location-use');
	$location_uses = json_decode($location_uses_result);

	$location_statuses_result =  $ots->execute('location','get-location-statuses');
	$location_statuses = json_decode($location_statuses_result);
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

<div class="page-title"><?=count($args) ? 'Edit' : 'Add';?> Location</div>
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white p-4 rounded-sm">
		<form method="post" action="<?=WEB_ROOT;?>/location/save?display=plain" class="bg-white" id="form-location">
			<div class="row forms">
					<div class="col-12 col-sm-4">
						<div class="form-group">
							<label>Company </label>
							<input type="text" class="form-control" name="company" value="">
						</div>
					</div>

					<div class="col-12 col-sm-4">
						<div class="form-group">
							<label for="" class="text-required">Contact Person</label>
							<input type="text" class='form-control' name='contact' value='<?= $contract->contract_name?>' required>
							
						</div>
					</div>

					<div class="col-12 col-sm-4">
						<div class="form-group">
							<label for="" class="text-required">Username</label>
							<input type="text" class='form-control' name='username' value='<?= $contract->contract_number?>' required>
						</div>
					</div>

					<div class="col-12 col-sm-4">
						<div class="form-group">
						<br>
							<label for="" class="text-required">Email</label>
							<input type="email" class="form-control" name="email" value="<?php echo $equipment ? $equipment['equipment_name'] : '';?>" required>
						</div>
					</div>
					
					<div class="col-12 col-sm-4">
						<div class="form-group">
						<br>
							<label>Contact Number </label>
							<input type="text" name='contact' value='' required class='form-control'>
						</div>
					</div>
				
					<div class="form-group mb-2">
					<br>
						<label for="" class="text-required">Company Address</label>
						<input type="text" name='company_address' class='form-control value='<?= $contract->office_address?>' required>
					</div>

				
					<div class="col-12 col-sm-4">
						<div class="form-group">
						<br>
							<label for="" class="text-required">Scope Of Service</label>
							<input type="text" class='form-control' name='scope' value='<?= $contract->contact_person?>' required>
						</div>
					</div>
					
					<div class="col-4 col-sm-8">
						<div class="form-group rate">
							Vendor Score
							<br>
							<input type="radio" id="star5" name="rate" value="5" />
							<label for="star5" title="text">5 stars</label>
							<input type="radio" id="star4" name="rate" value="4" />
							<label for="star4" title="text">4 stars</label>
							<input type="radio" id="star3" name="rate" value="3" />
							<label for="star3" title="text">3 stars</label>
							<input type="radio" id="star2" name="rate" value="2" />
							<label for="star2" title="text">2 stars</label>
							<input type="radio" id="star1" name="rate" value="1" />
							<label for="star1" title="text">1 star</label>
						</div>
					</div>

				</div>
				<br>
				<button class="btn btn-primary">Submit</button>
				<button type="button" class="btn btn-light btn-cancel">Cancel</button>
				
				<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$("#form-location").off('submit').on('submit',function(e){
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
						$(".notification-success-message").html(data.description);
						$(".notification-success").fadeIn('slow');
						<?php if(!$location):?>	
						$("#form-location")[0].reset();
						<?php endif;?>
					}	
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});

		$(".btn-cancel").off('click').on('click',function(){
			//loadPage('<?=WEB_ROOT;?>/location');
			window.location.href = '<?=WEB_ROOT;?>/location';
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