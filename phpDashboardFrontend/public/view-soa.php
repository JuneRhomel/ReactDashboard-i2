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
// vdumpx($record);

$result = apiSend('module', 'get-listnew', ['table' => 'soa_detail', 'condition' => 'soa_id=' . $id, 'orderby' => 'id asc']);
$soa_detail = json_decode($result);

$result =  apiSend('module', 'get-listnew', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $id . '" and not (particular like "%SOA Payment%" and status in ("Successful","Invalid"))', 'orderby' => 'id asc']);
$soa_payment = json_decode($result);


$total = 0;

foreach ($soa_payment as $item) {
    $total = $total +  $item->amount;
}
$total = $record->amount_due - $total;


?>
<div class="d-flex">
    <div class="main" style="margin-bottom: 82px;">

        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3 ">
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
                <div class="mb-4 view-details-billing">
                    <div class="d-flex justify-content-between p-2   ">
                        <label class="m-0 font-weight-bold  fs-5 ">Status</label>
                        <p class="m-0 font-weight-bold fs-5" style="color:<?= $record->status === "Paid" ? '#2ECC71' : '#C0392B' ?>;font-size: 17px;"><?= $record->status ?></p>
                    </div>

                    <!-- <div class="d-flex justify-content-between p-2   ">
                        <label class="m-0  ">Notes</label>
                        <p class="m-0 "><?= $record->notes ?></p>
                    </div> -->

                    <div class="d-flex justify-content-between p-2  ">
                        <label class="m-0 font-weight-bold">Descriptions</label>
                        <p class="m-0 font-weight-bold">Amount</p>
                    </div>
                    <?php
                    $total_soa_detail = 0;
                    foreach ($soa_detail as $item) {
                        if ($item->type === "Balance") continue;
                        $total_soa_detail += $item->amount
                    ?>
                        <div class="d-flex justify-content-between p-2 ">
                            <label class="m-0 pl-3"><?= $item->type ?></label>
                            <p class="m-0"><?= formatPrice($item->amount)   ?></p>
                        </div>
                    <?php } ?>
                    <div class="d-flex justify-content-between border rounded-1 p-2 my-3 bg-palette-gre bg-palette-grey">
                        <label class="m-0 font-weight-bold  fs-5">Sub Total</label>
                        <p class="m-0 font-weight-bold fs-5 "> <?= formatPrice($total_soa_detail) ?></p>
                    </div>
                    <div class="d-flex justify-content-between p-2  ">
                        <label class="m-0 pl-3">Outstanding Balance</label>
                        <?php
                        $Outstanding_balance = 0;
                        foreach ($soa_detail as $item) {
                            if ($item->type != "Balance") continue;
                            $Outstanding_balance += $item->amount;
                        }
                        ?>
                        <p class="m-0"><?= formatPrice($Outstanding_balance)  ?></p>
                    </div>
                    <div class="d-flex justify-content-between border rounded-1 p-2 my-3 bg-palette-gre bg-palette-grey">
                        <label class="m-0 font-weight-bold fs-5">Total</label>
                        <p class="m-0 font-weight-bold fs-5 "> <?= formatPrice($total_soa_detail + $record->balance) ?></p>
                    </div>
                    <?php if ($soa_payment) { ?>
                        <div class="d-flex mt-2 justify-content-between p-2 mt-3  ">
                            <label class="m-0 font-weight-bold  fs-5">Less</label>
                        </div>
                        <?php
                        $totalPaid = 0;
                        foreach ($soa_payment as $item) {
                            $current = $item->amount;
                            $totalPaid = $totalPaid + $current;
                        ?>
                            <div class="d-flex justify-content-between p-2  gap-5 ">
                                <label class="m-0 fs-8 pl-3"><?= $item->particular ?></label>
                                <p class="m-0"><?= formatPrice($item->amount)  ?></p>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>

                <div class="d-flex gap-3 justify-content-between mt-3">
                    <button onclick="soa_pdf('<?= $_GET['id'] ?>')" class="main-btn w-50">
                        SOA PDF
                    </button>
                        <?php if ($record->status !='Paid' && $record->posted == 0) { ?>
                            <button onclick="pay_now('<?= $_GET['id'] ?>')" class="red-btn pay-now w-50">
                                Pay now
                            </button>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php include('menu.php') ?>
</div>
<script>
    $('.cancel-btn').on('click', function() {
        window.location.href = "<?= WEB_ROOT ?>/billing.php"
    })
    $('.back-button-sr').on('click', function() {
        history.back();
    });
    const soa_pdf = (id) => {
        window.open(`<?= WEB_ROOT . "/genpdf.php?display=plain&id=" ?>${id}`, '_blank')
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