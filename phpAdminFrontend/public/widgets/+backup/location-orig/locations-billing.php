<a href="<?=WEB_ROOT."/billing/form?location_id=".$location['rec_id']?>" target="_blank"><button class="btn btn-sm btn-primary btn-add"> Add Billing <i class="bi bi-plus-circle"></i></button></a>
<div id="jsdata"></div>
<script>
	$(document).ready(function(){
		$("#jsdata").JSDataList({
			pageLength: 25,
			searchBoxID: 'searchbox',
			ajax: {
				url: '<?=WEB_ROOT."/module/get-list/view_billings?display=plain&loc_id={$location['rec_id']}"?>'
			},
			columns:[
				{
					data: "rec_id",
					label: "ID",
					class: 'col-1',
					render: function(data,row){
						return '<a href="<?php echo WEB_ROOT;?>/billing/view/' + row.id + '" target="_blank">' + data +'</a>';
					}
				},
				{
					data: "billing_date",
					label: "Date",
					class: 'col-2'
				},
				{
					data: "tenant_name",
					label: "Resident",
					class: 'col-3'
				},
				{
					data: "location_name",
					label: "Unit",
					class: 'col-2'
				},
				{
					data: "billing_type",
					label: "Type",
					class: 'col-1'
				},
				{
					data: "created_on",
					label: "Created",
					class: 'col-2',
					render: function(data,row){
						return time2date(data);
					}
				}
			]
		});
	});
</script>