<div id="jsdata"></div>
<script>
	$(document).ready(function(){
		$("#jsdata").JSDataList({
			pageLength: 25,
			searchBoxID: 'searchbox',
			ajax: {
				url: '<?=WEB_ROOT."/module/get-list/view_forms_uploaded?display=plain&loc_id={$location['rec_id']}"?>'
			},
			columns:[
				{
					data: "rec_id",
					label: "ID",
					class: 'col-1',
					render: function(data,row){
						return '<a href="<?php echo WEB_ROOT;?>/form/view-submitted/' + row.id + '" target="_blank">' + data +'</a>';
					}
				},
				{
					data: "title",
					label: "Form",
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