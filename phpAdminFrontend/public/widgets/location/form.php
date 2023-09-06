<?php
$module = "location";
$table = "location";
$view = "vw_location";

$id = $args[0];
if ($id!="") {
	$result = $ots->execute('module','get-record',[ 'id'=>$id,'view'=>$view ]);
	$record = json_decode($result);
}

$loc_id = initObj('loc_id');
if ($loc_id) {
	$parent_condition = "id=".decryptData($loc_id);
	$type_condition = "locationtype!='Building' and locationtype!='Floor' and ownership like '%{$ownership}%'";
	$record->parent_location_id = decryptData($loc_id);
} else {
	$parent_condition = "location_type!='Building'";
	$type_condition = "locationtype!='Building'";
}

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'location','condition'=>'id=1' ]);
$building = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'location','condition'=>$parent_condition,'orderby'=>'location_name' ]);
$parent_locs = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_locationtype','condition'=>$type_condition,'field'=>'locationtype' ]);
$list_locationtype = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_locationuse','condition'=>"ownership like '%{$ownership}%'",'field'=>'locationuse' ]);
$list_locationuse = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_locationstatus','condition'=>"ownership like '%{$ownership}%'",'field'=>'locationstatus' ]);
$list_locationstatus = json_decode($result);

// 23-0901 GET OWNERSHIP AND PROP TYPE FROM SYSTEM INFO
$result = $ots->execute('module','get-record',[ 'id'=>1,'view'=>'system_info' ]);
$system_info = json_decode($result);
$ownership = $system_info->ownership;
$property_type = $system_info->property_type;
?>
<div class="main-container">
	<div class="mt-2 mb-4"><label class="data-title"><?=($id=='') ? 'Add' : 'Edit';?> <?=($loc_id) ? "Sub-":""?><?=$page_title?></label> <b class="text-danger">* Required</b>&nbsp;<b class="text-warning">^ Unique</b></div>
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?=WEB_ROOT;?>/module/save?display=plain" id="form-main">
				<div class="row forms">
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="location_name" placeholder="Enter here" type="text" class="form-control" value="<?=($record) ? $record->location_name : ''?>" required>
							<label>Location Name <b class="text-danger">*</b> <b class="text-warning">^</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3 div-bldg">
						<div class="form-group input-box">
							<select name="location_type" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach($list_locationtype as $key=>$val) { ?>
								<option <?=($record && $record->location_type==$val) ? 'selected':''?>><?=$val?></option>
								<?php } ?>
							</select>
							<label>Location Type <b class="text-danger">*</b> <b class="text-warning">^</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="parent_location_id" class="form-control form-select">
								<option value="" selected disabled>Choose</option>
								<?php foreach($parent_locs as $key=>$val) { ?>
								<option value="<?=$val->id?>" <?=($record && $record->parent_location_id==$val->id) ? 'selected':''?>><?=$val->location_name?></option>
								<?php } ?>
							</select>
							<label>Parent Location <b class="text-danger lbl-non-building">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3 ">
						<div class="form-group input-box">
							<select name="location_use" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach($list_locationuse as $val) { ?>
								<option <?=($record && $record->location_use==$val) ? 'selected':''?>><?=$val?></option>
								<?php } ?>
							</select>
							<label>Location Use <b class="text-danger lbl-non-building">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3 ">
						<div class="form-group input-box">
							<input name="floor_area" class="form-control" type="number" value="<?=($record) ? $record->floor_area : ''?>" required>
							<label>Floor area <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3 ">
						<div class="form-group input-box">
							<select name="status" class="form-control form-select" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach($list_locationstatus as $val) { ?>
								<option <?=($record && $record->status==$val) ? 'selected':''?>><?=$val?></option>
								<?php } ?>
							</select>
							<label>Status <b class="text-danger lbl-non-building">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-8 mb-6">
						<div class="form-group input-box">
							<input name="notes" placeholder="Enter here" type="text" class="form-control mb-sm-3" value="<?=($record) ? $record->notes : ''?>">
							<label>Notes</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="d-flex gap-3 justify-content-start">
						<button class="main-btn btn">Submit</button>
						<button class="main-cancel btn-cancel btn" type="button">Cancel</button>
					</div>					
					<input name="id" type="hidden" value="<?=$args[0] ?? '';?>">
					<input name="module" type="hidden" value="<?=$module?>">
					<input name="table" type="hidden" value="<?=$table?>">
					<input name="loc_id" type="hidden" value="<?=$loc_id?>">
					<input name="unique" type="hidden" value="location_name,location_type">
				</div>
			</form>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	<?php if ($loc_id=="") { ?>
	$("select[name=location_type]").on('change',function(){
		if ($(this).val()=="Floor")
			cond = "id=1";
		else
			cond = "location_type='Floor'";
		$.ajax({
			url: '<?=WEB_ROOT."/module/get-listnew?display=plain"?>',
			type: 'POST',
			data: { table:'location',condition:cond,orderby:'location_name' },
			dataType: 'JSON',
			success: function(data){					
				var obj = $("select[name=parent_location_id]");
				obj.empty();
				$.each(data, function(key,val) {
					obj.append("<option value='" + val.id + "'>" + val.location_name + "</option");
				});
			},
		});
	});
	<?php } ?>

	$("#form-main").off('submit').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).prop('action'),
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			beforeSend: function(){
				$('.btn').attr('disabled','disabled');
			},
			success: function(data){					
				if(data.success == 1) {
					redirect = (data.loc_id) ? "<?=WEB_ROOT."/$module/view/"?>"+data.loc_id : "<?=WEB_ROOT."/$module/"?>";
					toastr.success(data.description,'Information',{ timeOut:2000, onHidden: function() { location=redirect; }});
				} else {
					toastr.warning(data.description,'Warning',{ timeOut:2000, onHidden: function() { }});
					$('.btn').attr('disabled',false);
				}
			},
		});
	});

	$(".btn-cancel").click(function(){
		<?php if ($loc_id=="") { ?>
		location = '<?=WEB_ROOT."/$module/"?>';
		<?php } else { ?>
		location = '<?=WEB_ROOT."/$module/view/$loc_id"?>';
		<?php } ?>
	});
});
</script>
