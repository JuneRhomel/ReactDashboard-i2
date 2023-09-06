<?php

	
?>
<!-- <a href='<?= WEB_ROOT ?>/contracts/edit-permit/<?= $args[0] ?>/Edit'  class='btn btn-primary'>Edit</a> -->
<div class="page-title float-right"><?= $args[1] ;?> Gate Pass</div>

<div class="bg-white rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="gp-add" class="bg-white">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/service-request?submenuid=service_request'>
			<input type="hidden" name='table'  id='id' value= 'gate_pass'>
			<input type="hidden" name='view_table'  id='id' value= 'view_gate_pass'>
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
                            
                            <label for="" class="text-required">Gate Pass Type <span class="text-danger">*</span></label>
                                <select name="gp_type" id="gp_type" class='form-select'>
                                    <option>Delivery</option>
                                    <option>Pull out</option>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 my-4">
                            <div class="form-group">
                            
								<label for="" class="text-required">Date <span class="text-danger">*</span></label>
								<input type="date" min="<?= date('Y-m-d')?>" class='form-control' name='gp_date' value='' required>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 my-4">
                            <div class="form-group">
                            
								<label for="" class="text-required">Time <span class="text-danger">*</span></label>
								<input type="time" id="time" class='form-control' name='gp_time' min='<?= date('h:i') ?>' required>
                            </div>
                        </div>

                    <div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Tenant Name <span class="text-danger">*</span></label>
							<input name="name" type="hidden" value="<?=$record ? ($record['unit_id']) ?? '0' : '0';?>" required>
							<input id="name_id" type="text" class="form-control" placeholder="Search Tenant" required>
						</div>
<!-- 
						<div class="form-group">
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
                            <input type="text" class='form-control' name='unit' id='unit' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
						<div class="form-group">
                            <label for="" class="text-required">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='contact_num' id='contact_num' required>
                        </div>
                    </div>
             </div>

			<div><br></div>

			<h4>Delivery Details</h4>
			<table class="table gatepass">
				<thead class="header-design">
					<tr>
						<th style="width:20%">Item Number</th>
						<th style="width:20%">Item Name</th>
						<th style="width:20%">Quantity</th>
						<th style="width:20%">Description</th>
						<th style="width:5%"></th>
					</tr>
				</thead>

				<tbody class="table-body">     
						<tr class="tr-data">
							<td>
								<input type="text"  name="item_num[]" class="input_0 form-control">
							</td>
							<td>
								<input type="text"  name="item_name[]" class="input_0 form-control">
							</td>
							<td>
								<input type="text"  name="item_qty[]" class="input_0 form-control">
							</td>
							<td>
								<input type="text"  name="description[]" class="input_0 form-control">
							</td>
							<td>
								<i class="bi bi-dash-circle" id="first-row" style="cursor:pointer; " disabled></i>
							</td>
						</tr>	
				</tbody>

			</table>
			<div class="d-flex">
				<button type="button" id="btn-add-item" class="btn btn-sm btn-add-item text-primary"> Add Item</button>
			</div>			
			<div><br></div>

			<h4>Courier Details</h4>
			<div class="row forms">

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Courier/Company <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='courier' value='' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Name <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='courier_name' value='' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Contact Details <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='courier_contact' value='' required>
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
<script>
	$(document).ready(function(){
		$("#gp-add").off('submit').on('submit',function(e){
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

		var i = 1;
		$('.btn-add-item').on('click', function(e) {
			e.preventDefault();
			i++;
			
				$('.table-body').append(`
					<tr class="tr-data">
						<td>
						<input type="text" name="item_num[]" class="input_0 form-control">
						</td>
						<td>
						<input type="text" name="item_name[]" class="input_0 form-control">
						</td>
						<td>
						<input type="text" name="item_qty[]"  class="input_0 form-control">
						</td>
						<td>
						<input type="text"  name="description[]" class="input_0 form-control">
						</td>
						<td>
							<i class="bi bi-dash-circle" id="remove-row" style="cursor:pointer"></i>
						</td>
					</tr>
                `);
		});
		

		$(document).on('click', '#remove-row', function() {
			i--;
			$(this).closest('tr').remove();
		
			return false;

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

		$("select[name=sr_type]").val('gate-pass');

		$("select[name=sr_type]").on('change',function(){
			if($(this).val() == 'unit-repair')
			{
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-unit-repair";

			}
			else if($(this).val() == 'visitor-pass'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-visitor-pass";

			}
			else if($(this).val() == 'reservation'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-reservation";

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