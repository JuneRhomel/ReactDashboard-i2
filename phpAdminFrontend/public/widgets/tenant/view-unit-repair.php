<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_unit_repair'
	];
	$unit_repair = $ots->execute('tenant','get-record',$data);
	$unit_repair = json_decode($unit_repair);

	//users
	$data = [	
        'view'=>'users'
	];
	$user = $ots->execute('property-management','get-record',$data);
	$user = json_decode($user);

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
		<a onclick="window.location.href = '<?=WEB_ROOT;?>/tenant/service-request?submenuid=service_request'"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $unit_repair->tenant_name?></a>
		<?php if($role_access->update == true): ?>
			<a href='<?= WEB_ROOT ?>/tenant/form-edit-unit-repair/<?= $args[0] ?>/Edit'  class='btn btn-sm btn-primary float-end btn-view-form px-5'>Edit</a>
		<?php endif; ?>
	</div>
	<table class="table table-data table-bordered tenant border-table text-capitalize" >
		<tr>
			<th>Service Category</th><td><?php echo $unit_repair->sr_type?></td>
		</tr>
		<tr>
			<th>Requestor Name</th><td><?php echo $unit_repair->tenant_name?></td>
		</tr>
        <tr>
			<th>Contact Number</th><td><?php echo $unit_repair->contact_num?></td>
		</tr>
		<tr>
			<th>Email</th><td><?php echo $unit_repair->email_add?></td>
		</tr>
		<tr>
			<th>Unit Number</th><td><?php echo $unit_repair->unit?></td>
		</tr>
        <tr>
			<th>Description</th><td><?php echo $unit_repair->description?></td>
		</tr>
		<tr>
			<th>Request Type</th><td><?php echo $unit_repair->request_type?></td>
		</tr>
		<tr>
			<th>Priority Level</th><td><?php echo $unit_repair->priority_level?></td>
		</tr>
	</table>

	<div class="d-flex justify-content-between my-5">
		<span style='font-size:20px'>Stages</span>
		<button class='btn btn-lg btn-primary px-5' onclick="show_modal_update(this)" update-table='pm_updates' reference-table='pm' reference-id='<?php echo $args[0]; ?>' id='<?php echo $args[0]; ?>'>Update</button>
	</div>
	<div class="d-flex align-items-center gap-4">
	<?php 
		// echo $stages[0]->rank;
		$ctr = 1;
		foreach($stages_button as $stage_button){
			?>
		
			
					<button class='btn <?= ($stage_button->rank <= $stages[0]->rank)?'current-status':'btn-outline-secondary'; ?> status-button'><label class="text-required text-capitalize"><?= ucfirst(str_replace('-',' ', $stage_button->stage_name)) ?></label></button> 
				
				<?php
				if($ctr < 6){
					?>
					<div>
						<i class="bi bi-arrow-right arrow-right-bigger"></i>
					</div>
				
				<?php
			}
			$ctr++;

		}
	?>
	</div>
	
	<span style='font-size:20px'>Comments And Updates</span>
	<table class="table table-data table-bordered property-management text-capitalize border-table" >
		<table class="table table-data table-bordered property-management text-capitalize border-table text-capitalize" >
			<tr>
				<th>Name</th>
				<th>Stage</th>
				<th>Comment</th>
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
			<button type="submit" class="btn btn-dark btn-primary btn-back px-5">Back</button>
		</div>
	</div>

	
    <div class="modal" tabindex="-1" role="dialog" id='update'>
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content px-1 pb-4 pt-2">
				<div class="modal-header flex-row-reverse pb-0" style="border-bottom: 0px;">
					<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#update").modal("hide")' aria-label="Close">
						<span aria-hidden="true"></span>
					</button>
				</div>
				<div class="modal-body pt-0">
					<h3 class="modal-title text-primary align-center text-center mb-3">Update Stage</h3>
					<form action="<?=WEB_ROOT;?>/property-management/pm-update-stage?display=plain" method='post' id='form-update-stage' enctype="multipart/form-data">
						
						<input type="hidden" name='reference_id' id='reference_id' value='<?= $args[0] ?>'>
						
						<div class="col-12 my-4">
						<?php 
									$data = ['stage_type'=>'unit_repair'];
									$stage_dropdown = $ots->execute('property-management','get-stages',$data);
									$stage_dropdown = json_decode($stage_dropdown);
								?>
							<label for="" class="text-required">Stage</label>
							<select class="form-control form-select" name="rank">
								<?php 
									foreach($stage_dropdown as $stage){
										?>
										<option value='<?= $stage->rank ?>'><?= ucfirst(str_replace('-',' ', $stage->stage_name)) ?></option>
										<?php
									}
								?>
							</select>
						</div>
						<div class="col-12 my-4">
							<label for="comments" class="text-required">Comments</label>
							<textarea name="comment" id="" class='form-control'></textarea>
							
						</div>
						<div class="col-12 my-4">
							<label for="created_by" class="text-required">Name</label>
							<input type="text" name='created_by' id='created_by' class='form-control' value='<?= $user->full_name?>' readonly>
						</div>
						<div class="d-flex justify-content-center gap-4 w-100">	
							<button type='submit' class='btn btn-primary px-5'>Submit</button>
							<a  class='btn btn-light btn-cancel px-5' onclick='$("#update").modal("hide")'>Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		
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

	$(".btn-back").on('click',function(){
		//loadPage('<?=WEB_ROOT;?>/location');
		window.location.href = '<?=WEB_ROOT;?>/tenant/service-request?submenuid=service_request';
	});

	
		
	


</script>
	
	<!-- <span style='font-size:20px'>Attachments</span> <button class='btn btn-lg btn-primary' onclick="show_modal_upload(this)" reference-table='tenant' reference-id='<?php echo $args[0]; ?>' id='<?php echo $args[0]; ?>'>Upload</button>
	<table class="table table-striped table-bordered tenant border-table text-capitalize" >
		<tr>
			<th>Create By</th>
			<th>Document</th>
			<th>Created By</th>
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
	</table> -->
