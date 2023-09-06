<?php
$module = "contract";
$table = "contract";
$view = "vw_contract";

$id = $args[0];
$result = $ots->execute('module', 'get-record', [ 'id'=>$id, 'view'=>$view ]);
$record = json_decode($result);
$recarr = (array) $record;

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'vw_contract_field','condition'=>'fieldkind="Custom"','orderby'=>'id' ]);
$custom_fields = json_decode($result);
?>
<style>
    .swal-wide { width: 850px !important; }
    table th, td { font-size:15px; padding:2px; }
</style>
<div class="row">
    <div class="col-9">
        <div class="py-4 ps-4 bg-gray">
            <div class="d-flex justify-content-between mb-3">
                <a onclick="location='<?=WEB_ROOT."/$module/"?>'"><label class="data-title" style="cursor:pointer;"><i class="fa-solid fa-arrow-left fa-sm"></i> <?=$record->contract_name?></label></a>
                <?php if ($role_access->update==true): ?>
                    <a href='<?=WEB_ROOT."/$module/form/$id"?>'>
                        <button class="main-btn"> Edit </button>
                    </a>
                <?php endif ?>
            </div>

            <!-- DETAIL -->
            <table class="table table-bordered bg-white p-5" width="100%">
                <tr>
                    <td class="p-3 bold" width="30%">Contract Number</td>
                    <td class="p-3" width="70%"><?=$record->contract_number?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Occupant</td>
                    <td class="p-3" width="70%"><?=$record->resident_name?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Company Name</td>
                    <td class="p-3" width="70%"><?=$record->company_name?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Unit</td>
                    <td class="p-3" width="70%"><?=$record->unit_name?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Start Date</td>
                    <td class="p-3" width="70%"><?=formatDate($record->start_date)?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">End Date</td>
                    <td class="p-3" width="70%"><?=formatDate($record->end_date)?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Duration</td>
                    <td class="p-3" width="70%"><?=$record->duration?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Monthly Rate</td>
                    <td class="p-3" width="70%"><?=formatPrice($record->monthly_rate)?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">CUSA</td>
                    <td class="p-3" width="70%"><?=formatPrice($record->cusa)?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Association Dues</td>
                    <td class="p-3" width="70%"><?=formatPrice($record->asso_dues)?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Months of Advance</td>
                    <td class="p-3" width="70%"><?=$record->months_advance?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Months of Deposit</td>
                    <td class="p-3" width="70%"><?=$record->months_deposit?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Payment Schedule</td>
                    <td class="p-3" width="70%"><?=$record->payment_schedule?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Day Due</td>
                    <td class="p-3" width="70%"><?=$record->day_due?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Notify Days</td>
                    <td class="p-3" width="70%"><?=$record->notify_days?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Template </td>
                    <td class="p-3" width="70%"><?=$record->template_name?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Status</td>
                    <td class="p-3" width="70%"><?=$record->status?></td>
                </tr>
            </table>
            <?php if ($custom_fields) { ?>
            <h5>CUSTOM FIELDS</h5>
            <table class="table table-bordered bg-white p-5" width="100%">                
                <?php 
                foreach($custom_fields as $custom_field) { 
                ?>
                <tr>
                    <td class="p-3 bold" width="30%"><?=$custom_field->fieldlabel?></td>
                    <td class="p-3" width="70%"><?=$recarr[$custom_field->fieldname]?></td>
                </tr>
                <?php 
                    }  // FOREACH
                ?>
            </table>
            <?php } // IF CUSTOM_FIELDS ?>

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