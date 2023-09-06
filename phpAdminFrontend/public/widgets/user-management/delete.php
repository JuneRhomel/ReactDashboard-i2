<?php
$module = $args[0];
$result = $ots->execute("user-management","delete",$args);
?>
<link href="<?=WEB_ROOT;?>/css/toastr.css" rel="stylesheet">
<script src="<?=WEB_ROOT;?>/js/toastr.min.js"></script>
<script>
	$(document).ready(function(){
		toastr.success('Record deleted','Information',{ timeOut:2000, onHidden: function() { location="<?=WEB_ROOT."/$module/"?>"; }});
	});
</script>