<?php
include("footerheader.php");
fHeader();
global $scriptname;

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

$arr = array(
    'Unit Repair'=>array('unitrepair','get-unitrepair','get-updates-unitrepair','unitrepairid'),
    'Gate Pass'=>array('gatepass','get-gatepass','gatepassid'),
    'Visitor Pass'=>array('visitorpass','get-visitorpass','vpid'),
    'Reservation'=>array('reservation','get-reservation','get-updates-reservation','reservation_id'),
    'Move In'=>array('movein','get-movein','get-updates-movement','miid'),
    'Move Out'=>array('moveout','get-moveout','get-updates-movement','moid'),
    'Work Permit'=>array('workpermit','get-workpermit','get-updates-punchlist','wpid'),
);

$id = initObj('id');
$form = (initObj('form')=="") ? "Gate Pass" : initObj('form');

$module = $arr[$form][0];
$command = $arr[$form][1];
$updcommand = $arr[$form][2];
$fldid = $arr[$form][3];

// CREATE NEW REQUEST
$api = apiSend($module,$command,[ "$fldid"=>$id ]);
$val = json_decode($api,true);

// CREATE NEW REQUEST UPDATE
$api = apiSend($module,$updcommand,[ "$fldid"=>$id ]);
$updates = json_decode($api,true);

//vdump($form." | ".$module." | ".$command." | ".$fldid);
//vdump($api);
//vdump($val);
//vdumpx($updates);

$status = ($val['approve'] == 0) ? 'Pending':'Approved';
if ($form=="Gate Pass") {
    $type = $val['gp_type'];    
    $details = $val['courier'];
    $date = $val['gp_date'];
} elseif ($form=="Unit Repair") {
    $type = $val['unit'];
    $details = $val['description'];
    $date = formatDateUnix($val['created_on']);
}   elseif ($form=="Visitor Pass") {
    $type = $val['unit'];
    $details = $val['purpose'];
    $date = formatDateUnix($val['created_on']);
}  elseif ($form=="Reservation") {
    $type = $val['amenity'];
    $details = $val['purpose'];
    $date = formatDateUnix($val['created_on']);
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
$attachment = (isset($val['attachments'][0]['attachment_url'])) ? $val['attachments'][0]['attachment_url'] : "";
?>
<div class="col-12 d-flex align-items-center justify-content-start mt-4">
    <div class="">
        <a href="myrequests.php"><i class="fas fa-arrow-left circle"></i></a>
    </div>
    <div class="font-18 ml-2"><a href="myrequests.php">Back to My Request</a></div>
</div>
<div class="col-12 d-flex align-items-center justify-content-between mt-3 mb-3">
    <div class="title">Request Status</div>
</div>
<div class="container mb-3">
    <div class="bg-white p-4 rounded">
        <div class="row">
            <div class="col-2 d-flex align-items-center justify-content-center"><i class="fa fa-check circle-inverse" style="padding:15px; font-size:18px;"></i></div>
            <div class="col-3 d-flex align-items-center justify-content-center"><img src="resources/images/onepix.gif" style="border:solid 1px #cecece;" width="80" height="1"></div>
            <div class="col-2 d-flex align-items-center justify-content-center"><i class="fa fa-check circle-inverse" style="padding:15px; font-size:18px; background-color:<?=($status=="New") ? "gray" : "orange" ?>;"></i></div>
            <div class="col-3 d-flex align-items-center"><img src="resources/images/onepix.gif" style="border:solid 1px #cecece;" width="80" height="1"></div>
            <div class="col-2 d-flex align-items-center justify-content-center"><i class="fa fa-check circle-inverse" style="padding:15px; font-size:18px; background-color:<?=($status=="Closed" || $status=="Approved" || $status=="Disapproved") ? "green" : "gray"?>;"></i></div>
        </div>
        <div class="row">
            <div class="col-2 d-flex align-items-center justify-content-center">New</div>
            <div class="col-8 d-flex align-items-center justify-content-center">In Progress</div>
            <div class="col-2 d-flex align-items-center justify-content-center">Closed</div>
        </div>
    </div>
</div>
<div class="col-12 d-flex align-items-center justify-content-between mt-4 mb-3">
    <div class="title">Request Detail</div>
</div>
<div class="container mb-3">
    <form name="frm" action="myrequests-save.php" method="post">
    <div class="bg-white rounded p-3">
        <div class="row px-3">
            <div class="col-4 p-1">Request</div>
            <div class="col-8 p-1"><b><?=$form?></b></div>
            <div class="col-4 p-1"><?=($form=="Reservation") ? "Amenity" : "Category"?></div>
            <div class="col-8 p-1"><b><?=$type?></b></div>
            <div class="col-4 p-1">Description</div>
            <div class="col-8 p-1"><b><?=$details?></b></div>
            <div class="col-4 p-1">Status</div>
            <div class="col-8 p-1"><b><?=$status?></b></div>
            <?php if ($attachment!="") { ?>
            <div class="col-4 p-1">Attachment</div>
            <div class="col-8 p-1"><img src="<?=$attachment?>"></div>
        <?php } ?>
            <div class="col-4 p-1">Feedback</div>
            <div class="col-8 p-1">
                <textarea name="description" rows="3" class="form-control"></textarea>
                <input name="id" type="hidden" value="<?=$id?>">
                <input name="form" type="hidden" value="<?=$form?>">
                <input name="status" type="hidden" value="<?=$status?>">
            </div>
            <div class="col-12"><button type="submit" class="btn btn-primary form-control pt-1 my-2" value="Submit">Submit</button></div>
        </div>
    </div>
    </form>
</div>
<div class="col-12 d-flex align-items-center justify-content-between mt-4 mb-3">
    <div class="title">Updates</div>
</div>
<?php 
if ($updates) {
    foreach($updates as $key=>$update) {
?>
<div class="container mb-3">
    <div class="bg-white rounded p-3">
        <div class="">
            <div class="d-flex align-items-center justify-content-between">
                <div class=""><?=date("m/d/Y h:m A",$update['created_on'])?></div>
                <div class="badge badge-pill badge-secondary pull-right badge-label"><?=$update['status']?></div>
            </div>
        </div>
        <div class="mb-2 mt-2">
            <div class="d-flex align-items-center justify-content-between">
                <div class=""><?=$update['description']?></div>
            </div>
        </div>
        <div class="d-flex mt-2 align-items-center">
            <div><i class="fa fa-user icon-inverse"></i></div>
            <div class="ml-2"><?=$update['first_name']." ".$update['last_name']?></div>
        </div>
    </div>
</div>
<?php 
    } // foreach
} else {
    echo '
    <div class="container mb-3">
        <div class="d-flex align-items-center justify-content-between bg-white rounded p-3">
            No record found.
        </div>
    </div>';
} // if update
?>
<div class="mt-4">&nbsp;</div>
<?=fFooter();?>