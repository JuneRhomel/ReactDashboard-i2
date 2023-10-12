<?php
require_once("header.php");
include("footerheader.php");
$location_menu = "occupant";
// $billings_result = apiSend('billing', 'getlist', []);
// $billings = json_decode($billings_result, true);


$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);
// vdump($user);


// var_dump($soa_detail);






?>

<div class="d-flex">
    <div class="main">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; " fdprocessedid="0g0hon"><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Back</label>
        </div>
        <div style="background-color: #F0F2F5;     padding: 11px 20px 104px 20px ">
            <label style="font-weight: 400;font-size: 24px; margin:24px 0">Tenant List</label>
            <div class="row table-data gap-2">
            </div>
        </div>
    </div>

    <?php include('menu.php') ?>
</div>
</div>
<script>

    // Pagination Logic
    table_data( {
        url: 'get-occupant.php',
        table: 'vw_resident',
        unitowner: <?=$user->id ?>,
        view: 'view-occupant.php'
    }
    )

    $('.back-button-sr').on('click', function() {
        window.location.href = '<?=WEB_ROOT ?>';
    });
</script>