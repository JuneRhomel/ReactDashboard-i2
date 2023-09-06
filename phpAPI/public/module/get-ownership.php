<?php
$return_value = [];
try {
	$sth = $db->prepare("select ownership from {$account_db}.system_info");
	$sth->execute();
	$return_value = $sth->fetch()['ownership'];
} catch (Exception $err) {
	$return_value = [ 'success'=>0, 'description'=>$err->getMessage()];
}
echo json_encode($return_value);