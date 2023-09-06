<?php 
$title = "Collection Efficiency";
$module = "bills";  
$table = "bills";  
$view = "view_bills_report"; 

$data = [
    'view'=>'view_bills_report',
];
$bills = $ots->execute('utilities','get-records',$data);
$bills = json_decode($bills);
// var_dump($bills);

$months = ["January","February","March","April","May","June","July","August","September","October","November","December"];


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
	'table'=>'collection_report',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>
<div class="main-container">

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
    <div class="filter-year gap-4 my-5 align-items-center" style="border-top: 1px solid #B4B4B4; border-bottom: 1px solid #B4B4B4;">
		
	<div class="col-12 col-sm-3 my-4">
		<div class="form-group">
			<label for="" class="text-required">Year</label>
			<input type="text" class="form-control">
		</div>
	</div>
	<div class="col-12 col-sm-4 my-4 btn-enter-year">
		<div class="form-group">
			<br>
			<button type="submit" class="btn btn-dark btn-primary px-5">Enter</button>
		</div>
	</div>
</div>

<div class="d-flex justify-content-between mb-2">
	<div class= "d-flex align-items-end">
		<label class="text-label-result px-3 mb-0" id="search-result">
			
			</label>
		</div>
	</div>
	
	<div class="bg-white pb-2 px-2 pt-0 rounded">
		<div class="d-flex align-items-center justify-content-between py-2">
			
			<div>
				<button type="button" class="btn btn-sm filter ce-filter">
					Filter
				</button>
				<div class="dropdown-menu-filter dropdown-menu my-5 px-2" style="width: 22%" id="dropdownmenufilter">
					<div class="dropdown-menu-filter-fields">
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
					</div>
					
					<div class="btn-group-buttons mt-5">
						<div class="d-flex flex-row-reverse mb-3" style="padding: 5px;">
							<button type="button" class="btn btn-dark btn-primary btn-filter-now px-5" style="border-radius: 20px 20px 20px 20px">Save</button>
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
						</div>
						
						<div class="position-relative col-4">
							<input type="search" class="form-control search-box ce-search" placeholder="Search" id="searchbox">
							<i class="bi bi-search position-absolute ce-search-icon" style="right: 5px; top: 4px; font-size: 17px; color: #B4B4B4;"></i>
						</div>
					</div>
					
					<div class="bg-white pb-2 px-2 pt-0 rounded">
						<div class="report-chart">
							<table class="table table-data table-bordered">
								<thead>
				<tr>
					<th  class="text-right">Months</th>
					<th  class="text-right">Collectibles</th>
					<th  class="text-right">Collected Amount</th>
					<th  class="text-right">Unpaid Amount</th>
					<th  class="text-right">Collection Efficiency</th>
				</tr>
			</thead>
			<?php $collectibles = 0; ?>
			<?php $collected = 0; ?>
			<?php $unpaid = 0; ?>
			
			<?php if(count($bills) == 0): ?>
				<tr><td>No available record..</td></tr>
				<?php else: ?>
					<?php foreach($months as $month):?>
						<tr>
							<td class="text-nowrap"><?= $month;?></td>
							<td>
								<?php $collectible = 1000000; ?>
								<?php echo '1,000,000';?>
								<?php $collectibles += $collectible; ?>
							</td>
							<td>
								<?php echo $collect = '0';?>
								<?php $collected += $collect; ?>
							</td>
							<td>
								<?php foreach($bills as $bill):?>
									<?php if($bill->month == date('m', strtotime($month)) && $bill->year == '2022'):?>
										<?php $amount = $bill->assoc + $bill->elec + $bill->water;?>
										<?= number_format($amount, 2); ?>
										<?php $unpaid += $amount; ?>
										<?php endif; ?>
										<?php endforeach;?>
									</td>
									<td>
										<label class="text-required" style="color: #1C5196"> <?=($collected/$collectibles)*100 ?>%
									</td>
								</tr>
								
								<?php endforeach;?>
								<tr>
									<td class="text-nowrap">TOTAL</td>
									<td class="text-nowrap"><?=number_format($collectibles, 2)?></td>
									<td class="text-nowrap"><?=number_format($collected, 2)?></td>
									<td class="text-nowrap"><?=number_format($unpaid, 2)?></td>
									<td><label class="text-required" style="color: #1C5196"> <?=($collected/$collectibles)*100 ?>%</td>
								</tr>
								<?php endif; ?>
							</table>
	</div>

	
	<!-- <div id="jsdata"></div> -->
</div>
<br>
<br>
<div style="border-top: solid 1px rgb(180,180,180, .3);">
	<br>
	<span style='font-size:20px'>History</span>
	
	<table class="table table-data water-table" style="box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);">
		<thead class="header-design">
			<tr>
				<th style="width:20%"><input type="checkbox"> Year</th>
				<th style="width:20%">Collectibles</th>
				<th style="width:20%">Collected Amount</th>
				<th style="width:20%">Unpaid Amount</th>
				<th style="width:20%">Collection Efficiency</th>
			</tr>
		</thead>
		<script>
			
			</script>
    
    <tbody class="table-body">     
		<tr class="tr-data">
			<td>
				<input type="checkbox"> 2022
			</td>
			<td>
				<?=number_format($collectibles, 2)?>
			</td>
			<td>
				<?=number_format($collected, 2)?>
			</td>
			<td>
				<?=number_format($unpaid, 2)?>
			</td>
			<td>
				<label class="text-required" style="color: #1C5196"> <?=($collected/$collectibles)*100 ?>%
			</td>
		</tr>	
		
    </tbody>
</table>

</div>
<br>
<?php endif; ?>
</div>
<script>
	
	<?php $unique_id = $module . time();?>
	var t<?=$unique_id;?>;
	$(document).ready(function(){
		$('#form-renew').submit(function(e){
			
			e.preventDefault();
			$.post({
				url:'<?= WEB_ROOT ?>/tenant/renew-permits?display=plain',
				data:{
					input:12
				},
				success:function(result){
					result = JSON.parse(result);
					if(result.success == 1){
						location.reload();
					}
				}
			});
			
		});
		
		// $(".btn-add").off('click').on('click',function(){
			// 	window.location.href = "<?=WEB_ROOT."/utilities/";?>new-input-reading";
			// });
			
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
			filterBoxID: 'dropdownmenufilter',
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
					data: "meter_name",
					label: "Work Order #",
					class: 'col-2 d-flex align-items-center gap-2',
					render: function(data,row){
						return '<input type="checkbox">'+ data;
					}
				},
				{
					data: null,
					label: "Last Reading",
					class: 'col-2'
					
				},
				{
                    data: "unit_area",
					label: "New Reading",
					class: 'col-2',
                },
				{
					data: "unit_area",
					label: "Consumption",
					class: 'col-2',
				},
				{
					data: null,
					label: "Amount",
					class: 'col-1'
				},
				{
					data: null,
					label: "Owner Email",
					class: 'col-2',
				},
				// {
				// 	data: "owner_username",
				// 	label: "Owner Username",
				// 	class: 'col-2'
				// },
				// {
				// 	label: "Type",
				// 	class: 'col-1'
				// },
				// {
				// 	label: "Billing",
				// 	class: 'col-1'
				// },
				{
					data: null,
					label: "Action",
					class: 'col-1 d-flex align-items-center',
					render: function(data,row){
						return '<a class="btn btn-sm btn-view" title="View ID ' + row.rec_id + '" href="<?=WEB_ROOT?>/report/view-wo-summary/' + row.id + '/View"><i class="bi bi-eye-fill text-primary"></i></a> '+
						'<a class="btn btn-sm text-primary btn-delete" role_access="<?=$role_access->delete ?>" onclick="show_delete_modal(this)" title="Delete ID ' + row.rec_id + '" del_url="<?=WEB_ROOT?>/tenant/delete-record/' + row.id + '?display=plain&table=tenant&view_table=view_tenant&redirect=/tenant/tenant-list?submenuid=tenant_list"><i class="bi bi-trash-fill"></i></a>';
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

        $('.all-btn').on('click', function(e) {
            $(".all-btn").addClass('active1');
            $(".open-btn").removeClass('active1');
            $(".aging-btn").removeClass('active1');
            $(".closed-btn").removeClass('active1');
		});
        
    
	});
</script>