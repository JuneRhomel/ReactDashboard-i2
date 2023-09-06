<?php 


$data = $_POST;
// print_r($data);
// exit();
$redirect= $_POST['redirect'];
unset($data['redirect']);
$data['view_table'] = 'views_pm';
$data['pm_start_date'] = $_POST['pm_start_date'] . " " . $_POST['pm_start_time'] . "";
unset($data['pm_start_time']);
$data['pm_end_date'] = $_POST['pm_end_date'] . " " . $_POST['pm_end_time'] . "";
unset($data['pm_end_time']);
$data['repeat_notif'] = $_POST['repeat_notif'] ?? 'off';
$data['stage'] = 'open';
// print_r($data);
// exit();
if($_FILES['file']['name']){ 
    $attachments = [];
    foreach($_FILES['file']['name'] as $index=>$name)
    {
        $attachments[] = [
            'filename' => $_FILES['file']['name'][$index],
            'data' => chunk_split(base64_encode(file_get_contents($_FILES['file']['tmp_name'][$index])))
        ];
    }
    $data['attachments'] = $attachments;
}

echo $result = $ots->execute('property-management','property-management-save',$data);


// if($result->success == 1){
//     echo $data['table'];
//     if($data['table']=='pm' && $data['repeat_notif'] == 'on'){
        
//         // header('Location:' . WEB_ROOT . "/property-management/pm");  
//         header("Location:" . $redirect);
//     }
//     else{
//         header("Location:" . $redirect);
//     }
    
// }

