<?php 
$title = "Building Application";
$module = "tenant";  
$table = "documents";  
$view = "view_documents"; 

$filters = [ array(
		'field'=>'renewable',
		'label'=>'Renewable',
		'filterval'=>array(
			'yes',
			'no')
			) 
		];
$fields = rawurlencode(json_encode([ "ID"=>"id","Contracts Name"=>"contract_name","Contract_number"=>"contract_number"]));

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

<?php if($role_access->read != true): ?>
	<div class="card mx-auto" style="max-width: 30rem;">
		<div class="card-header bg-danger">
			Unauthorized access
		</div>
		<div class="card-body text-center">
			You are not allowed to access this resource. Please check with system administrator.
		</div>
	</div>
<?php else: ?>

<div class="page-title"><?=$title?></div>
<div class="d-flex justify-content-between mb-2">
	<div class= "d-flex align-items-end">
		<label class="text-label-result px-3 mb-0" id="search-result">
		</label>
	</div>
	<div>
		<?php if($role_access->upload == true): ?>
			<button class='btn btn-lg btn-upload px-5' style="background-color: #E78B35; font-weight: 600; color: #FFFFFF">Upload</button>
		<?php endif; ?>
	</div>
</div>
<div class="bg-white pb-2 px-2 pt-0 rounded">
	<!-- <button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-download">Download <i class="bi bi-download"></i></button> -->
	<div class="d-flex align-items-center justify-content-between py-2">
		
		<div>
			<button type="button" class="btn btn-sm filter">
				Filter
			</button>
			<div class="dropdown-menu my-5 px-2" style="width: 22%">
				<div class="card mb-3">
					<div class="mb-0">
						<button class="d-flex align-items-center justify-content-between btn btn-status w-100">
							<div>Status</div>
							<div><i id="down1" class="bi bi-caret-down-fill"></i><i id="up1" class="bi bi-caret-up-fill"></i></div>
						</button>
					</div>
					<div id="collapse-status" class="collapse">
						<div class="card-body">
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="status-new" id="status-new"></div>
								<div>New</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="status-open" id="status-open"></div>
								<div>Open</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="status-aging" id="status-aging"></div>
								<div>Aging</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="status-closed" id="status-closed"></div>
								<div>Closed</div>
							</div>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<input type="date" name='issued_date' class="form-control" placeholder="date">
				</div>

				<div class="card mb-3">
					<div class="mb-0">
						<button class="d-flex align-items-center justify-content-between btn btn-priority-level w-100">
							<div>Priority Level</div>
							<div><i id="down3" class="bi bi-caret-down-fill"></i><i id="up3" class="bi bi-caret-up-fill"></i></div>
						</button>
					</div>
					<div id="collapse-priority-level" class="collapse">
						<div class="card-body">
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="priority-1" id="priority-1"></div>
								<div>Priority 1</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="priority-2" id="priority-2"></div>
								<div>Priority 2</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="priority-3" id="priority-3"></div>
								<div>Priority 3</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="priority-4" id="priority-4"></div>
								<div>Priority 4</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="priority-5" id="priority-5"></div>
								<div>Priority 5</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-3">
					<div class="mb-0">
						<button class="d-flex align-items-center justify-content-between btn btn-stages w-100">
							<div>Stages</div>
							<div><i id="down4" class="bi bi-caret-down-fill"></i><i id="up4" class="bi bi-caret-up-fill"></i></div>
						</button>
					</div>
					<div id="collapse-stages" class="collapse">
						<div class="card-body">
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="stage-open" id="stage-open"></div>
								<div>Open</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="stage-acknowledged" id="stage-acknowledged"></div>
								<div>Acknowledged</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="stage-work-started" id="stage-work-started"></div>
								<div>Work Started</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="stage-work-completed" id="stage-work-completed"></div>
								<div>Work Completed</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="stage-prop-manager-verification" id="stage-prop-manager-verification"></div>
								<div>Property Manager Verification</div>
							</div>
							<div class="d-flex align-items-center gap-2">
								<div><input type="checkbox" class="form-check-input my-2" name="stage-closed" id="stage-closed"></div>
								<div>Closed</div>
							</div>
						</div>
					</div>
				</div>

				<div class="btn-group-buttons mt-5">
					<div class="d-flex flex-row-reverse mb-3" style="padding: 5px;">
						<button type="submit" class="btn btn-dark btn-primary px-5" style="border-radius: 20px 20px 20px 20px">Save</button>
					</div>
				</div>
			</div>
			<?php if($role_access->delete == true): ?>
				<button class="btn btn-sm btn-delete-filter">Delete</button>
			<?php endif; ?>
			<?php if($role_access->download == true): ?>
				<button class="btn btn-sm btn-download">Download</button>
			<?php endif; ?>
			<?php if($role_access->import == true): ?>
				<button class="btn btn-sm btn-import">Import</button>
			<?php endif; ?>
			<!-- <button class="btn btn-sm btn-delete-filter">Delete</button>
			<button class="btn btn-sm btn-download">Download</button>
			<button class="btn btn-sm btn-import">Import</button> -->
		</div>
		<div class="position-relative col-4">
			<input type="search" class="form-control search-box" placeholder="Search" id="searchbox">
			<i class="bi bi-search position-absolute" style="right: 5px; top: 4px; font-size: 17px; color: #B4B4B4;"></i>
		</div>
		
		<!-- <div class="col-3">
			<label>Status</label>
			<div>
				<button class="btn btn-primary btn-filter-status" type="button">Pending</button>
				<button class="btn btn-secondary btn-filter-status" type="button">Approved</button>
				<button class="btn btn-secondary btn-filter-status" type="button">Disapproved</button>
			</div>
		</div> -->
	</div>


	<div id="jsdata"></div>
</div>
<?php endif; ?>
<script>
	// function show_renew_modal(button_data){
	// 	id = $(button_data).attr('id');
	// 	$('#renew').modal('show');
	// 	$('#renew .modal-title').html($(button_data).attr('title'));
	// 	$('#renew .modal-body input#renew_id').val(id);
	// }

	
	<?php $unique_id = $module . time();?>
	var t<?=$unique_id;?>;
	$(document).ready(function(){
		$('#form-renew').submit(function(e){
			data = $(this).serialize();
			e.preventDefault();
			$.post({
				// url:'<?= WEB_ROOT ?>/tenant/renew-permits?display=plain',
				data:data,
				success:function(result){
					result = JSON.parse(result);
					if(result.success == 1){
						location.reload();
					}
				}
			});
			
		});

		$(".btn-upload").off('click').on('click',function(){
			window.location.href = "<?=WEB_ROOT."/tenant/";?>form-add-ba";
		});

		$(".btn-download").on('click',function(){
			location = "<?=WEB_ROOT;?>/module/download/?display=csv&module=<?=$module?>&table=<?=$table?>&view=<?=$view?>&fields=<?=$fields?>";
		});

		$("#filterby").on('change',function(){
			getFilter();
		});

		$(".btn-filter").on('click',function(){
			filterby = $("#filterby option:selected").val();
			filtertxt = $("#filtertxt").val();
			t<?=$unique_id;?>.options.colFilter[filterby] = filtertxt;
			t<?=$unique_id;?>.ajax.reload();
		});
		
		$(".btn-reset").on('click',function(){
			filterby = $("#filterby option:selected").val();
			$("#filtertxt").val('');
			delete t<?=$unique_id;?>.options.colFilter[filterby];
			t<?=$unique_id;?>.ajax.reload();
		});

		t<?=$unique_id;?> = $("#jsdata").JSDataList({
			pageLength: 10,
			searchBoxID: 'searchbox',
			prefix: 'gatepass',
			ajax: {
				url: "<?=WEB_ROOT."/module/get-list/{$view}?display=plain"?>"
			},
			onDataChanged:function(){
				$('.permit-expired').closest('.row-list').addClass('bg-danger text-light');
				
				$('.permit-notify').closest('.row-list').addClass('bg-warning');

				$('.permit-notify').closest('.row-list').addClass('light-blue-bg');

			},
			columns:[
				{
					data: "form_name",
					label: "Name of Application Form",
					class: 'col-lg-4 col-md-6 col-sm-6 d-flex align-items-center gap-2',
					render: function(data, row){
						return '<input class="d-none d-lg-block d-xl-block" type="checkbox" id="'+ row.id +'" name="check_box" table="documents" view_table="view_documents" reload="<?=WEB_ROOT;?>/tenant/building-application?submenuid=building_application"> '+data;							
					}
				},
				{
					data: "description",
					label: "Description",
					class: 'col-lg-4 col-md-6 col-sm-6 d-flex align-items-center gap-2',
					render: function(data,row){
						return '<a href="<?=WEB_ROOT;?>/tenant/view-ba/' + row.id + '/View" target="_self">' + data +'</a>';
					}
				},
				{
					data: null,
					label: "Download",
					class: 'col-lg-4 col-md-6 col-sm-6 d-flex align-items-center gap-2',
					render: function(data,row){
						
						return ' <a href="<?=WEB_ROOT;?>/tenant/view-ba/' + row.id + '/View" class="btn btn-sm  btn-download-s"><i class="bi bi-download text-primary"></i><a>'+' <a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?=WEB_ROOT?>/tenant/view-ba/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> '+
							' <a class="btn btn-sm text-primary btn-delete" role_access="<?=$role_access->delete ?>" onclick="show_delete_modal(this)" title="Are you sure?" rec_id="'+row.rec_id+'" del_url="<?=WEB_ROOT?>/tenant/delete-record/' + row.id + '?display=plain&table=documents&view_table=view_documents&redirect=/tenant/building-application?submenuid=building_application"><i class="bi bi-trash-fill"></i></a>'
                    },
					orderable: false
				}
			],
			order: [[0,'asc']],
			// colFilter: {'status':'Active'}
		});

		$(document).on('click','.btn-approve-gatepass,.btn-disapprove-gatepass',function(e){
			e.preventDefault();
			$.ajax({
				url: $(this).prop('href') + '?display=plain',
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function(){
				},
				success: function(data){
					if(data.success == 1)
					{
						showSuccessMessage(data.description,function(){
							window.location.reload();
						});
					}
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});

		$('.btn-delete-filter').on('click', function(){
			var table=$('input[name="check_box"]').attr('table');
			var view_table=$('input[name="check_box"]').attr('view_table');
			var redirect=$('input[name="check_box"]').attr('reload');

			var ids = [];
			$('input[name="check_box"]').each(function(){
				var $this = $(this);

				if($this.is(":checked")){
					ids.push($this.attr("id"));
				}
			});
			if(ids.length != 0){
				var url = '<?=WEB_ROOT;?>/property-management/delete-records?display=plain';

				table_delete_records(ids,table,view_table,redirect,url);
			}
		});

		
$('.filter').on('click', function(){
			$(".dropdown-menu").toggle();
		});

		$('.btn-status').off('click').on('click', function(){
			$('#collapse-status').collapse('toggle');
		});

		$('#collapse-status').on('hidden.bs.collapse', function () {
			$('#up1').hide();
			$('#down1').show();

		});

		$('#collapse-status').on('show.bs.collapse', function () {
			$('#up1').show();
			$('#down1').hide();

		});

		$('.btn-building').off('click').on('click', function(){
			$('#collapse-building').collapse('toggle');
		});

		$('#collapse-building').on('hidden.bs.collapse', function () {
			$('#up2').hide();
			$('#down2').show();

		});

		$('#collapse-building').on('show.bs.collapse', function () {
			$('#up2').show();
			$('#down2').hide();

		});

		$('.btn-priority-level').off('click').on('click', function(){
			$('#collapse-priority-level').collapse('toggle');
		});

		$('#collapse-priority-level').on('hidden.bs.collapse', function () {
			$('#up3').hide();
			$('#down3').show();

		});

		$('#collapse-priority-level').on('show.bs.collapse', function () {
			$('#up3').show();
			$('#down3').hide();

		});
		
		$('.btn-stages').off('click').on('click', function(){
			$('#collapse-stages').collapse('toggle');
		});

		$('#collapse-stages').on('hidden.bs.collapse', function () {
			$('#up4').hide();
			$('#down4').show();

		});

		$('#collapse-stages').on('show.bs.collapse', function () {
			$('#up4').show();
			$('#down4').hide();

		});
	
		$('.bi-caret-up-fill').hide();
	});
</script>