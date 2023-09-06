<?php

	
?>
<div class="page-title float-right"><?= $args[1] ;?> Unit Repair</div>

<div class="bg-white rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' class="bg-white" id='ur-add' enctype="multipart/form-data">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/tenant/service-request?submenuid=service_request'>
			<input type="hidden" name='table'  id='id' value= 'unit_repair'>
			<input type="hidden" name='view_table'  id='id' value= 'view_unit_repair'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

				<div class="row forms">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                       
						<label for="" class="text-required">Service Request Category</label>
                            <select id="sr_type" name="sr_type" class='form-select'>
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
							<label for="" class="text-required">Tenant Name <span class="text-danger">*</span></label>
							<input name="requestor_name" type="hidden" required>
							<input id="name_id" type="text" class="form-control" placeholder="Search Tenant" required>
						</div>
                        <!-- <div class="form-group">
                            <label for="" class="text-required">Requestor Name <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='requestor_name' value='' required>
                        </div> -->
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            <label for="" class="text-required">Contact # <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='contact_num' value='' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                            <label for="" class="text-required">Email Address <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='email_add' value='' required>
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
                            <label for="" class="text-required">Priority Level <span class="text-danger">*</span></label>
                            <select name="priority_level" id="priority_level" class='form-select'>
								<option value="1">Priority 1</option>
								<option value="2">Priority 2</option>
								<option value="3">Priority 3</option>
								<option value="4">Priority 4</option>
								<option value="5">Priority 5</option>
							</select>
							<label class="text-danger text-required mt-2 p1-prio">Resolution Time is 24 hours</label>
							<label class="text-danger text-required mt-2 p2-prio">Resolution Time is 48 hours</label>
							<label class="text-danger text-required mt-2 p3-prio">Resolution Time is 72 hours</label>
							<label class="text-danger text-required mt-2 p4-prio">Resolution Time is 96 hours</label>
							<label class="text-danger text-required mt-2 p5-prio">Resolution Time is 120 hours</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 col-sm-8 mb-3">
                        <div class="form-group">
                           
                            <label for="" class="text-required">Description <span class="text-danger">*</span></label>
                            <input type="text" class='form-control' name='description' id="description" value='' required>
                        </div>
                    </div>
				</div>
				<div class="row">

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                           
                            <label class="text-required">Attachment </label>
							<input type="file" name="file[]" id="file" class='form-control' multiple> 
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group">
                       
                            <label for="" class="text-required">Request Type <span class="text-danger">*</span></label>
                            <select name="request_type" id="request_type" class='form-select'>
                                <option value="New">New</option>
                                <option value="Backjob">Backjob</option>
								<option value="Recurring">Recurring</option>
                            </select>
                        </div>
                    </div>
             </div>
			
			<div class="btn-group-form pull-right">

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

		$("#ur-add").off('submit').on('submit',function(e){
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

		$("select[name=sr_type]").val('unit-repair');
		
		$("select[name=sr_type]").on('change',function(){
			if($(this).val() == 'gate-pass')
			{
				window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-gate-pass";

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