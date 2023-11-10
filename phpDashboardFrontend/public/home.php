<?php
include("footerheader.php");
fHeader();
require_once("header.php");
$location_menu = "dashboard";
$result = apiSend('module', 'get-list', ['table' => 'system_info']);
$info = json_decode($result)[0];

$result = apiSend('tenant', 'get-user', ['view' => 'users']);
$user = json_decode($result);

$currentTime12HourFormat = date('h:i A');
$currentDate = date('Y-m-d');

$result = apiSend('tenant', 'get-list', [
    'table' => 'vw_visitor_pass',
    'condition' => 'name_id="' . $user->id . '" AND status = "Approved" AND arrival_date = "' . $currentDate . '"',
    'limit' => '1'
]);
$vp = json_decode($result);

$result =  apiSend('tenant', 'get-allsr', ['condition' => 'name_id="' . $user->id . '"', 'limit' => '3']);
$allsr = json_decode($result);


$result = apiSend('tenant', 'get-list', ['table' => 'news', 'condition' => 'status="Published"']);
$news = json_decode($result);

$result =  apiSend('tenant', 'get-list', ['table' => 'vw_soa', 'condition' => 'resident_id="' . $user->id . '"', 'limit' => '1']);
$soa = json_decode($result);

$result =  apiSend('tenant', 'get-list', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $soa[0]->id . '"  and not (particular like "%SOA Payment%" and status = "Successful") and particular not like "Balance%"', 'limit' => 4]);
$trans = json_decode($result);

$result =  apiSend('module', 'get-list', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $soa[0]->id . '"', 'orderby' => 'transaction_date DESC', 'limit' => 3]);
$soa_detail = json_decode($result);


$result =  apiSend('module', 'get-listnew', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $soa[0]->id . '" and not (particular like "%SOA Payment%" and status in("Successful","Invalid"))', 'orderby' => 'id asc']);
$balance = json_decode($result);

$total = 0;

foreach ($balance as $item) {
    $total = $total +  $item->amount;
}
$total = $soa[0]->amount_due - $total;

$name = $info->property_type == "Commercial" ? $user->company_name : $user->first_name;
$banner =  $info->banner ? $info->banner : 'assets/images/banner.png'
?>
<main>
    <!-- header -->
    <div class="d-flex">

        <div class="main">
            <?php include("navigation.php") ?>
            <div class="body py-4 mt-1" style="padding: 0 25px; background-color: #F0F2F5;">

                <!-- Banner -->
                <div class="banner">
                    <h1>
                        WELCOME <br>
                        <span>
                            <?= $name ?>,
                        </span>
                    </h1>
                    <p><?= $info->banner ? $info->banner : $info->banner ?></p>
                    <img src="<?= $banner ?>" alt="">

                </div>
                <?php if ($visitor) { ?>
                    <div class="visitor mt-3">
                        <p class="visitor-today pt-3 mb-0" style="color: #000000; font-size: 20px;">You have visitor today <span></span></p>
                        <div class="d-flex justify-content-end w-100" style="margin-bottom: 9px;">
                            <button type="button" class="btn-close btn-close-visitor" style="color: #1c5196;">
                        </div>

                        <div class="card-box">
                            <div class="card-container">
                                <div>
                                    <img src="assets/images/visitors-icon.png" alt="">
                                </div>
                                <div>
                                    <div>
                                        <label class="mb-0" style="font-weight: 600; font-size: 22px;"><?= $visitor[0]->guest_name ?></label>
                                    </div>
                                    <div>
                                        <p class="mb-0" style="color: black; font-size: 16px;">Arrival Time: <?= $vp[0]->arrival_time ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($soa) { ?>
                    <label class="title-section mt-4"> SOA </label>
                    <div class="soa-bill">
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <b style="color:<?= $soa[0]->status === "Paid" ? '#2ECC71' : '#C0392B' ?>;font-size: 17px;"><?= $soa[0]->status ?></b>
                                <p><?= date("F", strtotime("2023-" . $soa[0]->month_of . "-01")) . " " . $soa[0]->year_of ?> </label>

                                <p>Due Date: <?= date_format(date_create($soa[0]->due_date), "M d, Y"); ?> </p>
                            </div>
                            <div class="text-end">
                                <label>Total Amount Due</label>
                                <h3 class=""> <?= formatPrice($total) ?> </h3>
                            </div>
                        </div>
                        <div class="text-end m-2">
                            <a href="<?= WEB_ROOT ?>/view-soa.php?id=<?= $soa[0]->enc_id ?>">View Details</a>
                        </div>

                        <div class="d-flex gap-3 justify-content-between">
                            <button onclick="soa_pdf('<?= $soa[0]->enc_id ?>')" class="main-btn w-50">
                                SOA PDF
                            </button>
                            <?php if ($total > 0) { ?>
                                <button onclick="pay_now_('<?= $soa[0]->enc_id ?>')" class="red-btn pay-now w-50">
                                    Pay now
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <!-- recent bills payment -->
                <?php if ($trans) { 
?>
                    <div>
                        <div class="pt-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="title-section"> Payment Transactions </label>
                                <a class="see-all" href="payment-list.php">See all</a>
                            </div>
                            <div>
                                <!-- <a href="#"style="font-weight: 600;color:#1c5196;" >Show all ></a> -->
                            </div>
                        </div>
                        <?php if ($soa) { ?>
                            <div class="bills-container">
                                <?php
                                foreach ($soa  as $details) {
                                    $result =  apiSend('tenant', 'get-list', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $details->id . '"  and not (particular like "%SOA Payment%" and status = "Successful") and particular not like "Balance%"', 'limit' => 4]);
                                    $payment = json_decode($result);
                                    foreach ($payment as $item) {
                                        
                                ?>
                                        <div class="card-box payment">
                                            <div class="card-container">
                                                <div class="<?= $item->status === "Invalid" ? "box-red" : ($item->status === "Successful" ? "box-green" : "box-neutral") ?>  ">
                                                    <?= $item->status  ?>
                                                </div>
                                                <div>
                                                    <label class="history-date-billing mb-0" style="font-weight: 600; font-size: 13px;"><?= $item->particular ?></label>
                                                </div>
                                                <div>
                                                    <label class="date"><?= date("F j, Y g:i A", strtotime($item->transaction_date)) ?></label>
                                                    <p class="payemnt"><?= $item->payment_type ?></p>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="billing-price <?= $item->status === "Invalid" ? "invalid" : ($item->status === "Successful" ? "successful" : "neutral") ?>   "> <?= formatPrice($item->amount)  ?></p>
                                            </div>
                                        </div>
                                <?php }
                                }; ?>
                            </div>
                        <?php } else {
                            echo " No Payment Transactions";
                        } ?>
                    </div>
                <?php } ?>
                <?php if ($allsr) : ?>
                    <label class="title-section mt-5">Recent Requests</label>
                <?php endif ?>
                <div>
                    <div class="requests-scroll">
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
                                        <div class="w-100 ">
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0 fs-6"><?= $sr->type ?></label><br>
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
                                                <?php if ($comment) : ?>
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
                                                <?php else : ?>

                                                    <div class="comment mt-auto">
                                                        <div>
                                                            <span class="text-comment">No Updates</span>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="text-end mt-2">
                                                    <a href="myrequests-view.php?id=<?= $data->enc_id ?>&loc=<?= $sr->table ?>">View all</a>
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
                                            <div class="w-100 ">
                                                <div class="row">
                                                    <label class="fw-bold col-6 label m-0 fs-6"><?= $sr->type ?></label><br>
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
                                                <?php if ($comment) : ?>
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
                                                <?php else : ?>

                                                    <div class="comment">
                                                        <div>
                                                            <span class="text-comment">No Updates</span>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="text-end mt-2">
                                                    <a href="myrequests-view.php?id=<?= $data->enc_id ?>&loc=<?= $sr->table ?>">View all</a>
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
                                        <div class="w-100">
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0 fs-6"><?= $sr->type ?></label><br>
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

                                                <?php if ($comment) : ?>

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
                                                <?php else : ?>

                                                    <div class="comment">
                                                        <div>
                                                            <span class="text-comment">No Updates</span>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="text-end mt-2">
                                                    <a href="myrequests-view.php?id=<?= $data->enc_id ?>&loc=<?= $sr->table ?>">View all</a>
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
                                                        } ?>"><?= $data->status ?></p>
                                                </div>
                                                <div class="date">
                                                    <label><?= $data->date_upload ?></label>
                                                </div>
                                            </div>



                                            <div class="w-100 ">
                                                <div class="row">
                                                    <label class="fw-bold col-6 label m-0 fs-6"><?= $sr->type ?></label><br>
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
                                                    <?php if ($comment) : ?>
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
                                                    <?php else : ?>

                                                        <div class="comment">
                                                            <div>
                                                                <span class="text-comment">No Updates</span>
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
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <label class="title-section mt-4">Service Requests</label>
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

                <div class="pb-5">
                    <label class="title-section mt-5">News And Announcements</label>
                    <?php if ($news) { ?>
                        <div class="news-scroll">
                            <?php foreach ($news as $item) { ?>
                                <div class="col-6 col-sm-3 px-0 m-0" style="background-color: #FFFFFF; border-radius: 10px;">
                                    <a href="<?= WEB_ROOT ?>/news-view.php?id=<?= $item->enc_id ?>" style="color: black;">
                                        <div style="height: 77px;">
                                            <image class="w-100 h-100 object-fit" src="<?= $item->thumbnail ?>" style="border-radius: 10px;"></image>
                                        </div>
                                        <div class="px-1 pt-3">
                                            <div class="d-flex flex-wrap">
                                                <label class="col-12 px-0 my-0" style="font-weight: 600;font-size: 11px;"><?= $item->title ?></label>
                                                <label><?= date("F j, Y", strtotime($item->date)) ?></label>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="d-flex justify-content-center align-items-center" style="height: 104px">No News Announcement</div>
                    <?php }    ?>
                </div>
            </div>
        </div>
        <?php include('menu.php') ?>
    </div>
</main>
<script>
    const soa_pdf = (id) => {
        window.open(`<?= WEB_ROOT . "/genpdf.php?display=plain&id=" ?>${id}`, '_blank')
    }
    const payment_ = (id) => {
        window.location.href = `<?= WEB_ROOT ?>/proof-of-payment.php?id=${id}`;
    }
    const pay_now_ = (id) => {
        window.location.href = `<?= WEB_ROOT ?>/payment-method.php?id=${id}`;
    }

    $('.btn-close-visitor').on('click', function() {
        $('.visitor').hide();
    });
</script>