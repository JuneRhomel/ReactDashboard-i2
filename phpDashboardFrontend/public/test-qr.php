<?php
public function qrCodePdfMultiple(){
    session_write_close();
    include DIR.'/phpqrcode/qrlib.php';
    
    $start = $_POST['start'];
    $end = $_POST['end'];
    $limit = $_POST['limit'];
    $assets = $this->db->usetable('datadigest_70')->select("field_326")->where("field_326 != '' AND deleted_at=0")->limit($limit)->offset($start)->orderBy("id ASC")->fetch();
    
    $asset_qr = "";
    foreach($assets as $asset){
        $content = $asset->field_326;
        ob_start();
        QRcode::png($content);
        $result_qr_content_in_png = ob_get_contents();
        ob_end_clean();
        header("Content-type: text/html");
        $result_qr_content_in_base64 =  base64_encode($result_qr_content_in_png);

        $asset_qr .= "
            <div class='qr-container'>
                <img style='width: 100%;height: 100%;position: relative;margin-top:10px;' src='data:image/jpeg;base64,".$result_qr_content_in_base64."'/>
                <div class='qr-details' style='position: absolute;top: 115px;left: 0px;'>
                    <center><small>".$asset->field_326."</small></center>
                </div>
            </div>
        ";
    }

    $body = '
        <style>
            @page {
                margin: 0cm 0cm;
            }
        </style>
        '.$asset_qr.'
    ';

    $options = new Options();
    $options->setTempDir('temp');
    $options->setIsRemoteEnabled(true);
    $dompdf = new Dompdf();
    $dompdf->setOptions($options);
    $dompdf->set_option('enable_html5_parser', TRUE);
    $dompdf->loadHtml($body);
    $dompdf->setPaper(array(0,0,90,126));
    $dompdf->render();

    $target_dir = DIR_ROOT . '/public/uploads/afni/qr/'.$_SESSION['time_stamp_for_qr_code_folder'];
    if(!is_dir($target_dir))
    {
        mkdir($target_dir,0777,true);
    }

    file_put_contents("{$target_dir}/{$start}-{$end}.pdf", $dompdf->output());

    $result = [
        'is_error'=> false,
        'post'=> $_POST,
        'assets'=> $assets
    ];
    
    session_start();
    echo json_encode($result);
}



?>