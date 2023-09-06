<?php
require_once('header.php');
include("footerheader.php");
?>
<div class="d-flex">
    <div class="main">
        <?php include("navigation.php") ?>
        <div style="background-color: #F0F2F5;padding: 20px 24px;">
            <div class="d-flex justify-content-center pt-3" style="background-color: #F0F2F5;">
                <div class="card mb-3" style="width: 100%">
                    <div class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-status w-100" style="padding: 12px;">
                            <div><label class="m-0" style="font-weight: 400; color:#1C5196;">Request form</label></div>
                            <div><i id="down1" style="color:#1C5196" class="fa-solid fa-caret-down"></i><i id="up1" style="color:#1C5196" class="fa-solid fa-caret-down fa-rotate-180"></i></div>
                        </button>
                    </div>
                    <div id="collapse-status" class="collapse">
                        <form id="frm" name="frm" method="post" enctype="multipart/form-data" action="reservation-save.php">
                            <div class="card-body" style="margin-top:16px">
                                <div class="forms">
                                    <div>
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" name="amenity" type="text" required>
                                            <label id="request-form">Amenity <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" type="text" name="date" required onblur="(this.type='text')" onfocus="(this.type='date')">
                                            <label id="request-form" for="" class="text-required">Date <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" type="text" name="text" required onblur="(this.type='text')" onfocus="(this.type='time')">
                                            <label id="request-form" for="" class="text-required">Time <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" name="name" type="text" required>
                                            <label id="request-form">Requestor Name <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="select form-group">
                                            <select class="select-text" required>
                                                <option value="" disabled selected></option>
                                                <option value="1">Owner</option>
                                                <option value="2">Tenant</option>
                                            </select>
                                            <label class="select-label">Resident Type <span class="text-danger">*</span></label>
                                            <i class="fa-solid fa-sort-down"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" name="unit" type="text" required>
                                            <label id="request-form">Unit <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" name="contact" type="text" required>
                                            <label id="request-form">Contact # <span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <div>
                                        <label style="font-weight: 400; font-size: 24px;  margin:27px 0;">Reservation Details</label>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" name="purpose" type="text" required>
                                            <label id="request-form">Purpose of Reservation <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <input placeholder="text" id="request-form" name="guest" type="text" required>
                                            <label id="request-form">Number of Guest <span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <div class="terms-condition-text d-flex  gap-2 pt-3">
                                        <input placeholder="text" type="checkbox">I agree to the <a href="#">Terms and Condition</a>
                                    </div>

                                    <div class="w-100" style="margin-bottom: 34px;">
                                        <div class="grp-btn">
                                            <div class="btn-settings ">
                                                <button type="submit" class="btn btn-dark btn-primary settings-save d-block px-5 w-100">Submit</button>
                                            </div>
                                            <div class="btn-settings">
                                                <button type="button" class="close-btn btn btn-light btn-cancel settings-cancel d-block px-5 w-100">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="tab-service">
                <label for="">History</label>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input placeholder="text" type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                    <label id="btnSubmit" class="btn first-tab btn-tab-service btn-outline-primary" for="btnradio1">Submitted <span>3</span></label>

                    <input placeholder="text" type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                    <label id="btnAcknowledged" class="btn btn-tab-service btn-outline-primary" for="btnradio2">Acknowledged </label>

                    <input placeholder="text" type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                    <label id="btnFinish" class="btn btn-tab-service btn-outline-primary" for="btnradio3">Finished Work </label>
                </div>
            </div>

            <div>
                <div class="history-container submitted">
                    <div class="card-history">
                        <div class="head">
                            <span>#1</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                    <div class="card-history">
                        <div class="head">
                            <span>#12</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Broken door knob</p>
                    </div>
                    <div class="card-history">
                        <div class="head">
                            <span>#13</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                    <div class="card-history">
                        <div class="head">
                            <span>#14</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                </div>
                <div class="history-container acknowledged">
                    <div class="card-history">
                        <div class="head">
                            <span>#2</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                    <div class="card-history">
                        <div class="head">
                            <span>#12</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Broken door knob</p>
                    </div>
                    <div class="card-history">
                        <div class="head">
                            <span>#13</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                    <div class="card-history">
                        <div class="head">
                            <span>#14</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                </div>
                <div class="history-container finishedwork">
                    <div class="card-history">
                        <div class="head">
                            <span>#3</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                    <div class="card-history">
                        <div class="head">
                            <span>#12</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Broken door knob</p>
                    </div>
                    <div class="card-history">
                        <div class="head">
                            <span>#13</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                    <div class="card-history">
                        <div class="head">
                            <span>#14</span>
                            <label>Feb 9, 2022</label>
                        </div>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                </div>
            </div>
            <div class="py-4">
                <label style="font-size: 24px;" for="">Disapproved Requests</label>
                <div class="mt-4 d-flex flex-column justify-content-center align-items-center">
                    <label style="color:#B4B4B4;font-size: 16px;">No disapproved requests</label>
                </div>
            </div>
        </div>

    </div>
    <?php include('menu.php') ?>
</div>
    </body>

    </html>
    <script>
        $('.acknowledged').hide();
        $('.finishedwork').hide();
        $("#btnSubmit").on('click', function() {
            $('.submitted').show();
            $('.acknowledged').hide();
            $('.finishedwork').hide();
        })
        $("#btnAcknowledged").on('click', function() {
            $('.submitted').hide();
            $('.acknowledged').show();
            $('.finishedwork').hide();
        })
        $("#btnFinish").on('click', function() {
            $('.submitted').hide();
            $('.acknowledged').hide();
            $('.finishedwork').show();
        })
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
    </script>