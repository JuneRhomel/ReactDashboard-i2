<div class="page-title">Equipment</div>
<div class="bg-white p-2 rounded">
	<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add-equipment">Add Equipment <span class="bi bi-plus-circle"></span></button>
	<div class="row">
		<div class="col-2">
			<label>Search</label>
			<input type="text" class="form-control" placeholder="Search" id="searchbox">
		</div>
	</div>
</div>

<div id="jsdata"></div>

<script>
	$(document).ready(function(){
		$(".btn-add-equipment").off('click').on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/equipment/form';
		});

		$("#jsdata").JSDataList({
			pageLength: 25,
			searchBoxID: 'searchbox',
			ajax: {
				url: '<?php echo WEB_ROOT;?>/equipment/get-equipment-list?display=plain'
			},
			columns:[
				{
					data: "asset_id",
					label: "Asset ID",
					class: 'col-2',
					render: function(data,row){
						return '<a href="<?php echo WEB_ROOT;?>/equipment/view/' + row.id + '">' + data +'</a>';
					}
				},
				{
					data: "equipment_name",
					label: "Name",
					class: 'col-2'
				},
				{
					data: "equipment_type",
					label: "Type",
					class: 'col-2'
				},
				{
					data: "equipment_name",
					label: "Location",
					class: 'col-2'
				},
				{
					data: "is_critical",
					label: "Critical Equipmet",
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
						return '<a class="btn btn-sm btn-primary" href="<?php echo WEB_ROOT;?>/equipment/form/' + row.id + '">edit <i class="bi bi-pen"></i></a>';
					},
					orderable: false
				}
			]
		});
	});
</script>