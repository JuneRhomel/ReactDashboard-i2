<div class="page-title">Generate Billing</div>

<div class="bg-white p-2 rounded">
	<div class="mt-2">
		<a class="btn-generate" href="<?php echo WEB_ROOT;?>/billing/generate/assoc">Association Dues</a>
	</div>

	<div class="mt-2">
		<a class="btn-generate" href="<?php echo WEB_ROOT;?>/billing/generate/utility">Utility</a>
	</div>
</div>

<div class="bg-white p-2 rounded mt-5">
	<div class="status"></div>
</div>

<script>
	$(document).ready(function(){
		$(".btn-generate").on('click',function(e){
			e.preventDefault();

			$(".status").html('Processing please wait...');

			$.ajax({
				url: $(this).prop('href') + '?display=plain' ,
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'html',
				beforeSend: function(){
				},
				success: function(data){
					$(".status").html(data);
				},
				complete: function(){
					//$(".status").html('Done');
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});
	});
</script>