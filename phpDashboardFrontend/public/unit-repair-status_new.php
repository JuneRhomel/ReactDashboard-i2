<?php
require_once('header.php');
$location_menu = "billing";
?>
<div class="d-flex">



    <div class="main">
        <?php include("navigation.php") ?>
        <div  style="padding: 24px 25px 24px 25px">

        
        <div class="d-flex align-items-center px-3 my-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">
                Unit Repair Status</label>
        </div>
        <div style="background-color: #F0F2F5;">

            <div style="background-color: #F0F2F5;">
                <div class="card mb-3" style="width: 100%; ">
                    <div class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-status w-100" style="padding: 12px;">
                            <div><label class="m-0" style="font-weight: 400; color:#1C5196;">Request form</label></div>
                            <div><i id="down1" style="color:#1C5196" class="fa-solid fa-caret-down"></i><i id="up1" style="color:#1C5196" class="fa-solid fa-caret-down fa-rotate-180"></i></div>
                        </button>
                    </div>
                    <div id="collapse-status" class="collapse">
                        <form id="frm" name="frm" method="post" enctype="multipart/form-data" action="unitrepair-save.php" style="margin-top: 24px;">
                            <div class="card-body pt-1">
                                <div class="row forms">
                                    <div class="input-repare-status">
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" name="name" type="text" required>
                                            <label id="request-form">Requestor Name <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="input-repare-status">
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" name="contact_num" type="text" required>
                                            <label id="request-form">Contact # <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="input-repare-status">
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" name="email_add" type="text" required>
                                            <label id="request-form">Email Address <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="input-repare-status">
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" name="unit" type="text" required>
                                            <label id="request-form">Unit # <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="input-repare-status">
                                        <div class="select form-group">
                                            <select class="select-text" required>
                                                <option value="" selected></option>
                                                <option value="1">Priority 1</option>
                                                <option value="2">Priority 2</option>
                                                <option value="3">Priority 3</option>
                                            </select>
                                            <label class="select-label">Priority Level <span class="text-danger">*</span></label>
                                            <i class="fa-solid fa-sort-down"></i>
                                        </div>
                                    </div>
                                    <div class="input-repare-status">
                                        <div class="form-group">
                                            <textarea placeholder="text" id="request-form" name="unit" required></textarea>
                                            <label id="request-form" class="label-text-area">Description <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="input-repare-status input-box">
                                        <input type="file" id="file" name="upload_file" class="request-upload" multiple>
                                        <label for="file" class="file"><span class="material-icons">upload_file</span>Attachment File/Photo</label>
                                    </div>

                                    <div class=" w-100">
                                        <div class="grp-btn">
                                            <button type="submit" class="btn btn-dark btn-primary settings-save d-block px-5 w-100">Submit</button>
                                            <button type="button" class="close-btn btn btn-light btn-cancel settings-cancel d-block px-5 w-100">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="repair-status">
            <div class="repair-status-bar">
                <div class="status-container">
                    <button class="status-icon tab-button">
                        <img class="status-none" src="assets/icon/Property 1=acknowledge, Property 2=default.png" alt="">
                        <img src="assets/icon/Property 1=acknowledge, Property 2=active.png" alt="">
                    </button>
                    <p>Acknowledged</p>
                </div>

                <div class="status-container">
                    <button class="status-icon tab-button">
                        <img src="assets/icon/Property 1=Scheduled, Property 2=default.png" alt="">
                        <img class="status-none" src="assets/icon/Property 1=Scheduled, Property 2=active.png" alt="">
                    </button>
                    <p>Scheduled</p>
                </div>
                <div class="status-container">
                    <button class="status-icon  tab-button">
                        <img src="assets/icon/Property 1=progress, Property 2=default.png" alt="">
                        <img class="status-none" src="assets/icon/Property 1=progress, Property 2=active.png" alt="">
                    </button>
                    <p>Work in Progress</p>
                </div>
                <div class="status-container">
                    <button class="status-icon  tab-button">
                        <img src="assets/icon/Property 1=completed, Property 2=default.png" alt="">
                        <img class="status-none" src="assets/icon/Property 1=completed, Property 2=active.png" alt="">
                    </button>
                    <p>Completed</p>
                </div>
            </div>
        </div>
        <div class="update-repair-status">
            <div>
                <label style="font-weight: 400;font-size: 24px;">Concern Details</label>
            </div>
            <div class="concern-details">

                <div class="requests-card ">
                    <div class="">
                        <img src="assets/images/unit-repair-acknowledge.png">
                    </div>
                    <div class="">
                        <div>
                            <p class="status acknowledged-status">ACKNOWLEDGED</p>
                        </div>
                        <div>
                            <label class="label">Repair Request</label>
                        </div>
                        <div>
                            <label class="description ">Crack floor tile outside my unit.</label>
                        </div>
                        <div>
                            <button class="follow-up">
                                Follow up concern
                            </button>
                        </div>
                    </div>
                    <div class="date">
                        <label>Feb 9, 2023 </label>
                    </div>
                </div>
            </div>


            <div class="update-repair-status">
                <div>
                    <label style="font-weight: 400;font-size: 24px;">Updates</label>
                </div>
                <div class="repair-status-update-container">
                    <div class="update-card">
                        <div class="">
                            <label>Feb 10, 2023</label>
                            <label>18:25:23</label>
                            <p>When will repairman come?</p>
                        </div>
                        <span class="text-capitalize px-2 follow-up-concern-status">Follow up concern</span>
                    </div>

                    <div class="update-card">
                        <div class="">
                            <label>Feb 10, 2023</label>
                            <label>18:25:23</label>
                            <p>Acknowledged by building admin.</p>
                        </div>
                        <span class="text-capitalize px-2 acknowledged-status">Acknowledged</span>
                    </div>


                </div>
            </div>
        </div>

        <div class="modal follow-up-modal" tabindex="-1" role="dialog" id='follow-up'>
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content px-1 pt-2" style="border-radius: 10px;">
                    <div class="modal-header justify-content-end pb-0" style="border-bottom: 0px;">
                        <!-- <h5 class="modal-title">Upload Documents</h5> -->
                        <button type="button" class="btn-close btn-close-followup" style="position: absolute;top: 10px;z-index: 9;" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="modal-body pt-0 text-center" style="padding-bottom: 20px;">
                        <h3 class="modal-title align-center text-center mb-3" style="font-weight: 600">Follow Up</h3>
                        <textarea class=" form-control" placeholder="Message"></textarea>
                        <div class="">
                            <button class="submit px-5 py-2 w-100" id="registration-buttons">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id='follow-up-message'>
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content px-1 pt-2" style="border-radius: 10px;">
                    <div class="modal-header justify-content-end pb-0" style="border-bottom: 0px;">
                        <!-- <h5 class="modal-title">Upload Documents</h5> -->
                        <button type="button" class="btn-close btn-close-message" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="modal-body pt-0 text-center" style="padding-bottom: 20px;">
                        <h3 class="modal-title align-center text-center mb-3" style="font-weight: 600">Great!</h3>
                        <label>Your request has been created successfully!</label>
                        <div class="col-12 py-3">
                            <button class="ok px-5 py-2 w-100" id="registration-buttons">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>




    <?php include('menu.php') ?>
</div>
</body>

</html>
<script>
    $('.follow-up').on('click', function() {
        $('#follow-up').modal('show');
    });

    $('.btn-close-followup').on('click', function() {
        $('#follow-up').modal('hide');
    });

    $('.submit').on('click', function() {
        $('#follow-up').modal('hide');
        $('#follow-up-message').modal('show');
    });

    $('.btn-close-message').on('click', function() {
        $('#follow-up-message').modal('hide');
    });

    $('.ok').on('click', function() {
        $('#follow-up-message').modal('hide');
    });

    $('.back-button-sr').on('click', function() {
        history.back();
    });

    $('.btn-status').off('click').on('click', function() {
        $('#collapse-status').collapse('toggle');
    });
    $('#up1').hide();

    $('#collapse-status').on('hidden.bs.collapse', function() {
        $('#up1').hide();
        $('#down1').show();

    });
    $(".close-btn").on('click', function() {
        $('#collapse-status').collapse('toggle');
    });

    $('#collapse-status').on('show.bs.collapse', function() {
        $('#up1').show();
        $('#down1').hide();

    });
    $('.tab-button').click(function() {
        $('.tab-button').children(':nth-child(1)').css('display', 'block');
        $('.tab-button').children(':nth-child(2)').css('display', 'none');
        $(this).children(':nth-child(2)').css('display', 'block');
        $(this).children(':nth-child(1)').css('display', 'none');
    });
</script>