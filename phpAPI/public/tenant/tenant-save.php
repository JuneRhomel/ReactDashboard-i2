<?php
$return_value = ['success'=>1,'data'=>[]];
$sql_test = '';
try{
    $table =  $data['table'];
    $view_table =  $data['view_table'] ?? null;
	unset($data['stage_table']);
	$update_table =  $data['update_table'] ?? null;
	$id = null ?? decryptData($data['id']);
    unset($data['table']);
	unset($data['update_table']);
    unset($data['view_table']);
    unset($data['id']);
    unset($data['file']);
	if($view_table == 'view_gate_pass'){
		//gpitems
		$item_num=$data['item_num'];
		$item_name=$data['item_name'];
		$item_qty=$data['item_qty'];
		$description=$data['description'];
		unset($data['item_num']);
		unset($data['item_name']);
		unset($data['item_qty']);
		unset($data['description']);
	}
	if($view_table == 'view_visitor_pass'){
		//vp_guest
		$guest_name=$data['guest_name'];
		$guest_num=$data['guest_num'];
		$guest_add=$data['guest_add'];
		unset($data['guest_name']);
		unset($data['guest_num']);
		unset($data['guest_add']);
	}
	if($view_table == 'view_move_in'  || $view_table == 'view_move_out'  || $view_table == 'view_work_permit'){
		//worker
		$worker_id=$data['workers_id'];
		$worker_name=$data['workers_name'];
		$worker_desc=$data['workers_desc'];
		unset($data['workers_id']);	
		unset($data['workers_name']);
		unset($data['workers_desc']);
		//materials
		$material_id=$data['material_id'];
		$material_qty=$data['material_qty'];
		$material_desc=$data['material_desc'];	
		unset($data['material_id']);
		unset($data['material_qty']);
		unset($data['material_desc']);
		//tools
		$tools_id=$data['tools_id'];
		$tools_qty=$data['tools_qty'];
		$tools_desc=$data['tools_desc'];
		unset($data['tools_id']);	
		unset($data['tools_qty']);
		unset($data['tools_desc']);
	}
	//files
	$attachments = $data['attachments'];
	unset($data['attachments']);
	

	if($id) {
		if($view_table != 'view_pdcs'){
			$fields = [];
			foreach( array_keys($data) as $field) {
				$fields[] = "{$field}=:{$field}";
			}
			$sth = $db->prepare("update {$account_db}.{$table} set " . implode(",",$fields). " where id={$id}");
			$sth->execute($data);

			if($view_table != null){
				
				$fields = [];
				foreach( array_keys($data) as $field) {
					$fields[] = "{$field}=:{$field}";
				}
				if($view_table=="building_personnel_view"){
					$sth = $db->prepare("update {$account_db}.{$view_table} set " . implode(",",$fields). " where rec_id={$id}");
					$sth->execute($data);
				}else if($view_table=="service_providers_view"){
					$sth = $db->prepare("update {$account_db}.{$view_table} set " . implode(",",$fields). " where rec_id={$id}");
					$sth->execute($data);
				}else{
					$sth = $db->prepare("update {$account_db}.{$view_table} set " . implode(",",$fields). " where rec_id={$id}");
					$sth->execute($data);
				}
			}

			if($view_table == 'view_gate_pass'){
				$sth = $db->prepare("update {$account_db}.gp_items set deleted_on=1 where gp_id={$id}");
				$sth->execute($data);

				foreach ($item_num as $i=>$row) {
					$item['gp_id'] = $id;
					$item['created_by'] = $user_token['user_id'];
					$item['created_on'] = time();
					$item['item_num'] = $item_num[$i];
					$item['item_name'] = $item_name[$i];
					$item['item_qty'] = $item_qty[$i];
					$item['description'] = $description[$i];

					$fields = array_keys($item);
					$sth = $db->prepare("insert {$account_db}.gp_items (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
					$sth->execute($item);
				}
			}else if($view_table == 'view_visitor_pass'){
				$sth = $db->prepare("update {$account_db}.vp_guest set deleted_on=1 where vp_id={$id}");
				$sth->execute($data);

				foreach ($guest_name as $i=>$row) {
					$item['vp_id'] = $id;
					$item['created_by'] = $user_token['user_id'];
					$item['created_on'] = time();
					$item['guest_name'] = $guest_name[$i];
					$item['guest_num'] = $guest_num[$i];
					$item['guest_add'] = $guest_add[$i];

					$fields = array_keys($item);
					$sth = $db->prepare("insert {$account_db}.vp_guest (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
					$sth->execute($item);
				}
			}else if($view_table == 'view_move_in'  || $view_table == 'view_move_out'  || $view_table == 'view_work_permit'){
				//workers
				foreach ($worker_name as $i=>$row) {
					$w_id = $worker_id[$i];
					$w_item['rec_id'] = $id;
					$w_item['ref_table'] = $table;
					$w_item['name'] = $worker_name[$i];
					$w_item['description'] = $worker_desc[$i];
					
					if($w_id){
						$fields = [];
						foreach( array_keys($w_item) as $field) {
							$fields[] = "{$field}=:{$field}";
						}

						$sql_test = $sth = $db->prepare("update {$account_db}.workers set " . implode(",",$fields). " where id={$w_id}");
						$sth->execute($w_item);
					}else{
						$w_item['created_by'] = $user_token['user_id'];
						$w_item['created_on'] = time();

						$fields = array_keys($w_item);
						$sth = $db->prepare("insert {$account_db}.workers (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
						$sth->execute($w_item);
					}
				}

				//materials
				foreach ($material_qty as $i=>$row) {
					$m_id = $material_id[$i];
					
					$m_item['rec_id'] = $id;
					$m_item['ref_table'] = $table;
					$m_item['qty'] = $material_qty[$i];
					$m_item['description'] = $material_desc[$i];

					if($m_id){
						$fields = [];
						foreach( array_keys($m_item) as $field) {
							$fields[] = "{$field}=:{$field}";
						}

						$sql_test = $sth = $db->prepare("update {$account_db}.materials set " . implode(",",$fields). " where id={$m_id}");
						$sth->execute($m_item);
					}else{
						$m_item['created_by'] = $user_token['user_id'];
						$m_item['created_on'] = time();

						$fields = array_keys($m_item);
						$sth = $db->prepare("insert {$account_db}.materials (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
						$sth->execute($m_item);
					}
				}

				//tools
				foreach ($tools_qty as $i=>$row) {
					$t_id = $tools_id[$i];
					
					$item['rec_id'] = $id;
					$item['ref_table'] = $table;
					$item['qty'] = $tools_qty[$i];
					$item['description'] = $tools_desc[$i];

					if($t_id){
						$fields = [];
						foreach( array_keys($item) as $field) {
							$fields[] = "{$field}=:{$field}";
						}

						$sql_test = $sth = $db->prepare("update {$account_db}.tools set " . implode(",",$fields). " where id={$t_id}");
						$sth->execute($item);
					}else{
						$item['created_by'] = $user_token['user_id'];
						$item['created_on'] = time();

						$fields = array_keys($item);
						$sth = $db->prepare("insert {$account_db}.tools (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
						$sth->execute($item);
					}
				}
			}
		}else{
			$rec_id = $data['rec_id'];
    		unset($data['rec_id']);


			$fields = [];
			foreach( array_keys($data) as $field) {
				$fields[] = "{$field}=:{$field}";
			}
			
			$sth = $db->prepare("update {$account_db}.{$table} set " . implode(",",$fields). " where id={$rec_id}");
			$sth->execute($data);

			if($view_table != null){
				
				$fields = [];
				foreach( array_keys($data) as $field) {
					$fields[] = "{$field}=:{$field}";
				}
			
				$sth = $db->prepare("update {$account_db}.{$view_table} set " . implode(",",$fields). " where id={$id}");
				$sth->execute($data);
			}
		}
	
	}else{
		$data['created_by'] = $user_token['user_id'];
		$data['created_on'] = time();

		$fields = array_keys($data);
		$sql_test =  $sql = "insert {$account_db}.{$table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")";
		$sth = $db->prepare($sql);
		$sth->execute($data);
		$id = $db->lastInsertId(); 

        if($view_table != null){
            $data['rec_id'] = $id;
            $data['created_by'] = $user_token['user_id'];
            $data['created_on'] = time();

            $fields = array_keys($data);
            $sth = $db->prepare("insert {$account_db}.{$view_table} (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
            $sth->execute($data);
        }

		if($view_table == 'view_gate_pass'){
			foreach ($item_num as $i=>$row) {
				$item['gp_id'] = $id;
				$item['created_by'] = $user_token['user_id'];
				$item['created_on'] = time();
				$item['item_num'] = $item_num[$i];
				$item['item_name'] = $item_name[$i];
				$item['item_qty'] = $item_qty[$i];
				$item['description'] = $description[$i];

				$fields = array_keys($item);
				$sth = $db->prepare("insert {$account_db}.gp_items (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
				$sth->execute($item);
			}
		}else if($view_table == 'view_visitor_pass'){
			foreach ($guest_name as $i=>$row) {
				$item['vp_id'] = $id;
				$item['created_by'] = $user_token['user_id'];
				$item['created_on'] = time();
				$item['guest_name'] = $guest_name[$i];
				$item['guest_num'] = $guest_num[$i];
				$item['guest_add'] = $guest_add[$i];

				$fields = array_keys($item);
				$sth = $db->prepare("insert {$account_db}.vp_guest (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
				$sth->execute($item);
			}
		}else if($view_table == 'view_move_in' || $view_table == 'view_move_out' || $view_table == 'view_work_permit'){
			//workers
			foreach ($worker_name as $i=>$row) {
				$w_item['created_by'] = $user_token['user_id'];
				$w_item['created_on'] = time();
				$w_item['rec_id'] = $id;
				$w_item['ref_table'] = $table;
				$w_item['name'] = $worker_name[$i];
				$w_item['description'] = $worker_desc[$i];

				$fields = array_keys($w_item);
				$sth = $db->prepare("insert {$account_db}.workers (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
				$sth->execute($w_item);
			}

			//materials
			foreach ($material_qty as $i=>$row) {
				$m_item['created_by'] = $user_token['user_id'];
				$m_item['created_on'] = time();
				$m_item['rec_id'] = $id;
				$m_item['ref_table'] = $table;
				$m_item['qty'] = $material_qty[$i];
				$m_item['description'] = $material_desc[$i];

				$fields = array_keys($m_item);
				$sth = $db->prepare("insert {$account_db}.materials (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
				$sth->execute($m_item);
			}

			//tools
			foreach ($tools_qty as $i=>$row) {
				$item['created_by'] = $user_token['user_id'];
				$item['created_on'] = time();
				$item['rec_id'] = $id;
				$item['ref_table'] = $table;
				$item['qty'] = $tools_qty[$i];
				$item['description'] = $tools_desc[$i];

				$fields = array_keys($item);
				$sth = $db->prepare("insert {$account_db}.tools (" . implode(",",$fields). ") values(:" . implode(",:",$fields) . ")");
				$sth->execute($item);
			}
		}

		//if has attachments
		if(is_array($attachments))
		{
			foreach($attachments as $attachment)
			{
				//write to file
				$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/{$table}/";
				if(!is_dir($upload_dir))
				{
					mkdir($upload_dir,0777,true);
				}
				$content = base64_decode($attachment['data']);
				$diskname = uniqueFilename($attachment['filename']);
				file_put_contents($upload_dir . "/" . $diskname, $content);
				$attachments_data = [
					'attachment_url'=>WEB_ROOT . "/uploads/{$accountcode}/{$table}/{$diskname}",
					'filename' => $attachment['filename'],
					'diskname' => $diskname,
					'reference_table' => $table,
					'created_by' => $user_token['user_id'],
					'reference_id' => $id,
					'created_on' => time()
				]; 

				$sth = $db->prepare("insert into {$account_db}.attachments (" . implode(",",array_keys($attachments_data)) . ") values(?" . str_repeat(",?",count(array_keys($attachments_data))-1) .")");
				$sth->execute(array_values($attachments_data));
			}
		}
	}

	$return_value = ['success'=>1,'description'=>'Record saved.', 'id' =>  encryptData($id), 'data'=>$data];
}catch(Exception $e){
	$return_value = ['success'=>0,'description'=>$e->getMessage(), 'sql_test' => $sql_test, 'item' => $w_item];
}
echo json_encode($return_value);