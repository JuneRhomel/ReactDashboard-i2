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

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $balance[0]->id . '"',]);
$soa_detail = json_decode($result);





?>

<div class="d-flex">
    <div class="main">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; " fdprocessedid="0g0hon"><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Payment Transactions</label>
        </div>
        <div style="background-color: #F0F2F5;     padding: 11px 20px 104px 20px ">
            <div>

                <?php if ($soa_detail) { ?>
                    <div class="bills-container">
                        <?php foreach ($soa as $soa_item) {
                            $result =  apiSend('tenant', 'get-list-sr', ['table' => 'soa_payment', 'condition' => 'soa_id="' . $soa_item->id . '"',]);
                            $soa_detail = json_decode($result);

                        ?>
                            <?php foreach ($soa_detail as $item) { ?>
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
                                        <p class="billing-price text-decoration-line-through" style="color: #2ECC71;font-size: 17px;">₱ <?= $item->amount ?></p>
                                    </div>

                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } else {
                    echo " No Payment Transactions";
                } ?>
            </div>

        </div>
    </div>
    <!-- }  -->
    <?php include('menu.php') ?>
</div>
<script>
       $('.back-button-sr').on('click', function() {
        window.location.href = 'http://portali2.sandbox.inventiproptech.com/billing.php';
    })
</script>