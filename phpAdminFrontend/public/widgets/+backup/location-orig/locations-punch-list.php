<a href="<?=WEB_ROOT."/tenant/form-punchlist?location_id=".$location['rec_id']?>" target="_blank"><button class="btn btn-sm btn-primary btn-add"> Add Punch List <i class="bi bi-plus-circle"></i></button></a>
<div id="jsdata"></div>
<script>
	$(document).ready(function(){
		$("#jsdata").JSDataList({
			pageLength: 25,
			searchBoxID: 'searchbox',
			ajax: {
				url: '<?=WEB_ROOT."/module/get-list/view_tenant_punchlists?display=plain&loc_id={$location['rec_id']}"?>'
			},
			columns:[
				{
					data: "punchlist_id",
					label: "ID",
					class: 'col-1',
					render: function(data,row){
						return '<a href="<?php echo WEB_ROOT;?>/tenant/view-punchlist/' + row.id + '" target="_blank">' + data +'</a>';
					}
				},
				{
					data: "tenant_name",
					label: "Name of Owner",
					class: 'col-3'
				},
				{
					data: "details",
					label: "Remarks",
					class: 'col-4'
				},
				{
					data: "status",
					label: "Status",
					class: 'col-2'
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