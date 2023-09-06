<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_move_in'
	];
	$move_in = $ots->execute('tenant','get-record',$data);
	$move_in = json_decode($move_in);

	$data = [
		'_id'=>$move_in->name,
        'view'=>'tenant'
	];
	$tenant = $ots->execute('tenant','get-record',$data);
	$tenant = json_decode($tenant);

	//get workers
	$data = [
		'view'=>'workers',
        'filters'=>[
            'rec_id' => $move_in->rec_id,
			'ref_table' => "move_in"
        ]
	];
	$workers = $ots->execute('tenant','get-records',$data);
	$workers = json_decode($workers);

	//get materials
	$data = [
		'view'=>'materials',
        'filters'=>[
            'rec_id' => $move_in->rec_id,
			'ref_table' => "move_in"
        ]
	];
	$materials = $ots->execute('tenant','get-records',$data);
	$materials = json_decode($materials);

	//get tools
	$data = [
		'view'=>'tools',
        'filters'=>[
            'rec_id' => $move_in->rec_id,
			'ref_table' => "move_in"
        ]
	];
	$tools = $ots->execute('tenant','get-records',$data);
	$tools = json_decode($tools);
?>
<div class="page-title float-right"><?= $args[1] ;?> Move-In</div>

<div class="bg-white rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id='mi-edit" class="bg-white">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/view-move-in/<?=$args[0]?>/View'>
			<input type="hidden" name='table'  id='id' value= 'move_in'>
			<input type="hidden" name='view_table'  id='id' value= 'view_move_in'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

				<div class="row forms gap-5">
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
						
						<label for="" class="text-required">Service Request Category</label>
							<select name="sr_type" id="sr_type" class='form-select'>
								<option value="unit-repair" <?= ($move_in->sr_type == "unit-repair")?'selected':'';?>>Unit Repair</option>
                                <option value="gate-pass"  <?= ($move_in->sr_type == "gate-pass")?'selected':'';?>>Gate Pass</option>
                                <option value="visitor-pass"  <?= ($move_in->sr_type == "visitor-pass")?'selected':'';?>>Visitor's Pass</option>
                                <option value="reservation"  <?= ($move_in->sr_type == "reservation")?'selected':'';?>>Reservation</option>
                                <option value="move-in"  <?= ($move_in->sr_type == "move-in")?'selected':'';?>>Move-In</option>
                                <option value="move-out"  <?= ($move_in->sr_type == "move-out")?'selected':'';?>>Move-Out</option>
                                <option value="work-permit"  <?= ($move_in->sr_type == "work-permit")?'selected':'';?>>Work Permit</option>
                            </select>
						</div>
					</div>

					<div class="d-flex align-items-center gap-3 col-3 col-sm-4 my-5">
						<div>
							<i class="fa-solid fa-circle-info fa-2x text-primary"></i>
						</div>
						<div>
							<button type="button" class="btn-information" onclick="$('#info-checklist').modal('show')">Move In Checklist</button>
						</div>
					</div>
				</div>

				<div class="row forms">
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
						
						<label for="" class="text-required">Date Of Move In <span class="text-danger">*</span></label>
						<input type="date" name='date' value="<?= $move_in->date?>" min="<?= date('Y-m-d')?>"  class="form-control" required>
						</div>
					</div>
				</div>
                
                <div class="row">
                    <div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Tenant Name <span class="text-danger">*</span></label>
							<input name="name" type="hidden" value="<?= $move_in->name; ?>" required>
							<input id="name_id" type="text" class="form-control" placeholder="Search Tenant" value="<?= $tenant->owner_name ?>"required>
						</div>

                        <!-- <div class="form-group">
							
                            <label for="" class="text-required">Requestor Name <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='name' value="<?= $move_in->name?>" required>
                        </div> -->
                    </div>

					<div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                        <label for="" class="text-required">Resident Type <span class="text-danger">*</span></label>
							<select name="resident_type" id="resident_type" class='form-select'>
								<option <?= ($move_in->resident_type == "Unit Owner")?'selected':'';?>>Unit Owner</option>
								<option <?= ($move_in->resident_type == "Tenant")?'selected':'';?>>Tenant</option>
							</select>
                        </div>
                    </div>

					<div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                        <label for="" class="text-required">Unit <span class="text-danger">*</span></label>
							<input type="text" class='form-control' name='unit' value="<?= $move_in->unit?>" required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
							
                            <label for="" class="text-required">Contact # <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='contact_num' value="<?= $move_in->contact_num?>" required>
                        </div>
                    </div>
                </div>

				<div class="d-flex align-items-center my-4 gap-2">
				<input type="checkbox" id="" name="items" value="items">
				<label for="" class="text-required"> Gate pass form moving out items <span class="text-danger">*</span></label>
				</div>

				<div><br></div>
					<h4>List Of Workers/Personnel</h4>

				<table class="table gatepass">
				<thead class="header-design">
					<tr>
						
						<th style="width:25%">Name</th>
						<th style="width:70%">Description</th>
						<th style="width:5%"></th>
					</tr>
				</thead>

				<tbody class="table-body">   
					<?php foreach($workers as $worker){ ?>   
						<tr class="tr-data">
						<input type="hidden" name="workers_id[]" value="<?=$worker->id?>" class="input_0 form-control">
							<td>
								<input type="text" name="workers_name[]" value="<?=$worker->name?>" class="input_0 form-control">
							</td>
							<td>
								<input type="text" name="workers_desc[]" value="<?=$worker->description?>" class="input_0 form-control">
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
				<h4>List Of Materials</h4>

				<table class="table gatepass">
				<thead class="header-design">
					<tr>
						
						<th style="width:25%">Quantity</th>
						<th style="width:70%">Description</th>
						<th style="width:5%"></th>
					</tr>
				</thead>

				<tbody class="table-body1">   
					<?php foreach($materials as $material){ ?>    
						<tr class="tr-data1">
						<input type="hidden" name="material_id[]" value="<?=$material->id?>" class="input_0 form-control">
							<td>
								<input type="text" name="material_qty[]" value="<?=$material->qty?>" class="input_0 form-control">
							</td>
							<td>
								<input type="text" name="material_desc[]"  value="<?=$material->description?>"class="input_0 form-control">
							</td>
							<td>
								<i class="bi bi-dash-circle" id="first-row" style="cursor:pointer; " disabled></i>
							</td>
						</tr>	
					<?php	}	?>
				</tbody>

			</table>
			<div class="d-flex">
				<button type="button" id="btn-add-item" class="btn btn-sm btn-add-item1 text-primary"> Add Item</button>
			</div>

			<div><br></div>
				<h4>List Of Tools</h4>

				<table class="table gatepass">
				<thead class="header-design">
					<tr>
						
						<th style="width:25%">Quantity</th>
						<th style="width:70%">Description</th>
						<th style="width:5%"></th>
					</tr>
				</thead>

				<tbody class="table-body2">    
					<?php foreach($tools as $tool){ ?>   
						<tr class="tr-data2">
						<input type="hidden" name="tools_id[]" value="<?=$tool->id?>" class="input_0 form-control">
							<td>
								<input type="text" name="tools_qty[]" value="<?=$tool->qty?>" class="input_0 form-control">
							</td>
							<td>
								<input type="text" name="tools_desc[]" value="<?=$tool->description?>" class="input_0 form-control">
							</td>
							<td>
								<i class="bi bi-dash-circle" id="first-row" style="cursor:pointer; " disabled></i>
							</td>
						</tr>	
					<?php	}	?>
				</tbody>

			</table>
			<div class="d-flex">
				<button type="button" id="btn-add-item" class="btn btn-sm btn-add-item2 text-primary"> Add Item</button>
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

	<div class="modal" tabindex="-1" role="dialog" id='info-checklist'>
		<div class="modal-lg modal-dialog modal-dialog-centered" role="document" style="max-width: 40%">
			<div class="modal-content px-1 pb-4 pt-2" style="border-radius: 10px 10px 10px 10px" >
				<div class="modal-header flex-wrap pb-0" style="border-bottom: 1px solid;">
					<div class="d-flex justify-content-between w-100">
						<h5 class="modal-title text-primary mb-3" style="font-weight: 600">Important</h5>
						<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#info-checklist").modal("hide")' aria-label="Close">
							<span aria-hidden="true"></span>
						</button>
					</div>
					<div class="my-2">
						<label class="text-required">1. All unpaid accountabilities of the tenant including pentalties and other charges shall be fort the account of the unit owner. </label>
					</div>
					<div class="my-2">
						<label class="text-required">2. The unit owner is enjoined to orient the Tenants on the House Rules and Regulations of the Condo Corp. </label>
					</div>
				</div>
				
				<div class="modal-body pt-0">
					<h4 class="modal-title text-primary align-center my-3" style="font-weight: 600">List of Requirements Prior to Move in</h4>
					<form action="<?=WEB_ROOT;?>/property-management/pm-update-stage?display=plain" method='post' id='form-update-stage' enctype="multipart/form-data">
						<div class="d-flex">
							<div class="col-6">
								<div class="d-flex my-2">
									<li class="requirements-bullet"></li>
									<label class="checklist-requirements">Pay All Accountabilities</label>
								</div>

								<div class="d-flex my-2">
									<li class="requirements-bullet"></li>
									<label class="checklist-requirements">Notarized Copy of the Lease Contract</label>
								</div>

								<div class="d-flex my-2">
									<li class="requirements-bullet"></li>
									<label class="checklist-requirements">Tenant Information Sheet</label>
								</div>

								<div class="d-flex my-2">
									<li class="requirements-bullet"></li>
									<label class="checklist-requirements">Fire Extinguisher/s in the Unit</label>
								</div>
							</div>
							<div class="col-6">
								<div class="d-flex my-2 text-wrap">
									<li class="requirements-bullet"></li>
									<label class="checklist-requirements">Updated SPA if Unit Owner is represented by representative</label>
								</div>

								<div class="d-flex my-2 text-wrap">
									<li class="requirements-bullet"></li>
									<label class="checklist-requirements">Checked Sprinkler Heads and Smoke Detector by OIC</label>
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-center mb-3 mt-5 gap-4 w-100">	
							<button type='button' class='btn btn-primary px-5'  onclick='$("#info-checklist").modal("hide")'>Proceed</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<script>
	$(document).ready(function(){
		$("#mi-edit").off('submit').on('submit',function(e){
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
						<input type="text" name="workers_name[]" class="input_0 form-control">
						</td>
						<td>
						<input type="text" name="workers_desc[]" class="input_0 form-control">
						</td>
						<td>
							<i class="bi bi-dash-circle" id="remove-row" style="cursor:pointer"></i>
						</td>
					</tr>
                `);
		});

		$('.btn-add-item1').on('click', function(e) {
			e.preventDefault();
			i++;
			
				$('.table-body1').append(`
					<tr class="tr-data1">
						<td>
						<input type="text" name="material_qty[]" class="input_0 form-control">
						</td>
						<td>
						<input type="text" name="material_desc[]" class="input_0 form-control">
						</td>
						<td>
							<i class="bi bi-dash-circle" id="remove-row" style="cursor:pointer"></i>
						</td>
					</tr>
                `);
		});
		
		$('.btn-add-item2').on('click', function(e) {
			e.preventDefault();
			i++;
			
				$('.table-body2').append(`
					<tr class="tr-data2">
						<td>
						<input type="text" name="tools_qty[]" class="input_0 form-control">
						</td>
						<td>
						<input type="text" name="tools_description[]" class="input_0 form-control">
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

		$("select[name=sr_type]").val('move-in');

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
			else if($(this).val() == 'reservation'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-reservation";

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