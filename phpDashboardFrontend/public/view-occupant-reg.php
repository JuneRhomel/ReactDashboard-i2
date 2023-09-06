<?php
require_once('header.php');
include("footerheader.php");
$location_menu = 'occupant_reg';


$id = decryptData($_GET['id']);

$result = apiSend('module', 'get-listnew', ['table' => 'vw_occupant_reg', 'condition' => 'id="' . $id . '"']);
$resident = json_decode($result);
// var_dump($resident);

// $result = apiSend('module', 'get-listnew', ['table' => 'photos', 'condition' => 'reference_id="' . $resident[0]->id . '" AND description = "profile-pic"']);
// $profile = json_decode($result);
?>

<div class="d-flex">


    <div class="main">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Back </label>
        </div>
        <div style="background-color: #F0F2F5;padding: 24px 25px 120px 25px;">
            <div style="padding: 24px; background-color: #FFFFFF; border-radius: 5px;">
                <div>
                    <div class="user-details mt-2">
                        <div class="">
                            <p>Full Name</p>
                            <label><?= $resident[0]->fullname ?> </label>
                        </div>
                        <div class="">
                            <p>Email Address</p>
                            <label><?= $resident[0]->email ?></label>
                        </div>
                        <div class="">
                            <p>Status</p>
                            <label><?= $resident[0]->status ?></label>
                        </div>
                        <div class="">
                            <p>Address</p>
                            <label><?= $resident[0]->address ?></label>
                        </div>

                        <div class="">
                            <p>Contact #</p>
                            <label><?= $resident[0]->contact_no ?></label>
                        </div>
                        <div class="">
                            <p>Unit </p>
                            <label><?= $resident[0]->unit_name ? $resident[0]->unit_name : "-" ?></label>
                        </div>



                        <!-- <div class="">
                            <a style="font-weight: 800;" href="change-password.php">Change Password</a>
                        </div> -->

                    </div>
                </div>
            </div>
            <?php if($resident[0]->status === 'Pending' ) {?>
            <div class="mt-3 d-flex flex-column gap-3">
                <button class="primary-btn  w-100"
                onclick="update_status('occupant_reg', '<?= $_GET['id'] ?>', 'status', 'Approved', '<?= WEB_ROOT ?>', '<?= $resident->email ?>')"
                >Approve</button>
                <button class="border-btn-primary w-100" type="button" 
                onclick="update_status('occupant_reg', '<?= $_GET['id']?>', 'status', 'Disapproved', '<?= WEB_ROOT ?>', '<?= $resident->email ?>')"
                >Disapprove</button>
            </div>
            <?php }  ?>

        </div>

    </div>
    <?php include('menu.php') ?>
    </body>

    </html>
    <script>
        $('.eye-show').hide()
        $('.eye-hide').show()
        $('.show-contact').hide()
        $("#form-main").off('submit').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(data) {
                    console.log(data)
                    if (data.success) {
                        $('.eye-hide').hide()
                        $('.eye-show').show()
                        $('.show-contact').show()
                        $('#master-pass').modal('hide')

                    } else {
                        $('.master').addClass("error-input ")
                        $('.error-text').text(data.description)
                    }
                },
            });
        });
        $('.eye-btn-show').click(function() {
            $('.eye-hide').show()
            $('.eye-show').hide()
            $('.show-contact').hide()
        })
        $('.eye-btn').click(function() {

            $('#master-pass').modal('show')
        })
        $('.btn-close').click(function() {
            $('#master-pass').modal('hide')
        })
        $('.edit-profile').on('click', function() {
            window.location.href = 'http://portali2.sandbox.inventiproptech.com/occupant-edit.php?id=<?= $_GET['id'] ?>';
        });

        $('.back-button-sr').on('click', function() {
            window.location.href = 'http://portali2.sandbox.inventiproptech.com/occupant-reg.php';
        });
        const label = $('.password');
        const originalText = label.text();
        const numAsterisks = originalText.length;
        const asteriskText = "*".repeat(numAsterisks);
        label.text(asteriskText);
    </script>