
<div class="page-title">Scheduled Preventive Maintenance</div>
<div class="bg-white p-2 rounded">
	<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add-schedule">Add Schedule <span class="bi bi-plus-circle"></span></button>
	<div class="row">
		<div class="col-2">
			<label>Property</label>
			<select class="form-control">
			</select>
		</div>
		<div class="col-2">
			<label>Location</label>
			<select class="form-control">
			</select>
		</div>
		<div class="col-2">
			<label>Search</label>
			<input type="text" class="form-control" placeholder="Search">
		</div>
	</div>
</div>

<div id="jsdata"></div>

<script>
	$(document).ready(function(){
		$(".btn-add-schedule").off('click').on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/pm/form';
		});

		$("#jsdata").JSDataList({
			pageLength: 25,
			searchBoxID: 'searchbox',
			ajax: {
				url: '<?php echo WEB_ROOT;?>/pm/get-pm-list?display=plain'
			},
			columns:[
				{
					data: "wo",
					label: "Work Order",
					class: 'col-2',
					render: function(data,row){
						return '<a href="<?php echo WEB_ROOT;?>/equipment/view/' + row.id + '">' + data +'</a>';
					}
				},
				{
					data: "created_by",
					label: "Created By",
					class: 'col-2'
				},
				{
					data: "equipment",
					label: "Equipment",
					class: 'col-2'
				},
				{
					data: "priority",
					label: "Priority",
					class: 'col-2'
				},
				{
					data: "service_provider",
					label: "Service Provider",
					class: 'col-2',
					render: function(data,row){
						return data == 1 ? 'Yes' : 'No';
					}
				},
				{
					data: null,
					label: "",
					class: "text-center",
					render: function(data,row){
						return '<a class="btn btn-sm btn-primary" href="<?php echo WEB_ROOT;?>/pm/form/' + row.id + '">edit <i class="bi bi-pen"></i></a>';
					},
					orderable: false
				}
			]
		});
	});
</script>