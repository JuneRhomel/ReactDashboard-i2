<?php
	echo $location = null;
	
	$data = [
		'contract_id'=>$args[0]
	];
	$contract_result = $ots->execute('contracts','get-contracts',$data);
	$contract = json_decode($contract_result);
    // print_r($contract);
?>
<!-- <a href='<?= WEB_ROOT ?>/contracts/contract-tracker?submenuid=contractracker'  class='btn '>Back</a>
<a href='<?= WEB_ROOT ?>/contracts/renew-contract/<?= $args[0] ?>/Edit'  class='btn btn-info'>Renew</a> -->
<!-- <div class="page-title float-right"><?= $args[1] ;?> Contract</div> -->

<div class="bg-white rounded-sm">
		<?php $contract->id?>
		<form action="<?= WEB_ROOT ?>/contracts/update-permit-contracts?display=plain" method='post' id='contract-add' class="bg-white">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/contracts/view-contracts/'>
			<input type="hidden" name='table'  id='id' value= 'contracts'>
			<input type="hidden" name='view_table'  id='id' value= 'view_contracts'>
			<input type="hidden" name='update_table'  id='id' value= 'contract_updates'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Date Created </label>
						<input type="text" class="form-control" name="created_on" value="<?php echo date('Y-m-d h:i:s',time());?>" required readonly>
						<input type="hidden" class="form-control" value="<?php echo date('H:00');?>" id="hidden_time">	
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Contract Name <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='contract_name' value='<?= $contract->contract_name?>' required>
						
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
						<label for="" class="text-required">Contract Number <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='contract_number' value='<?= $contract->contract_number?>' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Status <span class="text-danger">*</span></label>
						<select name="status" id="status" class='form-select'>
							<option <?= ($contract->status == 'active')? 'selected' : ''?> value="active">Active</option>
							<option <?= ($contract->status == 'inactive')? 'selected' : ''?> value="inactive">Inactive</option>
						</select>
					</div>
				</div>
				
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Date Issued  <span class="text-danger">*</span></label>
						<input type="date" name='effectivity_date' value='<?= $contract->effectivity_date?>' required class='form-control'>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Renewable <span class="text-danger">*</span></label>
						<select name="renewable" id="renewable" class='form-select'>
							<option <?= ($contract->renewable == 'yes')? 'selected' : ''?> value="yes">Yes</option>
							<option <?= ($contract->renewable == 'no')? 'selected' : ''?> value="no">No</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Expiration Date  <span class="text-danger">*</span></label>
						<input type="date" class='form-control' name='expiration_date' value='<?= $contract->expiration_date?>' required>
					</div>
				</div>
				

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Days to notify <span class="text-danger">*</span></label>
						<input type="number" name='days_to_notify' class='form-control' value='<?= $contract->days_to_notify?>' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Negotiating Party <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='negotiating_party' value='<?= $contract->days_to_notify?>' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Type of Contract <span class="text-danger">*</span></label>
						<select name="type_of_contract" id="status" class='form-select'>
							<option <?= ($contract->type_of_contract == 'Service Contract')? 'selected' : ''?> value="Service Contract">Service Contract</option>
							<option <?= ($contract->type_of_contract == 'Lease Contract')? 'selected' : ''?> value="Lease Contract">Lease Contract</option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="col-12 mb-3 my-4">
			<br>
				<label for="" class="text-required">Office Address <span class="text-danger">*</span></label>
				<input type="text" name='office_address' class='form-control value='<?= $contract->office_address?>' required>
			</div>

			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Contact Person <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='contact_person' value='<?= $contract->contact_person?>' required>
					</div>
				</div>
				<div class="col-12 col-sm-4 my-4">
					<div class="form-group">
					<br>
						<label for="" class="text-required">Office Number <span class="text-danger">*</span></label>
						<input type="text" name='office_number'  class='form-control' value='<?= $contract->contact_person?>' required>
					</div>
				</div>
			</div>
			<div class="col-12 mb-3 my-4">
			<br>
				<label for="" class="text-required">Attachment: </label>
				<input type="file" class="form-control" name="file" multiple>
			</div>
			
			<div class="btn-group-buttons pull-right">
				<div class="mb-3 float-end">
					<button type="submit" class="btn btn-dark btn-primary px-5">Add</button>
					<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
				</div>
			</div>
				<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
		</form>
	</div>

<script>
	$(document).ready(function(){

		var currentDate = new Date();
  		var currentFormattedDate = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1).toString().padStart(2, '0') + '-' + currentDate.getDate().toString().padStart(2, '0');
		$('input[name=expiration_date]').attr('min', currentFormattedDate);

		$("#contract-add").off('submit').on('submit',function(e){
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
						redirect = "<?= WEB_ROOT?>/contracts/view-contracts/"+data.id;
						show_success_modal(redirect);
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
			Swal.fire({
					text: "This information will be deleted once you exit, are you sure you want to exit?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes',
				}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					window.location.href = '<?php echo WEB_ROOT;?>/contracts/contract-tracker?submenuid=contractracker';
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
	});
</script>


<?php exit();?>

<div class="grid lg:grid-cols-1 grid-cols-1 title">
    <form action="<?= WEB_ROOT ?>/contracts/update-permit-contracts?display=plain" method='post'>
        
        <table class="table table-striped permits-and-contract-table" >
            <tr>
                <th>Contract Name</th>
                <td>
                    <input type="text" name='contract_name' value='<?= $contract->contract_name?>' required>
                </td>
            </tr>
            <tr>
                <th>Contract Number</th>
                <td>
                    <input type="text" name='contract_number' value='<?= $contract->contract_number?>' required>
                </td>
            </tr>
            <tr>
                <th>Effectivity Date</th>
                <td>
                    <input type="date" name='effectivity_date' value='<?= $contract->effectivity_date?>' required>
                </td>
            </tr>
            <tr>
                <th>Renewable </th>
                <td>
                    <select name="renewable" id="renewable">
                        <option <?= ($contract->renewable == 'yes')? 'selected' : ''?> value="yes">Yes</option>
                        <option <?= ($contract->renewable == 'no')? 'selected' : ''?> value="no">No</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Expiration Date</th>
                <td>
                    <input type="date" name='expiration_date' value='<?= $contract->expiration_date?>' required>
                </td>
            </tr>
            <tr>
                <th>Days to notify</th>
                <td>
                    <input type="number" name='days_to_notify' value='<?= $contract->days_to_notify?>' required>
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <select name="status" id="status">
                        <option <?= ($contract->status == 'active')? 'selected' : ''?> value="active">Active</option>
                        <option <?= ($contract->status == 'inactive')? 'selected' : ''?> value="inactive">Inactive</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Negotiating Party</th>
                <td>
                    <input type="text" name='negotiating_party' value='<?= $contract->negotiating_party?>' required>
                </td>
            </tr>
            <tr>
                <th>Type of Contract <?= $contract->type_of_contract?></th>
                <td>
                    <select name="type_of_contract" id="status">
                        <option <?= ($contract->type_of_contract == 'Type1')? 'selected' : ''?> value="Type1">Type1</option>
                        <option <?= ($contract->type_of_contract == 'Type2')? 'selected' : ''?> value="Type2">Type2</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Office Address</th>
                <td>
                    <input type="text" name='office_address' value='<?= $contract->office_address?>' required>
                </td>
            </tr>
            <tr>
                <th>Contact Person</th>
                <td>
                    <input type="text" name='contact_person' value='<?= $contract->contact_person?>' required>
                </td>
            </tr>
            <tr>
                <th>Office Number</th>
                <td>
                    <input type="text" name='office_number' value='<?= $contract->office_number?>' required>
                </td>
            </tr>
            <tr>
                <th>File</th>
                <td>
                    <input type="file" name='file'>
                </td>
            </tr>
            <tr>
                <th></th><td><button type="submit" class="btn btn-dark btn-primary">Add</button></td>
            </tr>
        </table>
	</form>
</div>