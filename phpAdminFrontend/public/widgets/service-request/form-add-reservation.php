<div class="main-container">


<div class="page-title float-right"><?= $args[1] ;?> Reservation</div>

<div class=" rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="reservation-add" class="bg-white">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/service-request?submenuid=service_request'>
			<input type="hidden" name='table'  id='id' value= 'reservation'>
			<input type="hidden" name='view_table'  id='id' value= 'view_reservation'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
                        <label for="" class="text-required">Service Request Category</label>
                            <select name="sr_type" id="sr_type" class='form-select'>
                                <option value="unit-repair">Unit Repair</option>
                                <option value="gate-pass">Gate Pass</option>
                                <option value="visitor-pass">Visitor's Pass</option>
                                <option value="reservation">Reservation</option>
                                <option value="move-in">Move-In</option>
                                <option value="move-out">Move-Out</option>
                                <option value="work-permit">Work Permit</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
                            <label for="" class="text-required">Amenity <span class="text-danger">*</span></label>
								<input type="text" class='form-control' name='amenity' value='' required>
                            </div>
                        </div>

						<div class="col-12 col-sm-4 my-4">
							<div class="form-group">
                            <label for="" class="text-required">Date <span class="text-danger">*</span></label>
								<input type="date" class='form-control' name='date'  min="<?= date('Y-m-d')?>" value='' required>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 my-4">
							<div class="form-group">
								<label for="" class="text-required">Time <span class="text-danger">*</span></label>
									<input type="time" class='form-control' name='time'  min="<?= date('h:i')?>" value='' required>
                            </div>
                        </div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Tenant Name <span class="text-danger">*</span></label>
							<input name="name" type="hidden" required>
							<input id="name_id" type="text" class="form-control" placeholder="Search Tenant" required>
						</div>
						<!-- <div class="form-group">
                            <label for="" class="text-required">Requestor Name <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='name' value='' required>
                        </div> -->
                    </div>

                    <div class="col-12 col-sm-4 my-4">
						<div class="form-group">
                            <label for="" class="text-required">Resident Type <span class="text-danger">*</span></label>
                                <select name="resident_type" id="resident_type" class='form-select'>
									<option>Unit Owner</option>
									<option>Tenant</option>
                                </select>
                            </div>
                        </div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
                            <label for="" class="text-required">Unit <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='unit' value='' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
						<div class="form-group">
                            <label for="" class="text-required">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='contact_num' value='' required>
                        </div>
                    </div>
             </div>

			 <div><br></div>
			 <h4>Reservation Details</h4>
			 <div class="row forms">

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					
						<label for="" class="text-required">Purpose Of Reservation <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='purpose' value='' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					
						<label for="" class="text-required">Number Of Guest <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='number_guest' value='' required>
					</div>
				</div>

			</div>
			
			<div class="btn-group-form pull-right">
                <br>
				<div class="mb-3 float-end">
				<button type="submit" class="btn btn-dark btn-primary px-5">Submit</button>
				<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
			</div>
			</div>
		</form>
	</div>
	</div>
<script>
	$(document).ready(function(){
		$("#reservation-add").off('submit').on('submit',function(e){
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

		$("input[id=name_id]").autocomplete({
			autoSelect : true,
			autoFocus: true,
			search: function(event, ui) { $('.spinner').show();	},
			response: function(event, ui) {	$('.spinner').hide(); },
			source: function( request, response ) {
				$.ajax({
					url: '<?=WEB_ROOT;?>/property-management/get-records?display=plain',
					dataType: "json",
					type: 'post',
					data: {	
						view: 'tenant',
						auto_complete:true,
						term:request.term, filter:''
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

				$('input[name="unit"]').val(ui.item.unit_id);
				$('input[name="contact_num"]').val(ui.item.owner_contact);
				return false;
			},
			change: function(event, ui){
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
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
					window.location.href = '<?php echo WEB_ROOT;?>/tenant/service-request?submenuid=service_request';
				}
			})
			// window.location.href = '<?php echo WEB_ROOT;?>/property-management/pm';
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

		$("select[name=sr_type]").val('reservation');

		$("select[name=sr_type]").on('change',function(){
			if($(this).val() == 'unit-repair')
			{
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-unit-repair";

			}
			else if($(this).val() == 'gate-pass'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-gate-pass";

			}
			else if($(this).val() == 'visitor-pass'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-visitor-pass";

			}
			else if($(this).val() == 'move-in'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-move-in";

			}
			else if($(this).val() == 'move-out'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-move-out";

			}
			else if($(this).val() == 'work-permit'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-work-permit";

			}
			else{
				location.reload();
			}
		});
	});
</script>