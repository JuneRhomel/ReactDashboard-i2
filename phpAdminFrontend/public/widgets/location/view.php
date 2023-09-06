<?php
$module = "location";
$table = "location";
$view = "vw_location";

$id = $args[0];
$result = $ots->execute('module', 'get-record', [ 'id'=>$id, 'view'=>$view ]);
$record = json_decode($result);

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'vw_location','condition'=>'parent_location_id="'.decryptData($id).'"','orderby'=>'location_name' ]);
$sublocation = json_decode($result);
?>
<style>
    .swal-wide { width: 850px !important; }
    table th, td { font-size:15px; padding:2px; }
</style>
<div class="row">
    <div class="col-9">
        <div class="py-4 ps-4 bg-gray">
            <div class="d-flex justify-content-between mb-3">
                <a onclick="location='<?=WEB_ROOT."/$module/"?>'"><label class="data-title" style="cursor:pointer;"><i class="fa-solid fa-arrow-left fa-sm"></i> <?=$record->location_name?></label></a>
                <?php if ($role_access->update==true): ?>
                    <a href='<?=WEB_ROOT."/$module/form/$id"?>'>
                        <button class="main-btn"> Edit </button>
                    </a>
                <?php endif ?>
            </div>

            <!-- DETAIL -->
            <table class="table table-bordered bg-white p-5" width="100%">
                <tr>
                    <td class="p-3 bold" width="30%">Location Name</td>
                    <td class="p-3" width="70%"><?=$record->location_name?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Location Type</td>
                    <td class="p-3"><?=$record->location_type?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Location Use</td>
                    <td class="p-3"><?=$record->location_use?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Parent Location</td>
                    <td class="p-3"><?=$record->parent_location_name?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Floor Area (sqm)</td>
                    <td class="p-3"><?=$record->floor_area?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Status</td>
                    <td class="p-3"><?=$record->status?></td>
                </tr>
            </table>

            <?php if ($record->location_type=="Floor" || $record->location_type=="Building") { ?>
            <div>
                <div class="d-flex justify-content-between my-4 mt-5">
                    <label class="data-title">Sub-Location</label>
                    <button class="main-btn float-end btn-add-sublocation">Add</button>
                </div>
                <?php 
                if (!$sublocation) {
                    echo "<div class='p-3 bg-white'>No record found.</div>";
                } else {
                ?>
                <table class="table table-bordered table-striped border-table bg-white">
                    <tr>
                        <th>Location Name</th>
                        <th>Location Type</th>
                        <th>Location Use</th>
                        <th>Floor Area (sqm)</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach ($sublocation as $val) { ?>
                    <tr>
                        <td><?=$val->location_name?></td>
                        <td><?=$val->location_type?></td>                        
                        <td><?=$val->location_use?></td>
                        <td><?=formatNumber($val->floor_area,0)?></td>
                        <td><?=$val->status?></td>
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
    $(".btn-add-sublocation").on('click',function(){
        location = '<?=WEB_ROOT."/$module/form/?loc_id=$id"?>';
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