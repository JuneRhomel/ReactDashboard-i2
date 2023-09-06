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
    $thumbnail = $data['thumbnail'];

    if ($id) {
        $fields = [];
        foreach (array_keys($data) as $field) {
            $fields[] = "{$field}=:{$field}";
        }
        $sth = $db->prepare("UPDATE {$account_db}.{$table} SET " . implode(",", $fields) . " WHERE id={$id}");
        $sth->execute($data);
    } else {

        $data['created_by'] = $user_token['user_id'];
        $data['created_on'] = time();

        $fields = array_keys($data);
        $fieldsString = implode(",", $fields);
        $valuesString = ":" . implode(",:", $fields);
        $sth = $db->prepare("INSERT INTO {$account_db}.{$table} ({$fieldsString}) VALUES ({$valuesString})");
        $sth->execute($data);
        $id = $db->lastInsertId();

    }
    if (is_array($thumbnail)) {
        foreach ($thumbnail as $attachment) {
            $upload_dir = "uploads/$module";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $content = base64_decode($attachment['data']);
            $diskname = uniqueFilename($attachment['filename']);
            $attachment_url = WEB_ROOT . '/' . $upload_dir . '/' . $diskname;

            // Update the database with the image path
            file_put_contents($upload_dir . "/" . $diskname, $content);

            $sql = "UPDATE {$account_db}.{$table} SET  thumbnail = :thumbnail WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':thumbnail', $attachment_url);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
        // Save the thumbnail
    
    }
    $return_value = [
        'success' => 1,
        'description' => 'Record saved.',
        'id' => $id,
        'thumbnail' => $thumbnail
    ];

} catch (Exception $e) {
    $return_value = [
        'success' => 0,
        'description' => $e->getMessage()
    ];
}
echo json_encode($return_value);
