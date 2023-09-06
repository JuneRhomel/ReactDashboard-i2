<?php
	 $data = [
		'id'=>$args[0],
        'view'=>'view_unit_repair'
	];
	$unit_repair = $ots->execute('tenant','get-record',$data);
	$unit_repair = json_decode($unit_repair);

	$data = [
		'_id'=>$unit_repair->requestor_name,
        'view'=>'tenant'
	];
	$tenant = $ots->execute('tenant','get-record',$data);
	$tenant = json_decode($tenant);
?>
<div class="page-title float-right"><?= $args[1] ;?> Unit Repair</div>

<div class="bg-white rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="ur-edit" class="bg-white">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/view-unit-repair/<?=$args[0]?>/View'>
			<input type="hidden" name='table'  id='id' value= 'unit_repair'>
			<input type="hidden" name='view_table'  id='id' value= 'view_unit_repair'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
						<label for="" class="text-required">Service Request Category</label>
                            <select id="sr_type" name="sr_type" class='form-select' disabled>
                                <option value="unit-repair" <?= ($unit_repair->sr_type == "unit-repair")?'selected':'';?>>Unit Repair</option>
                                <option value="gate-pass"  <?= ($unit_repair->sr_type == "gate-pass")?'selected':'';?>>Gate Pass</option>
                                <option value="visitor-pass"  <?= ($unit_repair->sr_type == "visitor-pass")?'selected':'';?>>Visitor's Pass</option>
                                <option value="reservation"  <?= ($unit_repair->sr_type == "reservation")?'selected':'';?>>Reservation</option>
                                <option value="move-in"  <?= ($unit_repair->sr_type == "move-in")?'selected':'';?>>Move-In</option>
                                <option value="move-out"  <?= ($unit_repair->sr_type == "move-out")?'selected':'';?>>Move-Out</option>
                                <option value="work-permit"  <?= ($unit_repair->sr_type == "work-permit")?'selected':'';?>>Work Permit</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 col-sm-4 my-4">
						<div class="form-group">
							<label for="" class="text-required">Tenant Name <span class="text-danger">*</span></label>
							<input name="requestor_name" type="hidden" value="<?= $unit_repair->requestor_name; ?>" required>
							<input id="name_id" type="text" class="form-control" placeholder="Search Tenant" value="<?= $tenant->owner_name ?>"required>
						</div>
                        <!-- <div class="form-group">
                            <label for="" class="text-required">Tenant Name <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='requestor_name' value='' required>
                        </div> -->
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            <label for="" class="text-required">Contact # <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='contact_num' value='<?= $unit_repair->contact_num; ?>' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            <label for="" class="text-required">Email Address <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='email_add' value='<?= $unit_repair->email_add; ?>' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Unit <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='unit' value='<?= $unit_repair->unit; ?>' required>
                        </div>
                    </div>

					<div class="col-12 col-sm-4 my-4">
						<div class="form-group">
                            <label for="" class="text-required">Priority Level <span class="text-danger">*</span></label>
                            <select name="priority_level" id="priority_level" class='form-select'>
								<option value="1">Priority 1</option>
								<option value="2">Priority 2</option>
								<option value="3">Priority 3</option>
								<option value="4">Priority 4</option>
								<option value="5">Priority 5</option>
							</select>
							<label class="text-danger text-required mt-2 p1-prio active-label">Resolution Time 24 Days</label>
							<label class="text-danger text-required mt-2 p2-prio">Resolution Time 48 hours</label>
							<label class="text-danger text-required mt-2 p3-prio">Resolution Time 72 hours</label>
							<label class="text-danger text-required mt-2 p4-prio">Resolution Time 96 hours</label>
							<label class="text-danger text-required mt-2 p5-prio">Resolution Time 120 hours</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 mb-3 my-4">
                        <div class="form-group">
                            
                            <label for="" class="text-required">Description <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='description' value='<?= $unit_repair->description; ?>' required>
                        </div>
                    </div>

				</div>
				<div class="row">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            
                            <label class="text-required">Attachment: <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="file" multiple>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                        
                            <label for="" class="text-required">Request Type <span class="text-danger">*</span></label>
                            <select name="request_type" id="request_type" class='form-select'>
                                <option value="New" <?= ($unit_repair->request_type=="Type 1")?'selected':'' ?>>New</option>
                                <option value="Backjob" <?= ($unit_repair->request_type=="Type 2")?'selected':'' ?>>Backjob</option>
								<option value="Recurring" <?= ($unit_repair->request_type=="Type 3")?'selected':'' ?>>Recurring</option>
                            </select>
                        </div>
                    </div>
             </div>
			
			<div class="btn-group-form pull-right">
                <br>
				<div class="d-flex justify-content-end gap-4">
				<button type="submit" class="btn btn-dark btn-primary px-5">Save</button>
				<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
			</div>
			</div>
				<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
		</form>
	</div>
<script>
	$(document).ready(function(){
		$("#ur-edit").off('submit').on('submit',function(e){
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
		$("select[name=sr_type]").val('unit-repair');
		
		$("select[name=sr_type]").on('change',function(){
			if($(this).val() == 'gate-pass')
			{
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
			else if($(this).val() == 'work-permit'){
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-edit-work-permit";

			}
			else{
				location.reload();
			}
		});

		$(".p2-prio").hide();
		$(".p3-prio").hide();
		$(".p4-prio").hide();
		$(".p5-prio").hide();

		$('select[name=priority_level]').on('click', function(e) {
			if($(this).val() == '1')
			{
				$(".p1-prio").show();
				$(".p2-prio").hide();
				$(".p3-prio").hide();
				$(".p4-prio").hide();
				$(".p5-prio").hide();
				
			}
			else if($(this).val() == '2')
			{
				$(".p2-prio").show();
				$(".p1-prio").hide();
				$(".p3-prio").hide();
				$(".p4-prio").hide();
				$(".p5-prio").hide();

			}
			else if($(this).val() == '3')
			{
				$(".p3-prio").show();
				$(".p1-prio").hide();
				$(".p2-prio").hide();
				$(".p4-prio").hide();
				$(".p5-prio").hide();

			}
			else if($(this).val() == '4')
			{
				$(".p4-prio").show();
				$(".p1-prio").hide();
				$(".p2-prio").hide();
				$(".p3-prio").hide();
				$(".p5-prio").hide();

			}
			else if($(this).val() == '5')
			{
				$(".p5-prio").show();
				$(".p1-prio").hide();
				$(".p2-prio").hide();
				$(".p3-prio").hide();
				$(".p4-prio").hide();

			}
		});

	});
</script>