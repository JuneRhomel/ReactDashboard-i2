<?php
// header('Content-Type: application/json; charset=utf-8');
$redirect = $_POST['redirect'];
unset($_POST['redirect']);
$contact = $_POST['contact'];
unset($_POST['contact']);
$email = $_POST['email'];
unset($_POST['email']);
$username = $_POST['username'];
unset($_POST['username']);

if($_FILES['file']['name']){
    $attachments = [];
    foreach($_FILES['file']['name'] as $index=>$name)
    {
        $attachments[] = [
            'filename' => $_FILES['file']['name'][$index],
            'data' => chunk_split(base64_encode(file_get_contents($_FILES['file']['tmp_name'][$index])))
        ];
    }
    $_POST['attachments'] = $attachments;
    // print_r($_FILES['file']['name']);
}

$data = $_POST;
if($data['view_table']=="view_tenant" && $data['type']=="unit owner"){
    $data['owner_name'] = $_POST['first_name'] . ' ' . $_POST['last_name'];
    $data['owner_contact'] = $contact;
    $data['owner_email'] = $email;
    $data['owner_username'] = $username;
   
}else if($data['view_table']=="view_tenant" && $data['type']=="tenant"){
    $data['tenant_name'] = $_POST['first_name'] . ' ' . $_POST['last_name'];
    $data['tenant_contact'] = $contact;
    $data['tenant_email'] = $email;
    $data['tenant_username'] = $username;
}

// exit();
echo $result = $ots->execute('tenant','tenant-save',$data);
