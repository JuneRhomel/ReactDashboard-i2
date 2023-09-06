<?php
 	$data = [
		'id'=>$args[0],
		'view'=>'view_gate_pass'
	];
	$gate_pass = $ots->execute('tenant','get-record',$data);
	$gate_pass = json_decode($gate_pass);

	$data = [
		'_id'=>$gate_pass->name,
        'view'=>'tenant'
	];
	$tenant = $ots->execute('tenant','get-record',$data);
	$tenant = json_decode($tenant);

	//get items
	$data = [
		'view'=>'gp_items',
		'filters'=>[
			'gp_id' => $gate_pass->rec_id
		]
	];
	$gp_items = $ots->execute('tenant','get-records',$data);
	$gp_items = json_decode($gp_items);
	
?>
<!-- <a href='<?= WEB_ROOT ?>/contracts/edit-permit/<?= $args[0] ?>/Edit'  class='btn btn-primary'>Edit</a> -->
<div class="page-title float-right"><?= $args[1] ;?> Gate Pass</div>

<div class="bg-white rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="gp-edit" class="bg-white">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/view-gate-pass/<?=$args[0]?>/View'>
			<input type="hidden" name='table'  id='id' value='gate_pass'>
			<input type="hidden" name='view_table'  id='id' value= 'view_gate_pass'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                       
                        <label for="" class="text-required">Service Request Category</label>
                            <select name="sr_type" id="sr_type" class='form-select'>
								<option value="unit-repair" <?= ($gate_pass->sr_type == "unit-repair")?'selected':'';?>>Unit Repair</option>
                                <option value="gate-pass"  <?= ($gate_pass->sr_type == "gate-pass")?'selected':'';?>>Gate Pass</option>
                                <option value="visitor-pass"  <?= ($gate_pass->sr_type == "visitor-pass")?'selected':'';?>>Visitor's Pass</option>
                                <option value="reservation"  <?= ($gate_pass->sr_type == "reservation")?'selected':'';?>>Reservation</option>
                                <option value="move-in"  <?= ($gate_pass->sr_type == "move-in")?'selected':'';?>>Move-In</option>
                                <option value="move-out"  <?= ($gate_pass->sr_type == "move-out")?'selected':'';?>>Move-Out</option>
                                <option value="work-permit"  <?= ($gate_pass->sr_type == "work-permit")?'selected':'';?>>Work Permit</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 col-sm-4 my-4">
                            <div class="form-group">
                           
                            <label for="" class="text-required">Gate Pass Type <span class="text-danger">*</span></label>
                                <select name="gp_type" id="gp_type" class='form-select'>
                                    <option value="1" <?= ($gate_pass->gp_type == "1")?'selected':'';?>>Delivery</option>
                                    <option value="2" <?= ($gate_pass->gp_type == "2")?'selected':'';?>>Pull out</option>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 my-4">
                            <div class="form-group">
                           
                            <label for="" class="text-required">Date <span class="text-danger">*</span></label>
								<input type="date" class='form-control' name='gp_date' min="<?= date('Y-m-d')?>"  value='<?= $gate_pass->gp_date ?>' required>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 my-4">
                            <div class="form-group">
                           
                            <label for="" class="text-required">Time <span class="text-danger">*</span></label>
								<input type="time" class='form-control' name='gp_time' min="<?= date('h:i')?>"  value='<?= $gate_pass->gp_time ?>' required>
                            </div>
                        </div>

                    <div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Tenant Name <span class="text-danger">*</span></label>
							<input name="name" type="hidden" value="<?= $unit_repair->name; ?>" required>
							<input id="name_id" type="text" class="form-control" placeholder="Search Tenant" value="<?= $tenant->owner_name ?>"required>
						</div>
                        <!-- <div class="form-group">
                            <label for="" class="text-required">Requestor Name <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='name' value='<?= $gate_pass->name ?>' required>
                        </div> -->
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                            <div class="form-group">
                           
                            <label for="" class="text-required">Resident Type <span class="text-danger">*</span></label>
                                <select name="resident_type" id="resident_type" class='form-select'>
									<option <?= ($gate_pass->resident_type == "Unit Owner")?'selected':'';?>>Unit Owner</option>
									<option <?= ($gate_pass->resident_type == "Tenant")?'selected':'';?>>Tenant</option>
                                </select>
                            </div>
                        </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                       
                            <label for="" class="text-required">Unit <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='unit' value='<?= $gate_pass->unit ?>' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                       
                            <label for="" class="text-required">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='contact_num' value='<?= $gate_pass->contact_num ?>' required>
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
					<?php foreach($gp_items as $gp_item){ ?> 
						<tr class="tr-data">
							<td>
								<input type="text"  name="item_num[]" value='<?= $gp_item->item_num ?>' class="input_0 form-control">
							</td>
							<td>
								<input type="text"  name="item_name[]" value='<?= $gp_item->item_name ?>' class="input_0 form-control">
							</td>
							<td>
								<input type="text"  name="item_qty[]" value='<?= $gp_item->item_qty ?>' class="input_0 form-control">
							</td>
							<td>
								<input type="text"  name="description[]" value='<?= $gp_item->description ?>' class="input_0 form-control">
							</td>
							<td>
								<i class="bi bi-dash-circle" id="first-row" style="cursor:pointer; " disabled></i>
							</td>
						</tr>	
					<?php	}	?>
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
				
						<label for="" class="text-required">Courier/Company <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='courier' value='<?= $gate_pass->courier ?>' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
				
						<label for="" class="text-required">Name <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='courier_name' value='<?= $gate_pass->courier_name ?>' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
				
						<label for="" class="text-required">Contact Details <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='courier_contact' value='<?= $gate_pass->courier_contact ?>' required>
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
		$("#gp-edit").off('submit').on('submit',function(e){
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

		$("select[name=sr_type]").val('gate-pass');

		$("select[name=sr_type]").on('change',function(){
			if($(this).val() == 'unit-repair')
			{
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-unit-repair";

			}
			else if($(this).val() == 'visitor-pass'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-visitor-pass";

			}
			else if($(this).val() == 'reservation'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-reservation";

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