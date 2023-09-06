<div id="jsdata"></div>

<script>
	$(document).ready(function(){
		$("#jsdata").JSDataList({
			pageLength: 25,
			searchBoxID: 'searchbox',
			ajax: {
				url: '<?php echo WEB_ROOT;?>/location/get-sub-locations?locationid=<?php echo $location['id'];?>&display=plain'
			},
			columns:[
				{
					data: "location_name",
					label: "Name",
					class: 'col-2',
					render: function(data,row){
						return '<a href="<?php echo WEB_ROOT;?>/location/view/' + row.id + '">' + data +'</a>';
					}
				},
				{
					data: "parent_location_name",
					label: "Location",
					class: 'col-2'
				},
				{
					data: "location_type",
					label: "Type",
					class: 'col-2'
				},
				{
					data: "location_use",
					label: "Use",
					class: 'col-2'
				},
				{
					data: "location_status",
					label: "Status",
					class: 'col-2'
				},
				{
					data: null,
					label: "",
					class: "text-center",
					render: function(data,row){
						return '<a class="btn btn-sm btn-primary btn-edit-location" href="<?php echo WEB_ROOT;?>/location/form/' + row.id + '">edit <i class="bi bi-pen"></i></a>';
					},
					orderable: false
				}
			]
		});
	});
</script>