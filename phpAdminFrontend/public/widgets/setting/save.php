<?php
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

echo $result = $ots->execute('setting','save',$data);

// print_r($_POST);
?>