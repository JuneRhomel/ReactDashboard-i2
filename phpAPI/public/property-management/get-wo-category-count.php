<?php
$return_value = ['success'=>1,'data'=>['count'=>0]];
$category = $data['category'];

try{
	$count = 0;

	if($category == 'safetysecurity'){
		$sth = $db->query("select count(id) as c from {$account_db}.wo where deleted_on=0 and category_id='Structural' and stage != 'Closed'");
		$record = $sth->fetch();
		$count += $record['c'];

		$sth = $db->query("select count(id) as c from {$account_db}.wo where deleted_on=0 and category_id='Civil' and stage != 'Closed'");
		$record = $sth->fetch();
		$count += $record['c'];
	}else{
		$sth = $db->query("select count(id) as c from {$account_db}.wo where deleted_on=0 and category_id='{$category}' and stage != 'Closed'");
		$record = $sth->fetch();
		$count += $record['c'];
	}

	$return_value['data']['count'] = $count;
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage()];
}

echo json_encode($return_value);