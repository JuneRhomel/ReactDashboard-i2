<?php
include("footerheader.php");
fHeader();
global $scriptname;

//$arr = array('Gate Pass'=>'getlist','Service Request'=>'getlist', 'Reservation'=>'myreservations','Turnover'=>'getlist-turnover','Move In/Out'=>'getlist-movement','Punch List'=>'getlist-punchlist');

$arr = array(
    'Unit Repair'=>array('unitrepair','getlist'),
    'Gate Pass'=>array('gatepass','getlist'),
    'Visitor Pass'=>array('visitorpass','getlist'),
    'Reservation'=>array('reservation','getlist'),
    'Move In'=>array('movein','getlist'),
    'Move Out'=>array('moveout','getlist'),
    'Work Permit'=>array('workpermit','getlist'),
);

$status = initObj('status');
$form = (initObj('form')=="") ? "Gate Pass" : initObj('form');
$module = $arr[$form][0];
$command = $arr[$form][1];
//vdump($form." :: ".$module." :: ".$command);

$api = apiSend($module, $command, []);
$list = json_decode($api,true);
//vdumpx($api);
// vdumpx($list);
?>
<div class="col-12 d-flex align-items-center justify-content-between mt-4 mb-4">
    <div class="title">My Requests</div>
    <!-- <div>
        <a href="selectrequest.php">
            <button class="btn btn-primary btn-lg pb-0 px-3"><h6>New</h6></button>
        </a>
    </div> -->
</div>
<div class="col-12 mb-4">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border-bottom:solid 1px transparent">
            <button class="nav-link <?=($status=="") ? "active" : ""?>" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true" style="border-bottom:solid 2px var(--clrBlue);" onclick="location='<?=$scriptname?>?form=<?=$form?>'"> In Progress </button>
            <button class="nav-link <?=($status!="") ? "active" : ""?>" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false" style="border-bottom:solid 2px var(--clrBlue);" onclick="location='<?=$scriptname?>?form=<?=$form?>&status=ALL'"> All Requests </button>
        </div>
    </nav>
    <div class="my-4">
        <div><h6>Request Type</h6></div>
        <div>
            <select name="module" class="form-control" onchange="location='myrequests.php?form='+this.value">
                <?php foreach ($arr as $index=>$value) { ?>
                <option value="<?=$index?>" <?=($index==$form && $value[1]==$command) ? "selected" : ""?>><?=$index?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<?php 
if ($list) {

    foreach ($list as $key=>$val) { 
        $valstatus = $val['status'];
        if ($form=="Gate Pass") {
            $type = $val['gp_type'];    
            $details = $val['courier'];
            $date = $val['gp_date'];
        } elseif ($form=="Unit Repair") {
            $type = $val['unit'];
            $details = $val['description'];
            $date = formatDateUnix($val['created_on']);        
        }  elseif ($form=="Visitor Pass") {
            $type = $val['unit'];
            $details = $val['purpose'];
            $date = formatDateUnix($val['created_on']);        
        } elseif ($form=="Reservation") {
            $type = $val['amenity'];
            $details = $val['purpose'];
            $date = $val['date'];
        } elseif ($form=="Move In") {
            $type = $val['unit'];
            $details = $val['resident_type'];
            $date = $val['date'];        
        }  elseif ($form=="Move Out") {
            $type = $val['unit'];
            $details = $val['resident_type'];
            $date = $val['date'];        
        }  elseif ($form=="Work Permit") {
            $type = $val['contractor_name'];
            $details = $val['scope_work'];
            $date = $val['start_date'];        
        } else {
            $type = ($form=="Turnover") ? "" : $val['sr_type'];
            $details = ($form=="Turnover" || $form=="Service Request") ? $val['details'] : $val['description'];
            $date = ($form=="Turnover") ? $val['created_date'] : $val['date'];
        }
                  
        if ($status=="") {
            if ($valstatus!="Closed" && $valstatus!="Approved" && $valstatus!="Disapproved") {
?>
<div class="bg-white">
    <div class="col-12 mb-3 py-3">
        <div class="">
            <div class="d-flex align-items-center justify-content-between">
                <div class="font-16 font-weight-bold"><a href="myrequests-view.php?id=<?=$val['id']?>&form=<?=$form?>"><u><?=$form?></u></a></div>
                <div class="badge badge-pill badge-secondary pull-right badge-label  pb-2"><?=$valstatus?></div>
            </div>
        </div>
        <div class="mb-2">
            <div class="d-flex align-items-center justify-content-between">
                <div class="label-fade"><?=$type?></div>
            </div>
        </div>
        <div>
            <div><?=$details?></div>
            <?php if ($date!="") { ?>
            <div class="d-flex mt-3 align-items-center">
                <div><i class="fa fa-calendar icon-inverse"></i></div>
                <div class="ml-2"><?=$date?></div>
            </div>
            <?php } ?>
            <?php if ($val['user']!="") { ?>
            <div class="d-flex mt-2 align-items-center">
                <div><i class="fa fa-user icon-inverse"></i></div>
                <div class="ml-2"><?=$val['user']?></div>
            </div>
            <?php } ?>
            <?php if ($val['location']!="") { ?>
            <div class="d-flex mt-2 align-items-center">
                <div><i class="fa fa-map-marker-alt icon-inverse"></i></div>
                <div class="ml-2"><?=$val['location']?></div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
            } // if val['status']!=closed
        } else { // if status
?> 
<div class="bg-white">
    <div class="col-12 mb-3 py-3">
        <div class="">
            <div class="d-flex align-items-center justify-content-between">
                <div class="font-16 font-weight-bold"><a href="myrequests-view.php?id=<?=$val['id']?>&form=<?=$form?>"><u><?=$form?></u></a></div>
                <div class="badge badge-pill badge-secondary pull-right badge-label pb-2"><?=$valstatus?></div>
            </div>
        </div>
        <div class="mb-2">
            <div class="d-flex align-items-center justify-content-between">
                <div class="label-fade"><?=$type?></div>
            </div>
        </div>
        <div>
            <div><?=$details?></div>
            <?php if ($date!="") { ?>
            <div class="d-flex mt-3 align-items-center">
                <div><i class="fa fa-calendar icon-inverse"></i></div>
                <div class="ml-2"><?=$date?></div>
            </div>
            <?php } ?>
            <?php if ($val['user']!="") { ?>
            <div class="d-flex mt-2 align-items-center">
                <div><i class="fa fa-user icon-inverse"></i></div>
                <div class="ml-2"><?=$val['user']?></div>
            </div>
            <?php } ?>
            <?php if ($val['location']!="") { ?>
            <div class="d-flex mt-2 align-items-center">
                <div><i class="fa fa-map-marker-alt icon-inverse"></i></div>
                <div class="ml-2"><?=$val['location']?></div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php 
        } // if status
    } // foreach
} else {
    echo '<div class="bg-white"><div class="col-12 mb-3 py-3">No record found.</div></div>';
}
?>
<div class="mt-5">&nbsp;</div>
<?=fFooter();?>