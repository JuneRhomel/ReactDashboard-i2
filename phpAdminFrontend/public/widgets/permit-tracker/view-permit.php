<?php
	echo $location = null;
	
	$data = [
		'permit_id'=>$args[0]
	];
	$permit_result = $ots->execute('contracts','get-permits',$data);
	$permit = json_decode($permit_result);

	$data = [
		'table'=>'permit_updates',
		'identifier'=>'permit_id',
		'id'=> $args[0]
	];

	$permit_update_result = $ots->execute('contracts','get-updates',$data);
	$permit_updates = json_decode($permit_update_result);
	// print_r($permit_updates);

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
	'table'=>'permits',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>

<style>
</style>
<div class="main-container">
<div class="d-flex justify-content-between mb-3">
	<a onclick="history.back()"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $permit->permit_name;?></label></a>
	<?php if($role_access->update == true): ?>
		<a href='<?= WEB_ROOT ?>/contracts/edit-permit/<?= $args[0] ?>/Edit'  class='btn btn-sm btn-primary float-end btn-view-form px-5'>Edit</a>
	<?php endif; ?>
</div>

	<table class="table table-data table-bordered permits-and-contract-table border-table" >
		<tr>
			<th>Date Created</th><td><?php echo date('d-M-Y',$permit->created_on);?></td>
		</tr>
		<tr>
			<th>Permit Name</th><td><?php echo $permit->permit_name;?></td>
		</tr>
		<tr>
			<th>Permit Number</th><td><?php echo $permit->permit_number;?></td>
		</tr>
		<tr>
			<th>Status</th><td><?php echo $permit->status;?></td>
		</tr>
		<tr>
			<th>Date Issued</th><td><?php echo $permit->date_issued;?></td>
		</tr>
		<tr>
			<th>Renewable</th><td><?php echo $permit->permit_name;?></td>
		</tr>
		<tr>
			<th>Expiration Date</th><td><?php echo $permit->expiration_date;?></td>
		</tr>
		<tr>
			<th>Days to notify</th><td><?php echo $permit->days_to_notify;?></td>
		</tr>
		<tr>
			<th>Issuing Office</th><td><?php echo $permit->issuing_office;?></td>
		</tr>
		<tr>
			<th>Office Address</th><td><?php echo $permit->office_address;?></td>
		</tr>
		<tr>
			<th>Contact Person</th><td><?php echo $permit->contact_person;?></td>
		</tr>
		<tr>
			<th>Office Number</th><td><?php echo $permit->office_number;?></td>
		</tr>
		<tr>
			<th>File</th><td><?php echo $contract->file;?></td>
		</tr>
		<tr>
			<!-- <th></th><td><button type="button" class="btn btn-light btn-cancel">Cancel</button></td> -->
		</tr>
	</table>
	<br>
	<h3>History</h3>
	<div class="history">
		<table class='table table-data'>
			<tr>
				<th>Date Created</th>
				<th>Description</th>
				<th>Created By</th>
				<th>Permit Number</th>
				<th>Issued Date</th>
				<th>Expiration Date</th>
				<th>Download</th>
			</tr>
			<?php 
			foreach($permit_updates as $update){
				?>
				<tr>
					<td><?= date('d-M-Y',$update->created_on)?></td>
					<td><?= $update->description?></td>
					<td><?= $update->created_by?></td>
					<td><?= $update->permit_number?></td>
					<td><?= $update->date_issued?></td>
					<td><?= $update->expiration_date?></td>
					<td></td>
				</tr>
				<?php
			}
			?>
		</table>
		<div class="btn-group-buttons pull-right">
			<div class="d-flex flex-row-reverse" style="padding: 5px;">
				<button type="submit" class="btn btn-dark btn-primary btn-cancel px-5">Back</button>
			</div>
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


		$(".btn-cancel").off('click').on('click',function(){
			//loadPage('<?=WEB_ROOT;?>/location');
			window.location.href = '<?=WEB_ROOT;?>/contracts/permit-tracker?submenuid=permittracker';
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