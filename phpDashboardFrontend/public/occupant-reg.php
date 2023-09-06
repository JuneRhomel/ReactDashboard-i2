<?php
require_once("header.php");
include("footerheader.php");
$location_menu = "occupant-reg";
// $billings_result = apiSend('billing', 'getlist', []);
// $billings = json_decode($billings_result, true);


$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);
// vdump($user);


// var_dump($soa_detail);

$result = apiSend('tenant', 'get-listnew', ['table' => 'vw_occupant_reg', 'condition' => 'status="Pending" and created_by= ' . $user->id . '']);
$occupant_reg = json_decode($result);

// var_dump(decryptData($occupant_reg[0]->enc_id) );
// var_dump($occupant_reg[0]->id);


?>

<div class="d-flex">
    <div class="main">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; " fdprocessedid="0g0hon"><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Back </label>
        </div>
        <div style="background-color: #F0F2F5;     padding: 11px 20px 104px 20px ">
            <?php if ($occupant_reg) { ?>
                <label class="title-section my-4">Tenant Registration </label>
                <div class="row gap-2">
                    <?php foreach ($occupant_reg as $item) { ?>
                        <div onclick="view('<?= $item->enc_id ?>',event)" class="col-12">
                            <div class="occupant">
                                <div class="d-flex gap-2">
                                    <img src="./assets/icon/profile.png" alt="">
                                    <div class=" ">
                                        <h1><?= $item->fullname ?></h1>
                                        <p><?= $item->unit_name ?></p>
                                    </div>
                                </div>
                                <div class="d-flex w-100 gap-3">
                                    <button onclick="update_status('occupant_reg', '<?= $item->enc_id ?>', 'status', 'Approved', '<?= WEB_ROOT ?>', '<?= $item->email ?>')">Approve</button>
                                    <button onclick="update_status('occupant_reg', '<?= $item->enc_id ?>', 'status', 'Disapproved', '<?= WEB_ROOT ?>', '<?= $item->email ?>')">Disapprove</button>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <div>
                <label class="title-section my-4">Occupant Registration List</label>
                <div class="row table-data gap-2">
                </div>
                <!-- <div class="row gap-2">
                    <div class="col-12">
                        <div class="occupant">
                            <div class="d-flex gap-2">
                                <img src="./assets/icon/profile.png" alt="">
                                <div class="d-flex flex-column  gap-2 ">
                                    <b class="red">Disapproved</b>
                                    <h1>Arkin Paroan</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="occupant">
                            <div class="d-flex gap-2">
                                <img src="./assets/icon/profile.png" alt="">
                                <div class="d-flex flex-column  gap-2 ">
                                    <b class="green">Approved</b>
                                    <h1>Arkin Paroan</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>

    </div>
    <?php include('menu.php') ?>
</div>
<script>

    const view = (id, event) => {
    // Check if the clicked element is a button
    if (event.target.tagName != 'BUTTON') {
         window.location.href = `http://portali2.sandbox.inventiproptech.com/view-occupant-reg.php?id=${id}`;
    }
};
    table_data({
        url: 'get-occupant-reg.php',
        table: 'vw_occupant_reg',
        unitowner: <?= $user->id ?>,
        view: 'view-occupant-reg.php',
    })
    $('.back-button-sr').on('click', function() {
        window.location.href = 'http://portali2.sandbox.inventiproptech.com';
    });
</script>