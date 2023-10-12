<?php
$location_menu = "my-request";
require_once('header.php');
include("footerheader.php");

$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_visitor_pass', 'condition' => 'name_id="' . $user->id . '"', 'orderby' => 'id', 'limit' => '2']);
$vp = json_decode($result);


$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_report_issue', 'condition' => 'name_id="' . $user->id . '"', 'orderby' => 'id', 'limit' => '2']);
$issue = json_decode($result);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_gatepass', 'condition' => 'name_id="' . $user->id . '"', 'orderby' => 'id', 'limit' => '2']);
$gp = json_decode($result);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_workpermit', 'condition' => 'name_id="' . $user->id . '"', 'orderby' => 'id', 'limit' => '2']);
$wp = json_decode($result);

$result =  apiSend('tenant', 'get-allsr', ['condition' => 'name_id="' . $user->id . '"', 'limit' => '10']);
$allsr = json_decode($result);
// vdump($allsr)


?>
<html style="background-color: #F0F2F5;">
<!-- <div class="header py-3">
        <div class="bg-white pt-2 rounded-sm" >
            <div class="d-flex align-items-center px-3">
                <button class="back-button-sr" ><i class="fa-solid fa-chevron-left"></i></button>
                <label class="heading-page px-2 m-0" >My request</label>
            </div>
        </div>
    </div> -->
<div class="d-flex">

    <div class="main ">
        <?php include("navigation.php") ?>


        <div style="background-color: #F0F2F5; padding: 10px 25px 100px 25px">


            <div class="request-filter justify-content-between">
            <label class="title-section">My Request</label>
                <button class="add-btn-sr w-auto px-5">
                    <span class="material-icons">add</span> Create New
                </button>
            </div>
          


            <div>
                <div class="my-requests">

                    <?php if ($allsr) { ?>
                        <?php foreach ($allsr as $sr) { ?>
                            <?php if ($sr->type === "Gate Pass") {
                                $result =  apiSend('tenant', 'get-list-sr', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result);
                                $result =  apiSend('tenant', 'get-list-sr', ['table' => "gatepass_personnel", 'condition' => 'gatepass_id="' .  $data[0]->id . '"']);
                                $personel = json_decode($result);

                            ?>
                                <div class="requests-card w-100">
                                    <?php if ($item->attachments) { ?>
                                        <div>
                                            <img src="<?= $data[0]->attachments ?>" style="border-radius: 5px;">
                                        </div>
                                    <?php } ?>
                                    <div>
                                        <div>
                                            <p class="status  m-0
                                    <?php if ($data[0]->status === "Approved") {
                                        echo "closed-status";
                                    } elseif ($data[0]->status === "Denied") {
                                        echo "open-status";
                                    } else {
                                        echo "open-status acknowledged-btn";
                                    } ?>"><?= $data[0]->status ?>
                                            </p>
                                        </div>
                                        <div class="">
                                            <label class=" label m-0"><b><?= $sr->type ?></b> </label><br>
                                            <label class="label m-0">Type: <b><?= $data[0]->type   ?></b> </label><br>
                                            <label class=" label m-0">Personel: <b><?= $personel[0]->personnel_name  ?></b> </label><br>
                                        </div>
                                    </div>
                                    <div class="date">
                                        <label><?= $data[0]->date_upload ?></label>
                                    </div>
                                </div>
                            <?php } elseif ($sr->type === "Report Issue") {
                                $result =  apiSend('tenant', 'get-list-sr', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result);
                                // var_dump($data);
                            ?>
                                <div class="requests-card w-100 ">

                                    <div>
                                        <div>
                                            <p class="status  m-0
                                        <?php if ($data[0]->status === "Open") {
                                            echo "closed-status";
                                        } elseif ($data[0]->status === "Closed") {
                                            echo "open-status";
                                        } else {
                                            echo "open-status acknowledged-btn";
                                        } ?>"><?= $data[0]->status ?></p>
                                        </div>
                                        <div class="">
                                            <label class="label m-0"> <b>Report Issue</b></label><br>
                                            <label class="label">Category: <b><?= $data[0]->issue_name ?></b> </label></br>
                                            <label class="">Issue : <b><?= $data[0]->description ?></b> </label>
                                        </div>
                                    </div>
                                    <div>
                                        <?php if ($data[0]->attachments) { ?>
                                            <img src="<?= $data[0]->attachments ?>" style="border-radius: 5px;">
                                        <?php } ?>
                                    </div>
                                    <div class="date">
                                        <label><?= $data[0]->date_upload ?></label>
                                    </div>
                                </div>



                            <?php } elseif ($sr->type === "Visitor Pass") {
                                $result =  apiSend('tenant', 'get-list-sr', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result);

                                $result =  apiSend('tenant', 'get-list-sr', ['table' => "vp_guest", 'condition' => 'guest_id="' .  $data[0]->id . '"']);
                                $vp_g = json_decode($result);
                                // vdump($vp_g);

                            ?>
                                <div class="requests-card w-100">
                                    <?php if ($data[0]->attachments) { ?>
                                        <div>
                                            <img src="<?= $data[0]->attachments ?>" style="border-radius: 5px;">
                                        </div>
                                    <?php } ?>
                                    <div class="w-100">
                                        <div>
                                            <p class="status  m-0
                                    <?php if ($data[0]->status === "Approved") {
                                        echo "closed-status ";
                                    } elseif ($data[0]->status === "Denied") {
                                        echo "open-status open-status";
                                    } else {
                                        echo "acknowledged-btn open-status";
                                    } ?> "><?= $data[0]->status ?></p>
                                        </div>
                                        <div class="w-100">
                                            <label class="label m-0"><b><?= $sr->type ?></b> </label><br>
                                            <label class="label m-0">Location : <b><?= $data[0]->location_name ?></b></label><br>
                                            <label class="label m-0 label-limit">Visitor Name: <b>
                                                    <?php
                                                    echo implode(", ", array_column($vp_g, 'guest_name'));
                                                    ?>
                                                </b></label>
                                        </div>
                                        <div>
                                            <label class="description">Date of Arrival: <?= $data[0]->arrival_date ?></label>
                                        </div>
                                    </div>
                                    <div class="date">
                                        <label><?= $data[0]->date_upload ?></label>
                                    </div>
                                </div>
                            <?php } elseif ($sr->type === "Work Permit") {
                                $result =  apiSend('tenant', 'get-list-sr', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result);

                                $result =  apiSend('tenant', 'get-list-sr', ['table' => 'work_details', 'condition' => 'id="' .  $data[0]->work_details_id . '"']);
                                $work = json_decode($result);

                            ?>

                                <div class="requests-card w-100">
                                    <?php if ($data[0]->attachments) { ?>
                                        <div>
                                            <img src="<?= $data[0]->attachments ?>" style="border-radius: 5px;">
                                        </div>
                                    <?php } ?>
                                    <div>
                                        <div>
                                            <p class="status  m-0
                                    <?php if ($data[0]->status === "Open") {
                                        echo "closed-status";
                                    } elseif ($data[0]->status === "Closed") {
                                        echo "open-status";
                                    } else {
                                        echo " open-status acknowledged-btn";
                                    } ?>"><?= $data[0]->status ?></p>
                                        </div>
                                        <div class="">
                                            <label class="label m-0"><b>Work Permit</b></label><br>
                                            <label class="label m-0">Category: <b><?= $data[0]->category_name   ?></b> </label><br>
                                            <label class="label m-0">Name Contractor : <b><?= $work[0]->name_contractor ?></b> </label><br>
                                            <label class="label m-0">Scope of work : <b><?= $work[0]->scope_work ?></b> </label>
                                        </div>
                                    </div>
                                    <div class="date">
                                        <label><?= $data[0]->date_upload ?></label>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } else {
                        echo "No Service Requests";
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <?php include('menu.php') ?>
</div>



</html>
<script>
    $('.follow-up').on('click', function() {
        window.location.href = "<?=WEB_ROOT ?>/unit-repair-status_new.php";
    });
    $('.add-btn-sr').on('click', function() {
        window.location.href = "<?=WEB_ROOT ?>/service-request.php";
    });

    $('.back-button-sr').on('click', function() {
        window.location.href = "<?=WEB_ROOT ?>/home.php";
    });
</script>