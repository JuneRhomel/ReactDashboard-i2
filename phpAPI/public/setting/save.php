<?php
$return_value = ['success' => 1, 'description' => ''];
try {
	$process = $data['process'];
	unset($data['process']);
	$id = $data['id'];
	unset($data['id']);
	unset($data['redirect']);
	$attachments = $data['attachments'];
	unset($data['attachments']);
	$desc = $data['description'];
	unset($data['description']);

	if ($process == 'update_record') {
		$data['updated_by'] = $user_token['user_id'];
		$data['updated_at'] = time();

		$fields = [];
		foreach (array_keys($data) as $field) {
			$fields[] = "{$field}=:{$field}";
		}

		$sth = $db->prepare("update {$account_db}._users set " . implode(",", $fields) . " where id={$id}");
		$sth->execute($data);
	} else if ($process == 'change_pass') {
		$sth = $db->prepare("select * from {$account_db}._users where id={$id}");
		$sth->execute();
		$user_info = $sth->fetch();

		//checking if old pass == inputed old pass
		if ($user_info['password'] == md5($data['old_password'])) {
			if ($data['new_password'] == $data['confirm_password']) {
				$decryptPass = md5($data['new_password']);
				$sth = $db->prepare("UPDATE {$account_db}._users SET password = :password WHERE id = :id");
				$sth->bindParam(':password', $decryptPass);
				$sth->bindParam(':id', $id);
				$sth->execute();

				$sth->execute();
			} else {
				throw new Exception('New Password and Confirm Password not match');
			}
		} else {
			throw new Exception('Incorrect Old Password');
		}
	} else if ($process == 'upload_profile') {
		if (is_array($attachments)) {
			foreach ($attachments as $attachment) {
				//write to file
				$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/setting/";
				if (!is_dir($upload_dir)) {
					mkdir($upload_dir, 0777, true);
				}
				$content = base64_decode($attachment['data']);
				$diskname = uniqueFilename($attachment['filename']);
				file_put_contents($upload_dir . "/" . $diskname, $content);
				$attachments_data = [
					'attachment_url' => WEB_ROOT . "/uploads/{$accountcode}/setting/{$diskname}",
					'filename' => $attachment['filename'],
					'diskname' => $diskname,
					'reference_table' => 'Setting',
					'created_by' => $user_token['user_id'],
					'reference_id' => $id,
					'description' => $desc,
					'created_on' => time()
				];

				$sth = $db->prepare("insert into {$account_db}.attachments (" . implode(",", array_keys($attachments_data)) . ") values(?" . str_repeat(",?", count(array_keys($attachments_data)) - 1) . ")");
				$sth->execute(array_values($attachments_data));
			}
		}
	}

	$return_value = ['success' => 1, 'description' => 'Record saved.', 'id' =>  encryptData($id), 'data' => $data];

	//OLD CODE
	// $id = isset($data['id']) ? decryptData($data['id']) : 0;
	// unset($data['id']);

	// if(!$id)
	// {
	// 	$data['created_on'] = time();
	// 	$data['created_by'] = $user_id;
	// }

	// if(is_array($data['file']) && $data['file']['filename'] && $data['file']['data'])
	// {
	// 	//write to file
	// 	$upload_dir = DIR_ROOT . "/public/uploads/{$accountcode}/news/";
	// 	if(!is_dir($upload_dir))
	// 	{
	// 		mkdir($upload_dir,0777,true);
	// 	}
	// 	$content = base64_decode($data['file']['data']);
	// 	$diskname = uniqueFilename($data['file']['filename']);
	// 	file_put_contents($upload_dir . "/" . $diskname, $content);
	// 	$data['image_url'] = WEB_ROOT . "/uploads/{$accountcode}/news/{$diskname}"; 
	// }

	// unset($data['file']);

	// if($id)
	// {
	// 	$update_values = [];
	// 	foreach(array_keys($data) as $field)
	// 		$update_values[] = "{$field}=?";

	// 	$sth = $db->prepare("update {$account_db}.news set " . implode(",",$update_values) . " where id=?");
	// 	$data['id'] = $id;
	// }
	// else
	// 	$sth = $db->prepare("insert into {$account_db}.news (" . implode(",",array_keys($data)) . ") values(?" . str_repeat(",?",count(array_keys($data))-1) .")");
	// $sth->execute(array_values($data));

} catch (Exception $e) {
	$return_value = ['success' => 0, 'description' => $e->getMessage()];
}
echo json_encode($return_value);
