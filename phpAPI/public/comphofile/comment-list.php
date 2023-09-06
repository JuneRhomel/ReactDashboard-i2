<?php
$result = ['success'=>0,'description'=>'','data'=>[]];

try{
	$id = decryptData($data['reference_id']);
	$sql = "select a.*,date_format(a.created_on,'%m/%d/%Y') as created_on, b.full_name
		from {$account_db}.comments a left join {$account_db}.`vw_users` b on b.id=a.created_by where a.reference_id=? and a.reference_table=?";
	$sth = $db->prepare($sql);
	$sth->execute([ $id, $data['reference_table'] ]);
	$recs = $sth->fetchAll();

	$result = ['success'=>1,'description'=>'','data'=>$recs];
}catch(Exception $err){
	$result['description'] = $err->$message;
}

echo json_encode($result);