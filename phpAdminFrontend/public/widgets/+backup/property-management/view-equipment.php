<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_equipments'
	];
	$equipment_result = $ots->execute('property-management','get-record',$data);
	$equipment = json_decode($equipment_result);

	$data = [
		'reference_table' => 'equipments',
		'reference_id' => $args['0']
	];
	$attachments = $ots->execute('files','get-attachments',$data);
	$attachments = json_decode($attachments);

	//comments
	$data = [
		'id' => $args[0],
		'table' => 'equipment_updates',
	];
	$comments = $ots->execute('property-management','get-updates',$data);
	$comments = json_decode($comments);
	// var_dump($comments);

	//PERMISSIONS
	$table='equipments';
	//get user role
	$data = [	
		'view'=>'users'
	];
	$user = $ots->execute('property-management','get-record',$data);
	$user = json_decode($user);

	//check if has access
	$data = [
		'role_id'=>$user->role_type,
		'table'=>$table,
		'view'=>'role_rights'

	];
	
	$role_access = $ots->execute('form','get-role-access',$data);
	$role_access = json_decode($role_access);
	// var_dump($role_access);
?>

<style>
	.swal-wide{
    width:850px !important;
}
</style>

<div class="main-container ">


	<div class="d-flex justify-content-between mb-3">
		<a onclick="history.back()"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $equipment->equipment_name;?></label></a>
		<?php if($role_access->update == true): ?>
			<a href='<?= WEB_ROOT ?>/property-management/form-edit-equipment/<?= $args[0] ?>/Edit'  class='  float-end  '>
			<button class="btn main-btn">Edit</button>
			</a>
		<?php endif; ?>
	</div>
	<table class="table table-data table-bordered property-management border-table" >
		<tr>
			<th>Name</th><td><?php echo $equipment->equipment_name;?></td>
		</tr>
		<tr>
			<th>Category</th>
			<td><?php echo $equipment->category;?></td>
		</tr>
		<tr>
			<th>Type</th><td><?php echo $equipment->type;?></td>
		</tr>
		<tr>
			<th>Area Served</th><td><?php echo $equipment->area_served;?></td>
		</tr>
		<tr>
			<th>Brand</th><td><?php echo $equipment->brand;?></td>
		</tr>
		<tr>
			<th>Model</th><td><?php echo $equipment->model;?></td>
		</tr>
		<tr>
			<th>Serial #</th><td><?php echo $equipment->serial_number;?></td>
		</tr>
		<tr>
			<th>Capacity</th><td><?php echo $equipment->capacity;?></td>
		</tr>
		<tr>
			<th>Date Installed</th><td><?php echo $equipment->date_installed;?></td>
		</tr>
		<tr>
			<th>Asset #</th><td><?php echo $equipment->asset_number;?></td>
		</tr>
		<tr>
			<th>Critical Equipments</th><td><?php echo ($equipment->critical_equipment==0)?'No':'Yes';?></td>
		</tr>
		<tr>
			<th>Service Provider</th><td><?php echo $equipment->sp_name;?></td>
		</tr>
		<tr>
			<th>Maintenance Frequency</th><td><?php echo $equipment->maintenance_frequency?></td>
		</tr>
	</table>
	
	<div class="d-flex justify-content-between my-4">
		<span style='font-size:20px'>Attachments</span> 
		<?php if($role_access->upload == true): ?>
			<button class='btn btn-lg main-btn ' onclick="show_modal_upload(this)" update-table='equipment_updates' reference-table='equipments' reference-id='<?php echo $args[0]; ?>' id='<?php echo $args[0]; ?>'>Upload</button>
		<?php endif; ?>
	</div>
	<?php 
	
	?>
	<table class="table table-data table-bordered property-management border-table" >
		<tr>
			<th>Created By</th>
			<th>Document</th>
			<th>Date Created</th>
		</tr>
		<?php 

			foreach($attachments as $attachment){
				?>
				<tr>
					<td><?= $attachment->created_by_full_name?></td>
					<td><a href='<?= $attachment->attachment_url ?>' ><?= $attachment->filename ?></a></td>
					<td><?= date('Y-m-d', $attachment->created_on);?></td>
					
				</tr>
				<?php
			}
		?>
	</table>

	<div class="d-flex justify-content-between my-4">
		<span style='font-size:20px'>Comments And Updates</span> 
		<?php if($role_access->comment == true): ?>
			<button class='btn btn-lg main-btn ' style="padding: 5px 20px 5px 20px;" onclick="show_modal_update(this)" update-table='equipment_updates' reference-table='equipments' reference-id='<?php echo $args[0]; ?>' id='<?php echo $args[0]; ?>'>+ Add</button>
		<?php endif; ?>
	</div>
	<table class="table table-data table-bordered property-management border-table" >
		<table class="table table-data table-bordered property-management border-table" >
			<tr>
				<th>Name</th>
				<th>Comment</th>
				<th>Date and Time Created</th>
			</tr>
			<?php 

				foreach($stages as $stage){
					?>
					<tr>
						<td><?= $stage->created_by_full_name ?></td>
						<td><?= $stage->comment ?></td>
						<td><?= date('Y-m-d h:i:s', $stage->created_on) ?></td>
					</tr>
					<?php
				}
			?>
		</table>
	</table>
	
	<br> 
	<br>
	<span style='font-size:20px'>History</span>
	<table class="table table-data table-bordered property-management border-table" >
		<table class="table table-data table-bordered property-management border-table" >
			<tr>
				<th>Edited By</th>
				<th>Stage</th>
				<th>Description</th>
				<th>Date and Time Created</th>
			</tr>
			<?php 

				foreach($stages as $stage){
					?>
					<tr>
						<td><?= $stage->created_by_full_name ?></td>
						<td><?= $stage->stage ?></td>
						<td><?= $stage->comment ?></td>
						<td><?= date('Y-m-d h:i:s', $stage->created_on) ?></td>
					</tr>
					<?php
				}
			?>
		</table>
	</table>

	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class="btn  main-btn btn-back ">Back</button>
		</div>
	</div>

<div class="modal" tabindex="-1" role="dialog" id='update'>
	<div class="modal-dialog  modal-dialog-centered" role="document">
		<div class="modal-content px-1 pb-4 pt-2">
			<div class="modal-header flex-row-reverse pb-0" style="border-bottom: 0px;">
				<!-- <h5 class="modal-title">Update Stage</h5> -->
				<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#update").modal("hide")' aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<div class="modal-body pt-0">
				<h3 class="modal-title text-primary align-center text-center mb-3">Comments and Updates</h3>
				<form action="<?=WEB_ROOT;?>/property-management/pm-update-stage?display=plain" method='post' id='form-update-stage' enctype="multipart/form-data">
					
					<!-- <input type="hidden" name='reference_table' id='reference_table' > -->
					<input type="hidden" name='reference_id' id='reference_id' value='<?= $args[0] ?>'>
					
					<div class="col-12 my-4">
						<label for="created_by" class="text-required">Name <span class="text-danger">*</span></label>
						<input type="text" name='created_by' id='created_by' class='form-control' value='<?= $user->full_name?>' readonly>
					</div>

					<div class="col-12 my-4">
						<label for="comments" class="text-required">Comments <span class="text-danger">*</span></label>
						<textarea name="comment" id="" class='form-control' style="heigth: 100%" required></textarea>
					</div>

					<div class="d-flex justify-content-center gap-4 w-100">	
						<button type='submiit' class='btn main-btn '>Submit</button>
						<button  class='btn btn-light btn-cancel ' onclick='$("#update").modal("hide")'>Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
</div>
<!-- Success Upload Modal -->
<template id="upload-modal-success">
	<swal-html>
		<div class="p-5">
			<h4 class="text-primary">Upload Complete</h4>
			<p class="text-primary" style="font-size:12px">Congrats! Your upload successfully done.</p>
			<button class="btn btn-sm main-btn w-50 close-swal" onclick="closeSwal();">View</button>
		</div>
	</swal-html>
	<swal-param name="allowEscapeKey" value="false" />
</template>

<!-- Error Upload Modal -->
<template id="upload-modal-error">
	<swal-html>
		<div class="p-5">
			<h4 class="text-primary">Upload Error</h4>
			<p class="text-primary" style="font-size:12px">Sorry! Something went wrong.</p>
			<button class="btn btn-sm btn-danger w-50 close-swal" onclick="closeSwal();">Try Again</button>
		</div>
	</swal-html>
	<swal-param name="allowEscapeKey" value="false" />
</template>
</div>
<script>
	function show_modal_update(button_data){
		$('#update').modal('show');
		reference_table = $(button_data).attr('reference-table');
		reference_id = $(button_data).attr('reference-id');
		update_table = $(button_data).attr('update-table');

		$("#upload #reference_table").val(reference_table);
		$("#upload #update_table").val(update_table);
		$("#upload #reference_id").val(reference_id);
	}
	function show_modal_upload_message_success(){
		Swal.fire({
			template: '#upload-modal-success',
			showCloseButton: true,
			showConfirmButton:false,
			width: '580px'
			})
	}
	function show_modal_upload_message_err(){
		Swal.fire({
			template: '#upload-modal-error',
			showCloseButton: true,
			showConfirmButton:false,
			width: '580px'
			})
	}
</script>

<script>
	$(document).ready(function(){
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

		


		$(".btn-back").on('click',function(){
			//loadPage('<?=WEB_ROOT;?>/location');
			window.location.href = '<?=WEB_ROOT;?>/property-management/equipment?submenuid=equipment';
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
	
	$('#file').change(function() {
		var file = $('#file')[0].files[0].name;

		$('#upload_label').text(file);
	});
</script>