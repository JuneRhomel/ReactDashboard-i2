<?php
    $data = [
		'id'=>$args[0],
        'view'=>'news'
	];
	$tenant = $ots->execute('tenant','get-record',$data);
	$news = json_decode($tenant);

	$data = [
		'reference_table' => 'news',
		'reference_id' => $args['0']
	];
	$attachments = $ots->execute('files','get-attachments',$data);
	$attachments = json_decode($attachments);


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
	'table'=>'news',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>

<div class="main-container">
	
	<div class="d-flex justify-content-between mb-3">
		<a onclick="history.back()"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $news->title?></a>
		<?php if($role_access->update == true): ?>
			<a href='<?= WEB_ROOT ?>/tenant/form-edit-news/<?= $args[0] ?>/Edit'  class='btn btn-sm btn-primary float-end btn-view-form px-5'>Edit</a>
		<?php endif; ?>
	</div>
	<table class="table table-data table-bordered tenant border-table text-capitalize" >
		<tr>
			<th>ID</th><td><?php echo $news->id?></td>
		</tr>
		<tr>
			<th>Title</th><td><?php echo $news->title?></td>
		</tr>
		<tr>
			<th>Content</th><td><?php echo $news->content?></td>
		</tr>
		
	</table>
    
	<div class="d-flex justify-content-between my-4">
		<span style='font-size:20px'>Attachments</span>
		<?php if($role_access->upload == true): ?>
			<button class='btn btn-lg btn-primary px-5' onclick="show_modal_upload(this)" reference-table='news' reference-id='<?php echo $args[0]; ?>' id='<?php echo $args[0]; ?>'>Upload</button>
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

	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class="btn btn-dark btn-primary btn-cancel px-5">Back</button>
		</div>
	</div>

<script>

	$(".btn-cancel").on('click',function(){
		//loadPage('<?=WEB_ROOT;?>/location');
		window.location.href = '<?=WEB_ROOT;?>/tenant/tenant-list?submenuid=tenant_list';
	});

</script>
