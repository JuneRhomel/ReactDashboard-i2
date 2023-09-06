<?php
$module = $args[0];
$result = $ots->execute("module", "delete", $args);
?>
<link href="<?= WEB_ROOT; ?>/css/toastr.css" rel="stylesheet">
<script src="<?= WEB_ROOT; ?>/js/toastr.min.js"></script>
<script>
	$(document).ready(function() {
		popup({
			title: "Record deleted",
			data: {
				success: 1
			},
			reload_time: 2000,
			redirect: "<?= WEB_ROOT . "/$module/" ?>"
		});

	});
</script>