<?php
require_once("header.php");
include("footerheader.php");
$location_menu = "billing";
$module = "soa";
$table = "soa";
$view = "vw_soa";
$id = decryptData($_GET['id']);





$result = apiSend('module', 'get-record', ['id' => $id, 'view' => $view]);
$record = json_decode($result);
// var_dump($record->id);

$result =  apiSend('module', 'get-listnew', ['table' => 'soa_detail', 'condition' => 'soa_id="' . $id . '"', 'orderby' => 'id asc']);
$soa_detail = json_decode($result);

$result =  apiSend('module', 'get-listnew', ['table' => 'photos', 'condition' => 'reference_table="soa" and reference_id= "' . $record->id . '"', 'orderby' => 'id asc']);
$proof = json_decode($result);
// var_dump($proof[0]->attachment_url);

?>
<div class="d-flex">
    <div class="main" style="margin-bottom: 82px;">

        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Back</label>
        </div>
        <div style="padding: 24px 24px 24px 24px; background-color: #F0F2F5;">
            <h1 class="fs-2 font-weight-bolder m-0">
                Statement of Account <br>
            </h1>
            <label class="fs-6 font-weight-bold m-0" for="">

                for <?= date('F', mktime(0, 0, 0, $record->month_of, 1)) . " " . $record->year_of ?>

            </label>
            <div class="bg-white mt-4 p-2">
                <div class="mb-4">
                    <div class="d-flex justify-content-between p-2 mb-3  bg-palette-grey">
                        <label class="m-0 font-weight-bold  fs-5 ">Status</label>
                        <p class="m-0 font-weight-bold fs-5" style="color:<?= $record->status === "Paid" ? '#2ECC71' : '#C0392B' ?>;font-size: 17px;"><?= $record->status ?></p>
                    </div>
                    <div class="d-flex justify-content-between p-2">
                        <label class="m-0 font-weight-bold">Descriptions</label>

                    </div>
                    <div class="d-flex justify-content-between p-2">
                        <label class="m-0">Balance</label>
                        <p class="m-0"><?= formatPrice($record->balance)  ?></p>
                    </div>
                    <div class="d-flex justify-content-between p-2 bg-palette-grey">
                        <label class="m-0">Charge Amount</label>
                        <p class="m-0"><?= formatPrice($record->charge_amount)  ?></p>
                    </div>
                    <div class="d-flex justify-content-between p-2 ">
                        <label class="m-0">Electricity</label>
                        <p class="m-0"><?= formatPrice($record->electricity)  ?></p>
                    </div>
                    <div class="d-flex justify-content-between p-2  bg-palette-grey">
                        <label class="m-0  ">Water</label>
                        <p class="m-0 "><?= formatPrice($record->water)  ?></p>
                    </div>
                    <div class="d-flex justify-content-between p-2 ">
                        <label class="m-0">Current Charges</label>
                        <p class="m-0"><?= formatPrice($record->current_charges)   ?></p>
                    </div>
                    <div class="d-flex justify-content-between p-2 bg-palette-grey ">
                        <label class="m-0  ">Notes</label>
                        <p class="m-0 "><?= $record->notes ?></p>
                    </div>
                    <div class="d-flex justify-content-between p-2 mt-3  bg-palette-grey">
                        <label class="m-0 font-weight-bold  fs-5">Amount Due</label>
                        <p class="m-0 font-weight-bold fs-5 <?= $record->status === "Paid" ? 'text-decoration-line-through' : '' ?>"> <?= formatPrice($record->amount_due) ?></p>
                    </div>


                </div>
                <label class="title-section"> SOA Detail </label>
                <div class="p-3">
                    <?php
                    if (!$soa_detail) {
                        echo "<div class='p-3 bg-white'>No record found.</div>";
                    } else {
                    ?>
                        <div class="row ">
                            <label class="col-6 fs-8 py-2  m-0 font-weight-bold">Descriptions</label>
                            <p class="col-2 fs-8 py-2 justify-content-center m-0 d-flex align-items-center m-0 font-weight-bold">Balance</p>
                            <p class="col-2 fs-8 py-2 justify-content-center m-0 d-flex align-items-center m-0 font-weight-bold">Amount</p>
                            <p class="col-2 fs-8 py-2 justify-content-center m-0 d-flex align-items-center m-0 font-weight-bold">Status</p>
                        </div>
                        <?php foreach ($soa_detail as $val) { ?>
                            <div class="row soa-detail ">
                                <label class="col-6  fs-8 d-flex align-items-center py-2 m-0"><?= $val->particular ?></label>
                                <p class="col-2 fs-8  justify-content-center m-0 d-flex align-items-center py-2"><?= formatPrice($val->amount) ?></p>
                                <p class="col-2 fs-8 justify-content-center m-0 d-flex align-items-center  py-2"><?= formatPrice($val->amount_bal, 0) ?></p>
                                <p class="col-2 fs-8 justify-content-center m-0 d-flex align-items-center text-end py-2"><?= ($val->amount_bal > 0) ? 'Unpaid' : 'Paid' ?> <?= $record->status === "For Verification" ? " ($record->status)" : "" ?></p>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

            </div>
            <div class="d-flex gap-3 justify-content-between mt-3">
                <button onclick="soa_pdf('<?= $record->id ?>')" class="main-btn w-50">
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


                <?php if ($record->due_date >= date('Y-m-d')) { ?>
                    <?php if ($record->status != "Paid" && $record->status  != "Partially Paid" && $record->status  != "For Verification") { ?>
                        <button onclick="pay_now('<?= $_GET['id'] ?>')" class="red-btn pay-now w-50">
                            Pay now
                        </button>
                    <?php } ?>
                <?php } ?>


            </div>
        </div>
    </div>
    <?php include('menu.php') ?>
</div>
<script>
    $('.cancel-btn').on('click', function() {
        window.location.href = "http://portali2.sandbox.inventiproptech.com/billing.php"
    })
    $('.back-button-sr').on('click', function() {
        history.back();
    });
    const soa_pdf = (id) => {
        window.open(`<?= WEB_ROOT . "/genpdf.php?display=plain&id=" ?>${id}`, '_blank')
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


    $("#form-main").off('submit').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            beforeSend: function() {
                $('.btn').attr('disabled', 'disabled');
            },
            success: function(data) {
                popup({
                    data: data,
                    reload_time: 2000,
                    redirect: location.href
                })
            },
        });
    });

    $('#master-card').on('click', function() {
        $('.gcash').addClass('d-none');
        $('.gcash').removeClass('d-flex gap-2 flex-wrap');
        $('.master-card').addClass('d-flex gap-2 flex-column align-items-center justify-content-center');
        $('.master-card').removeClass('d-none');
    });

    $('#gcash').on('click', function() {
        $('.gcash').removeClass('d-none');
        $('.gcash').addClass('d-flex gap-2 flex-wrap');
        $('.master-card').addClass('d-none');
        $('.master-card').removeClass('d-flex gap-2 flex-wrap');
    });
</script>