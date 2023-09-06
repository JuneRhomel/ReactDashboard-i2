<?php
$module = "pdc";
$table = "pdcs";
$view = "vw_pdcs";

$id = $args[0];
$result = $ots->execute('module', 'get-record', [ 'id'=>$id, 'view'=>$view ]);
$record = json_decode($result);
// var_dump($record);

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($result);

?>
<style>
    .swal-wide { width: 850px !important; }
    table th, td { font-size:15px; padding:2px; }
</style>
<div class="row">
    <div class="col-9">
        <div class="py-4 ps-4 bg-gray">
            <div class="d-flex justify-content-between mb-3">
                <a onclick="location='<?=WEB_ROOT."/$module/"?>'"><label class="data-title" style="cursor:pointer;"><i class="fa-solid fa-arrow-left fa-sm"></i> <?=$record->fullname?></label></a>
                <?php if ($role_access->update==true): ?>
                    <a href='<?=WEB_ROOT."/$module/form/$id"?>'>
                        <button class="main-btn"> Edit </button>
                    </a>
                <?php endif ?>
            </div>

            <!-- DETAIL -->
            <table class="table table-bordered bg-white p-5" width="100%">
                <tr>
                    <td class="p-3 bold" width="30%">Check Number</td>
                    <td class="p-3" width="70%"><?=$record->check_no?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Check Number</td>
                    <td class="p-3" width="70%"><?=$record->fullname?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Unit</td>
                    <td class="p-3" width="70%"><?=$record->location_name?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Check Date</td>
                    <td class="p-3"><?=$record->check_date?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Check Amount</td>
                    <td class="p-3"><?=$record->check_amount?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Status</td>
                    <td class="p-3"><?=$record->status?></td>
                </tr>
            </table>



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