<?php

// API FOR WORK PERMIT GATE PASS VISITOR PASS
$return_value = ['success' => 1, 'data' => []];
try {

    $module = $data['module'];
    unset($data['module']);
    $table = $data['table'];
    unset($data['table']);

    if (is_int(intval($data['id'])) && intval($data['id']) > 0) {
        $id = $data['id'];
    } else {
        $id = ($data['id']) ? decryptData($data['id']) : 0;
        unset($data['id']);
    }

    $loc_id = $data['loc_id'];
    unset($data['loc_id']);
    $content = $data['content'];

    $attachments = $data['attachments'];
    unset($data['attachments']);

    if ($id) {
        if ($module=="soa") {
			$arrAmount = (array) $data['amount'];
			$soa_status = "For Verification";
			// UPDATE SOA DETAIL			
			foreach($data['payment'] as $key=>$val) {
				if ($arrAmount[$key]!=$val)
					$soa_status = "Partially Paid";
				$sth = $db->prepare("update {$account_db}.{$table} set amount_bal=amount_bal-? where id=?");	
				$sth->execute([ $val, $key ]);
				// GET PARTICULAR
				$sth = $db->prepare("select particular from {$account_db}.soa_detail where id=?");	
				$sth->execute([ $key ]);
				$soa_detail = $sth->fetch();
				// INSERT INTO SOA_PAYMENT
				$sth = $db->prepare("insert {$account_db}.soa_payment set soa_id=?,payment_type=?,particular=?,amount=?,created_by=?,created_on=?");	
				$sth->execute([ $id, $data['payment_type'], $soa_detail['particular'], $val, $user_token['tenant_id'], time() ]);
			}
			// IF CHECK, INSERT INTO PDC
			if ($data['payment_type']=="Check") {
				// GET RESIDENT AND UNIT INFO
				$sth = $db->prepare("select a.resident_id,b.unit_id from {$account_db}.soa a left join {$account_db}.resident b on b.id=a.resident_id where a.id=?");	
				$sth->execute([ $id ]);
				$info = $sth->fetch();
				// ADD PDC
				$sth = $db->prepare("insert {$account_db}.pdcs set unit_id=?,resident_id=?,check_no=?,check_date=?,check_amount=?,status_id=1,created_by=?,created_on=?");	
				$sth->execute([ $info['unit_id'],$info['resident_id'], $data['check_no'], $data['check_date'], $data['check_amount'], $user_token['tenant_id'], time() ]);
			}
			// UPDATE SOA
			$sth = $db->prepare("update {$account_db}.soa set status=? where id=?");	
			$sth->execute([ $soa_status, $id ]);
		} else {
			// INIT UNIQUE FIELDS
			if ($arrUnique) {
				$unique_data['id'] = $id;
				foreach ($arrUnique as $unique) {
					$uniques[] = "{$unique}=:{$unique}";
					$unique_data[$unique] = $data[$unique];
				}
				// CHECK IF EXISTING DUPLICATE RECORD BASE ON UNIQUE FIELDS
				$sql = "select * from {$account_db}.{$table} where id<>:id and " . implode(" and ",$uniques);
				$sth = $db->prepare("select * from {$account_db}.{$table} where deleted_on=0 and id<>:id and " . implode(" and ",$uniques));
				$sth->execute($unique_data);
				$check = $sth->fetch();
				if ($check) {
					echo json_encode(['success'=>0,'description'=>'Duplicate record.']);
					exit;
				} 
			}

			$fields = [];
			foreach (array_keys($data) as $field) {
				$fields[] = "{$field}=:{$field}";
			}
			$sth = $db->prepare("update {$account_db}.{$table} set " . implode(",",$fields). " where id={$id}");
			$sth->execute($data);
		}
    } else {
        if ($table == "workpermit") {
            $data['created_by'] = $user_token['tenant_id'];
            $data['created_on'] = time();

            $fields = array_keys($data);
            $sth = $db->prepare("insert {$account_db}.{$table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")");
            $sth->execute($data);
            $id = $db->lastInsertId();

            if ($id) {
                $sth = $db->prepare("INSERT INTO {$account_db}.workpermit_status (status_id, workpermit_id,created_by) VALUES (:status_id, :workpermit_id,:created_by)");
                $sth->execute([
                    'status_id' => 1,
                    'workpermit_id' => $id,
                    'created_by' => $user_token['tenant_id']
                ]);

                $id_status = $db->lastInsertId();

                if ($id_status) {
                    $sth = $db->prepare("UPDATE {$account_db}.{$table} SET status_id = :status_id WHERE id = :id");
                    $sth->execute([
                        'status_id' => $id_status,
                        'id' => $id,
                    ]);
                }
            }
        } elseif ($table == "photos") {
            $data['created_by'] = $user_token['tenant_id'];


            $fields = array_keys($data);
            $sth = $db->prepare("insert {$account_db}.{$table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")");
            $sth->execute($data);
            $id = $db->lastInsertId();
            if (is_array($attachments)) {
                foreach ($attachments as $attachment) {
                    $upload_dir = "uploads/$accountcode/$module/proof-of-payment";

                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    $content = base64_decode($attachment['data']);
                    $diskname = uniqueFilename($attachment['filename']);
                    $attachment_url = WEB_ROOT . '/' . $upload_dir . '/' . $diskname;

                    // Update the database with the image path
                    file_put_contents($upload_dir . "/" . $diskname, $content);

                    $sql = "UPDATE {$account_db}.{$table} SET  attachment_url = :attachment_url, filename= :filename, diskname= :diskname  WHERE id = :id";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':attachment_url', $attachment_url);
                    $stmt->bindParam(':filename', $attachment['filename']);
                    $stmt->bindParam(':diskname', $diskname);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    
                }
                // Save the attachments

            }
        } else {
            $data['created_by'] = $user_token['tenant_id'];
            $data['created_on'] = time();

            $fields = array_keys($data);
            $sth = $db->prepare("insert {$account_db}.{$table} (" . implode(",", $fields) . ") values(:" . implode(",:", $fields) . ")");
            $sth->execute($data);
            $id = $db->lastInsertId();
        }
    }

    $return_value = ['success' => 1, 'description' => 'Record saved.', 'id' => $id];
} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage()];
}
echo json_encode($return_value);
