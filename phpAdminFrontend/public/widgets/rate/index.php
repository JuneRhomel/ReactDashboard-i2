<?php
$title = "Rates";
$module = "rate";
$table = "rates";
$view = "view_rates";
$fields = rawurlencode(json_encode(["ID" => "id", "Name" => "rate_name", "Code" => "rate_code", "Value" => "rate_value", "Created" => "from_unixtime(created_on) created_date"]));
?>

<style>

</style>
<div class="page-title"><?= $title ?></div>

</div>
<!-- alert-warning -->
<!-- alert-error -->


<script>

</script>