<?php
$result = $ots->execute('tenant','delete-movement',$args);
?>
<script>
	$(document).ready(function(){
		$(".notification-success-message").html("Record deleted.");		
		$(".notification-success").fadeIn('slow');
		window.location.href = "<?=WEB_ROOT;?>/tenant/movements?submenuid=moveio";
	});
</script>