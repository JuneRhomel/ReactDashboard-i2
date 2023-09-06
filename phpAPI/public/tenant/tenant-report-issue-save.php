<?php
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

    if ($id) {
        $fields = [];
        foreach (array_keys($data) as $field) {
            $fields[] = "{$field}=:{$field}";
        }
        $sth = $db->prepare("UPDATE {$account_db}.{$table} SET " . implode(",", $fields) . " WHERE id={$id}");
        $sth->execute($data);
    } else {

        $data['created_by'] = $user_token['tenant_id'];
        $data['created_on'] = time();
        
        $fields = array_keys($data);
        $fieldsString = implode(",", $fields);
        $valuesString = ":" . implode(",:", $fields);
        
        // Assuming $db is your PDO instance
        $sth = $db->prepare("INSERT INTO {$account_db}.{$table} ({$fieldsString}) VALUES ({$valuesString})");
        $sth->execute($data);
        
        $id = $db->lastInsertId();
        
        if ($id) {
            $sth = $db->prepare("INSERT INTO {$account_db}.reportissue_status (status_id, reportissue_id,created_by) VALUES (:status_id, :reportissue_id,:created_by)");
            $sth->execute([
                'status_id' => 1,
                'reportissue_id' => $id,
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
        
    }
    if (is_array($attachments)) {
        foreach ($attachments as $attachment) {
            $upload_dir = "uploads/$accountcode/$module";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $content = base64_decode($attachment['data']);
            $diskname = uniqueFilename($attachment['filename']);
            $attachment_url = WEB_ROOT . '/' . $upload_dir . '/' . $diskname;

            // Update the database with the image path
            file_put_contents($upload_dir . "/" . $diskname, $content);

            $sql = "UPDATE {$account_db}.{$table} SET  attachments = :attachments WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':attachments', $attachment_url);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
        // Save the attachments

    }
    $return_value = [
        'success' => 1,
        'description' => 'Record saved.',
        'id' => $id,
        'attachments' => $attachments
    ];
} catch (Exception $e) {
    $return_value = [
        'success' => 0,
        'description' => $e->getMessage()
    ];
}
echo json_encode($return_value);
