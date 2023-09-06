<div class="page-title">Billing</div>
<div class="bg-white p-2 rounded">
	<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add-billing">Add Billing <span class="bi bi-plus-circle"></span></button>
	<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-upload-billing">Upload Billing <span class="bi bi-plus-circle"></span></button>
	<div class="row">
		<div class="col-12 col-sm-6">
			<label>Search</label>
			<input type="text" class="form-control" placeholder="Search" id="searchbox">
		</div>
	</div>
</div>

<div id="jsdata"></div>

<script>
	var jsdata = null;
	$(document).ready(function(){
		$(".btn-add-billing").off('click').on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/billing/form';
		});

		$(".btn-upload-billing").on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/billing/upload';
		});

		jsdata = $("#jsdata").JSDataList({
			pageLength: 25,
			searchBoxID: 'searchbox',
			prefix: 'billing',
			ajax: {
				url: '<?php echo WEB_ROOT;?>/billing/get-billings?display=plain'
			},
			columns:[
				{
					data: "id",
					label: "No.",
					class: 'col-1',
					render: function(data,row){
						return '<a href="<?php echo WEB_ROOT;?>/billing/view/' + row.id + '">' + row.billing_number +'</a>';
					}
				},
				{
					data: "billing_date",
					label: "Date",
					class: 'col-1',
				},
				{
					data: "tenant_name",
					label: "Resident",
					class: 'col-2'
				},
				{
					data: "location_name",
					label: "Unit",
					class: 'col-2',
				},
				{
					data: "billing_type",
					label: "Type",
					class: 'col-1',
				},
				{
					data: "amount",
					label: "Amount",
					class: 'col-1',
					render: function(data,row){
						return jsdata.numberWithCommas(data);
					},
					orderable: false
				},
				{
					data: "due_date",
					label: "Due Date",
					class: 'col-1',
					orderable: false
				},
				{
					data: "payment",
					label: "Payment",
					class: 'col-1',
					render: function(data,row){
						return jsdata.numberWithCommas(data);
					},
					orderable: false
				},
				{
					data: "amount",
					label: "Balance",
					class: 'col-1',
					render: function(data,row){
						return jsdata.numberWithCommas(row.amount - row.payment);
					},
					orderable: false
				},
				{
					data: null,
					label: "",
					class: "text-center",
					render: function(data,row){
						return '<a class="btn btn-sm btn-primary btn-edit-billing" href="<?php echo WEB_ROOT;?>/billing/form/' + row.id + '">edit <i class="bi bi-pen"></i></a>';
					},
					orderable: false
				},
				
			],
			order: [[0,'desc']]
		});
	});
</script>