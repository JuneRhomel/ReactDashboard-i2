<?php
require_once('header.php');
include("footerheader.php");
$location_menu = 'profile';
$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);
// var_dump($user);

$result = apiSend('module', 'get-listnew', ['table' => 'photos', 'condition' => 'reference_id="' . $user->id . '" AND description = "profile-pic"']);
$profile = json_decode($result);

$result = apiSend('module', 'get-listnew', ['table' => 'system_info']);
$info = json_decode($result);


$result = apiSend('module', 'get-listnew', ['table' => 'vw_contract', 'condition' => 'resident_id="' . $user->id . '"']);
$contract = json_decode($result);
?>

<div class="d-flex">


    <div class="main">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">My Profile</label>
        </div>
        <div style="background-color: #F0F2F5;padding: 24px 25px 120px 25px;">
            <div style="padding: 24px; background-color: #FFFFFF; border-radius: 5px;">
                <div>
                    <div class="d-flex align-items-end gap-2 pl-0">
                        <div class="d-flex profile-box align-items-end gap-2 pl-0">

                            <img src="<?= $profile ? $profile[0]->attachment_url : './assets/images/profilepic.jpg'  ?>">
                        </div>
                        <div class="pb-2">
                            <button class="edit-profile">Edit</button>
                        </div>
                    </div>
                    <div class="user-details">
                        <div class="">
                            <p>Full Name</p>
                            <label><?= $user->fullname ?> </label>
                        </div>
                        <div class="">
                            <p>Email Address</p>
                            <label><?= $user->email ?></label>
                        </div>

                        <div class="">
                            <p>Contact #</p>
                            <label><?= $user->contact_no ?></label>
                        </div>
                        <div class="">
                            <p>Company</p>
                            <label><?= $user->company_name ?></label>
                        </div>

                        <div class="">
                            <p>Unit</p>
                            <label><?= $user->default_unit ?></label>
                        </div>


                        <div class="">
                            <p>Password</p>
                            <label class="password">One Neo</label>
                        </div>
                        <div class="">
                            <a style="font-weight: 800;" href="change-password.php">Change Password</a>
                        </div>
                        <?php if ($info[0]->property_type === 'Commercial') { ?>
                        <div class="">
                            <a style="font-weight: 800;" href="change-master-pass.php">Change Master Password</a>
                        </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <?php if($info[0]->ownership === 'SO') { ?>
            <div class="d-flex  justify-content-between">
                <label class="my-3 lease-text" for="">Lease History</label>
                <button class="eye-hide border-0 bg-transparent eye-btn">
                    <i class=" fa-regular fa-eye-slash"></i>
                </button>
                <button class="eye-show eye-btn-show bg-transparent border-0">
                    <i class="eye-show fa-solid fa-eye"></i>
                </button>
            </div>
            <div class="show-contact ">

                <div class="d-flex flex-column  gap-2 pb-5">
                    <?php foreach ($contract as $item) { ?>
                        <div class=" lease-history">
                            <div>
                                <p>Lease Start: <span><?= $item->start_date ?></span></p>
                            </div>
                            <div>
                                <p>Lease End: <span><?= $item->end_date ?></span></p>
                            </div>
                            <div>
                                <p>Monthly Rate <span>₱ <?= $item->monthly_rate ?></span></p>
                            </div>
                            <div>
                                <p>Contract: <a href='<?= WEB_ROOT ?>/contract-genpdf.php?display=plain&id=<?= $item->id ?>' target="_blank">View</a></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
             <?php } ?>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="master-pass">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content px-1 pt-2" style="border-radius: 10px;">
                <div class="modal-header justify-content-end pb-0" style="border-bottom: 0px;">
                    <!-- <h5 class="modal-title">Upload Documents</h5> -->
                    <button type="button" class="btn-close btn-close-verification" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <form id="form-main" action="master_pass.php" method="POST" class="modal-body pt-0 text-center" style="padding-bottom: 20px;">
                    <h3 class="modal-title align-center text-center" style="font-size: 15px; font-weight: 600;margin-bottom: 29px;">The information is safeguarded. Kindly input your master password.</h3>
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <div class="form-group">
                        <input class="master" id="request-form" name="master_password" type="password" placeholder="text">
                        <label id="request-form">Master password</label>
                    </div>
                    <p class="error-text m-0" style="text-align: start; font-size:12px; color:red;"></p>
                    <div class="col-12 py-3">
                        <button type="submit" class="confirm-email succsess px-5 py-2 w-100" style="height: 50px;" id="registration-buttons">Submit</button>
                    </div>
            </div>
        </div>
    </div>
    <?php include('menu.php') ?>
</div>

</div>
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
        window.location.href = '<?=WEB_ROOT ?>/my-profile-edit_new.php';
    });

    $('.back-button-sr').on('click', function() {
        window.location.href = '<?=WEB_ROOT ?>';
    });
    const label = $('.password');
    const originalText = label.text();
    const numAsterisks = originalText.length;
    const asteriskText = "*".repeat(numAsterisks);
    label.text(asteriskText);
</script>