<?php
	$resident = null;
	if(count($args))
	{
		$resident_result = $ots->execute('tenant','get-resident',['id'=>$args[0]]);
		$resident = json_decode($resident_result,true);
		$action = $args[1];
		if ($action=="")
			$action = count($args) ? 'Edit' : 'Add';			
	}
	$units =  json_decode($ots->execute('location','get-unit-list-restricted',[]),true);
?>
<div class="page-title"><?=$action?> Resident</div>
<div class="col-12 col-sm-6 bg-white p-3">
	<form method="post" action="<?=WEB_ROOT;?>/tenant/save-resident?display=plain" class="bg-white" id="frm" enctype="multipart/form-data">
		<div class="form-group mb-2"><b class="text-danger">* REQUIRED</b></div>
		<div class="form-group mb-2">
			<label>Name of Resident <b class="text-danger">*</b></label>
			<input name="tenant_name" type="text" class="form-control" value="<?=($resident) ? $resident['tenant_name'] : ""?>" required>
		</div>
		<div class="form-group mb-2">
			<label>Type <b class="text-danger">*</b></label>
			<select class="form-control" name="tenant_type">
				<option value="Owner" <?=($resident && $resident['tenant_type']=="Owner") ? "selected" : ""?>>Owner</option>
				<option value="Tenant" <?=($resident && $resident['tenant_type']=="Tenant") ? "selected" : ""?>>Tenant</option>
			</select>
		</div>
		<div class="form-group mb-2">
			<label>Unit <b class="text-danger">*</b></label>
			<select name="location_id" class="form-control form-select">
				<?php foreach($units as $unit):?>
					<option value="<?=$unit['id'];?>" <?=($resident && $resident['location_id']==$unit['id']) ? "selected" : ""?>><?=$unit['location_name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
		<div class="form-group mb-2">
			<label>Email <b class="text-danger">*</b></label>
			<input name="email" type="email" class="form-control" value="<?=($resident) ? $resident['email'] : ""?>" required>
		</div>
		<div class="form-group mb-2">
			<label>Mobile No. <b class="text-danger">*</b></label>
			<input name="mobile" type="text" class="form-control" value="<?=($resident) ? $resident['mobile'] : ""?>" required>
		</div>
		<?php if ($action!="View") { ?>
		<button type="button" class="btn btn-light btn-cancel">Cancel</button>
		<button class="btn btn-primary">Submit</button>
		<?php }	else { ?>
		<button type="button" class="btn btn-primary" onclick="window.close()">Close</button>			
		<?php } ?>
		<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
	</form>
</div>
<script>

	$(document).ready(function(){
		$(".date").datetimepicker({'format':'Y-m-d','timepicker':false});

		$("#frm").off('submit').on('submit',function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: new FormData($(this)[0]),
				dataType: 'JSON',
				contentType: false,
				processData: false,
				beforeSend: function(){},
				success: function(data){
					if(data.success == 1)
					{
						$(".notification-success-message").html(data.description);
						$(".notification-success").fadeIn('slow');
						window.location.href = "<?=WEB_ROOT;?>/tenant/";
					}	
				},
				complete: function(){},
				error: function(jqXHR, textStatus, errorThrown){}
			});
		});

		$(".btn-cancel").off('click').on('click',function(){
			window.location.href = '<?=WEB_ROOT;?>/tenant/';
		});

	});

	function viewOnly() {
		$("input[type=text]").prop('disabled', true);
		$("input[type=radio]").prop('disabled', true);
		$("input[type=email]").prop('disabled', true);
		$("input[type=checkbox]").prop('disabled', true);
		$("textarea").prop('disabled', true);
		$("select").prop('disabled', true);
	}
</script>
<?php
if ($action=="View")
	echo '<script type="text/javascript">viewOnly();</script>';
?>