<?php
   $data = [
	'id'=>$args[0],
	'view'=>'view_reservation'
	];
	$reservation = $ots->execute('tenant','get-record',$data);
	$reservation = json_decode($reservation);
	
	$data = [
		'_id'=>$reservation->name,
        'view'=>'tenant'
	];
	$tenant = $ots->execute('tenant','get-record',$data);
	$tenant = json_decode($tenant);
?>
<!-- <a href='<?= WEB_ROOT ?>/contracts/edit-permit/<?= $args[0] ?>/Edit'  class='btn btn-primary'>Edit</a> -->
<div class="page-title float-right"><?= $args[1] ;?> Reservation</div>

<div class="bg-white rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="reservation-edit" class="bg-white">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/view-reservation/<?=$args[0]?>/View'>
			<input type="hidden" name='table'  id='id' value= 'reservation'>
			<input type="hidden" name='view_table'  id='id' value= 'view_reservation'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                        <label for="" class="text-required">Service Request Category</label>
							<select name="sr_type" id="sr_type" class='form-select'>
								<option value="unit-repair" <?= ($reservation->sr_type == "unit-repair")?'selected':'';?>>Unit Repair</option>
                                <option value="gate-pass"  <?= ($reservation->sr_type == "gate-pass")?'selected':'';?>>Gate Pass</option>
                                <option value="visitor-pass"  <?= ($reservation->sr_type == "visitor-pass")?'selected':'';?>>Visitor's Pass</option>
                                <option value="reservation"  <?= ($reservation->sr_type == "reservation")?'selected':'';?>>Reservation</option>
                                <option value="move-in"  <?= ($reservation->sr_type == "move-in")?'selected':'';?>>Move-In</option>
                                <option value="move-out"  <?= ($reservation->sr_type == "move-out")?'selected':'';?>>Move-Out</option>
                                <option value="work-permit"  <?= ($reservation->sr_type == "work-permit")?'selected':'';?>>Work Permit</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 col-sm-4 my-4">
                            <div class="form-group">
                            
                            <label for="" class="text-required">Amenity <span class="text-danger">*</span></label>
								<input type="text" class='form-control' name='amenity' value='<?= $reservation->amenity ?>' required>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 my-4">
                            <div class="form-group">
                            
                            <label for="" class="text-required">Date <span class="text-danger">*</span></label>
								<input type="date" class='form-control' min="<?= date('Y-m-d')?>"  name='date' value='<?= $reservation->date ?>' required>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 my-4">
                            <div class="form-group">
                            
                            <label for="" class="text-required">Time <span class="text-danger">*</span></label>
								<input type="time" class='form-control' min="<?= date('h:i')?>"  name='time' value='<?= $reservation->time ?>' required>
                            </div>
                        </div>

                    <div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Tenant Name <span class="text-danger">*</span></label>
							<input name="name" type="hidden" value="<?= $reservation->name; ?>" required>
							<input id="name_id" type="text" class="form-control" placeholder="Search Tenant" value="<?= $tenant->owner_name ?>"required>
						</div>

                        <!-- <div class="form-group">
                            <label for="" class="text-required">Requestor Name <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='name' value='<?= $reservation->name ?>' required>
                        </div> -->
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                            <div class="form-group">
                            
                            <label for="" class="text-required">Resident Type <span class="text-danger">*</span></label>
								<select name="resident_type" id="resident_type" class='form-select'>
									<option <?= ($reservation->resident_type == "Unit Owner")?'selected':'';?>>Unit Owner</option>
									<option <?= ($reservation->resident_type == "Tenant")?'selected':'';?>>Tenant</option>
                                </select>
                            </div>
                        </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Unit <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='unit' value='<?= $reservation->unit ?>' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Contact Number <span class="text-danger">*</span></label>
							<input type="text" class='form-control' name='contact_num' value='<?= $reservation->contact_num ?>' required>
                        </div>
                    </div>
             </div>

			 <div><br></div>
			 <h4>Reservation Details</h4>
			 <div class="row forms">

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					
						<label for="" class="text-required">Purpose Of Reservation <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='purpose' value='<?=$reservation->purpose;?>' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					
						<label for="" class="text-required">Number Of Guest <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='number_guest' value='<?=$reservation->number_guest;?>' required>
					</div>
				</div>

			</div>
			
			<div class="btn-group-form pull-right">
                <br>
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
		$("#reservation-edit").off('submit').on('submit',function(e){
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
				$('input[name="email_add"]').val(ui.item.owner_email);
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

		$("select[name=sr_type]").val('reservation');

		$("select[name=sr_type]").on('change',function(){
			if($(this).val() == 'unit-repair')
			{
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-unit-repair";

			}
			else if($(this).val() == 'gate-pass'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-gate-pass";

			}
			else if($(this).val() == 'visitor-pass'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-visitor-pass";

			}
			else if($(this).val() == 'move-in'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-move-in";

			}
			else if($(this).val() == 'move-out'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-move-out";

			}
			else if($(this).val() == 'work-permit'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-work-permit";

			}
			else{
				location.reload();
			}
		});
	});
</script>