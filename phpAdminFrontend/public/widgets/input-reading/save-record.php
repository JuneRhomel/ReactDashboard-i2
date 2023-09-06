<?php
// header('Content-Type: application/json; charset=utf-8');
unset($_SESSION['error']);
$redirect = $_POST['redirect'];
unset($_POST['redirect']);
$error_redirect = $_POST['error_redirect'];
unset($_POST['error_redirect']);
$data = $_POST;

// print_r($data);

echo $result = $ots->execute('utilities','utilities-save',$data);
// $result = json_decode($result);
// // print_r($result);


// // exit();
// if($result->success == 1){
//     if($_FILES){
//         $attachments = [];
//         foreach($_FILES['file']['name'] as $index=>$name)
//         {
//             $attachments[] = [
//                 'filename' => $_FILES['file']['name'][$index],
//                 'data' => chunk_split(base64_encode(file_get_contents($_FILES['file']['tmp_name'][$index])))
//             ];
//         }
//         $_POST['attachments'] = $attachments;
//         $_POST['reference_table'] = 'documents';
//         $_POST['reference_id'] = $result->id;
//         // print_r($_FILES['file']['name']);

//         $upload_result = $ots->execute('files','upload-attachments',$_POST);
//     }

//     $redirect_view = $result->id ?? '';
//     $redirect = $redirect . $redirect_view ?? '';
//     $header = 'Location: ' . $redirect;
//     // exit();
//     header($header);
// }
// else{
    
//     $_SESSION['error']  = $result->description;
//     $header = 'Location: ' . $error_redirect;
//     // exit();
//     header($header);
// }