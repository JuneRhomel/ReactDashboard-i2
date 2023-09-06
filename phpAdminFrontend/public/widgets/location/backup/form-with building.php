<?php
$menu = "property-management";
$module = "location";
$table = "locations";
$view = "vw_locations";

$id = $args[0];
if ($id!="") {
	$result = $ots->execute('module','get-record',[ 'id'=>$id,'view'=>$view ]);
	$record = json_decode($result);
}

$result =  $ots->execute('module','get-record',[ 'id'=>1,'view'=>$view ]);
$building = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'locations','condition'=>'location_type!="Building"','orderby'=>'location_name' ]);
$parent_locs = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_locationtype','condition'=>'locationtype!="Building"','field'=>'locationtype' ]);
$location_types = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_locationuse','field'=>'locationuse' ]);
$location_uses = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_locationstatus','field'=>'locationstatus' ]);
$location_statuses = json_decode($result);
?>
<div class="main-container">
	<div class="mt-2 mb-4"><label class="data-title"><?=($id=='') ? 'Add' : 'Edit';?> Location</label> <b class="text-danger">* Required</b></div>
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?=WEB_ROOT;?>/module/save?display=plain" id="form-main">
				<div class="row forms">
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="location_name" placeholder="Enter here" type="text" class="form-control" value="<?=($record) ? $record->location_name : ''?>" required>
							<label>Location Name <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3 div-bldg">
						<div class="form-group input-box">
							<select name="location_type" class="form-control" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach($location_types as $key=>$val) { ?>
								<option <?=($record && $record->location_type==$val) ? 'selected':''?>><?=$val?></option>
								<?php } ?>
							</select>
							<label>Location Type <b class="text-danger">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<!-- <div class="col-12 col-sm-8 mb-6">
						<div class="form-group input-box">
							<input name="address" placeholder="Enter here" type="text" class="form-control mb-sm-3 building" value="<?=($record) ? $record->address : ''?>">
							<label>Address <b class="text-danger lbl-building">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="property_manager" placeholder="Enter here" type="text" class="form-control building" value="<?=($record) ? $record->property_manager : ''?>">
							<label>Property Manager <b class="text-danger lbl-building">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="building_owner" placeholder="Enter here" type="text" class="form-control building" value="<?=($record) ? $record->building_owner : ''?>">
							<label>Building Owner <b class="text-danger lbl-building">*</b></label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div> -->

					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<select name="parent_location_id" class="form-control non-building">
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
							<select name="location_use" class="form-control non-building" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach($location_uses as $val) { ?>
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
							<select name="location_status" class="form-control non-building" required>
								<option value="" selected disabled>Choose</option>
								<?php foreach($location_statuses as $val) { ?>
								<option <?=($record && $record->location_status==$val) ? 'selected':''?>><?=$val?></option>
								<?php } ?>
							</select>
							<label>Status <b class="text-danger lbl-non-building">*</b></label>
						</div>
					</div>

					<div class="col-12 col-sm-8 mb-6">
						<div class="form-group input-box">
							<input name="notes" placeholder="Enter here" type="text" class="form-control mb-sm-3" value="<?=($record) ? $record->notes : ''?>">
							<label>Notes</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3"></div>

					<div class="d-flex gap-3 justify-content-start">
						<button class=" main-btn">Submit</button>
						<button type="button" class="main-cancel btn-cancel">Cancel</button>
					</div>					
					<input name="id" type="hidden" value="<?=$args[0] ?? '';?>">
					<input name="module" type="hidden" value="<?=$module?>">
					<input name="table" type="hidden" value="<?=$table?>">
					<input id="building_id" type="hidden" value="<?=$building->id?>">
					<input id="building_name" type="hidden" value="<?=$building->location_name?>">
				</div>
			</form>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$("select[name=location_type]").on('change',function(){
		if ($(this).val()!=null) {
			if($(this).val().toLowerCase()=='floor')	{
				parentlocid = $("select[name='parent_location_id']");
				bldgid = $("#building_id").val();
				bldgname = $("#building_name").val();
				parentlocid.empty();
				parentlocid.append('<option value="'+bldgid+'">'+bldgname+'</option');
			} else {
			}
			/*if($(this).val().toLowerCase()=='building')	{
				$('.building').removeAttr('disabled');
				$('.non-building').attr('disabled','');
				$('.lbl-building').removeClass('d-none');
				$('.lbl-non-building').addClass('d-none');
			} else {
				$('.building').attr('disabled','');
				$('.non-building').removeAttr('disabled');
				$('.lbl-building').addClass('d-none');
				$('.lbl-non-building').removeClass('d-none');			
			}*/

		}
	});

	$("select[name=location_type]").trigger("change");

	$("#form-main").off('submit').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).prop('action'),
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			success: function(data){					
				if(data.success == 1) {
					toastr.success(data.description,'Information',{ timeOut:2000, onHidden: function() { location="<?=WEB_ROOT."/$module/"?>"; }});
				}	
			},
		});
	});

	/*$("input[id=parent_location]").autocomplete({
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
	});*/

	$(".btn-cancel").off('click').on('click',function(){
		window.location.href = '<?=WEB_ROOT."/$module/"?>';
	});
});
</script>