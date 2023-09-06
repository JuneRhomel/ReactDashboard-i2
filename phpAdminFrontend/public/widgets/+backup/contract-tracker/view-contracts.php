<?php
	echo $location = null;
	$data = [
		'contract_id'=>$args[0]
	];
	$contract_result = $ots->execute('contracts','get-contracts',$data);
	$contract = json_decode($contract_result);
	$data = [
		'table'=>'contract_updates',
		'identifier'=>'contract_id',
		'id'=> $args[0]
	];

	$contract_update_result = $ots->execute('contracts','get-updates',$data);
	$contract_updates = json_decode($contract_update_result);

	// p_r($contract_updates);
	
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
	'table'=>'contracts',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>
<div class="main-container">
<div class="d-flex mb-3">
	<div class="d-flex" style="width: 100%">
		<a onclick="history.back()"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $contract->contract_name;?></label></a>
	</div>
	<div class="d-flex flex-row-reverse gap-1" style="width: 100%">
		<?php if($role_access->update == true): ?>
			<a href='<?= WEB_ROOT ?>/contracts/edit-contract/<?= $args[0] ?>/Edit'  class='btn btn-primary float-end btn-view-form px-5'>Edit</a>
		<?php endif; ?><!-- <a href='<?= WEB_ROOT ?>/contracts/renew-contracts/<?= $args[0] ?>' class='btn btn-info float-end btn-view-form px-5'>Renew</a> -->
	</div>
</div>

<style>
	/* .permits-and-contract-table{
		width:70vmin;
	}
	.color-table th{
		color:var(--primary-color)
	} */
</style>
<div class="grid lg:grid-cols-1 grid-cols-1 title">
<table class="table table-data table-bordered permits-and-contract-table border-table" >
		<tr>
			<th>Date Created</th><td><?php echo date('d-M-Y',$contract->created_on);?></td>
		</tr>
		<tr>
			<th>Contract Name</th><td><?php echo $contract->contract_name;?></td>
		</tr>
		<tr>
			<th>Effectivity Date	</th><td><?php echo $contract->effectivity_date;?></td>
		</tr>
		<tr>
			<th>Renewable</th><td><?php echo $contract->renewable;?></td>
		</tr>
		<?php
			$remaining_days = compute_days_to_expire($contract->expiration_date);
		?>
		<tr>
			<th>Expiration Date</th><td ><?php echo $contract->expiration_date;?></td>
		</tr>
		<tr>
			<th>Days to Expire</th><td <?= ($remaining_days < 0)? 'class="text-danger"':''; ?> ><?= $remaining_days ?></td>
		</tr>
		<tr>
			<th>Days to notify</th><td <?= ($remaining_days < $contract->days_to_notify)? 'class="text-warning"':''; ?>  ><?php echo $contract->days_to_notify;?></td>
		</tr>
		<tr>
			<th>Status</th><td><?php echo $contract->status;?></td>
		</tr>
		<tr>
			<th>Negotiating Party</th><td><?php echo $contract->negotiating_party;?></td>
		</tr>
		<tr>
			<th>Type of Contract</th><td><?php echo $contract->type_of_contract;?></td>
		</tr>
		<tr>
			<th>Office Address</th><td><?php echo $contract->office_address;?></td>
		</tr>
		<tr>
			<th>Contact Person</th><td><?php echo $contract->contact_person;?></td>
		</tr>
		<tr>
			<th>Office Number</th><td><?php echo $contract->office_number;?></td>
		</tr>
		<tr>
			<th>File</th><td><?php echo $contract->file;?></td>
		</tr>
	</table>
</div>
<h3>History</h3>
<div class="history">
	<table class='table table-data'>
		<tr>
			<th>Date Created</th>
			<th>Created By</th>
			<th>Contract Number</th>
			<th>Effectivity Date</th>
			<th>Expiration Date</th>
			<th>Download</th>
		</tr>
		<?php 
		foreach($contract_updates as $update){
			?>
			<tr>
				<td><?= date('d-M-Y',$update->created_on)?></td>
				<td><?= $update->created_by?></td>
				<td><?= $update->contract_number?></td>
				<td><?= $update->effectivity_date?></td>
				<td><?= $update->expiration_date?></td>
				<td></td>
			</tr>
			<?php
		}
		?>
	</table>
</div>
	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class="btn btn-dark btn-primary btn-cancel px-5">Back</button>
		</div>
	</div>

<?php
$view = 'contract_updates';
 ?>
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
			window.location.href = '<?=WEB_ROOT;?>/contracts/contract-tracker?submenuid=contractracker';
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

<?php exit();?>

	<div class="p-4 rounded-sm">
		<?php $contract->id?>
		<form method="post" action="<?=WEB_ROOT;?>/location/save?display=plain"  id="form-location">
			<div class="row forms">
				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label>Date Created </label>
						<input type="text" class="form-control" name="date_created" value="<?php echo date('Y-m-d h:i:s',$contract->created_on);?>" required readonly>
						<input type="hidden" class="form-control" value="<?php echo date('H:00');?>" id="hidden_time">	
					</div>
				</div>
				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Contract Name</label>
						<span class='form-control'><?=$contract->contract_name ?? '&nbsp;' ?></span>
						
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Contract Number</label>
						<span class='form-control'><?=$contract->contract_number ?? '&nbsp;' ?></span>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Status</label>
						<span class='form-control'><?=$contract->status ?? '&nbsp;' ?></span>
					</div>
				</div>
				
				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label>Date Issued </label>
						<span class='form-control'><?=$contract->date_issued ?? '&nbsp;' ?></span>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Renewable</label>
						<span class='form-control'><?=$contract->renewable ?? '&nbsp;' ?></span>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label>Expiration Date </label>
						<span class='form-control'><?=$contract->expiration_date ?? '&nbsp;'?></span>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Days Before Expiration</label>
						<span class='form-control'><?=$contract->dayes_before_expiration ?? '&nbsp;' ?></span>
					</div>
				<div class="col-12 col-sm-4">
					
					<div class="form-group">
						<label>Expiration Dat1e </label>
						<span class='form-control'><?=$contract->expiration_date ?? '&nbsp;'?>( ''days to expire)</span>
					</div>
				</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Days to notify</label>
						<span class='form-control'><?=$contract->days_to_notify ?? '&nbsp;'?></span>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Negotiating Party</label>
						<span class='form-control'><?=$contract->negotitating_party ?? '&nbsp;' ?></span>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Types of Contract</label>
						<span class='form-control'><?=$contract->type_of_contract ?? '&nbsp;'?></span>
					</div>
				</div>
			</div>
			
			<div class="form-group mb-2">
				<label for="" class="text-required">Office Address</label>
				<span class='form-control'><?=$contract->office_address ?? '&nbsp;'?></span>
			</div>

			<div class="row forms">
				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Contact Person</label>
						<span class='form-control'><?=$contract->contact_person ?? ' ' ?></span>
					</div>
				</div>
				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="" class="text-required">Office Number</label>
						<span class='form-control'><?=$contract->office_number ?></span>
					</div>
				</div>
			</div>
			<div class="col-12 mb-3">
				<label>Attachment </label>
				<input type="file" class="form-control" name="upload[]" multiple>
			</div>
			<div class="btn-group pull-right">
				<!-- <button class="btn btn-primary">Submit</button> -->
				<button type="button" class="btn btn-light btn-cancel">Cancel</button>
			</div>
				<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
		</form>
	</div>
</div>