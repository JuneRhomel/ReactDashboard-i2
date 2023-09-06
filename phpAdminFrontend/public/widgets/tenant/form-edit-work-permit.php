<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_work_permit'
	];
	$work_permit = $ots->execute('tenant','get-record',$data);
	$work_permit = json_decode($work_permit);

	$data = [
		'_id'=>$work_permit->name,
        'view'=>'tenant'
	];
	$tenant = $ots->execute('tenant','get-record',$data);
	$tenant = json_decode($tenant);

	//get workers
	$data = [
		'view'=>'workers',
        'filters'=>[
            'rec_id' => $work_permit->rec_id,
			'ref_table' => "work_permit"
        ]
	];
	$workers = $ots->execute('tenant','get-records',$data);
	$workers = json_decode($workers);

	//get materials
	$data = [
		'view'=>'materials',
        'filters'=>[
            'rec_id' => $work_permit->rec_id,
			'ref_table' => "work_permit"
        ]
	];
	$materials = $ots->execute('tenant','get-records',$data);
	$materials = json_decode($materials);

	//get tools
	$data = [
		'view'=>'tools',
        'filters'=>[
            'rec_id' => $work_permit->rec_id,
			'ref_table' => "work_permit"
        ]
	];
	$tools = $ots->execute('tenant','get-records',$data);
	$tools = json_decode($tools);
?>

<div class="page-title float-right"><?= $args[1] ;?> Work Permit</div>

<div class="bg-white rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="wp-edit" class="bg-white">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/view-work-permit/<?=$args[0]?>/View'>
			<input type="hidden" name='table'  id='id' value= 'work_permit'>
			<input type="hidden" name='view_table'  id='id' value= 'view_work_permit'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Service Request Category</label>
							<select name="sr_type" id="sr_type" class='form-select'>
								<option value="unit-repair" <?= ($work_permit->sr_type == "unit-repair")?'selected':'';?>>Unit Repair</option>
                                <option value="gate-pass"  <?= ($work_permit->sr_type == "gate-pass")?'selected':'';?>>Gate Pass</option>
                                <option value="visitor-pass"  <?= ($work_permit->sr_type == "visitor-pass")?'selected':'';?>>Visitor's Pass</option>
                                <option value="reservation"  <?= ($work_permit->sr_type == "reservation")?'selected':'';?>>Reservation</option>
                                <option value="move-in"  <?= ($work_permit->sr_type == "move-in")?'selected':'';?>>Move-In</option>
                                <option value="move-out"  <?= ($work_permit->sr_type == "move-out")?'selected':'';?>>Move-Out</option>
                                <option value="work-permit"  <?= ($work_permit->sr_type == "work-permit")?'selected':'';?>>Work Permit</option>
                            </select>
                        </div>
                    </div>
                </div>

				<div class="row">
					<div class="col-12 col-sm-4 my-4">
							<div class="form-group">
							
								<label for="" class="text-required">Nature Of Work <span class="text-danger">*</span></label>
								<select name="nature_work" id="nature_work" class='form-select'>
									<option value="1" <?=($work_permit->nature_work==1)?'selected':''?>>Electrical</option>
									<option value="2" <?=($work_permit->nature_work==2)?'selected':''?>>Mechanical</option>
									<option value="3" <?=($work_permit->nature_work==3)?'selected':''?>>Civil Works</option>
									<option value="4" <?=($work_permit->nature_work==4)?'selected':''?>>Plumbing</option>
									<option value="5" <?=($work_permit->nature_work==5)?'selected':''?>>Pest Control</option>
									<option value="6" <?=($work_permit->nature_work==6)?'selected':''?>>Others</option>
								</select>
							</div>
						</div>
						<div class="col-12 col-sm-4 my-4">
							<div class="form-group">
							
								<label for="" class="text-required">Date <span class="text-danger">*</span></label>
								<input type="date" name='date' min="<?= date('Y-m-d')?>"  value="<?=$work_permit->date?>"class='form-control' required>
							</div>
						</div>

				</div>
                
                <div class="row">
                    <div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Tenant Name <span class="text-danger">*</span></label>
							<input name="name" type="hidden" value="<?= $work_permit->name; ?>" required>
							<input id="name_id" type="text" class="form-control" placeholder="Search Tenant" value="<?= $tenant->owner_name ?>"required>
						</div>

                        <!-- <div class="form-group">
                            <label for="" class="text-required">Requestor Name <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='name' value='<?=$work_permit->name?>' required>
                        </div> -->
                    </div>

                    <div class="col-12 col-sm-4 my-4">
							<div class="form-group">
								<label for="" class="text-required">Resident Type <span class="text-danger">*</span></label>
								<select name="resident_type" id="resident_type" class='form-select'>
									<option <?= ($work_permit->resident_type == "Unit Owner")?'selected':'';?>>Unit Owner</option>
									<option <?= ($work_permit->resident_type == "Tenant")?'selected':'';?>>Tenant</option>
								</select>
							</div>
						</div>

                    <div class="col-12 col-sm-4 my-4">
							<div class="form-group">
								<label for="" class="text-required">Unit <span class="text-danger">*</span></label>
								<input type="text" class='form-control' name='unit' value='<?= $work_permit->unit ?>' required>
							</div>
						</div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='contact_num' value='<?= $work_permit->contact_num ?>' required>
                        </div>
                    </div>
                </div>
				<div></div>
					<h4>Work Details</h4>
				<div class="row">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            
                            <label for="" class="text-required">Name Of Contractor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contractor_name" value='<?= $work_permit->contractor_name ?>'>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
							<label for="" class="text-required">Scope Of Work <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="scope_work"  value='<?= $work_permit->scope_work ?>'>
                        </div>
                    </div>
             	</div>

				 <div class="row">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            
                            <label for="" class="text-required">Name Of Person-In-Charge <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pic_name"  value='<?= $work_permit->pic_name ?>'>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
							<label for="" class="text-required">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pic_contact"  value='<?= $work_permit->pic_contact ?>'>
                        </div>
                    </div>
             	</div>

				 <div class="row">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            
                            <label for="" class="text-required">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start_date" min="<?= date('Y-m-d')?>"  value='<?= $work_permit->start_date ?>' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
							<label for="" class="text-required">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="end_date" min="<?= date('Y-m-d')?>"  value='<?= $work_permit->end_date ?>' required>
                        </div>
                    </div>
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
<script>
	$(document).ready(function(){
		$("#wp-edit").off('submit').on('submit',function(e){
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

		$("select[name=sr_type]").val('work-permit');

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
			else if($(this).val() == 'move-in'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-move-in";

			}
			else if($(this).val() == 'move-out'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-move-out";

			}
			else{
				location.reload();
			}
		});
	});
</script>