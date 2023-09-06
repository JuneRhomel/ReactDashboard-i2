<?php
$return_value = [];
try{
	$records = $db->prepare("select forms.title,form_uploads.created_on uploaded_on,form_uploads.file_url,
	form_uploads.status
	from {$account_db}.form_uploads,{$account_db}.forms where form_uploads.form_id=forms.id and tenant_id=?");
	$records->execute([$user_id]);
	$return_value = $records->fetchAll();

	foreach($return_value as $index=>$record)
	{
		$return_value[$index]['id'] = encryptData($record['id']);
	}
}catch(Exception $e){
	$return_value[] = $e->getMessage();
}

echo json_encode($return_value,JSON_NUMERIC_CHECK);