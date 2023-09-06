<?php
    $data = [
		'id'=>$args[0],
        'view'=>'building_personnel_view'
	];
	$bp_result = $ots->execute('property-management','get-record',$data);
	$building_p = json_decode($bp_result);

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
	'table'=>'building_personnel',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>

	<div class="d-flex justify-content-between mb-3">
		<a onclick="history.back()"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $building_p->employee_name;?></label></a>
		<?php if($role_access->update == true): ?>
			<a href='<?= WEB_ROOT ?>/property-management/form-edit-personnel/<?= $args[0] ?>/Edit'  class='btn btn-sm btn-primary float-end btn-view-form px-5'>Edit</a>
		<?php endif; ?>
	</div>
	<table class="table table-data table-bordered property-management border-table text-capitalize" >
		<tr>
			<th>Employee Number</th><td><?php echo $building_p->employee_number;?></td>
		</tr>
		<tr>
			<th>Name</th><td><?php echo $building_p->employee_name;?></td>
		</tr>
		<tr>
			<th>Username</th><td><?php echo $building_p->username;?></td>
		</tr>
		<tr>
			<th>Email</th><td><?php echo $building_p->email;?></td>
		</tr>
		<tr>
			<th>Contact Number</th><td><?php echo $building_p->contact_number;?></td>
		</tr>
		<tr>
			<th>Home Address</th><td><?php echo $building_p->home_address;?></td>
		</tr>
		<tr>
			<th>Working Schedule</th><td><?php echo $building_p->working_schedule;?></td>
		</tr>
		<tr>
			<th>Working Hours</th><td><?php echo $building_p->working_hours;?></td>
		</tr>
		<tr>
			<th>Person To Contact In Case Of Emergency</th><td><?php echo $building_p->person_to_contact_in_case_of_emergency;?></td>
		</tr>
		<tr>
			<th>Relationship</th><td><?php echo $building_p->relationship;?></td>
		</tr>
		<tr>
			<th>Contact Number</th><td><?php echo $building_p->emergency_contact_number;?></td>
		</tr>
		
	</table>
		<div class="btn-group-buttons pull-right">
			<div class="d-flex flex-row-reverse" style="padding: 5px;">
				<button type="submit" class="btn btn-dark btn-primary btn-cancel px-5">Back</button>
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
			window.location.href = '<?=WEB_ROOT;?>/property-management/building-personnel?submenuid=location';
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