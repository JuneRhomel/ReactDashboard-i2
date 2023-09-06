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


    if ($id) {
        $fields = [];
        foreach (array_keys($data) as $field) {
            $fields[] = "{$field}=:{$field}";
        }
        $sth = $db->prepare("update {$account_db}.{$table} set " . implode(",", $fields) . " where id={$id}");
        $sth->execute($data);
    } else {
        if($table == "workpermit"){
            $data['created_by'] = $user_token['user_id'];
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
                    'created_by' => $user_token['user_id']
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
        }else {
            $data['created_by'] = $user_token['user_id'];
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
