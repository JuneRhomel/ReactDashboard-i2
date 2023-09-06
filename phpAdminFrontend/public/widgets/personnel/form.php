<?php
$module = "personnel";
$table = "personnel";
$view = "vw_personnel";

$id = $args[0];
if ($id!="") {
	$result = $ots->execute('module','get-record',[ 'id'=>$id,'view'=>$view ]);
	$record = json_decode($result);
}

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_workingsked','field'=>'workingsked' ]);
$working_skeds = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_workinghours','field'=>'workinghours' ]);
$working_hours = json_decode($result);
?>
<div class="main-container">
	<div class="mt-2 mb-4"><label class="data-title"><?=($id=='') ? 'Add' : 'Edit';?> <?=$page_title?></label> <b class="text-danger">* Required</b></div>
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?=WEB_ROOT;?>/module/save?display=plain" id="form-main">
				<div class="row forms">
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="employee_number" class="form-control" type="text" placeholder="Type Here" value="<?=($record) ? $record->employee_number : ''?>" required>
							<label>Employee Number <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3 div-bldg">
						<div class="form-group input-box">
							<input name="employee_name" class="form-control" type="text" placeholder="Type Here" value="<?=($record) ? $record->employee_name : ''?>" required>
							<label>Employee Name <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="username" class="form-control" type="text" placeholder="Type Here" value="<?=($record) ? $record->username : ''?>" required>
							<label>Username <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3 ">
						<div class="form-group input-box">
							<input name="email" class="form-control" type="text" placeholder="Type Here" value="<?=($record) ? $record->email : ''?>" required>
							<label>Email <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="contact_number" class="form-control" type="text" placeholder="Type Here" value="<?=($record) ? $record->contact_number : ''?>" required>
							<label>Contact Number <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="home_address" class="form-control" type="text" placeholder="Type Here" value="<?=($record) ? $record->home_address : ''?>" required>
							<label>Home Address <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="working_schedule" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach($working_skeds as $val) { ?>
								<option <?=($record && $record->working_schedule==$val) ? 'selected':''?>><?=$val?></option>
								<?php } ?>
							</select>
							<label>Working Schedule <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3 ">
						<div class="form-group input-box">
							<select name="working_hours" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach($working_hours as $val) { ?>
								<option <?=($record && $record->working_hours==$val) ? 'selected':''?>><?=$val?></option>
								<?php } ?>
							</select>
							<label>Working Hours <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="emergency_contact_person" class="form-control" type="text" placeholder="Type Here" value="<?=($record) ? $record->emergency_contact_person : ''?>" required>
							<label>Emergency Contact Person <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="relationship" class="form-control" type="text" placeholder="Type Here" value="<?=($record) ? $record->relationship : ''?>" required>
							<label>Relationship <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="emergency_contact_number" class="form-control" type="text" placeholder="Type Here" value="<?=($record) ? $record->emergency_contact_number : ''?>" required>
							<label>Emergency Contact No. <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-8 my-3"></div>

					<div class="d-flex gap-3 justify-content-start">
						<button class=" main-btn">Submit</button>
						<button type="button" class="main-cancel btn-cancel">Cancel</button>
					</div>					
					<input name="id" type="hidden" value="<?=$args[0] ?? '';?>">
					<input name="module" type="hidden" value="<?=$module?>">
					<input name="table" type="hidden" value="<?=$table?>">
				</div>
			</form>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$("#form-main").off('submit').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).prop('action'),
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			success: function(data){					
				if(data.success == 1) {
					redirect = (data.loc_id) ? "<?=WEB_ROOT."/$module/view/"?>"+data.loc_id : "<?=WEB_ROOT."/$module/"?>";
					toastr.success(data.description,'Information',{ timeOut:2000, onHidden: function() { location=redirect; }});
				}	
			},
		});
	});

	$(".btn-cancel").click(function(){
		location = '<?=WEB_ROOT."/$module/"?>';
	});
});
</script>