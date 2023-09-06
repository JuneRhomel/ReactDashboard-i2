<?php
include("footerheader.php");

// DISPLAY ERROR
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dateNow = date("F d, Y");
$id = initObj('id');
$tenant = initSession('tenant');

// **************************************************************************************
// GET SOA INFO
// **************************************************************************************
$api = apiSend('billing','get-soa',[ 'billingid'=>$id ]);
$soa = json_decode($api,true);
//vdump($soa);

$api = apiSend('billing','get-payment-history',[ 'tenant_id'=>$soa['tenant_id'] ] );
$payments = json_decode($api,true);
//vdump($payments);

// Include the main TCPDF library (search for installation path).
require_once('resources/plugins/tcpdf/tcpdf.php');

// **************************************************************************************
// INIT PDF
// **************************************************************************************
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, [200, 245], true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('INVENTI');
$pdf->SetTitle('Inventi Billing');
$pdf->SetSubject('Utilities Billing');
$pdf->SetKeywords('Utilities Billing, PDF');
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

// **************************************************************************************
// INIT HTML FILE
// **************************************************************************************
// add a page
$pdf->AddPage();

ob_start();
include("billing-soa.html");
$html = ob_get_clean();

// **************************************************************************************
// REPLACE VALUES
// **************************************************************************************
$html = str_replace("[DATE]",$dateNow,$html);
$html = str_replace("[RESIDENT]",$soa['tenant_name'],$html);

// INIT ACCOUNT DETAILS
$html = str_replace("[FLOOR]",$soa['floor'],$html);
$html = str_replace("[UNITNO]",$soa['location_name'],$html);
$html = str_replace("[UNITAREA]",$soa['unitarea'],$html);
$html = str_replace("[TYPE]",$soa['type'],$html);
$html = str_replace("[RATE]",$soa['rate'],$html);

// INIT PAYMENT HISTORY
$history = "<tr><td></td></tr>";
if ($payments) {
	$history = '
		<tr>
			<td colspan="4"><b>PAYMENT HISTORY (LAST 3 MONTHS)</b></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td><b>Payment Date</b></td>
			<td><b>Payment Type</b></td>
			<td><b>Amount</b></td>
		</tr>';
	foreach ($payments as $payment)	{
		$history .= '
		<tr>
			<td>'.formatDate($payment['payment_date']).'</td>
			<td>'.$payment['payment_type'].'</td>
			<td>'.formatPrice($payment['amount'],1).'</td>
		</tr>';
	}
	$history .= '
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4">
				<hr>
			</td>
		</tr>';
}
$html = str_replace("[HISTORY]",$history,$html);

// COMPUTE FOR BILLING AMOUNT
$pastdue = $soa['pastdue'];
$assodues = $soa['assodues'];
$interest = $soa['interest'];
$rentalfee = $servicefee = $penalties = 0;
$vat = formatNumber(($pastdue+$assodues+$interest)*0.12);
$subtotal = $assodues + $rentalfee + $servicefee + $penalties + $interest + $vat;
$amountdue = $pastdue + $subtotal;

$billperiod = formatDate($soa['billing_date'])." to ".date("d M Y",strtotime("+1 month -1 day",strtotime($soa['billing_date'])));
$html = str_replace("[BILLNO]",$soa['billing_number'],$html);
$html = str_replace("[BILLPERIOD]",$billperiod,$html);
$html = str_replace("[AMOUNTDUE]",formatPrice($amountdue,1),$html);
$html = str_replace("[DUEDATE]",formatDate($soa['due_date']),$html);	

$html = str_replace("[PASTDUE]",formatPrice($pastdue),$html);
$html = str_replace("[ASSODUES]",formatPrice($assodues),$html);
/*$html = str_replace("[RENTALFEE]",$rentalfee,$html);
$html = str_replace("[SERVICEFEE]",$servicefee,$html);
$html = str_replace("[PENALTIES]",$penalties,$html);*/
$html = str_replace("[INTEREST]",formatPrice($interest),$html);
$html = str_replace("[VAT]",formatPrice($vat),$html);
$html = str_replace("[SUBTOTAL]",formatPrice($subtotal),$html);
$html = str_replace("[TOTAL]",formatPrice($soa['amount'],1),$html);
// **************************************************************************************

// print a block of text using Write()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


// close and output PDF document
$pdf->Output('billing-soa.pdf', 'I');