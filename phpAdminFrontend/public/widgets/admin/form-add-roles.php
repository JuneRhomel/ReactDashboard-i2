<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white rounded-sm">
		<form method="post" action="<?php echo WEB_ROOT;?>/property-management/save-record?display=plain" class="bg-white" id="form-roles-save" enctype="multipart/form-data">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/admin/roles?submenuid=roles'>
			<input type="hidden" name='table' value= 'roles'>
			<input type="hidden" name='duplicate_check' value= 'role_name'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>
			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">	
					<div class="form-group">
						<label for="" class="text-required">Role Name <span class="text-danger">*</span></label>
						<input name="role_name" id="role_name" type="text" class="form-control" required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">	
					<div class="form-group">
						<label for="" class="text-required">Role Description</label>
						<input name="description" id="description" type="text" class="form-control">
					</div>
				</div>
			</div>
			<div class="btn-group-buttons pull-right">
				<div class="mb-3 float-end" style="padding: 5px;">
					<button type="submit" class="btn btn-dark btn-primary btn-save px-5">Add</button>
					<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
				</div>
			</div>
			
				<input type="hidden" value="<?php echo $args[0] ?? '';?>" name="id">
			
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){

		$(".btn-cancel").off('click').on('click',function(){
			Swal.fire({
					text: "This ticket will be deleted once you exit, are you sure you want to exit?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes',
				}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					window.location.href = '<?php echo WEB_ROOT;?>/property-management/cm?submenuid=cm';
				}
			})
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

		$("#form-roles-save").on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				dataType: 'JSON',
				data: new FormData($(this)[0]),
				contentType: false,
				processData: false,
				beforeSend: function(){
				},
				success: function(data){
					if(data.success == 1)
					{
						show_success_modal($('input[name=redirect]').val());
					}else{
						alert(data.description);
					}
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});

		$("input[id=equipment_location]").autocomplete({
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
					url: '<?php echo WEB_ROOT;?>/location/search?display=plain',
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

		$("input[id=equipment_id]").autocomplete({
			autoSelect : true,
			autoFocus: true,
			search: function(event, ui) { $('.spinner').show();	},
			response: function(event, ui) {	$('.spinner').hide(); },
			source: function( request, response ) {
				var category = $("select[name=category_id]").val();

				$.ajax({
					url: '<?=WEB_ROOT;?>/property-management/get-records?display=plain',
					dataType: "json",
					type: 'post',
					data: {	
						view: 'view_equipments',
						auto_complete:true,
						term:request.term, filter_field:'category', filter:category
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
				$('input[name="location"]').val(ui.item.location);
				return false;
			},
			change: function(event, ui){
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
			}
		});
		
		$("input[id=assigned_personnel_id]").autocomplete({
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
						view: 'building_personnel_view',
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
				return false;
			},
			change: function(event, ui){
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
			}
		});

		$("input[id=service_provider_id]").autocomplete({
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
						view: 'service_providers_view',
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
				return false;
			},
			change: function(event, ui){
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
			}
		});

		$("select[name=equipment_type]").on('change',function(){
			if($(this).val().toLowerCase() == 'property')
			{
				$(".equipment-container").addClass('d-none');
				$("input[name=parent_equipment]").val('');
				$("#parent_equipment_id").val(0);
			}else{
				$(".equipment-container").removeClass('d-none');
			}
		});

		$("input[id=assigned_personnel_id]").autocomplete({
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
						view: 'building_personnel_view',
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
				return false;
			},
			change: function(event, ui){
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
			}
		});
	});
</script>