<?php
require_once("header.php");
include("footerheader.php");
$location_menu = "billing";
// $billings_result = apiSend('billing', 'getlist', []);
// $billings = json_decode($billings_result, true);


$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);
// vdump($user);

// var_dump($soa_detail);

$result =  apiSend('tenant', 'get-soabal', ['table' => 'soa', 'condition' => 'resident_id="' . $user->id . '"', "limit" => 1]);
$balance = json_decode($result);
// vdump($balance[0]->balance);


$result =  apiSend('tenant', 'get-list', ['table' => 'vw_soa', 'condition' => 'resident_id="' . $user->id . '"', 'limit' => 1]);
$soa = json_decode($result);

$result =  apiSend('tenant', 'get-list', ['table' => 'vw_soa', 'condition' => 'resident_id="' . $user->id . '" and status = "Paid" and id != "'.$soa[0]->id.'"', 'limit' => 3]);
$soaPaid = json_decode($result);

$result =  apiSend('tenant', 'get-list', ['table' => 'vw_soa', 'condition' => 'resident_id="' . $user->id . '" AND (status = "Unpaid" OR status = "Partially Paid") and id != "'.$soa[0]->id.'"', 'limit' => 3]);
$soaUnpaid = json_decode($result);

$result =  apiSend('tenant', 'get-list', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $balance[0]->id . '"']);
$soa_detail = json_decode($result);
// var_dump($soa_detail);

if ($soa_detail) {
    $totalbal = $balance[0]->amount_due;
    foreach ($soa_detail as $item) {
        $totalbal = $totalbal - $item->amount;
    }
} else {
    $totalbal = $balance[0]->amount_due;
}


$result =  apiSend('module', 'get-listnew', ['table' => 'photos', 'condition' => 'reference_table="soa" and reference_id= "' . $soa[0]->id . '"', 'orderby' => 'id asc']);
$proof = json_decode($result);

?>

<div class="d-flex">
    <div class="main">
        <?php include("navigation.php") ?>



        <div style="background-color: #F0F2F5;     padding: 11px 20px 104px 20px ">

            <label class="title-section">SOA </label>
            <?php if($soa) { ?>
            <div class="soa-bill">
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <b style="color:<?= $soa[0]->status === "Paid" ? '#2ECC71' : '#C0392B' ?>;font-size: 17px;"><?= $soa[0]->status ?></b>
                        <p><?= date("F", strtotime("2023-" . $soa[0]->month_of . "-01")) . " " . $soa[0]->year_of ?> </label>

                        <p>Due Date: <?= date_format(date_create($soa[0]->due_date), "M d, Y"); ?> </p>
                    </div>
                    <div class="text-end">
                        <label>Total Amount Due</label>
                        <h3 class="<?= $soa[0]->status === "Paid" ? 'text-decoration-line-through' : '' ?>"> <?= formatPrice($soa[0]->amount_due)  ?> </h3>
                    </div>
                </div>
                <div class="text-end m-2">
                    <a href="<?= WEB_ROOT ?>/view-soa.php?id=<?= $soa[0]->enc_id ?>">View Details</a>
                </div>
                <div class="d-flex gap-3 justify-content-between">
                    <button onclick="soa_pdf('<?= $soa[0]->id ?>')" class="main-btn w-50">
                        SOA PDF
                    </button>
                    <?php if ($proof) { ?>
                        <button onclick="view_proof('<?= $proof[0]->attachment_url ?>')" class="border-btn-primary w-50 payment ">
                            View Proof of Payment
                        </button>
                    <?php } else { ?>
                        <button onclick="payment('<?= $_GET['id'] ?>')" class="border-btn-primary w-50 payment ">
                            Proof of Payment
                        </button>
                    <?php } ?>
                    <?php if ($soa[0]->status != "Paid" && $soa[0]->status != "Partially Paid") { ?>
                        <button onclick="pay_now('<?= $soa[0]->enc_id ?>')" class="red-btn pay-now w-50">
                            Pay now
                        </button>
                    <?php } ?>
                </div>
            </div>

            <?php } ?>



            <div class="mt-3">

                <div class=" py-3 d-flex  justify-content-between align-items-center">
                    <div class="nav-billing d-flex gap-1">

                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input placeholder="text" type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                            <label id="btnSubmit" class="unpaid btn first-tab btn-tab-service btn-outline-primary" for="btnradio1">SOA Unpaid <span><?= count($soaUnpaid) ?></span></label>

                            <input placeholder="text" type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                            <label id="btnFinish" class=" billing btn btn-tab-service btn-outline-primary" for="btnradio3">SOA Paid<span><?= count($soaPaid) ?></span> </label>
                        </div>
                    </div>
                    <?php if ($soa) { ?><a class="see-all" href="soa-list.php">See all</a> <?php } ?>

                </div>


                <!-- unpaid -->
                <div class="unpaid-section ">

                    <div class=" d-flex flex-column gap-3">
                        <?php if ($soaUnpaid) { ?>

                            <?php
                            foreach ($soaUnpaid  as $key => $item) {

                            ?>
                                <div class="soa-bill">
                                    <div class="d-flex justify-content-between align-items-end">
                                        <div>
                                            <b style="color: #C0392B;font-size: 17px;"><?= $item->status ?></b>
                                            <p><?= date("F", strtotime("2023-$item->month_of-01")) . " " . $item->year_of ?> </label>
                                            <p>Due Date: <?= date_format(date_create($item->due_date), "M d, Y"); ?> </p>
                                        </div>
                                        <div class="text-end">
                                            <label>Total Amount Due</label>
                                            <h3> <?= formatPrice($item->amount_due)  ?> </h3>
                                        </div>
                                    </div>
                                    <div class="text-end m-2">
                                        <a href="<?= WEB_ROOT ?>/view-soa.php?id=<?= $item->enc_id ?>">View Details</a>
                                    </div>
                                    <div class="d-flex gap-3 justify-content-between">
                                        <!-- <button onclick="soa_pdf('<?= $item->id ?>')" class="main-btn w-50">
                                            SOA PDF
                                        </button>
                                        <button onclick="payment('<?= $item->enc_id ?>')" class="w-50 border-btn-primary payment ">
                                            Proof of Payment
                                        </button> -->
                                        <!-- <button onclick="pay_now('<?= $item->enc_id ?>')" class="red-btn pay-now">
                                            Pay now
                                        </button> -->
                                    </div>
                                </div>
                            <?php }; ?>

                        <?php } else {
                            echo " No Soa List";
                        } ?>

                    </div>
                </div>
                <!--soaPaid  -->
                <div class="billing-section ">
                    <div class=" d-flex flex-column gap-3">
                        <?php if ($soaPaid) { ?>

                            <?php
                            foreach ($soaPaid  as $item) {

                            ?>
                                <div class="soa-bill">
                                    <div class="d-flex justify-content-between align-items-end">
                                        <div>
                                            <b style="color: #2ECC71;font-size: 17px;"><?= $item->status ?></b>
                                            <p><?= date("F", strtotime("2023-$item->month_of-01")) . " " . $item->year_of ?> </label>
                                            <p>Due Date: <?= date_format(date_create($item->due_date), "M d, Y"); ?> </p>
                                        </div>
                                        <div class="text-end">
                                            <label>Total Amount Due</label>
                                            <h3 class="text-decoration-line-through"> <?= formatPrice($item->amount_due)  ?> </h3>
                                        </div>
                                    </div>
                                    <div class="text-end m-2">
                                        <a href="<?= WEB_ROOT ?>/view-soa.php?id=<?= $item->enc_id ?>">View Details</a>
                                    </div>
                                    <div class="d-flex gap-3 justify-content-between">
                                    </div>
                                </div>
                            <?php }; ?>

                        <?php } else {
                            echo " No Soa List";
                        } ?>
                    </div>
                </div>
            </div>

            <div>
                <div class="pt-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="title-section"> Payment Transactions </label>
                        <?php if ($soa_detail) { ?><a class="see-all" href="payment-list.php">See all</a><?php } ?>
                    </div>
                    <div>
                        <!-- <a href="#"style="font-weight: 600;color:#1c5196;" >Show all ></a> -->
                    </div>
                </div>
                <?php if ($soa_detail) { ?>
                    <div class="bills-container">
                        <?php
                        foreach ($soa_detail  as $item) {
                            // echo $item->amount_paid;
                        ?>
                            <div class="card-box payment">
                                <div class="card-container">
                                    <div>
                                        <div>
                                            <label class="history-date-billing mb-0" style="font-weight: 600; font-size: 13px;"><?= $item->particular ?></label>
                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class="billing-price text-decoration-line-through" style="color: #2ECC71;font-size: 17px;"> <?= formatPrice($item->amount)  ?></p>
                                </div>

                            </div>
                        <?php }; ?>
                    </div>
                <?php } else {
                    echo " No Payment Transactions";
                } ?>
            </div>

        </div>
    </div>
    <?php include('menu.php') ?>
</div>
<script>
    $('.back-button-sr').on('click', function() {
        history.back();
    });
    const soa_pdf = (id) => {
        window.open(`<?= WEB_ROOT . "/genpdf.php?display=plain&id=" ?>${id}`,'_blank' )
    }
    const payment = (id) => {
        window.location.href = `<?= WEB_ROOT ?>/proof-of-payment.php?id=${id}`;
    }
    const pay_now = (id) => {
        window.location.href = `<?= WEB_ROOT ?>/payment-method.php?id=${id}`;
    }
    const view_proof = (url) => {
        // Open the URL in a new tab
        window.open(url, '_blank');
    }

    $('.billing-section').hide();

    $('.unpaid').on('click', function() {
        $('.unpaid').addClass('active').removeAttr("style");;
        $('.unpaid').removeClass('inactive');
        $('.billing').removeClass('active');
        $('.billing').addClass('inactive').css("color", "gray");
        $('.unpaid-section').show();
        $('.billing-section').hide();
    });

    $('.billing').addClass('inactive').css("color", "gray");;

    $('.billing').on('click', function() {
        $('.billing').addClass('active').removeAttr("style");
        $('.billing').removeClass('inactive');
        $('.unpaid').removeClass('active');
        $('.unpaid').addClass('inactive').css("color", "gray");
        $('.unpaid-section').hide();
        $('.billing-section').show();
    })
</script>