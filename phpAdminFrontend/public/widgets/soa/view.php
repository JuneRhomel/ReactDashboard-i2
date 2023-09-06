<?php
$module = "soa";
$table = "soa";
$view = "vw_soa";

$id = $args[0];
$result = $ots->execute('module', 'get-record', [ 'id'=>$id, 'view'=>$view ]);
$record = json_decode($result);

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'soa_detail','condition'=>'soa_id="'.decryptData($id).'"','orderby'=>'id asc' ]);
$soa_detail = json_decode($result);
?>
<style>
    .swal-wide { width: 850px !important; }
    /*table td { padding:2px; }*/
    .table-bordered td { font-weight:normal; }
</style>
<div class="row">
    <div class="col-9">
        <div class="py-4 ps-4 bg-gray">
            <div class="d-flex justify-content-between mb-3">
                <a onclick="location='<?=WEB_ROOT."/$module/"?>'"><label class="data-title" style="cursor:pointer;"><i class="fa-solid fa-arrow-left fa-sm"></i> <?=$record->resident_name?></label></a>
                <?php if ($role_access->update==true): ?>
                    <a href='<?=WEB_ROOT."/$module/form/$id"?>'>
                        <button class="main-btn"> Edit </button>
                    </a>
                <?php endif ?>
            </div>

            <!-- DETAIL -->
            <table class="table table-bordered bg-white" width="100%">
                <tr>
                    <td class="p-3" width="30%"><b>Month</b></td>
                    <td class="p-3" width="70%"><?=$record->month_of?></td>
                </tr>
                <tr>
                    <td class="p-3" width="30%"><b>Year</b></td>
                    <td class="p-3" width="70%"><?=$record->year_of?></td>
                </tr>
                <tr>
                    <td class="p-3" width="30%"><b>Balance</b></td>
                    <td class="p-3" width="70%"><?=formatPrice($record->balance)?></td>
                </tr>
                <tr>
                    <td class="p-3" width="30%"><b>Charge Amount</b></td>
                    <td class="p-3" width="70%"><?=formatPrice($record->charge_amount)?></td>
                </tr>
                <tr>
                    <td class="p-3" width="30%"><b>Electricity</b></td>
                    <td class="p-3" width="70%"><?=formatPrice($record->electricity)?></td>
                </tr>
                <tr>
                    <td class="p-3" width="30%"><b>Water</b></td>
                    <td class="p-3" width="70%"><?=formatPrice($record->water)?></td>
                </tr>
                <tr>
                    <td class="p-3" width="30%"><b>Current Charges</b></td>
                    <td class="p-3" width="70%"><?=formatPrice($record->current_charges)?></td>
                </tr>
                <tr>
                    <td class="p-3" width="30%"><b>Amount Due</b></td>
                    <td class="p-3" width="70%"><?=formatPrice($record->amount_due)?></td>
                </tr>
                <tr>
                    <td class="p-3" width="30%"><b>Notes</b></td>
                    <td class="p-3" width="70%"><?=$record->notes?></td>
                </tr>
                <tr>
                    <td class="p-3" width="30%"><b>Status</b></td>
                    <td class="p-3" width="70%"><?=$record->status?></td>
                </tr>
            </table>

            <div>
                <div class="d-flex justify-content-between my-4 mt-5">
                    <label class="data-title">SOA Detail</label>
                </div>
                <?php 
                if (!$soa_detail) {
                    echo "<div class='p-3 bg-white'>No record found.</div>";
                } else {
                ?>
                <table class="table table-bordered bg-white">
                    <tr>
                        <th class="p-3">Particular</th>
                        <th class="p-3">Amount</th>
                        <th class="p-3">Balance</th>
                        <th class="p-3">Status</th>
                    </tr>
                    <?php foreach ($soa_detail as $val) { ?>
                    <tr>
                        <td class="p-3"><?=$val->particular?></td>
                        <td class="p-3"><?=formatPrice($val->amount)?></td>
                        <td class="p-3"><?=formatPrice($val->amount_bal,0)?></td>
                        <td class="p-3"><?=($val->amount_bal>0) ? 'Unpaid' : 'Paid'?><?= $record->status === "For Verification"?" ($record->status)": ""?></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>

            <div class="btn-group-buttons pull-right mt-5">
                <div class="d-flex flex-row-start">
                    <button type="button" class="main-btn" onclick="location='<?=WEB_ROOT."/$module/"?>'">Back</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="bg-white border-2 rounded-lg p-3 me-3 comphofilecontainer"></div>
    </div>
</div>
<script>
$(document).ready(function() {
    $(".btn-add-contract").click(function(){
        location = '<?=WEB_ROOT."/contract/form/?resident_id={$record->id}&unit_id={$record->unit_id}"?>';
    });

    $.ajax({
        url: '<?=WEB_ROOT;?>/comphofile/widget?reference=<?=$id?>&source=<?=$table?>&display=plain',
        type: 'GET',
        data: $(this).serialize(),
        dataType: 'html',
        beforeSend: function(){},
        success: function(data){
            $(".comphofilecontainer").html(data);
        },
        complete: function(){},
        error: function(jqXHR, textStatus, errorThrown){}
    });
});
</script>