<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_reservation'
	];
	$reservation = $ots->execute('tenant','get-record',$data);
	$reservation = json_decode($reservation);


//PERMISSIONS
//get user role
$data = [	
	'view'=>'users'
];
$user = $ots->execute('property-management','get-record',$data);
$user = json_decode($user);

//check if has access
$data = [
	'role_id'=>$user->role_type,
	'table'=>'sr',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>
<div class="main-container">

	<div class="d-flex justify-content-between mb-3">
		<a onclick="window.location.href = '<?=WEB_ROOT;?>/tenant/service-request?submenuid=service_request'"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $reservation->tenant_name?></a>
		<?php if($role_access->update == true): ?>
			<a href='<?= WEB_ROOT ?>/tenant/form-edit-reservation/<?= $args[0] ?>/Edit'  class='btn btn-sm btn-primary float-end btn-view-form px-5'>Edit</a>
			<?php endif; ?>
		</div>
		<table class="table table-data table-bordered property-management border-table text-capitalize" >
			<tr>
				<th>Type</th><td><?php echo $reservation->sr_type?></td>
			</tr>
			<tr>
				<th>Amenity</th><td><?php echo $reservation->amenity;?></td>
			</tr>
			<tr>
				<th>Date</th><td><?php echo $reservation->date;?></td>
			</tr>
			<tr>
				<th>Time</th><td><?php echo $reservation->time;?></td>
		</tr>
		<tr>
			<th>Requestor Name</th><td><?php echo $reservation->tenant_name;?></td>
		</tr>
		<tr>
			<th>Resident Type</th><td><?php echo $reservation->resident_type;?></td>
		</tr>
		<tr>
			<th>Unit Number</th><td><?php echo $reservation->unit;?></td>
		</tr>
		<tr>
			<th>Contact Number</th><td><?php echo $reservation->contact_num;?></td>
		</tr>
		<tr>
			<th>Purpose Of Reservation</th><td><?php echo $reservation->purpose;?></td>
		</tr>
		<tr>
			<th>Number Of Guest</th><td><?php echo $reservation->number_guest;?></td>
		</tr>
		
	</table>
	
	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class="btn btn-dark btn-primary btn-cancel px-5">Back</button>
		</div>
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


		$(".btn-cancel").on('click',function(){
			//loadPage('<?=WEB_ROOT;?>/location');
			window.location.href = '<?=WEB_ROOT;?>/tenant/service-request?submenuid=service_request';
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