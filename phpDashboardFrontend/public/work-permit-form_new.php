<?php
require_once('header.php');
include("footerheader.php");

$module = "workpermit";
$table = "workpermit";
$view = "vw_workpermit";


$result =  apiSend('tenant', 'get-list-sr', ['table' => 'list_workpermitcategory',  'orderby' => 'category']);
$category = json_decode($result);



$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_workpermit', 'condition' => 'created_by="' . $user->id . '" AND status = "Open"']);
$open = json_decode($result);
$opentotal = count($open);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_workpermit', 'condition' => 'created_by="' . $user->id . '" AND status = "Ongoing"']);
$ongoing = json_decode($result);
$ongoingdtotal = count($ongoing);


$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_workpermit', 'condition' => 'created_by="' . $user->id . '" AND status = "Closed"']);
$closed = json_decode($result);
$closedtotal = count($closed);

$result =  apiSend('tenant', 'get-allsr', ['condition' => 'name_id="' . $user->id . '"']);
$allsr = json_decode($result);

?>
<div class="d-flex">

    <div class="main">
        <?php include("navigation.php") ?>

        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Work Permit</label>
        </div>
        <div style="background-color: #F0F2F5; padding: 20px 24px 106px 24px;">
            <div class="d-flex justify-content-center pt-3" style="background-color: #F0F2F5;">
                <div class="card mb-3" style="width: 100%">
                    <div class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-status w-100" style="padding: 12px;">
                            <div><label class="m-0" style="font-weight: 400; color:#1C5196;">Request form</label></div>
                            <div><i id="down1" style="color:#1C5196" class="fa-solid fa-caret-down"></i><i id="up1" style="color:#1C5196" class="fa-solid fa-caret-down fa-rotate-180"></i></div>
                        </button>
                    </div>
                    <div id="collapse-status" class="collapse">




                        <div class="card-body" style="margin-top:16px;">
                            <div class="forms">

                                <input type="hidden" readonly id="workpermit_id">
                                <form method="post" action="workpermit-save.php" id="form-main">
                                    <input name="date" type="hidden" readonly value="<?= date('Y-m-d H:i:s') ?> ">
                                    <input name="module" type="hidden" readonly value="<?= $module ?>">
                                    <input name="table" type="hidden" readonly value="<?= $table ?>">
                                    <input type="hidden" name="name_id" readonly value="<?= $user->id ?>">
                                    <input type="hidden" name="unit_id" readonly value="<?= $user->unit_id ?>">
                                    <input name="work_details_id" readonly type="hidden" id="work_details_id">
                                    <div class="">
                                        <div class="select form-group">
                                            <select name="workpermitcategory_id" class="select-text" required>
                                                <option selected disabled></option>
                                                <?php foreach ($category as $key => $val) {; ?>
                                                    <option value="<?= $val->id ?>" <?= ($record && $record->workpermitcategory_id == $val->id) ? 'selected' : '' ?>><?= $val->category ?></option>
                                                <?php } ?>
                                            </select>
                                            <label class="select-label">Nature of Work <span class="text-danger">*</span></label>
                                            <i class="fa-solid fa-sort-down"></i>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <input id="request-form" name="name" value="<?= $user->fullname ?>" disabled required placeholder="text">
                                            <label id="request-form">Name <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <input id="request-form" type="date" required name="start_date" placeholder="text">
                                            <label id="request-form" for="" class="text-required">Start Date <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <input id="request-form" type="date" required name="end_date" placeholder="text">
                                            <label id="request-form" for="" class="text-required">End Date <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <input id="request-form" name="unit" type="text" disabled value="<?= $user->unit_name ?>" required placeholder="text">
                                            <label id="request-form">Unit # <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="">

                                        <div class="form-group">
                                            <input id="request-form" name="contact_no" type="text" value="<?= $user->contact_no ?>" required placeholder="text">
                                            <label id="request-form">Contact Number <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </form>
                                <label style="font-weight: 400; font-size: 24px;  margin:20px 0;">Work Details</label>


                                <div class="input-items ">
                                    <form method="post" enctype="multipart/form-data" action="gatepass-save.php" id="work-details">
                                        <input name="module" type="hidden" readonly value="<?= $module ?>">
                                        <input name="table" type="hidden" readonly value="work_details">
                                        <div>
                                            <div class="form-group">
                                                <input id="request-form" required type="text" name="name_contractor" placeholder="text">
                                                <label id="request-form">Name of Contractor<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-group">
                                                <input id="request-form" required type="text" name="scope_work" placeholder="text">
                                                <label id="request-form">Scope of Work<span class="text-danger">*</span></label>

                                            </div>
                                            <div class="form-group">
                                                <input id="request-form" required type="text" name="person_charge" placeholder="text">
                                                <label id="request-form">Name of Person-In-Charge<span class="text-danger">*</span></label>

                                            </div>
                                            <div class="form-group">
                                                <input id="request-form" required type="number" name="contact_number" value="" placeholder="text">
                                                <label id="request-form">Contact Number<span class="text-danger">*</span></label>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <label style="font-weight: 400; font-size: 24px;  margin:27px 0;">List of Workers/Personnel</label>

                                <div class="table-data" id="add-ons">
                                </div>

                                <div class="input-items ">
                                    <div>
                                        <div class="form-group">
                                            <input id="request-form" type="text" id name="personnel_name[]" placeholder="text">
                                            <label id="request-form">Name<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-group">
                                            <input id="request-form" type="text" name="personnel_description[]" placeholder="text">
                                            <label id="request-form">Description</label>

                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="btn-add-item" class=" btn-add-item"> + Add Workers/Personnel</button>
                                        </div>
                                    </div>

                                </div>

                                <label style="font-weight: 400; font-size: 24px;  margin:27px 0;">List of Materials</label>

                                <div class="table-data2 " id="add-ons">
                                </div>


                                <div class="input-items ">
                                    <div>
                                        <div class="form-group">
                                            <input id="request-form" type="text" name="materials_name[]" placeholder="text">
                                            <label id="request-form">Material Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-group">
                                            <input id="request-form" type="number" name="material_qty[]" placeholder="text">
                                            <label id="request-form">Quantity <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-group">
                                            <input id="request-form" type="text" name="material_desc[]" placeholder="text">
                                            <label id="request-form">Description </label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="button" id="btn-add-item2" class=" btn-add-item"> + Add Materials</button>
                                    </div>
                                </div>

                                <label style="font-weight: 400; font-size: 24px;  margin:27px 0;">List of Tools</label>

                                <div class="table-data3" id="add-ons">
                                </div>

                                <div class="input-items ">
                                    <div>
                                        <div class="form-group">
                                            <input id="request-form" type="text" name="tools_name[]" placeholder="text">
                                            <label id="request-form">Tool Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-group">
                                            <input id="request-form" type="number" name="tools_qty[]" placeholder="text">
                                            <label id="request-form">Quantity <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-group">
                                            <input id="request-form" type="text" name="tools_desc[]" placeholder="text">
                                            <label id="request-form">Description </label>
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" id="btn-add-item3" class=" btn-add-item"> + Add Tools</button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="switch">
                                        <input type="checkbox" id="switch1">
                                        <label for="switch1">Toggle</label>
                                    </div>
                                    <label for="" class="label-switch mx-3">Create Gate Pass</label>
                                </div>
                                <div class="gatepass">
                                    <div class="d-flex gap-3">
                                        <div>
                                            <input type="radio" name="gp_type" value="3" id="delivery" checked>
                                            <label for="delivery" class="label-switch">Service</label>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <div class="form-group w-100 ">
                                                    <input name="gp_time" id="request-form" placeholder="Enter here" type="time" class="form-control  w-100 ">
                                                    <label id="request-form" for="request-form">Time<b class="text-danger">*</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="terms-condition-text d-flex  gap-2 pt-3">
                                    <!-- <input type="checkbox">I agree to the <a href="#">Terms and Condition</a> -->
                                </div>

                                <div class="w-100" style="margin-bottom: 34px;">
                                    <div class="grp-btn">
                                        <div class=" btn-settings pb-2">
                                            <button type="submit" class="main-submit btn btn-dark btn-primary settings-save d-block px-5 w-100">Submit</button>
                                        </div>
                                        <div class="btn-settings">
                                            <button type="button" class="close-btn btn btn-light btn-cancel settings-cancel d-block px-5 w-100">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="tab-service">
                <label for="">History</label>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                    <label id="btnSubmit" class="btn first-tab btn-tab-service btn-outline-primary" for="btnradio1">Open <span><?= $opentotal ?></span></label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                    <label id="btnAcknowledged" class="btn btn-tab-service btn-outline-primary" for="btnradio2">Ongoing <span><?= $ongoingdtotal ?></span> </label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                    <label id="btnFinish" class="btn btn-tab-service btn-outline-primary" for="btnradio3">Closed<span><?= $closedtotal ?></span> </label>
                </div>
            </div>


            <div class="history-container submitted">
            <?php
                $count = 0;
                foreach ($allsr as $key => $sr): ?>
                <?php if ($sr->type === "Work Permit"): ?>
                    <?php
                        $result =  apiSend('tenant', 'get-listnew', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"and status = "Open" ']);
                        $data = json_decode($result)[0];
                    if ($data->status == "Open") {
                    $count += 1;
                    if ($count > 5){
                        break;
                    }
                    }
                    if ($data) {
                        $result =  apiSend('tenant', 'get-listnew', ['table' => 'work_details', 'condition' => 'id="' .  $data->work_details_id . '"']);
                        $work = json_decode($result);
                        $result =  apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id="' . $sr->id . '" and reference_table="' . $sr->main_table . '"', 'orderby' => 'id DESC', 'limit' => '1']);
                        $comment = json_decode($result);
                    ?>
                            <div class="p-2">
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
                                                        <label class="fw-bold  col-6 label m-0 fs-6"><?= $sr->type ?></label><br>
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
                                                        <?php if ($comment[0]->comment) : ?>
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
            <?php endif ?>
          <?php endforeach; ?>
            </div>
            <div class="history-container acknowledged">
            <?php
                $count = 0;
                foreach ($allsr as $key => $sr): ?>
                <?php if ($sr->type === "Work Permit"): ?>
                    <?php
                        $result =  apiSend('tenant', 'get-listnew', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"and status = "Ongoing" ']);
                        $data = json_decode($result)[0];
                    if ($data->status == "Ongoing") {
                    $count += 1;
                    if ($count > 5){
                        break;
                    }
                    }
                    if ($data) {
                        $result =  apiSend('tenant', 'get-listnew', ['table' => 'work_details', 'condition' => 'id="' .  $data->work_details_id . '"']);
                        $work = json_decode($result);
                        $result =  apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id="' . $sr->id . '" and reference_table="' . $sr->main_table . '"', 'orderby' => 'id DESC', 'limit' => '1']);
                        $comment = json_decode($result);
                    ?>
                            <div class="p-2">
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
                                                        <label class="fw-bold  col-6 label m-0 fs-6"><?= $sr->type ?></label><br>
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
                                                        <?php if ($comment[0]->comment) : ?>
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
            <?php endif ?>
          <?php endforeach; ?>
            </div>
            <div class="history-container finishedwork">
            <?php
                $count = 0;
                foreach ($allsr as $key => $sr): ?>
                <?php if ($sr->type === "Work Permit"): ?>
                    <?php
                        $result =  apiSend('tenant', 'get-listnew', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"and status = "Closed" ']);
                        $data = json_decode($result)[0];
                    if ($data->status == "Closed") {
                    $count += 1;
                    if ($count > 5){
                        break;
                    }
                    }
                    if ($data) {
                        $result =  apiSend('tenant', 'get-listnew', ['table' => 'work_details', 'condition' => 'id="' .  $data->work_details_id . '"']);
                        $work = json_decode($result);
                        $result =  apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id="' . $sr->id . '" and reference_table="' . $sr->main_table . '"', 'orderby' => 'id DESC', 'limit' => '1']);
                        $comment = json_decode($result);
                    ?>
                            <div class="p-2">
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
                                                        <label class="fw-bold  col-6 label m-0 fs-6"><?= $sr->type ?></label><br>
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
                                                        <?php if ($comment[0]->comment) : ?>
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
            <?php endif ?>
          <?php endforeach; ?>
            </div>
        </div>


    </div>

    <?php include('menu.php') ?>
</div>
</body>

</html>
<script>
		$("input[name=end_date]").change(function() {
			if ($("input[name=start_date]").val() === "") {
				popup({
					title: "Please enter start date first.",
					data: {
						success: 0
					},
					reload_time: 3000,
					
				});
				$("input[name=start_date]").focus();
				$(this).val('');
			} else if ($("input[name=end_date]").val() < $("input[name=start_date]").val()) {
				popup({
					title: "End date cannot be before start date. Please change.",
					data: {
						success: 0
					},
					reload_time: 3000,
					
				});
				$("input[name=end_date]").val(''); 
				$("input[name=end_date]").focus();
			}
		});

    $('.acknowledged').hide();
    $('.finishedwork').hide();
    $("#btnSubmit").on('click', function() {
        $('.submitted').show();
        $('.acknowledged').hide();
        $('.finishedwork').hide();
    })
    $("#btnAcknowledged").on('click', function() {
        $('.submitted').hide();
        $('.acknowledged').show();
        $('.finishedwork').hide();
    })
    $("#btnFinish").on('click', function() {
        $('.submitted').hide();
        $('.acknowledged').hide();
        $('.finishedwork').show();
    })


    $('.main-submit').click(function() {
        // alert("tst")
        // Check if inputs and selects have values
        var isFormValid = true;
        $('.main input[required], .main select[required]').each(function() {
            if (!$(this).val()) {
                isFormValid = false;

                // $(this).addClass('error');

            }
        });

        if (isFormValid) {
            $("#work-details").submit();
            if ($('#switch1').is(':checked')) {
                send_gatepass();
            }
        } else {
            // Trigger HTML built-in validation pop-up for all elements
            $('.main input[required], .main select[required]').each(function() {
                this.reportValidity();
            });
        }
    });
    const workpermit_id = $('#workpermit_id')

    $("#work-details").off('submit').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                const res = JSON.parse(data)
                $('#work_details_id').val(res.id);
                $('#form-main').submit();


                // if (data.success == 1) {
                //     toastr.success(data.description, 'Information', {
                //         timeOut: 2000,
                //         onHidden: function() {
                //             location = "<?= WEB_ROOT . "/$module/" ?>";
                //         }
                //     });
                // }
            },
        });
    });
    $("#form-main").off('submit').on('submit', function(e) {
        // alert("test")
        e.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                const res = JSON.parse(data)

                workpermit_id.val(res.id)
                item_send(materials, res.id)
                item_send(personel, res.id)
                item_send(tools, res.id)
                // status(res.id)
                popup({
                    data: res,
                    reload_time: 2000,
                    redirect: location.href
                })
            },
        });
    });
    let personel = []
    $('#btn-add-item').on('click', function(e) {
        e.preventDefault();
        const name = $('input[name="personnel_name[]"]').val()
        const desc = $('input[name="personnel_description[]"]').val()
        if (name) {
            $('.table-data').append(`

            <div class="description-form">
                    <div class="description-label">
                        <p>Name</p>
                        <p>Description </p>
                    </div>
                    <div class="description-value">
                        <p>${name}</p>
                        <p>${desc}</p>
                     </div>
            </div>
            `);
            var item = {
                personnel_name: name,
                personnel_description: desc,
            };
            personel.push(item);
        }
        personel = personel.map(obj => ({
            ...obj,
            workpermit_id: Number(workpermit_id.val()),
            table: 'workers'
        }));
    });
    let materials = []
    $('#btn-add-item2').on('click', function(e) {
        e.preventDefault();
        const materials_name = $('input[name="materials_name[]"]').val()
        const materialQty = $('input[name="material_qty[]"]').val()
        const materialDesc = $('input[name="material_desc[]"]').val()
        if (materials_name && materialQty) {
            $('.table-data2').append(`
            <div class="description-form">
                    <div class="description-label">
                        <p>Material Name</p>
                        <p>Quantity</p>
                        <p>Description</p>
                    </div>
                    <div class="description-value">
                        <p>${materials_name}</p>
                        <p>${materialQty}</p>
                        <p>${materialDesc}</p>
                     </div>
            </div>
            `);
            var item = {
                materials_name: materials_name,
                quantity_materials: materialQty,
                description_materials: materialDesc,
            };

            // Push the item to the array
            materials.push(item);
        }

        materials = materials.map(obj => ({
            ...obj,
            workpermit_id: Number(workpermit_id.val()),
            table: 'work_materials'
        }));
    });
    let tools = []
    $('#btn-add-item3').on('click', function(e) {
        const tools_name = $('input[name="tools_name[]"]').val()
        const toolsQty = $('input[name="tools_qty[]"]').val()
        const toolsDesc = $('input[name="tools_desc[]"]').val()
        e.preventDefault();

        if (tools_name && toolsQty) {

            $('.table-data3').append(`
            <div class="description-form">
                    <div class="description-label">
                        <p>Tool Name</p>
                        <p>Quantity</p>
                        <p>Description</p>
                    </div>
                    <div class="description-value">
                        <p>${tools_name}</p>
                        <p>${toolsQty}</p>
                        <p>${toolsDesc}</p>
                     </div>
            </div>
            `);

            var item = {
                tools_name: tools_name,
                quantity_tools: toolsQty,
                description_tools: toolsDesc,
            };

            // Push the item to the array
            tools.push(item);
        }
        tools = tools.map(obj => ({
            ...obj,
            workpermit_id: Number(workpermit_id.val()),
            table: 'work_tools'
        }));
    });

    const item_send = (items, id) => {
        items.forEach(i => {
            <?php if ($decrypt_id) { ?>
                i.workpermit_id = <?php echo $decrypt_id ?>
            <?php } else { ?>
                i.workpermit_id = id
            <?php } ?>

            // console.log(items)
            $.ajax({
                url: '<?= WEB_ROOT; ?>/gatepass-save.php',
                method: 'POST',
                data: i,
                success: function(response) {
                    const data = JSON.parse(response)


                },
                error: function(xhr, status, error) {

                    console.error(error);
                }
            });
        })
    }

    $('.gatepass').hide()
    $('#switch1').change(function() {
        const gate = $('.gatepass');
        // alert("test")
        if ($(this).is(':checked')) {
            $("input[name=delivery_date]").prop('required', true);
            $("input[name=delivery_time]").prop('required', true);
            gate.show();

        } else {
            $("input[name=delivery_date]").prop('required', false);
            $("input[name=delivery_time]").prop('required', false);
            gate.hide();
        }
    });


    let personnel_gatepass = []
    $('#btn-add-item').click(function() {
        // console.log(workpermit_id.val())
        const personnel_name = $('input[name="personnel_name[]"]').val()
        const personnel_description = $('input[name="personnel_description[]"]').val()
        if (personnel_name) {

            var item = {
                personnel_name: personnel_name,
                personnel_description: personnel_description,
            };

            // Push the item to the array
            personnel_gatepass.push(item);
        }
        // console.log(personel)
        personnel_gatepass = personnel_gatepass.map(obj => ({
            ...obj,
            workpermit_id: Number(workpermit_id.val()),
            table: 'workers'
        }));
        $('input[name="personnel_name[]"]').val('')
        $('input[name="personnel_description[]"]').val('')
    });
    let materials_gatepass = [];
    $('#btn-add-item2').click(function() {
        const materials_name = $('input[name="materials_name[]"]').val()
        const materialQty = $('input[name="material_qty[]"]').val()
        const materialDesc = $('input[name="material_desc[]"]').val()

        var item = {
            item_name: materials_name,
            item_qty: materialQty,
            description: materialDesc,
        };
        materials_gatepass.push(item);

        materials_gatepass = materials_gatepass.map(obj => ({
            ...obj,
            workpermit_id: Number(workpermit_id.val()),
            table: 'work_materials'
        }));
        $('input[name="materials_name[]"]').val('')
        $('input[name="material_qty[]"]').val('')
        $('input[name="material_desc[]"]').val('')
    });

    let tools_gatepass = []
    $('#btn-add-item3').click(function() {
        const tools_name = $('input[name="tools_name[]"]').val()
        const toolsQty = $('input[name="tools_qty[]"]').val()
        const toolsDesc = $('input[name="tools_desc[]"]').val()
        if (tools_name && toolsQty) {

            var item = {
                item_name: tools_name,
                item_qty: toolsQty,
                description: toolsDesc,
            };

            // Push the item to the array
            tools_gatepass.push(item);
        }
        tools_gatepass = tools_gatepass.map(obj => ({
            ...obj,
            workpermit_id: Number(workpermit_id.val()),
            table: 'work_tools'
        }));
        $('input[name="tools_name[]"]').val('')
        $('input[name="tools_qty[]"]').val('')
        $('input[name="tools_desc[]"]').val('')
    });


    const item_send_gatepass = (items, id, table) => {
        items.forEach(i => {

            // Remove the workpermit_id property
            delete i.workpermit_id;

            i.gatepass_id = id;
            i.table = table;

            $.ajax({
                url: '<?= WEB_ROOT; ?>/gatepass-save.php',
                method: 'POST',
                data: i,
                success: function(response) {
                    const data = JSON.parse(response);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    };
    let selectedID = "5"
    // $('input[name="gp_type"]').change(function() {
    //     var selectedValue = $(this);
    //     if (selectedValue.attr('id') === 'pullout') {
    //         selectedID = "2";

    //     } else {
    //         selectedID = "1";
    //     }
    // });

    const send_gatepass = () => {

        const gp_date = $('input[name="start_date"]').val();
        const gp_time = $('input[name="gp_time"]').val();
        const unit_id = $('input[name="unit_id"]').val();
        const name_id = $('input[name="name_id"]').val();
        const contact_no = $('input[name="contact_no"]').val();
        const date = $('input[name="date"]').val();
        let gp_type = $('input[name="gp_type"]');
        const formData = new FormData();
        formData.append('gp_date', gp_date);
        formData.append('gp_time', gp_time);
        formData.append('date', date);
        formData.append('unit_id', unit_id);
        formData.append('name_id', name_id);
        formData.append('contact_no', contact_no);
        formData.append('gp_type', selectedID);
        formData.append('module', "gatepass");
        formData.append('table', "gatepass");

        // console.log(gp_type)
        $.ajax({
            url: '<?= WEB_ROOT; ?>/gatepass-save.php',
            dataType: 'JSON',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                const res = JSON.parse(data)

                item_send_gatepass(tools_gatepass, res.id, "gatepass_items")
                item_send_gatepass(materials_gatepass, res.id, "gatepass_items")
                item_send_gatepass(personnel_gatepass, res.id, "gatepass_personnel")
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    };

    $('.btn-status').off('click').on('click', function() {
        $('#collapse-status').collapse('toggle');
    });
    $('#up1').hide();

    $('#collapse-status').on('hidden.bs.collapse', function() {
        $('#up1').hide();
        $('#down1').show();

    });

    $('#collapse-status').on('show.bs.collapse', function() {
        $('#up1').show();
        $('#down1').hide();
        $('.main input:not([readonly]):not([disabled]):not([name="contact_no"]), .main select:not([readonly]):not([disabled]), .main textarea ').each(function() {
            $(this).val('');
        });
        $('#switch1').prop('checked', false);
        $('#delivery').prop('checked', true);
        $('.gatepass').hide()
        personel = []
        materials = []
        tools = []
        personnel_gatepass = []
        materials_gatepass = []
        tools_gatepass = []
        $('.description-form').remove();

    });
    $(".close-btn").on('click', function() {
        $('#collapse-status').collapse('toggle');
    });

    $('.back-button-sr').on('click', function() {
        history.back();
    });
</script>