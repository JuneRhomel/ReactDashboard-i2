<?php
require_once("header.php");
include("footerheader.php");
$location_menu = "billing";

$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);

$result =  apiSend('tenant', 'get-list', ['table' => 'vw_soa', 'condition' => 'resident_id="' . $user->id . '"']);
$soa = json_decode($result);

?>

<div class="d-flex">
    <div class="main">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; " ><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Payment Transactions</label>
        </div>
        <div style="background-color: #F0F2F5;     padding: 11px 20px 104px 20px ">
            <div>
                <?php if ($soa) {

                ?>

                    <div class="bills-container">
                        <?php
                        foreach ($soa  as $details) {
                            $result =  apiSend('tenant', 'get-list', ['table' => 'soa_payment', 'condition' => 'soa_id="' .$details->id . '" and not (particular like "%SOA Payment%" and status = "Successful") and particular not like "Balance%"']);
                            $soa_detail = json_decode($result);
                            foreach ($soa_detail as $item) {
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
                        <?php };
                        }; ?>
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
        window.location.href = '<?= WEB_ROOT ?>/billing.php';
    })
</script>