<?php
require_once('../public/resources/plugins/tcpdf/tcpdf.php');
include("footerheader.php");


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$view = "vw_contract";
$id = initObj('id');

$result = apiSend('module','get-record',[ 'id'=>$id,'view'=>'vw_contract' ]);
$record = json_decode($result);
$recarr = (array) $record;

$result = apiSend('module','get-record',[ 'id'=>$record->template_id,'view'=>'vw_contract_template' ]);
$contract_template = json_decode($result);

$result =  apiSend('module','get-listnew',[ 'table'=>'vw_contract_field','orderby'=>'id' ]);
$fields = json_decode($result);

$filename = API_URL."/uploads/{$record->accountcode}/contract_template/{$record->template_id}.html";
$content = file_get_contents($filename);
// var_dump($content);
// exit;

// REPLACE WITH VALUE FROM RECORD
if ($fields) {
	foreach($fields as $field) {
        if (strpos($field->fieldname,"date")!==false)
		    $content = str_replace("[{$field->fieldname}]",formatDate($recarr[$field->fieldname]),$content);		
        elseif (strpos($field->fieldname,"rate")!==false)
            $content = str_replace("[{$field->fieldname}]",formatPrice($recarr[$field->fieldname]),$content);
        else
            $content = str_replace("[{$field->fieldname}]",$recarr[$field->fieldname],$content);
	}
}

class PDF extends TCPDF {
    public function Footer() {
        $this->SetY(-25);
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 10, $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$obj_pdf = new PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->setPrintHeader(false);
$obj_pdf->SetAutoPageBreak(TRUE, '35');
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
if(isset($_POST['pdfmargin']))
    $obj_pdf->SetMargins(10, 10, 10, PDF_MARGIN_BOTTOM);
else
    $obj_pdf->SetMargins(25, 20, 25, true);

$obj_pdf->AddPage();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output($contract_template->template .'-'. date("Y-m-d-his") . '.pdf', 'I');