<div class="page-title">Service Providers</div>
<div class="bg-white p-2 rounded">
	<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add-provider">Add Service Provider <span class="bi bi-plus-circle"></span></button>
	<div class="row">
		<div class="col-2">
			<label>Search</label>
			<input type="text" class="form-control" placeholder="Search">
		</div>
	</div>
</div>

<div class="p-2 rounded bg-white mt-2">
	<div class="row">
		<div class="col">NAME</div>
		<div class="col">CONTACT PERSON</div>
		<div class="col">CONTACT NUMBER</div>
		<div class="col">EMAIL ADDRESS</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".btn-add-provider").off('click').on('click',function(){
			window.location.href = '<?php echo WEB_ROOT;?>/serviceprovider/form';
		});
	});
</script>