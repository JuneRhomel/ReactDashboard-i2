<?php 

$data = [
    'soa_id' => $args[0]
];

$soa = $ots->execute('utilities','get-soa-details',$data);
$soa = json_decode($soa,true);
// p_r($soa);
?>

<style>
 .details1 tr:nth-child(odd) {
    background-color: #FFFFFF;
    }
    .details2 tr:nth-child(odd) {
    background-color: #FFFFFF;
    }

   .details1 tr:nth-child(even) {
    background-color: #EFF8FF;
    }
    .details2 tr:nth-child(even) {
    background-color: #EFF8FF;
    }
    .table thead>tr>th {
   vertical-align: bottom;
   border-bottom: 2px solid hsl(0, 0%, 87%);
}
.details1 thead>tr>th,.table tbody>tr>th,.table tfoot>tr>th,.table thead>tr>td,.table tbody>tr>td,.table tfoot>tr>td{
   padding:8px;
   line-height:1.428571429;
   vertical-align:top;
   border-top:1px solid #ddd
}
.details2 thead>tr>th,.table tbody>tr>th,.table tfoot>tr>th,.table thead>tr>td,.table tbody>tr>td,.table tfoot>tr>td{
   padding:8px;
   line-height:1.428571429;
   vertical-align:top;
   border-top:1px solid #ddd
}
</style>
<div class="main-container">
    <div class="close float-right">
        <a onclick="history.back()"><label class="data-title"  style="cursor: pointer;"><i class="bi bi-x" style="font-size:25px;color:white"></i></a>
    </div>
    <div class="soa-container border" style="background:#FFFFFF" id="soa_div">
        <div class="header row p-5">
            <div class="col-6">
                <img id="remove-input-reading"  class="mb-3" src="<?php echo WEB_ROOT;?>/images/Inventi-logo-blue.png" width="220">
                <h4 class="text-primary">Statement of Account</h4>
            </div>
            <div class="col-6">
                <div class="d-flex flex-column align-items-end">
                    <div style="">
                        <button class="btn btn-primary mb-5" id="soa_download"><i class="bi bi-download"></i> Download</button>
                    </div>
                    <div style="">
                        <h2 class="text-right">SOA No:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= decryptData($soa['data']['soa_id'])?></h2>
                    </div>
                    <!-- <div class="col-12 border">
                        <h3 class="text-right">SOA No: 123456 </h3>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="details p-5">
            <div>
                <table class="table details1 ">
                    <?php// foreach($soa['soa_details'] as $details):?>
                     <tr>
                        <td col="">Unit Number:</td>
                        <td></td>
                        <td class="text-end"><?= $soa['soa_details']['unit_id']?></td>
                    </tr>
                    <tr>
                        <td>Unit Owner:</td>
                        <td></td>
                        <td class="text-end"><?= $soa['soa_details']['owner_name']?></td>
                    </tr>
                    <tr>
                        <td>Statement Date:</td>
                        <td></td>
                        <td class="text-end"><?= date('F j, Y',$soa['soa_details']['created_on'])?></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr style="background-color: #FFF385">
                        <td>Payment Due Date</td>
                        <td></td>
                        <?php  $duedate = $soa['soa_details']['due_year'].'/'.$soa['soa_details']['due_month'].'/'.$soa['soa_details']['due_date']?>
                        <td class="text-end"><h5><?=  date("F j, Y", strtotime($duedate)); ?></h5></td>
                    </tr>
                    <tr style="background-color: #FFF385">
                        <td>Please Pay</td>
                        <td></td>
                        <td class="text-end"><h5>&#8369; <?= number_format((float)$soa['soa_details']['amount_due'], 2, '.', ''); ?></h5></td>
                    </tr>
                </table>
                <table class="table-bordered details2 table">
                    <tr>
                        <td class="text-center" colspan="3" ><h5>Summary of Amount Due</h5></td>
                    </tr>
                    <tr>
                        <td class="" col="1"><h6 class="text-required">Particulars</h6></td>
                        <td class="text-center"><h6 class="text-required">Amount</h6></td>
                        <td class="text-end"><h6 class="text-required">Total</h6></td>
                    </tr>
                    <tr>
                        <td class="" colspan="3"></td>
                    </tr>
                    <tr>
                        <td class=""><label class="text-required">Unpaid Balance</label></td>
                        <td class=""></td>
                        <td class=""></td>
                    </tr>
                    <tr>
                        <td class=""><label class="">Remaining balance from previous bill</label></td>
                        <td class="text-center text-required">₱ 
                            <?= ($soa['soa_items']['unpaid_balances']['amount'] > 0) ? number_format((float)$soa['soa_items']['unpaid_balances']['amount'], 2, '.', ''):0?></td>
                        <td class=""></td>
                    </tr>
                    <tr>
                        <td class="" colspan="3"></td>
                    </tr>
                    <!-- Current charges -->
                    <tr>
                        <td class="" colspan="3"><label class="text-required" >Current Charges</label></td>
                    </tr>
                    <tr>
                        <td class="">Common Area Charges: <?=$soa['soa_items']['current_charges']['common_area_charges_month']?>/sqm / mo.</td>
                        <td class=""></td>
                        <td class=""></td>
                    </tr>
                    <tr>
                        <td class="">Your Unit Area: <?=$soa['soa_items']['current_charges']['unit_area']?> sqm</td>
                        <td class="text-center"><label class="text-required" >₱ <?=number_format((float)$soa['soa_items']['current_charges']['amount'], 2, '.', '')?></label></td>
                        <td class=""></td>
                    </tr>
                    <!-- End Current charges -->
                    <tr>
                        <td class="" colspan="3"></td>
                    </tr>
                    <!-- Electricity Charges  -->
                    <tr>
                        <td class="" colspan="3"><label class="text-required" >Electricity Charges</label></td>
                    </tr>
                    <tr>
                        <td class="" colspan="3">Current Reading: <?= $soa['soa_items']['electricity_charges']['current']?></td>
                    </tr>
                    <tr>
                        <td class="" colspan="3">Previous Reading: <?= $soa['soa_items']['electricity_charges']['previous']?></td>
                    </tr>
                    <tr>
                        <td class="" colspan="3">Consumption: <?= $soa['soa_items']['electricity_charges']['consumption']?></td>
                    </tr>
                    <tr>
                        <td class="">Your Rate for this month: <?= $soa['soa_items']['electricity_charges']['rate']?></td>
                        <td class="text-center"><label class="text-required" >₱ <?=number_format((float)$soa['soa_items']['electricity_charges']['item_amount'], 2, '.', '')?></label></td>
                        <td class=""></td>
                    </tr>
                    <!-- End -->
                    <tr>
                        <td class="" colspan="3"></td>
                    </tr>
                    <!-- Water Charges  -->
                    <tr>
                        <td class="" colspan="3"><label class="text-required" >Water Charges</label></td>
                    </tr>
                    <tr>
                        <td class="" colspan="3">Current Reading: <?= $soa['soa_items']['water_charges']['current']?></td>
                    </tr>
                    <tr>
                        <td class="" colspan="3">Previous Reading: <?= $soa['soa_items']['water_charges']['previous']?></td>
                    </tr>
                    <tr>
                        <td class="" colspan="3">Consumption: <?= $soa['soa_items']['water_charges']['consumption']?></td>
                    </tr>
                    <tr>
                        <td class="">Your Rate for this month: <?= $soa['soa_items']['water_charges']['rate']?></td>
                        <td class="text-center"><label class="text-required" >₱ <?=number_format((float)$soa['soa_items']['water_charges']['item_amount'], 2, '.', '')?></label></td>
                        <td class=""></td>
                    </tr>
                    <!-- End -->
                    <tr>
                        <td  colspan="3"></td>
                    </tr>

                 
                    <tr>
                        <td class="" colspan="">Charges Inclusive of VAT</td>
                        <td class="text-center" colspan=""><label class="text-required">₱ <?=number_format((float)$soa['soa_details']['charges_inc_vat'], 2, '.', '')?></label></td>
                        <td class="" colspan=""></td>
                    </tr>

                    <tr>
                        <td class="">Total VAT exempted</td>
                        <td class="text-center" colspan=""><label class="text-required">₱ <?=number_format((float)$soa['soa_details']['vat_exempted'], 2, '.', '')?></label></td>
                        <td class="" colspan=""></td>
                    </tr>
                    <tr>
                        <td class="">Total Value Added Tax</td>
                        <td class="text-center" colspan=""><label class="text-required">₱ <?=number_format((float)$soa['soa_details']['total_vat'], 2, '.', '')?></label></td>
                        <td class="" colspan=""></td>
                    </tr>
                    <tr>
                        <td class=""><label class="text-required" >Total Amount Due</label> </td>
                        <td class="" colspan=""></td>
                        <td class="text-center" colspan=""><label class="text-required">₱ <?=number_format((float)$soa['soa_details']['total_amount_due'], 2, '.', '')?></label></td>
                    </tr>
                </table>
            </div>
            <div class="">
            <div >
                <h5>Reminders:</h5>
                <p>1. Please present this billing statement when paying. If payment has been made, kindly disregard this statement.</p>
                <p>2. Please make check payable to _______________.</p> 
                <p>3. As per House Rules, delinquent accounts are charged with 1% interest per month compounded annually.</p>
                <p>4. As provided for in the Master Deed, any sum owing to the Condo Corp. from any Tenant shall be considered prime and sole responsibility of the Unit Owner not withstanding any agreement he/she may have entered into with his/her lessee or tenant.</p>
                <p>5. Payments made on or after the statement date will be reflected on the next billing.</p>
                <p>6. For clarification, please call the Property Management Office at 8-800-8700</p>
               
            </div>
        </div>
        </div>
    </div>
</div>
<script>
    $("#soa_download").on('click',function(){
        location = "<?=WEB_ROOT;?>/tenant/pdf-download/?display=pdf&ids=test";
    });
</script>