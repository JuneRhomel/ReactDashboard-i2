<div class="page-title">Tenant Registrations</div>
<div class="bg-white p-2 rounded">
	<!--button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add-tenant">Add Gate Pass <span class="bi bi-plus-circle"></span></button-->
	<div class="row">
		<div class="col-12 col-sm-6">
			<label>Search</label>
			<input type="text" class="form-control" placeholder="Search" id="searchbox">
		</div>

		<div class="col-12 col-sm-6">
			<label>Status</label>
			<div>
				<button class="btn btn-primary btn-filter-status" type="button">Pending</button>
				<button class="btn btn-secondary btn-filter-status" type="button">Approved</button>
				<button class="btn btn-secondary btn-filter-status" type="button">Disapproved</button>
			</div>
		</div>
	</div>
</div>

<div class="mt-3">
	<ul class="tabs">
		<li class="">
			<a class="tab-link" aria-current="page" href="<?php echo WEB_ROOT;?>/visitor">Visitors</a>
		</li>
		<li>
			<a class="tab-link active" aria-current="page" href="<?php echo WEB_ROOT;?>/tenant/registrations">Tenants</a>
		</li>	
	</ul>
</div>

<div id="jsdata"></div>

<script>
	<?php $unique_id = 'tenantregistration' . time();?>
	var t<?php echo $unique_id;?>;
	$(document).ready(function(){
		$(".btn-add-tenant").off('click').on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/tenant/form';
		});

		t<?php echo $unique_id;?> = $("#jsdata").JSDataList({
			pageLength: 10,
			searchBoxID: 'searchbox',
			prefix: 'tenantregistration',
			ajax: {
				url: '<?php echo WEB_ROOT;?>/tenant/get-registrations?display=plain'
			},
			columns:[
				{
					data: "tenant_name",
					label: "Name",
					class: 'col-2',
					render: function(data,row){
						return '<a href="<?php echo WEB_ROOT;?>/tenant/view-registration/' + row.id + '">' + data +'</a>';
					}
				},
				{
					data: "owner_name",
					label: "Owner",
					class: 'col-2'
				},
				{
					data: "email",
					label: "Email",
					class: 'col-2'
				},
				{
					data: "mobile",
					label: "Mobile",
					class: 'col-2'
				},
				{
					data: "status",
					label: "Status",
					class: 'col-2',
				},
				{
					data: "created_on",
					label: "Registration Date",
					render: function(data,row){
						return time2date(data);
					}
				},
				/*{
					data: "status",
					label: "Action",
					class: "text-center",
					class: 'col-2 text-nowrap',
					render: function(data,row){
						var buttons = '';
						if(data == 'Pending')
						{
							buttons += '<a class="btn btn-sm btn-primary btn-approve-tenant" href="<?php echo WEB_ROOT;?>/tenant/approved/' + row.id + '">Approve</a>';
							buttons += '<a class="ms-1 btn btn-sm btn-primary btn-disapprove-tenant" href="<?php echo WEB_ROOT;?>/tenant/approved/' + row.id + '">Disapprove</a>';
						}
						return buttons;
					},
					orderable: false
				},*/
			],
			order:[[5,'desc']],
			colFilter: {'status':'Pending'}
		});

		$(document).on('click','.btn-approve-tenant,.btn-disapprove-tenant',function(e){
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

		$(".btn-filter-status").on('click',function(){
			t<?php echo $unique_id;?>.options.colFilter = {'status':$(this).html()};
			t<?php echo $unique_id;?>.ajax.reload();

			$(".btn-filter-status").not($(this)).removeClass('btn-primary').addClass('btn-secondary');
			$(this).addClass('btn-primary').removeClass('btn-secondary');
		});
	});
</script>