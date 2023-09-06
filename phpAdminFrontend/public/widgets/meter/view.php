<?php
$module = "meter";
$table = "meter";
$view = "vw_meter";

$id = $args[0];
$result = $ots->execute('module', 'get-record', [ 'id'=>$id, 'view'=>$view ]);
$record = json_decode($result);

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'vw_meter','condition'=>"utility_type='{$record->utility_type}' and meter_type='Submeter' ",'orderby'=>'location_name' ]);
$submeter = json_decode($result);
?>
<style>
    .swal-wide { width: 850px !important; }
    table th, td { font-size:15px; padding:2px; }
</style>
<div class="row">
    <div class="col-9">
        <div class="py-4 ps-4 bg-gray">
            <div class="d-flex justify-content-between mb-3">
                <a onclick="location='<?=WEB_ROOT."/$module/"?>'"><label class="data-title" style="cursor:pointer;"><i class="fa-solid fa-arrow-left fa-sm"></i> <?=$record->meter_name?></label></a>
                <?php if ($role_access->update==true): ?>
                    <a href='<?=WEB_ROOT."/$module/form/$id"?>'>
                        <button class="main-btn"> Edit </button>
                    </a>
                <?php endif ?>
            </div>

            <!-- DETAIL -->
            <table class="table table-bordered bg-white p-5" width="100%">
                <tr>
                    <td class="p-3 bold" width="30%">Utility Type</td>
                    <td class="p-3" width="70%"><?=$record->utility_type?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">UoM</td>
                    <td class="p-3"><?=$record->uom?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Meter Type</td>
                    <td class="p-3"><?=$record->meter_type?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Serial No.</td>
                    <td class="p-3"><?=$record->serial_number?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Location</td>
                    <td class="p-3"><?=$record->location_name?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Unit</td>
                    <td class="p-3"><?=$record->unit_name?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Below Threshold</td>
                    <td class="p-3"><?=$record->below_threshold?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Max. Threshold</td>
                    <td class="p-3"><?=$record->max_threshold?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Max. Digit</td>
                    <td class="p-3"><?=$record->max_digit?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Multiplier</td>
                    <td class="p-3"><?=$record->multiplier?></td>
                </tr>
            </table>

            <?php if ($record->meter_type=="Mother Meter") { ?>
            <div>
                <div class="d-flex justify-content-between my-4 mt-5">
                    <label class="data-title">Submeter</label>
                    <!-- <button class="main-btn float-end btn-add-sublocation">Add</button> -->
                </div>
                <?php 
                if (!$submeter) {
                    echo "<div class='p-3 bg-white'>No record found.</div>";
                } else {
                ?>
                <table class="table table-bordered table-striped border-table bg-white">
                    <tr>
                        <th>Meter Name</th>
                        <th>Serial No.</th>
                        <th>Location</th>
                        <th>Unit</th>
                    </tr>
                    <?php foreach ($submeter as $val) { ?>
                    <tr>
                        <td><?=$val->meter_name?></td>
                        <td><?=$val->serial_number?></td>                        
                        <td><?=$val->location_name?></td>
                        <td><?=$val->unit_name?></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>
            <?php } ?>

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