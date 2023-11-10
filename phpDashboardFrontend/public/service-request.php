<?php
require_once('header.php');
include("footerheader.php");
$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);
$result =  apiSend('tenant', 'get-allsr', ['condition' => 'name_id="' . $user->id . '"', 'limit' => '3']);
$allsr = json_decode($result);
$location_menu = "my-request";
?>

<div class="d-flex">
    <div class="main">
        <?php include("navigation.php") ?>
        <div style="background-color: #F0F2F5;padding: 0 25px;margin-top: 24px;padding-bottom: 100px;">
            <div>
            <label class="title-section mb-4">Service Requests</label>
                <div class=" card-sr">
                    <a href="<?= WEB_ROOT ?>/report-issue.php" class=" p-1">
                                                        
                        <img class="position-relative img-fluid" src="assets/images/Warning.png" alt="" style="border-radius: 5px;">
                        <label for="">Report Issue</label>
                    </a>
                    <a href="<?= WEB_ROOT ?>/gatepass.php" class=" p-1">
                        <img class="position-relative img-fluid" src="assets/images/gatepass_icon.png" alt="" style="border-radius: 5px;">
                        <label for="">Gate Pass</label>
                    </a>
                    <a href="<?= WEB_ROOT ?>/visitor.php" class=" p-1">
                        <img class="position-relative img-fluid" src="assets/images/visitor_icon.png" alt="" style="border-radius: 5px;">
                        <label for="">Visitor Pass</label>
                    </a>
                    <a href="<?= WEB_ROOT ?>/work-permit-form_new.php" class=" p-1">
                        <img class="position-relative img-fluid" src="assets/images/workpermit_icon.png" alt="" style="border-radius: 5px;">
                        <label for="">Work Permit</label>
                    </a>
                </div>
            </div>

            <div>
            <?php if ($allsr) :?>
                    <label class="title-section mt-5">Recent Requests</label>
                <?php endif ?>
            <div class="my-requests row ">
                        <?php foreach ($allsr as $sr) { ?>
                            <?php if ($sr->type === "Gate Pass") {
                                $result =  apiSend('tenant', 'get-listnew', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result)[0];
                                if ($data) {
                                $result =  apiSend('tenant', 'get-listnew', ['table' => "gatepass_personnel", 'condition' => 'gatepass_id="' .  $data->id . '"']);
                                $personel = json_decode($result);
                                $result =  apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id ="' . $sr->id . '" and  reference_table="' . $sr->main_table . '"', 'orderby' => 'id DESC', 'limit' => '1']);
                                $comment = json_decode($result);
                            ?>
                                <div class="p-2 col-12 col-lg-6 col-xl-4 ">
                                    <div class="requests-card flex-column gap-2  w-100">

                                        <div class="d-flex justify-content-between border-sr">
                                        <div class="d-flex  gap-1">
                                                <b class="id">#<?= $data->id ?></b>
                                                <p class="status  m-0
                                            <?php if ($data->status === "Approved") {
                                                echo "closed-status";
                                            } elseif ($data->status === "Denied") {
                                                echo "open-status";
                                            } else {
                                                echo "open-status acknowledged-btn";
                                            } ?>"><?= $data->status ?></p>
                                            </div>
                                            <div class="date">
                                                <label><?= $data->date_upload ?></label>
                                            </div>
                                        </div>
                                        <div class="w-100 mt-3">
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0 "><?= $sr->type ?></label><br>
                                            </div>
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0">Type:</label><br>
                                                <label class="col-6 label m-0 "><?= $data->type  ?> </label>
                                            </div>
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0">Personnel:</label><br>
                                                <label class="col-6 label m-0 "><?= $personel[0]->personnel_name ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-auto">
                                            <div class="w-100">
                                                <?php if ($comment->comment) : ?>
                                                    <label class="label m-0 " for="">Updates:</label>
                                                    <div class="comment">
                                                        <div>
                                                            <span class="date-comment">Date & Time: <?= formatDateTime($comment[0]->created_on) ?> </span>
                                                            <div>
                                                                <span class="from-comment">-from admin-</span>
                                                                <p class="text-comment"><?= $comment[0]->comment ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="text-end mt-2">
                                                    <a href="myrequests-view.php?id=<?= $data->enc_id ?>&loc=<?= $sr->table ?>">View all</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php } ?>
                            <?php } elseif ($sr->type === "Report Issue") {
                                $result =  apiSend('tenant', 'get-listnew', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result)[0];
                                if ($data) {
                                $result =  apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id="' . $sr->id . '" and reference_table="' . $sr->main_table . '"', 'orderby' => 'id DESC', 'limit' => '1']);
                                $comment = json_decode($result);
                            ?>
                                <div class="p-2 col-12 col-lg-6 col-xl-4 ">
                                    <div class="requests-card flex-column gap-2 w-100 ">
                                        <div class="d-flex justify-content-between border-sr">
                                        <div class="d-flex  gap-1">
                                                <b class="id">#<?= $data->id ?></b>
                                                <p class="status  m-0
                                        <?php if ($data->status === "Open") {
                                            echo "closed-status";
                                        } elseif ($data->status === "Closed") {
                                            echo "open-status";
                                        } else {
                                            echo "open-status acknowledged-btn";
                                        } ?>"><?= $data->status ?></p>
                                            </div>
                                            <div class="date">
                                                <label><?= $data->date_upload ?></label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="w-100 mt-3">
                                                <div class="row">
                                                    <label class="fw-bold col-6 label m-0 "><?= $sr->type ?></label><br>
                                                </div>
                                                <div class="row">
                                                    <label class="fw-bold col-6 label m-0">Category:</label><br>
                                                    <label class="col-6 label m-0 "><?= $data->issue_name ?> </label>
                                                </div>

                                                <div class="row">
                                                    <label class="fw-bold col-6 label m-0">Issue:</label><br>
                                                    <label class="col-6 label m-0 "><?= $data->description  ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-auto">
                                            <div class="w-100">
                                                <?php if ($comment->comment) : ?>
                                                    <label class="label m-0" for="">Updates:</label>
                                                    <div class="comment">
                                                        <div>
                                                            <span class="date-comment">Date & Time: <?= formatDateTime($comment[0]->created_on) ?> </span>
                                                            <div>
                                                                <span class="from-comment">-from admin-</span>
                                                                <p class="text-comment"><?= $comment[0]->comment ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="text-end mt-2">
                                                    <a href="myrequests-view.php?id=<?= $data->enc_id ?>&loc=<?= $sr->table ?>">View all</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            <?php } elseif ($sr->type === "Visitor Pass") {
                                $result =  apiSend('tenant', 'get-listnew', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result)[0];
                                if ($data) {
                                $result =  apiSend('tenant', 'get-listnew', ['table' => "vp_guest", 'condition' => 'guest_id="' .  $data->id . '"']);
                                $vp_g = json_decode($result);
                                $result =  apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id="' . $sr->id . '" and reference_table="' . $sr->main_table . '"', 'orderby' => 'id DESC', 'limit' => '1']);
                                $comment = json_decode($result);

                            ?>
                                <div class="p-2 col-12 col-lg-6 col-xl-4 ">
                                    <div class="requests-card flex-column gap-2  w-100">

                                        <div class="d-flex justify-content-between border-sr">
                                        <div class="d-flex  gap-1">
                                                <b class="id">#<?= $data->id ?></b>
                                                <p class="status  m-0
                                                    <?php if ($data->status === "Approved") {
                                                        echo "closed-status";
                                                    } elseif ($data->status === "Denied") {
                                                        echo "open-status";
                                                    } else {
                                                        echo "open-status acknowledged-btn";
                                                    } ?>"><?= $data->status ?></p>
                                            </div>
                                            <div class="date">
                                                <label><?= $data->date_upload ?></label>
                                            </div>
                                        </div>
                                        <div class="w-100 mt-3">
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0 "><?= $sr->type ?></label><br>
                                            </div>
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0">Guest:</label><br>
                                                <label class="col-6 label m-0 ">
                                                    <?php
                                                    echo implode(", ", array_column($vp_g, 'guest_name'));
                                                    ?>
                                                </label>
                                            </div>
                                            <div class="row">
                                                  <label class="fw-bold col-6 label m-0">Visit Purpose:</label><br>
                                                  <label class="col-6 label m-0 "><?= $data->visit_purpose ?> </label>
                                              </div>
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0">Arrival Date:</label><br>
                                                <label class="col-6 label m-0 "><?= $data->arrival_date ?> </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-auto">
                                            <div class="w-100">

                                                <?php if ($comment->comment) : ?>

                                                    <label class="label m-0" for="">Updates:</label>
                                                    <div class="comment">
                                                        <div>
                                                            <span class="date-comment">Date & Time: <?= formatDateTime($comment[0]->created_on) ?> </span>
                                                            <div>
                                                                <span class="from-comment">-from admin-</span>
                                                                <p class="text-comment"><?= $comment[0]->comment ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="text-end mt-2">
                                                    <a href="myrequests-view.php?id=<?= $data->enc_id ?>&loc=<?= $sr->table ?>">View all</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <?php } ?>
                            <?php } elseif ($sr->type === "Work Permit") {
                                $result =  apiSend('tenant', 'get-listnew', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result)[0];
                                if ($data) {
                                $result =  apiSend('tenant', 'get-listnew', ['table' => 'work_details', 'condition' => 'id="' .  $data->work_details_id . '"']);
                                $work = json_decode($result);
                                $result =  apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id="' . $sr->id . '" and reference_table="' . $sr->main_table . '"', 'orderby' => 'id DESC', 'limit' => '1']);
                                $comment = json_decode($result);
                            ?>
                                <div class="p-2 col-12 col-lg-6 col-xl-4 ">
                                    <div class="requests-card w-100">
                                        <div class="d-flex justify-content-between gap-2 flex-column w-100">

                                            <div class="d-flex justify-content-between border-sr">
                                            <div class="d-flex  gap-1">
                                                <b class="id">#<?= $data->id ?></b>
                                                    <p class="status  m-0
                                            <?php if ($data->status === "Open") {
                                                echo "closed-status";
                                            } elseif ($data->status === "Closed") {
                                                echo "open-status";
                                            } else {
                                                echo "open-status acknowledged-btn";
                                            } ?>"><?= $data->status ?>
                                                    </p>
                                                </div>
                                                <div class="date">
                                                    <label><?= $data->date_upload ?></label>
                                                </div>
                                            </div>



                                            <div class="w-100 mt-3">
                                                <div class="row">
                                                    <label class="fw-bold col-6 label m-0 "><?= $sr->type ?></label><br>
                                                </div>
                                                <div class="row">
                                                    <label class="fw-bold col-6 label m-0">Category:</label><br>
                                                    <label class="col-6 label m-0 "><?= $data->category_name ?> </label>
                                                </div>
                                                <div class="row">
                                                    <label class="fw-bold col-6 label m-0">Name Contractor :</label><br>
                                                    <label class="col-6 label m-0 "><?= $work[0]->name_contractor ?></label>
                                                </div>
                                                <div class="row">
                                                    <label class="fw-bold col-6 label m-0">Scope of work :</label><br>
                                                    <label class="col-6 label m-0 "><?= $work[0]->scope_work ?> </label>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between mt-auto">
                                                <div class="w-100">
                                                    <?php if ($comment->comment) : ?>
                                                        <label class="label m-0" for="">Updates:</label>
                                                        <div class="comment">
                                                            <div>
                                                                <span class="date-comment">Date & Time: <?= formatDateTime($comment[0]->created_on) ?> </span>
                                                                <div>
                                                                    <span class="from-comment">-from admin-</span>
                                                                    <p class="text-comment"><?= $comment[0]->comment ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <div class="text-end mt-2">
                                                        <a href="myrequests-view.php?id=<?= $data->enc_id ?>&loc=<?= $sr->table ?>">View all</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php include('menu.php') ?>
</div>
</body>

</html>
<script>
    $('.back-button-sr').on('click', function() {
        history.back();
    });
</script>