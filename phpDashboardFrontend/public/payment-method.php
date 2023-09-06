<?php
require_once("header.php");
include("footerheader.php");
$location_menu = "billing";
$module = "soa";
$table = "soa_detail";

$id = decryptData($_GET['id']);



$result =  apiSend('module', 'get-listnew', ['table' => 'soa_detail', 'condition' => '(amount_bal>0) and soa_id="' . $id . '"', 'orderby' => 'id asc']);
$soa_detail = json_decode($result);

$result =  apiSend('tenant', 'get-list', ['table' => 'vw_soa', 'condition' => 'id="' . $id . '"', 'limit' => 3]);
$soa = json_decode($result);


?>
<div class="d-flex">
    <div class="main" style="margin-bottom: 82px;">
        <?php include("navigation.php") ?>
        <div style="padding: 24px 25px 24px 25px; background-color: #F0F2F5;">
            <div>
                <label class="title-section">Summary</label>
                <div class="soa-bill">
                    <div class="d-flex justify-content-between align-items-end">
                        <div>
                            <b style="color: #C0392B;font-size: 17px;"><?= $soa[0]->status ?></b>
                            <p><?= date("F", strtotime("2023-" . $soa[0]->month_of . "-01")) . " " . $soa[0]->year_of ?> </label>

                            <p>Due Date: <?= date_format(date_create($soa[0]->due_date), "M d, Y"); ?> </p>
                        </div>
                        <div class="text-end">
                            <label>Total Amount Due</label>
                            <h3> <?= formatPrice($soa[0]->amount_due)  ?> </h3>
                        </div>
                    </div>
                    <div class="text-end m-2">
                        <a href="">View Details</a>
                    </div>
                    <div class="d-flex gap-3 justify-content-between">
                        <button onclick="soa_pdf('<?= $soa[0]->id ?>')" class="main-btn w-50">
                            SOA PDF
                        </button>
                        <button onclick="payment('<?= $soa[0]->enc_id ?>')" class="border-btn-primary w-50 payment ">
                            Proof of Payment
                        </button>
                    </div>
                </div>


                <form action="<?= WEB_ROOT; ?>/save.php" id="form-main">
                    <input name="id" type="hidden" value="<?= $id ?? ''; ?>">
                    <input name="module" type="hidden" value="<?= $module ?>">
                    <input name="table" type="hidden" value="<?= $table ?>">
                    <input name="payment_type" type="hidden" value="Bank transfer">
                    <div class="payment-container mt-4">

                        <!-- <div class="align-items-center justify-content-center d-flex gap-5" style="margin-buttom: 21px;">
                        <div class="d-flex align-items-center gap-1 active">
                            <input  type="radio" id="master-card"  name="payment-method" >
                            <label class="m-0" for="master-card"><image src="assets/images/master-card-icon.png"></image></label>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <input type="radio" id="cashtransfer" name="payment-method">
                            <label class="m-0" for="cashtransfer"><image src="assets/images/gcash-icon.png"></image></label>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <input type="radio" id="gcash" name="payment-method">
                            <label class="m-0" for="gcash"><image src="assets/images/gcash-icon.png"></image></label>
                        </div>
                    </div>

                    <div class="input-container master-card d-none" style="padding: 0;">
                        <div class="input-method  ">
                            <input placeholder="text" id="request-form" name="name" type="text" required>
                            <label placeholder="text" id="request-form">Account Name</label>
                        </div>
                        <div class="input-method  ">
                            <input placeholder="text" id="request-form" name="number" type="text" required>
                            <label placeholder="text" id="request-form">Account Number</label>
                        </div>
                        <div class="d-flex">
                            <div class="input-method pr-1">
                                <input  placeholder="text" id="request-form" name="month" type="text" required>
                                <label id="request-form">Month</label>
                            </div>
                            <div class="input-method pl-1">
                                <input placeholder="text" id="request-form" name="year" type="text" required>
                                <label id="request-form">Year</label>
                            </div>
                        </div>
                        <div class="input-method pr-1">
                            <input placeholder="text" id="request-form" name="CVV" type="text" required>
                            <label id="request-form">CVV</label>
                        </div>
                    </div>
                    <div class="input-container gcash d-none" style="padding: 0;">
                        <div class="input-method  ">
                            <input placeholder="text" id="request-form" name="name" type="text" required>
                            <label id="request-form">Account Name</label>
                        </div>
                        <div class="input-method  ">
                            <input placeholder="text" id="request-form" name="number" type="text" required>
                            <label id="request-form">Account Number</label>
                        </div>
                    </div> -->

                        <div class="input-container ">
                            <div class="">
                                <label class="title-section mb-4">Payment </label>
                            </div>
                            <!-- <div class=" d-flex flex-column gap-2">
                                <div class="input-method  ">
                                    <input placeholder="text" id="request-form" name="name" type="text" required>
                                    <label placeholder="text" id="request-form">Check No.</label>
                                </div>
                                <div class="input-method  ">
                                    <input placeholder="text" id="request-form" name="number" type="date" required>
                                    <label placeholder="text" id="request-form">Check Date</label>
                                </div>
                                <div class="input-method  ">
                                    <input placeholder="text" id="request-form" name="number" type="number" required>
                                    <label placeholder="text" id="request-form">Check Amount</label>
                                </div>

                            </div> -->
                            <div class="d-flex flex-column mt-3 gap-2">
                                <label class="title-section">Unpaid Charge(s) </label>

                                <?php
                                $ct = 1;
                                $total = 0;
                                foreach ($soa_detail as $val) {
                                    if ($ct % 3 == 0) {
                                        echo '<div class=""></div>';
                                        $ct++;
                                    }
                                ?>
                                    <div class="">
                                        <div class="input-method">
                                            <input  class="w-100" id="request-form" name="amount[<?= $val->id ?>]" type="hidden" value="<?= $val->amount ?>">
                                            <input  class="w-100" id="request-form" name="payment[<?= $val->id ?>]" placeholder="<?= $val->amount ?>" type="number" max="<?= $val->amount ?>" value="<?= $val->amount ?>">
                                            <label id="request-form"><?= $val->particular ?></label>
                                        </div>
                                    </div>
                                <?php
                                    $total += $val->amount;
                                    $ct++;
                                } // FOREACH
                                ?>
                                <div class="">
                                <label class="title-section">Total Amount: <?= formatPrice($total) ?></label>
                                </div>
                            </div>

                        </div>

                        <div class="input-method  btn-container  pb-3">
                            <button class="submit " id="registration-buttons" type="submit">Submit</button>
                            <button type="button" class=" cancel-btn">Cancel</button>
                        </div>
                    </div>
                </form>
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
        window.location.href = `<?= WEB_ROOT . "/genpdf.php?display=plain&id=" ?>${id}`;
    }
    const payment = (id) => {
        window.location.href = `<?= WEB_ROOT ?>/proof-of-payment.php?id=${id}`;
    }
    const pay_now = (id) => {
        window.location.href = `<?= WEB_ROOT ?>/payment-method.php?id=${id}`;
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
                        redirect: '<?=WEB_ROOT ?>/proof-of-payment.php?id=<?=$_GET['id'] ?>'
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