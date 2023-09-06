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


$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_soa', 'condition' => 'resident_id="' . $user->id . '"']);
$soa = json_decode($result);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $balance[0]->id . '"', 'limit' => 3]);
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


?>

<div class="d-flex">
    <div class="main">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; " fdprocessedid="0g0hon"><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">SOA</label>
        </div>

        <div style="background-color: #F0F2F5;     padding: 11px 20px 104px 20px ">
            <div>

                <div class="d-flex flex-column gap-3">
                    <?php if ($soa) { ?>
                        <?php
                        foreach ($soa  as $item) {
                            // echo;
                        ?>
                            <div class="soa-bill">
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <b style="color:<?= $item->status === "Paid" ? '#2ECC71' : '#C0392B' ?>;font-size: 17px;"><?= $item->status ?></b>
                                        <p><?= date("F", strtotime("2023-" . $item->month_of . "-01")) . " " . $item->year_of ?> </label>

                                        <p>Due Date: <?= date_format(date_create($item->due_date), "M d, Y"); ?> </p>
                                    </div>
                                    <div class="text-end">
                                        <label>Total Amount Due</label>
                                        <h3 class="<?= $item->status === "Paid" ? 'text-decoration-line-through' : '' ?>">₱ <?= $item->amount_due ?> </h3>
                                    </div>
                                </div>
                                <div class="text-end m-2">
                                    <a href="">View Details</a>
                                </div>
                                <div class="d-flex gap-3 justify-content-between">
                                    <button onclick="soa_pdf('<?= $item->id ?>')" class="main-btn w-50">
                                        SOA PDF
                                    </button>
                                    <button onclick="payment('<?= $item->enc_id ?>')" class="border-btn-primary w-50 payment ">
                                        Proof of Payment
                                    </button>

                                </div>
                            </div>

                        <?php }; ?>
                    <?php } else {
                        echo " No Payment Transactions";
                    } ?>
                </div>
            </div>


        </div>
        <!-- }  -->
    </div>
    <?php include('menu.php') ?>
</div>
<script>
    $('.back-button-sr').on('click', function() {
        window.location.href = 'http://portali2.sandbox.inventiproptech.com/billing.php';
    })
</script>