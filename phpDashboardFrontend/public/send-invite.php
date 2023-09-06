<?php
require_once("header.php");
include("footerheader.php");
$location_menu = "send-invite";
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
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Send Invite</label>
        </div>

        <div style="background-color: #F0F2F5;     padding: 11px 20px 104px 20px ">
            <div class="" style="max-width: 508px;">
                <div class="rounded-sm">
                    <form method="post" action="<?= WEB_ROOT; ?>/send-email.php" id="form-main">
                        <div class=" forms">


                            <div class="w-100 form-group">
                                <input id="request-form" name="email" required placeholder="text">
                                <label id="request-form">Email <span class="text-danger">*</span></label>
                            </div>

                            <div class="d-flex gap-3 justify-content-start">
                                <button type="submit" class="btn btn-dark btn-primary settings-save d-block px-5 py-2 w-100">Send</button>
                            </div>
                            <input name="module" type="hidden" value="<?= $module ?>">
                            <input name="table" type="hidden" value="<?= $table ?>">
                            <input name="from" type="hidden" value="<?= $user->id ?>">
                            <input name="unit_id" type="hidden" value="<?= $user->def_unit_id ?>">
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <?php include('menu.php') ?>
</div>
<script>
    $(document).ready(function() {
        $('.back-button-sr').on('click', function() {
            window.location.href = 'http://portali2.sandbox.inventiproptech.com/billing.php';
        })
        $("#form-main").off('submit').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    $('.main-btn').attr('disabled', 'disabled');
                },
                success: function(data) {
                    console.log(data)
                    popup({
                        data: data,
                        reload_time: 2000,
                        redirect: location.href
                    })
                },
            });
        });
    });
</script>