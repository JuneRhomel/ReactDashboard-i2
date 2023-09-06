<?php
$result = $ots->execute('tenant','delete-punchlist',$args);
?>
<script>
	$(document).ready(function(){
		$(".notification-success-message").html("Record deleted.");		
		$(".notification-success").fadeIn('slow');
		window.location.href = "<?=WEB_ROOT;?>/tenant/punchlists?submenuid=punchlist";
	});
</script>