<?php
$module = "resident";
$table = "resident";
$view = "vw_resident";

$id = $args[0];
$result = $ots->execute('module', 'get-record', [ 'id'=>$id, 'view'=>$view ]);
$record = json_decode($result);

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'list_residenttype','field'=>'residenttype' ]);
$resident_types = json_decode($result);

$result =  $ots->execute('module','get-listnew',[ 'table'=>'vw_contract','condition'=>'resident_id="'.decryptData($id).'"','orderby'=>'id desc' ]);
$contracts = json_decode($result);

// 23-0901 GET OWNERSHIP AND PROP TYPE FROM SYSTEM INFO
$result = $ots->execute('module','get-record',[ 'id'=>1,'view'=>'system_info' ]);
$system_info = json_decode($result);
$ownership = $system_info->ownership;
$property_type = $system_info->property_type;
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
                <?php if ($property_type=="Commercial") { ?>
                <tr>
                    <td class="p-3 bold" width="30%">Company Name</td>
                    <td class="p-3" width="70%"><?=$record->company_name?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="p-3 bold">Type</td>
                    <td class="p-3"><?=$record->type?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Unit</td>
                    <td class="p-3"><?=$record->unit_name?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Address</td>
                    <td class="p-3"><?=$record->address?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Contact No.</td>
                    <td class="p-3"><?=$record->contact_no?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Email</td>
                    <td class="p-3"><?=$record->email?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Status</td>
                    <td class="p-3"><?=$record->status?></td>
                </tr>
            </table>

            <div>
                <div class="d-flex justify-content-between my-4 mt-5">
                    <label class="data-title">Contract</label>
                    <?php if ($role_access->add_contracts==true): ?>
                    <button class="main-btn btn-add-contract">Add</button>
                    <?php endif ?>
                </div>
                <?php 
                if (!$contracts) {
                    echo "<div class='p-3 bg-white'>No record found.</div>";
                } else {
                ?>
                <table class="table table-bordered table-striped border-table bg-white">
                    <tr>
                        <th>Contract Name</th>
                        <th>Contract No.</th>                        
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Days to Expiration</th>
                        <th>Monthly Rate</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($contracts as $val) { ?>
                    <tr>
                        <td><?=$val->contract_name?></td>
                        <td><?=$val->contract_number?></td>                        
                        <td><?=formatDate($val->start_date)?></td>
                        <td><?=formatDate($val->end_date)?></td>
                        <td><?=$val->expire_days?></td>
                        <td><?=formatPrice($val->monthly_rate)?></td>
                        <td><?=$val->status?></td>
                        <?php if ($role_access->print_contracts==true): ?>
                        <td><a href="<?=WEB_ROOT."/contract/genpdf?display=plain&id=".$val->id?>" target="_blank" title="Print [<?=$val->contract_name?>]"><i class="fa-solid fa-print fa-lg text-warning"></i></a></td>
                        <?php endif ?>
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