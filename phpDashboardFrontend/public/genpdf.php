<?php

require_once('../public/resources/plugins/tcpdf/tcpdf.php');
include("footerheader.php");


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$view = "vw_soa";

$id = $_GET['id'];

$result = apiSend('module','get-record',[ 'id'=>$id,'view'=>$view ]);
$soa = (array) json_decode($result);

$result = apiSend('module','get-record',[ 'id'=>'1','view'=>'system_info' ]);
$system_info = (array) json_decode($result);

$result = apiSend('tenant','get-listnew',[ 'table'=>'soa_payment','condition'=>'soa_id='.$id,'orderby'=>'id asc' ]);
$payments = (array) json_decode($result);
// var_dump($payments);

// exit;
// LOAD SOA TEMPLATE
ob_start();
include("soa.html");
$html = ob_get_clean();

// **************************************************************************************
// REPLACE VALUES
// **************************************************************************************
$html = str_replace("[BUILDING]",$system_info['property_name'],$html);
$html = str_replace("[ADDRESS]",$system_info['property_address'],$html);

$html = str_replace("[DATE]",date("m/d/Y"),$html);
$html = str_replace("[RESIDENT]",$soa['company_name'],$html);

// INIT ACCOUNT DETAILS
$html = str_replace("[FLOOR]",$soa['location_name'],$html);
$html = str_replace("[UNITNO]",$soa['unit_name'],$html);
$html = str_replace("[FLOORAREA]",$soa['floor_area'],$html);
$html = str_replace("[TYPE]",$soa['location_type'],$html);

// INIT SOA
$html = str_replace("[MONTHOF]",date("F",strtotime("2023-{$soa['month_of']}-01")),$html);
$html = str_replace("[YEAROF]",$soa['year_of'],$html);
$html = str_replace("[AMOUNTDUE]",formatPrice($soa['amount_due']),$html);
$html = str_replace("[DUEDATE]",formatDate($soa['due_date']),$html);    

// INIT PAYMENT HISTORY
$history = '<tr><td colspan="4"><b>PAYMENT HISTORY</b></td></tr>';
if ($payments) {
    $history = '
        <tr>
            <td colspan="4"><b>PAYMENT HISTORY</b></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td width="20%"><b>Payment Date</b></td>
            <td width="20%"><b>Payment Type</b></td>
            <td width="50%"><b>Particular</b></td>
            <td width="10%" align="right"><b>Amount</b></td>
        </tr>';
    foreach ($payments as $payment) {
        $payment = (array) $payment;
        $history .= '
        <tr>
            <td>'.formatDateUnix($payment['created_on']).'</td>
            <td>'.$payment['payment_type'].'</td>
            <td>'.$payment['particular'].'</td>
            <td align="right">'.formatPrice($payment['amount']).'</td>
        </tr>';
    }    
} else {
    $history .= '<tr><td>No record found.</td></tr>';
}
$html = str_replace("[HISTORY]",$history,$html);

// COMPUTE FOR BILLING AMOUNT

/*$pastdue = $soa['pastdue'];
$assodues = $soa['assodues'];
$interest = $soa['interest'];
$rentalfee = $servicefee = $penalties = 0;
$vat = formatNumber(($pastdue+$assodues+$interest)*0.12);
$subtotal = $assodues + $rentalfee + $servicefee + $penalties + $interest + $vat;
$amountdue = $pastdue + $subtotal;*/


$html = str_replace("[BALANCE]",formatPrice($soa['balance']),$html);
$html = str_replace("[CHARGEAMOUNT]",formatPrice($soa['charge_amount']),$html);
$html = str_replace("[ELECTRICITY]",formatPrice($soa['electricity']),$html);
$html = str_replace("[WATER]",formatPrice($soa['water']),$html);
$html = str_replace("[SUBTOTAL]",formatPrice($soa['current_charges']),$html);
$html = str_replace("[TOTAL]",formatPrice($soa['amount_due']),$html);
// **************************************************************************************


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, [200, 245], true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('INVENTI');
$pdf->SetTitle('Inventi Statement of Account');
$pdf->SetSubject('SOA');
$pdf->SetKeywords('SOA, PDF');
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(0, 1, 0);
// set auto page breaks
$pdf->SetAutoPageBreak(false, 0);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// set font
$pdf->SetFont('Helvetica', '', 9);

$pdf->AddPage();
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// close and output PDF document
$pdf->Output('SOA-'.$soa['company_name'].'.pdf', 'I');