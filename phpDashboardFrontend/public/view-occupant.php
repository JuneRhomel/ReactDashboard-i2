<?php
require_once('header.php');
include("footerheader.php");
$location_menu = 'occupant';


$id = decryptData($_GET['id']);
// echo $id;
$result = apiSend('module', 'get-listnew', ['table' => 'vw_resident', 'condition' => 'id="' . $id . '"']);
$resident = json_decode($result);
// var_dump($resident);

$result = apiSend('module', 'get-listnew', ['table' => 'photos', 'condition' => 'reference_id="' . $resident[0]->id . '" AND description = "profile-pic"']);
$profile = json_decode($result);

$result =  apiSend('tenant', 'get-allsr', ['condition' => 'name_id="' . $resident[0]->id . '"', 'limit' => '10']);
$allsr = json_decode($result);
// var_dump($allsr);

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
                            <p>Type</p>
                            <label><?= $resident[0]->type ?></label>
                        </div>
                        <div class="">
                            <p>Address</p>
                            <label><?= $resident[0]->address ?></label>
                        </div>
                        <?php if ($info[0]->property_type === 'Commercial') { ?>
                            <div class="">
                                <p>Company</p>
                                <label><?= $resident[0]->company_name ?></label>
                            </div>
                        <?php } ?>
                        <div class="">
                            <p>Contact #</p>
                            <label><?= $resident[0]->contact_no ?></label>
                        </div>

                        <div class="">
                            <p>Unit</p>
                            <label><?= $resident[0]->unit_name ?></label>
                        </div>

                        <!-- <div class="">
                            <a style="font-weight: 800;" href="change-password.php">Change Password</a>
                        </div> -->

                    </div>
                </div>

            </div>



            <div class="mt-4">
                <label class="title-section mb-3">Service Requests</label>
                <div class="my-requests">

                    <?php if ($allsr) { ?>
                        <?php foreach ($allsr as $sr) { ?>
                            <?php if ($sr->type === "Gate Pass") {
                                $result =  apiSend('tenant', 'get-list-sr', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result);


                                $result =  apiSend('tenant', 'get-list-sr', ['table' => "gatepass_personnel", 'condition' => 'gatepass_id="' .  $data[0]->id . '"']);
                                $personel = json_decode($result);

                            ?>
                                <div class="requests-card w-100">
                                    <?php if ($item->attachments) { ?>
                                        <div>
                                            <img src="<?= $data[0]->attachments ?>" style="border-radius: 5px;">
                                        </div>
                                    <?php } ?>
                                    <div>
                                        <div>
                                            <p class="status  m-0
                                    <?php if ($data[0]->status === "Approved") {
                                        echo "closed-status";
                                    } elseif ($data[0]->status === "Denied") {
                                        echo "open-status";
                                    } else {
                                        echo "open-status acknowledged-btn";
                                    } ?>"><?= $data[0]->status ?>
                                            </p>
                                        </div>
                                        <div class="">
                                            <label class=" label m-0"><b><?= $sr->type ?></b> </label><br>
                                            <label class="label m-0">Type: <b><?= $data[0]->type   ?></b> </label><br>
                                            <label class=" label m-0">Personel: <b><?= $personel[0]->personnel_name  ?></b> </label><br>
                                        </div>
                                    </div>
                                    <div class="date">
                                        <label><?= $data[0]->date_upload ?></label>
                                    </div>
                                </div>
                            <?php } elseif ($sr->type === "Report Issue") {
                                $result =  apiSend('tenant', 'get-list-sr', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result);
                                // var_dump($data);
                            ?>
                                <div class="requests-card w-100 ">

                                    <div>
                                        <div>
                                            <p class="status  m-0
                                        <?php if ($data[0]->status === "Open") {
                                            echo "closed-status";
                                        } elseif ($data[0]->status === "Closed") {
                                            echo "open-status";
                                        } else {
                                            echo "open-status acknowledged-btn";
                                        } ?>"><?= $data[0]->status ?></p>
                                        </div>
                                        <div class="">
                                            <label class="label m-0"> <b>Report Issue</b></label><br>
                                            <label class="label">Category: <b><?= $data[0]->issue_name ?></b> </label></br>
                                            <label class="">Issue : <b><?= $data[0]->description ?></b> </label>
                                        </div>
                                    </div>
                                    <div>
                                        <?php if ($data[0]->attachments) { ?>
                                            <img src="<?= $data[0]->attachments ?>" style="border-radius: 5px;">
                                        <?php } ?>
                                    </div>
                                    <div class="date">
                                        <label><?= $data[0]->date_upload ?></label>
                                    </div>
                                </div>



                            <?php } elseif ($sr->type === "Visitor Pass") {
                                $result =  apiSend('tenant', 'get-list-sr', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result);

                                $result =  apiSend('tenant', 'get-list-sr', ['table' => "vp_guest", 'condition' => 'guest_id="' .  $data[0]->id . '"']);
                                $vp_g = json_decode($result);
                                // vdump($vp_g);

                            ?>
                                <div class="requests-card w-100">
                                    <?php if ($data[0]->attachments) { ?>
                                        <div>
                                            <img src="<?= $data[0]->attachments ?>" style="border-radius: 5px;">
                                        </div>
                                    <?php } ?>
                                    <div class="w-100">
                                        <div>
                                            <p class="status  m-0
                                    <?php if ($data[0]->status === "Approved") {
                                        echo "closed-status ";
                                    } elseif ($data[0]->status === "Denied") {
                                        echo "open-status open-status";
                                    } else {
                                        echo "acknowledged-btn open-status";
                                    } ?> "><?= $data[0]->status ?></p>
                                        </div>
                                        <div class="w-100">
                                            <label class="label m-0"><b><?= $sr->type ?></b> </label><br>
                                            <label class="label m-0">Location : <b><?= $data[0]->location_name ?></b></label><br>
                                            <label class="label m-0 label-limit">Visitor Name: <b>
                                                    <?php
                                                    echo implode(", ", array_column($vp_g, 'guest_name'));
                                                    ?>
                                                </b></label>
                                        </div>
                                        <div>
                                            <label class="description">Date of Arrival: <?= $data[0]->arrival_date ?></label>
                                        </div>
                                    </div>
                                    <div class="date">
                                        <label><?= $data[0]->date_upload ?></label>
                                    </div>
                                </div>
                            <?php } elseif ($sr->type === "Work Permit") {
                                $result =  apiSend('tenant', 'get-list-sr', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '"']);
                                $data = json_decode($result);

                                $result =  apiSend('tenant', 'get-list-sr', ['table' => 'work_details', 'condition' => 'id="' .  $data[0]->work_details_id . '"']);
                                $work = json_decode($result);

                            ?>

                                <div class="requests-card w-100">
                                    <?php if ($data[0]->attachments) { ?>
                                        <div>
                                            <img src="<?= $data[0]->attachments ?>" style="border-radius: 5px;">
                                        </div>
                                    <?php } ?>
                                    <div>
                                        <div>
                                            <p class="status  m-0
                                    <?php if ($data[0]->status === "Open") {
                                        echo "closed-status";
                                    } elseif ($data[0]->status === "Closed") {
                                        echo "open-status";
                                    } else {
                                        echo " open-status acknowledged-btn";
                                    } ?>"><?= $data[0]->status ?></p>
                                        </div>
                                        <div class="">
                                            <label class="label m-0"><b>Work Permit</b></label><br>
                                            <label class="label m-0">Category: <b><?= $data[0]->category_name   ?></b> </label><br>
                                            <label class="label m-0">Name Contractor : <b><?= $work[0]->name_contractor ?></b> </label><br>
                                            <label class="label m-0">Scope of work : <b><?= $work[0]->scope_work ?></b> </label>
                                        </div>
                                    </div>
                                    <div class="date">
                                        <label><?= $data[0]->date_upload ?></label>
                                    </div>
                                </div>
                            <?php } ?>









                        <?php } ?>
                    <?php } else {
                        echo "No Service Requests";
                    } ?>
                </div>
            </div>

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
            window.location.href = '<?=WEB_ROOT ?>/occupant-edit.php?id=<?= $_GET['id'] ?>';
        });

        $('.back-button-sr').on('click', function() {
            window.location.href = '<?=WEB_ROOT ?>/occupant.php';
        });
        const label = $('.password');
        const originalText = label.text();
        const numAsterisks = originalText.length;
        const asteriskText = "*".repeat(numAsterisks);
        label.text(asteriskText);
    </script>