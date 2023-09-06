<?php
$return_value = ['success' => 1, 'data' => []];

try {
    $id = $data['id'];
    $meter_id = $data['meter_id'];
    $month = $data['month'];
    $year = $data['year'];
    $new_reading = $data['new_reading'];
    $consumption = $data['consumption'];
    $attachments = $data['attachments'];

    if ($id) {

        if (is_array($attachments)) {
            foreach ($attachments as $attachment) {
                $upload_dir = "uploads/meter_reading_upload";

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $content = base64_decode($attachment['data']);
                $diskname = uniqueFilename($attachment['filename']);
                $attachment_url = WEB_ROOT . '/' . $upload_dir . '/' . $diskname;

                // Update the database with the image path
                file_put_contents($upload_dir . "/" . $diskname, $content);

                $sql = "UPDATE {$account_db}.meter_readings SET reading = :new_reading, consumption = :consumption, upload_img = :upload_img WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':new_reading', $new_reading);
                $stmt->bindParam(':consumption', $consumption);
                $stmt->bindParam(':upload_img', $attachment_url);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
            }
        } else {
            // Update the database without the image path
            $sql = "UPDATE {$account_db}.meter_readings SET reading = :new_reading, consumption = :consumption WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':new_reading', $new_reading);
            $stmt->bindParam(':consumption', $consumption);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    } else if ($meter_id) {
        if (is_array($attachments)) {
            foreach ($attachments as $attachment) {
                $upload_dir = "uploads/$accountcode/meter_reading_upload";

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $content = base64_decode($attachment['data']);
                $diskname = uniqueFilename($attachment['filename']);
                $attachment_url = WEB_ROOT . '/' . $upload_dir . '/' . $diskname;

                // Update the database with the image path
                file_put_contents($upload_dir . "/" . $diskname, $content);
                $sql = "INSERT INTO {$account_db}.meter_readings (meter_id,upload_img,month, year) VALUES (:meter_id,:upload_img,:month, :year)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':meter_id', $meter_id);
                $stmt->bindParam(':upload_img', $attachment_url);
                $stmt->bindParam(':month', $month);
                $stmt->bindParam(':year', $year);
                $stmt->execute();
                $id = $db->lastInsertId();
            }
        } else {

            $sql = "INSERT INTO {$account_db}.meter_readings (meter_id, reading, consumption, month, year) VALUES (:meter_id, :new_reading, :consumption, :month, :year)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':new_reading', $new_reading);
            $stmt->bindParam(':meter_id', $meter_id);
            $stmt->bindParam(':consumption', $consumption);
            $stmt->bindParam(':month', $month);
            $stmt->bindParam(':year', $year);
            $stmt->execute();
            $id = $db->lastInsertId();
        }
    } else {
        $return_value = ['Error' => 0, 'description' => $e->getMessage(), 'sql' => $sql];
    }
    $return_value = ['success' => 1, 'data' => $data,'id'=>$id, 'attachment_url' => $attachment_url];
} catch (Exception $e) {
    $sql = isset($sql) ? $sql : ""; // Set an initial value for $sql
    $return_value = ['success' => 0, 'description' => $e->getMessage(), 'sql' => $sql];
}

echo json_encode($return_value);
