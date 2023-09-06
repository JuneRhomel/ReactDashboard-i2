<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_documents'
	];
	$document = $ots->execute('tenant','get-record',$data);
	$document = json_decode($document);
    // print_r($documents);
    $data = [
		'reference_table' => 'documents',
		'reference_id' => $args['0']
	];
	$attachments = $ots->execute('files','get-attachments',$data);
	$attachments = json_decode($attachments);
    // print_r($attachments);

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
	'table'=>'building_app_form',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>

<div class="main-container">
	<div class="d-flex justify-content-between mb-3">
		<a onclick="history.back()"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $document->form_name?></label></a>
	</div>


	<table class="table table-data table-bordered tenant border-table text-capitalize" >
		<tr>
			<th>Name of Application Form</th><td><?php echo $document->form_name?></td>
		</tr>
		<tr>
			<th>Description</th><td><?php echo $document->description?></td>
		</tr>
		<tr>
			<th>File</th><td>
				<?php 
					$i = 0;
					foreach($attachments as $attachment){
						if ($i++ == 0) {
						?>
							<a class='text-primary' href='<?= $attachment->attachment_url ?>' ><?= $attachment->filename ?></a>
						<?php
						break;
						}
					}
				?>
			</td>
		</tr>
	</table>
    
	<br>
	<br>
	<div class="d-flex justify-content-between mb-3">
		<span style='font-size:20px'>Attachments</span> 
		<?php if($role_access->upload == true): ?>
			<button class='btn btn-lg btn-primary px-5' onclick="show_modal_upload(this)" reference-table='documents' reference-id='<?php echo $args[0]; ?>' id='<?php echo $args[0]; ?>'>Upload</button>
		<?php endif; ?>
	</div>
	<table class="table table-data table-bordered tenant border-table text-capitalize" >
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
	</table>
