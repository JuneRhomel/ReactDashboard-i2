<?php
require_once("header.php");
include("footerheader.php");
$location_menu = "billing";
$module = "soa";
$table = "soa_detail";

$view = "vw_soa";
$id = decryptData($_GET['id']);
// vdumpx($id);

$result = apiSend('module', 'get-record', ['id' => $id, 'view' => $view]);
$soa = json_decode($result);

// vdump($soa);

$result = apiSend('module', 'get-listnew', ['table' => 'soa_detail', 'condition' => 'soa_id=' . $id, 'orderby' => 'id asc']);
$soa_detail = json_decode($result);


$result =  apiSend('module', 'get-listnew', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $soa->id . '" and status= "Successful" ', 'orderby' => 'id asc']);
$soa_payment = json_decode($result);
// var_dump($soa_payment);

$result =  apiSend('module', 'get-listnew', ['table' => 'soa_payment', 'condition' => 'soa_id="' .$soa->id . '" and not (particular like "%SOA Payment%" and status in("Successful","Invalid"))', 'orderby' => 'id asc']);
$balance = json_decode($result);
$total = 0;
foreach ($balance as $item) {
    $total = $total + $item->amount;
}

$total =  $soa->amount_due - $total;
$total = number_format($total, 2);

// vdump($total);
?>
<div class="d-flex">
    <div class="main" style="margin-bottom: 82px;">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Back</label>
        </div>
        <div style="padding: 24px 25px 24px 25px; background-color: #F0F2F5;">


            <div>

                <h1 class="fs-2 font-weight-bolder m-0">
                    Total Outstanding Balance <br>
                </h1>
                <label class="fs-6 font-weight-bold m-0" for="">
                    for <?= date('F', mktime(0, 0, 0, $soa->month_of, 1)) . " " . $soa->year_of ?>
                </label>

                <label class="title-section mt-4 mb-2">Summary</label>
                <div class="bg-white  p-2 rounded-2">
                    <div class="mb-4 view-details-billing ">
                        <div class="d-flex justify-content-between align-items-center p-1  ">
                            <label class="m-0 fs-6 font-weight-bold">Descriptions</label>
                            <p class="m-0 fs-6 font-weight-bold">Amount</p>
                        </div>
                        <?php 
                        $total_soa_detail = 0;
                        foreach ($soa_detail as $item) { 
                            if($item->type ==="Balance") continue;
                            $total_soa_detail += $item->amount
                            ?>
                            <div class="d-flex justify-content-between align-items-center p-1    ">
                            <label class="m-0 fs-6 pl-3"><?= $item->type ?></label>
                            <p class="m-0 fs-6"><?= formatPrice($item->amount)   ?></p>
                            </div>
                        <?php } ?>
                        <div class="d-flex justify-content-between align-items-center rounded-1 p-1 my-1 bg-palette-gre bg-palette-grey">
                            <label class="m-0 fs-6 font-weight-bold  fs-5">Sub Total</label>
                            <p class="m-0 fs-6 font-weight-bold fs-5 "> <?= formatPrice($total_soa_detail) ?></p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-1  ">
                            <label class="m-0 fs-6 pl-3">Outstanding Balance</label>
                            <p class="m-0 fs-6"><?= formatPrice($soa->balance)  ?></p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-1 mt-3 bg-indicator ">
                            <label class="m-0 fs-6 font-weight-bold  fs-5">Total</label>
                            <p class="m-0 fs-6 font-weight-bold fs-5 "> <?= formatPrice($total_soa_detail + $soa->balance) ?></p>
                        </div>
                        <?php if ($balance) { ?>
                            <div class="d-flex mt-2 justify-content-between p-1 mt-2  ">
                                <label class="m-0 fs-6 font-weight-bold  fs-5">Less</label>
                            </div>
                            <?php
                            foreach ($balance as $item) {
                            ?>
                                <div class="d-flex justify-content-between align-items-center p-2  gap-5 ">
                                    <label class="m-0 fs-8 pl-3"><?= $item->particular ?></label>
                                    <p class="m-0"><?= formatPrice($item->amount)  ?></p>
                                </div>
                            <?php } ?>
                           
                        <?php } ?>
                    </div>

                    <button onclick="soa_pdf('<?= $_GET['id'] ?>')" class="main-btn w-50">
                        SOA PDF
                    </button>
                </div>




                <div class="payment-container px-3 py-4 mt-4">
                    <div class="">
                        <label class="title-section mb-4">Choose your payment method</label>
                    </div>
                    <div class="align-items-center  d-flex gap-2" style="margin-buttom: 21px;">
                        <div class="d-flex align-items-center w-100 gap-1 active">
                            <input type="radio" class=" payment-select" value="Bank Transfer/ Over the counter" id="bank-transfer" name="payment-method">
                            <label class="m-0 w-100 font-weight-bolder" for="bank-transfer">
                                Bank Transfer/ Over the counter
                            </label>
                        </div>
                        <!-- <div class="d-flex align-items-center w-100 gap-1">
                            <input type="radio" class="payment-select" id="over-the-counter" value="Over the counter" name="payment-method">
                            <label class="m-0 w-100 font-weight-bolder " for="over-the-counter">
                                Over the counter
                            </label>
                        </div> -->
                    </div>

                    <form action="<?= WEB_ROOT; ?>/save.php" id="form-main">
                        <input name="soa_id" type="hidden" value="<?= $id ?? ''; ?>">
                        <input name="module" type="hidden" value="soa_payment">
                        <input name="table" type="hidden" value="soa_payment">
                        <input name="payment_type" id="payment_type" type="hidden" value="Bank Transfer/ Over the counter">
                        <input name="status" id="status" type="hidden" value="For Verification">
                        <input name="particular" id="particular" type="hidden" value="SOA Payment - <?= date('F j, Y') ?>">
                        <!-- <div class="payment-description"> -->
                        <!-- <h1 class="my-4 fs-6 font-weight-bold">NOTE: <span class="text-danger note-message"></span> </h1> -->
                        <!-- </div> -->
                        <div class="charge py-3">


                            <div class="d-flex flex-column gap-2">
                                <div class="w-100 form-group">
                                    <input class="paymnet-input" type="number" required max="<?= (float)str_replace(',', '',  $total) ?>" value="<?= (float)str_replace(',', '',  $total) ?>" id="request-form" name="amount" step="0.01" placeholder="text">
                                    <label id="request-form">Amount </label>
                                </div>
                                <div>
                                    <p><b class="fw-bold">NOTE: </b>Please upload a clear picture of the proof of payment.</p>
                                    <label class="fw-bold" for="">Proof of Payment</label>
                                    <p class="required font-italic text-danger mb-0" for=""></p>
                                </div>
                                <div class="input-repare-status input-box w-100">
                                    <input type="file" id="file" name="attachments" class="request-upload" multiple>
                                    <label for="file" class="file file-name"><span class="material-icons">upload_file</span>Attachment File/Photo</label>

                                </div>
                            </div>


                            <div class="input-method  btn-container mt-3  pb-3">
                                <button class="submit red-btn pay-now w-100 py-3" type="submit">Pay Now</button>
                            </div>
                        </div>
                    </form>
                </div>



            </div>

        </div>
    </div>
    <?php include('menu.php') ?>
</div>
<script>
    $(document).on('change', '.paymnet-input', function() {
        var maxAttributeValue = $(this).attr('max');
        if ($(this).val() === "") {
            $(this).val(0);
        } else if (parseFloat($(this).val()) > parseFloat(maxAttributeValue)) {
            $(this).val(maxAttributeValue);
        }
    });
    $(".paymnet-input").each(function() {
        var maxAttributeValue = $(this).attr('max');
        if (maxAttributeValue) {
            $(this).val(maxAttributeValue);
        }
    });

    $('.paymnet-input').change(function() {
        if ($(this).val() === "") {
            $(this).val(00)
        }
    })
    $('.cancel-btn').on('click', function() {
        window.location.href = "<?= WEB_ROOT ?>/billing.php"
    })
    $('.back-button-sr').on('click', function() {
        history.back();
    });
    const soa_pdf = (id) => {
        window.open(`<?= WEB_ROOT . "/genpdf.php?display=plain&id=" ?>${id}`, '_blank');
    }
    const payment = (id) => {
        window.location.href = `<?= WEB_ROOT ?>/proof-of-payment.php?id=${id}`;
    }
    const pay_now = (id) => {
        window.location.href = `<?= WEB_ROOT ?>/payment-method.php?id=${id}`;
    }

    function sendFormData(formData) {
        $.ajax({
            url: "<?= WEB_ROOT; ?>/save.php",
            type: 'POST',
            dataType: 'JSON',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.btn').attr('disabled', 'disabled');
            },
            success: function(data) {
                popup({
                    data: data,
                    reload_time: 2000,
                    redirect: "<?= WEB_ROOT ?>/billing.php"
                });
            },
        });
    }

    $("#form-main").off('submit').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData($(this)[0]);
        const logo = ($('#file')[0].files[0]);

        if (logo) {
            const maxSize = 2 * 1024 * 1024;
            compressImage(logo, maxSize, function(compressedBlob) {
                const compressedFile = new File([compressedBlob], logo.name, {
                    type: logo.type
                });
                formData.set('attachments', compressedFile);

                // Convert 'amount' to a number without commas
                const amount = formData.get('amount');
                formData.set('amount', parseFloat(amount.replace(/,/g, '')));

                sendFormData(formData);
            });
        } else {
            $('.required').text("Please upload your proof of payment")
        }
    });



    $('.payment-description').hide()
    $('.charge').hide()

    $('.payment-select').change(function() {
        $('.payment-description').show()
        // if ($(this).val() === 'Over the counter') {
        // $('.note-message').text("Please upload your receipt after you've paid your charges at the counter.")
        // } else if ($(this).val() === 'Bank transfer') {
        // $('.note-message').text("Please upload your proof of payment once you've paid your charges.")
        // }
        $('.charge').show()
        $('#payment_type').val($(this).val());
    })
</script>