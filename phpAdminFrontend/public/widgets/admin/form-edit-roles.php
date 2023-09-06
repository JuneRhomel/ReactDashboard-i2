<?php
	$equipment = null;
	if(count($args))
	{
		$data = [
			'id'=>$args[0],
			'view'=>'roles'
		];
		$roles = $ots->execute('admin','get-record',$data);
		$roles = json_decode($roles,true);
	}
	// var_dump($roles);
?>
<div class="grid lg:grid-cols-1 grid-cols-1 title">
	<div class="bg-white rounded-sm">
		<form method="post" action="<?php echo WEB_ROOT;?>/property-management/save-record?display=plain" class="bg-white" id="form-roles-edit">
			<input type="hidden" name='redirect'  id='redirect' value= '<?= WEB_ROOT?>/admin/view-roles/<?=$args[0]?>/View' >
			<input type="hidden" name='table'  id='id' value= 'roles'>
			<input type="hidden" name='duplicate_check' value= 'role_name'>

			<label class="required-field mt-4">* Please Fill in the required fields</label>
			<div class="row forms">
				<div class="col-12 col-sm-4 my-4">	
					<div class="form-group">
						<label for="" class="text-required">Role Name <span class="text-danger">*</span></label>
						<input name="role_name" type="text" class="form-control" value="<?php echo $roles['role_name'];?>" required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-4">	
					<div class="form-group">
						<label for="" class="text-required">Role Description</label>
						<input name="description" type="text" value="<?=$roles['description'];?>" class="form-control">
					</div>
				</div>
			</div>
            <div><br></div>
			<div class="btn-group-buttons pull-right">
				<div class="mb-3 float-end" style="padding: 5px;">
					<button type="submit" class="btn btn-dark btn-primary px-5">Save</button>
					<button type="button" class="btn btn-light btn-cancel px-5">Cancel</button>
				</div>
			</div>
			<br>
				<input type="hidden" value="<?php echo $args[0] ?? '';?>" name="id">
			
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".btn-cancel").off('click').on('click',function(){
			window.location.href = '<?=WEB_ROOT;?>/admin/view-roles/<?=$args[0]?>/View';
		});

		$("#form-roles-edit").on('submit',function(e){
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

	});
</script>