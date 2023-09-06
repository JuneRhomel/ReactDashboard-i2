<?php
$result = $ots->execute('tenant','delete-turnover',$args);
?>
<script>
	$(document).ready(function(){
		$(".notification-success-message").html("Record deleted.");		
		$(".notification-success").fadeIn('slow');
		window.location.href = "<?=WEB_ROOT;?>/tenant/turnovers?submenuid=turnover";
	});
</script>