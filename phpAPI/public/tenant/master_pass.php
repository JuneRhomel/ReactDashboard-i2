<?php
$return_value = ['success' => 0, 'description' => '']; // Assume failure initially.

try {
    $id = $data['id'];
    $master_password = md5($data['master_password']);

    // Assuming $db is the database connection.
    $sth = $db->prepare("SELECT * FROM {$account_db}.resident WHERE id = :id AND master_password = :master_password");
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->bindParam(':master_password', $master_password, PDO::PARAM_STR);
    $sth->execute();

    // Fetch the user_info.
    $user_info = $sth->fetch(PDO::FETCH_ASSOC);

    if ($user_info) {
        $return_value = ['success' => 1, 'description' => 'User information retrieved successfully.'];
    } else {
        $return_value = ['success' => 0, 'description' => 'Invalid master password.'];
    }

} catch (Exception $e) {
    $return_value = ['success' => 0, 'description' => $e->getMessage()];
}

echo json_encode($return_value);
?>
