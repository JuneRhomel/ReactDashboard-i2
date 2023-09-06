<div class="page-title">Reservation</div>
<div class="bg-white p-2 rounded">
	<!--button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add-reservation">Add Reservation <span class="bi bi-plus-circle"></span></button-->
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

<div id="jsdata"></div>

<script>
	<?php $unique_id = 'amenityreservation' . time();?>
	var t<?php echo $unique_id;?>;

	function timetoDate(unix_timestamp)
	{
		var date = new Date(unix_timestamp * 1000);
		return date.getFullYear() + '-' + ((date.getMonth() + 1 ) < 10 ? '0' : '') + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + (date.getHours() < 10 ? '0' : '') + date.getHours() + ':' + (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();
	}


	$(document).ready(function(){
		$(".btn-add-reservation").off('click').on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/reservation/form';
		});

		t<?php echo $unique_id;?> = $("#jsdata").JSDataList({
			pageLength: 10,
			searchBoxID: 'searchbox',
			prefix: 'reservation',
			ajax: {
				url: '<?php echo WEB_ROOT;?>/amenity/get-reservations?display=plain'
			},
			columns:[
				{
					data: "reserved_from",
					label: "Schedule",
					class: 'col-3',
					render: function(data,row){
						return '<a href="<?php echo WEB_ROOT;?>/amenity/view-reservation/' + row.id + '">' + row.schedule +'</a>';
					}
				},
				{
					data: "amenity_name",
					label: "Amenity",
					class: 'col-2'
				},
				{
					data: "tenant_name",
					label: "Tenant",
					class: 'col-2'
				},
				{
					data: "description",
					label: "Remarks",
					class: 'col-3'
				},
				{
					data: "status",
					label: "Status",
					class: 'col-1',
					orderable: false
				},
				/*{
					data: "status",
					label: "Action",
					class: "text-center",
					class: 'col-2',
					render: function(data,row){
						var buttons = '';
						if(data == 'Pending')
						{
							buttons += '<a class="btn btn-sm btn-primary btn-approve-reservation" href="<?php echo WEB_ROOT;?>/amenity/reservation-approved/' + row.id + '">Approve</a>';
							buttons += '<a class="ms-1 btn btn-sm btn-primary btn-disapprove-reservation" href="<?php echo WEB_ROOT;?>/amenity/reservation-disapproved/' + row.id + '">Disapprove</a>';
						}
						return buttons;
					},
					orderable: false
				}*/
			],
			colFilter:{'status':'Pending'}
		});

		$(document).on('click','.btn-approve-reservation,.btn-disapprove-reservation',function(e){
			e.preventDefault()

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