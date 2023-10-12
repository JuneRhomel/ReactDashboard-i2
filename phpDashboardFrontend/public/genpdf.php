<?php
require_once('../public/resources/plugins/tcpdf/tcpdf.php');
include("footerheader.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$view = "vw_soa";
$id =  decryptData($_GET['id']);

$result = apiSend('module', 'get-record', ['id'=>$id, 'view'=>$view]);
$soa = (array) json_decode($result);
$soa_month = date("F", mktime(0, 0, 0, $soa['month_of'], 1));
$resident_id = $soa['resident_id'];
// 23-0901 GET OWNERSHIP AND PROP TYPE FROM SYSTEM INFO
$result = apiSend('module', 'get-record', ['id' => 1, 'view' => 'system_info']);
$system_info = json_decode($result);
$ownership = $system_info->ownership;
$property_type = $system_info->property_type;

// PREVIOUS SOA

$previous_soa =  $previous_soa_id =  $previous_payments = null;
$result = apiSend('module', 'get-listnew', ['table'=>$view, 'condition'=>'id<' . $soa['id'] . ' and resident_id=' . $soa['resident_id'] . '', 'orderby'=>'id DESC']);
//vdump($result);
if (!empty(json_decode($result))) {
    $previous_soa = (array) json_decode($result)[0];
    $previous_soa_id = $previous_soa['id'];
    // PREVIOUS PAYMENT
    $result = apiSend('module', 'get-listnew', ['table'=>'soa_detail', 'condition'=>'soa_id=' . $previous_soa['id'], 'orderby'=>'id asc']);
    $previous_payments = (array) json_decode($result);

    // COMPUTE TOTAL PREVIOUS PAYMENTS
    /*if ($previous_payments) {
        $prev_total = 0;
        foreach ($previous_payments as $item) {
            $paid = $item->amount - $item->amount_bal;
            $prev_total = $paid + $prev_total;
        };
        $remaining_bal =  $previous_soa['amount_due'] - $prev_total;
    }*/
}


// INIT HEADER & FOOTER
$result = apiSend('module', 'get-listnew', ['table'=>'settings',]);
$custom = (array) json_decode($result);
if ($custom) {
    foreach ($custom as $item) {
        if ($item->setting_name === "header") {
            $header = $item->setting_value;
        } elseif ($item->setting_name === "footer") {
            $footer =  $item->setting_value;
        };
    };
}

// SYSTEM INFO
$result = apiSend('module', 'get-record', ['id'=>'1', 'view'=>'system_info']);
$system_info = (array) json_decode($result);

// CURRENT CHARGES
$result = apiSend('module', 'get-listnew', ['table'=>'soa_detail', 'condition'=>'soa_id=' . $id, 'orderby'=>'id asc']);
$soa_detail = (array) json_decode($result);
// GET PREVIOUS MONTH/YEAR OF CURRENT SOA FOR PAYMENTS MADE IN PREVIOUS MONTH
$prev_month = intval(date("m",strtotime($soa['year_of']."-".$soa['month_of']."-01 -1 months")));
$prev_year = intval(date("Y",strtotime($soa['year_of']."-".$soa['month_of']."-01 -1 months")));

// PREVIOUS MONTH PAYMENTS
if($previous_soa_id) {
    $result = apiSend('module', 'get-listnew', ['table'=>'soa_payment', 'condition'=>"soa_id=$previous_soa_id and particular NOT LIKE '%SOA Payment%'", 'orderby'=>'transaction_date asc']);
    $soa_payment = (array) json_decode($result);
}

// HEADER LOGO
$result = apiSend('module', 'get-listnew', ['table'=>'photos', 'condition'=>'reference_table="settings"', 'orderby'=>'id DESC']);
$logo = (array) json_decode($result);

// FOOTER LOGO
$result = apiSend('module', 'get-listnew', ['table'=>'photos', 'condition'=>'reference_table="poweredby"', 'orderby'=>'id DESC']);
$poweredby = (array) json_decode($result);

// LOAD SOA TEMPLATE
ob_start();
include("soa.html");
$html = ob_get_clean();


// **************************************************************************************
// REPLACE VALUES
// **************************************************************************************
$html = str_replace("[BUILDING]", $system_info['property_name'], $html);
$html = str_replace("[ADDRESS]", $system_info['property_address'], $html);

$html = str_replace("[DATE]", date("m/d/Y"), $html);
$html = str_replace("[OCCUPANT]", ($property_type=="Residential") ? $soa['resident_name'] : $soa['company_name'], $html);


$resident = "";
if ($property_type=="Commercial") {
    $resident = '<tr style="height: 22.3906px; border-style: none;">
        <td style="text-align: left; height: 22.3906px; width: 66.9519%; border-width: 0px; background-color: rgb(244, 247, 250); border-style: none; line-height: 2; font-size: 10pt;">Contact Person:
        </td>
        <td style="text-align: right; height: 22.3906px; width: 33.0481%; border-width: 0px; background-color: rgb(244, 247, 250); border-style: none; line-height: 2;">
            <span style="font-size: 10pt;">'.$soa['resident_name'].' </span>
        </td>
    </tr>';
}
$html = str_replace("[RESIDENT]", $resident, $html);

$year = $soa['year_of'];
$month = $soa['month_of'];
$dateStart = date('F', strtotime("$year-$month-01")) . '-' . $year;

// Input date in the format MM/DD/YYYY
$inputDate = formatDate($soa['due_date']);
$dateTime = DateTime::createFromFormat('m/d/Y', $inputDate);
$duedate = $dateTime->format('F j, Y');

$html = str_replace("[DATEISSUED]", $dateStart, $html);
$html = str_replace("[PERIOD]", date("F d",strtotime("{$soa['year_of']}-{$soa['month_of']}-01"))." - ".date("t, Y",strtotime("{$soa['year_of']}-{$soa['month_of']}-01")), $html);
// INIT ACCOUNT DETAILS
$html = str_replace("[FLOOR]", $soa['location_name'], $html);
$html = str_replace("[UNITNO]", $soa['unit_name'], $html);
$html = str_replace("[FLOORAREA]", $soa['floor_area'], $html);
$html = str_replace("[TYPE]", $soa['location_type'], $html);

// INIT SOA
$html = str_replace("[MONTHOF]", date("F", strtotime("2023-{$soa['month_of']}-01")), $html);
$html = str_replace("[YEAROF]", $soa['year_of'], $html);
$html = str_replace("[DUEDATE]", $duedate, $html);

// PREVIOUS SOA 
$prev_amount_due = 0;
if ($previous_soa) 
    $prev_amount_due = $previous_soa['amount_due'];

$html = str_replace("[PREVIOUSBAL]", formatPrice($prev_amount_due,0), $html);

// if ($previous_payments) {
//     $html = str_replace("[PAYMENT-PREV]", formatPrice($prev_total), $html);
//     $html = str_replace("[REMAINING_BAL]", formatPrice($remaining_bal), $html);
// } else {
//     $html = str_replace("[PAYMENT-PREV]", formatPrice(0), $html);
//     $html = str_replace("[REMAINING_BAL]", formatPrice($soa['balance'],'0'), $html);
// }

// CUSTOM
$html = str_replace("[HEADER]", $header, $html);
$html = str_replace("[FOOTER]", $footer, $html);

// INIT CURRENT CHARGES
if (!empty($soa_detail)) {
    $charge  = "";
    foreach ($soa_detail as $key=>$item) {
        if ($item->type === "Balance") continue;
        $charge .= '<tr style="height: 22px; border-style: none; ' . ($key % 2 === 1 ? "background-color: rgb(244, 247, 250);" : "") . '" >
        <td style="height: 22px; border-style: none; line-height: 2;">
            <span style="font-size: 10pt;">  ' . $item->particular . '</span>
        </td>
        <td style="text-align: right; height: 22px; border-style: none; line-height: 2;"><span
                style="font-size: 10pt;">
                ' . formatPrice($item->amount) . '
            </span>
        </td>
    </tr>';
    }
} else {
    $charge  .= '<tr><td colspan="2" style="height: 22px; border-style: none; line-height: 2;">No record found.</td></tr>';
}
$html = str_replace("[SOA_DETAIL]", $charge, $html);

// INIT PAYMENTS
$payment  = ""; $payment_total = 0;
$prev_bal = 0;
// vdumpx($soa_payment);
if (!empty($soa_payment)) {
    $payment = '
        <tr style="height: 22px; border-style: none;">
            <td style="height: 22px; background-color: rgb(244, 247, 250); border-style: none; line-height: 2;">
                <span style="font-size: 10pt;">  LESS:</span>
            </td>
            <td style="text-align: right; height: 22px; background-color: rgb(244, 247, 250); border-style: none; line-height: 2;">&nbsp;</td>
        </tr>';
    foreach ($soa_payment as $key=>$item) {
        $payment .= '<tr style="height: 22px; border-style: none; ' . ($key % 2 === 1 ? "background-color: rgb(244, 247, 250);" : "") . '" >
            <td style="height: 22px; border-style: none; line-height: 2;">
                <span style="font-size: 10pt;">  ' . $item->particular . '</span>
            </td>
            <td style="text-align: right; height: 22px; border-style: none; line-height: 2;"><span
                    style="font-size: 10pt;">
                    ' . formatPrice($item->amount) . '
                </span>
            </td>
        </tr>';
        $payment_total += $item->amount;
    }
} 
$prev_bal = $prev_amount_due - $payment_total;
$html = str_replace("[SOA_PAYMENT]", $payment, $html);
$html = str_replace("[REMAINING_BAL]", formatPrice($prev_amount_due - $payment_total,0), $html);


// LOGO
if ($logo) {
    $brand = '<img height="auto" width="110px"src="' . $logo[0]->attachment_url . '" alt="">';
} else {
    $brand = '<img height="auto" width="110px"src="' . WEB_ROOT . "/images/logo-gray.png" . '" alt="">';
}
$html = str_replace("[LOGO]", $brand, $html);

// LOGO FOOTER
$footer_logo = '<img height="auto" width="110px"src="' . $poweredby[0]->attachment_url . '" alt="">';


// COMPUTE FOR BILLING AMOUNT

/*$pastdue = $soa['pastdue'];
$assodues = $soa['assodues'];
$interest = $soa['interest'];
$rentalfee = $servicefee = $penalties = 0;
$vat = formatNumber(($pastdue+$assodues+$interest)*0.12);
$subtotal = $assodues + $rentalfee + $servicefee + $penalties + $interest + $vat;
$amountdue = $pastdue + $subtotal;*/


$html = str_replace("[CHARGEAMOUNT]", formatPrice($soa['charge_amount']), $html);
$html = str_replace("[ELECTRICITY]", formatPrice($soa['electricity']), $html);
$html = str_replace("[WATER]", formatPrice($soa['water']), $html);

$soa_details_total = 0;
// COMPUTE FOR  Current Charges TOTAL
//vdumpx($soa_detail);
foreach ($soa_detail as $item) {
    if ($item->type === "Balance") continue;
    $soa_details_total = $soa_details_total + $item->amount;
}
$amounttopay = $soa_details_total + $prev_bal;
// var_dump($prev_bal);
$html = str_replace("[TOTALCURRENT]", formatPrice($soa_details_total), $html);

$html = str_replace("[AMOUNTDUE]", formatPrice($amounttopay), $html);
// **************************************************************************************

$imageFile =  $logo[0]->attachment_url;
$footer_logo  =  $poweredby[0]->attachment_url;

$pdf = new TCPDF('P', 'mm', array(215.9, 330.2), true, 'UTF-8', false);

class CustomTCPDF extends TCPDF
{
    private $imageFile;
    private $footer_logo;
    private $header;
    private $footer;

    public function __construct($imageFile, $footer_logo, $header, $footer)
    {
        parent::__construct();
        $this->imageFile = $imageFile;
        $this->header = $header;
        $this->footer = $footer;
        $this->footer_logo = $footer_logo;
    }
    public function Header()
    {
        if ($this->header) {
            $headerContent = preg_replace('/text-align:\s*left;/', '', $this->header);
            $headerContent = str_replace('<p', '<span style="font-size: 8pt"', $headerContent);
            $headerContent = str_replace('</p>', '</span> <div style="line-height: .6;"> </div>
            ', $headerContent);

            // var_dump($headerContent);
            // Wrap the header content in a <div> with text-align set to "right"
            $html = '<div style="font-size: 8pt; text-align: right;">' . $headerContent . '</div>';

            // exit;
            $this->writeHTML($html, true, false, false, false, '');

            $desiredWidth = 25;
            $desiredHeight = 15;
            list($originalWidth, $originalHeight) = getimagesize($this->imageFile);
            $aspectRatio = $originalWidth / $originalHeight;
            if ($desiredWidth / $desiredHeight > $aspectRatio) {
                $newWidth = $desiredHeight * $aspectRatio;
                $newHeight = $desiredHeight;
            } else {
                $newWidth = $desiredWidth;
                $newHeight = $desiredWidth / $aspectRatio;
            }
            $x = 15 + ($desiredWidth - $newWidth) / 2;
            $y = PDF_MARGIN_TOP - 20 + ($desiredHeight - $newHeight) / 2;

            // Output the image with the new dimensions and position
            $this->Image($this->imageFile, $x, $y, $newWidth, $newHeight);
            $this->Line(10, PDF_MARGIN_TOP - 3, 200, PDF_MARGIN_TOP - 3);

            $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 4, PDF_MARGIN_RIGHT);
        } else {
            $this->Image($this->imageFile, 15, 4, 30);
            $this->Line(10, 20, 200, 20);
        }
    }

    public function Footer()
    {
        if ($this->footer) {

            $html = $this->footer;
            // $html = '<div style="line-height: 1; margin-top:20px;">' . $html . '</div>';
            $html = str_replace('<p', '<span', $html);
            $html = str_replace('</p>', '</span> <br>', $html);
            // echo($html);
            $htmlHeight = $this->getStringHeight(0, $html);
            $this->SetY(-35);

            $this->writeHTML($html, true, false, false, false, '');
        }

        $imageWidth = 20;
        $x = ($this->w - $imageWidth) / 2;
        $this->SetY(-17);
        $this->SetLineWidth(0.1);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->SetY(-15);
        $this->Image($this->footer_logo, $x, $this->GetY(), $imageWidth);
    }
}

$pdf = new CustomTCPDF($imageFile, $footer_logo, $header, $footer,);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('INVENTI');
$pdf->SetTitle('Statement of Account');
$pdf->SetSubject('SOA');
$pdf->SetKeywords('SOA, PDF');
$pdf->SetHeaderData(PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setPrintHeader(true);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins

$pdf->SetHeaderMargin(5);
$pdf->SetMargins(PDF_MARGIN_LEFT, 23, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(true, 34);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// set font
$pdf->SetFont('Helvetica', '', 9);

$pdf->AddPage();

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
//$pdf->writeHTML($content, true, false, true, false, '');
$name = ($property_type=="Residential") ? $soa['resident_name'] : $soa['company_name'];
$pdf->Output('SOA-' . $name . '_'. $soa_month .'.pdf', 'I');
