<?php
require_once('header.php');
include("footerheader.php");
?>
<div class="d-flex">



    <div class="main">
        <?php include("navigation.php") ?>

        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Move In Form</label>
        </div>
        <div style="background-color: #F0F2F5; padding: 20px 24px;">
            <div class="d-flex justify-content-center pt-3" style="background-color: #F0F2F5;">
                <div class="card mb-3" style="width: 100%">
                    <div class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-status w-100" style="padding: 12px;">
                            <div><label class="m-0" style="font-weight: 400; color:#1C5196;">Request form</label></div>
                            <div><i id="down1" style="color:#1C5196" class="fa-solid fa-caret-down"></i><i id="up1" style="color:#1C5196" class="fa-solid fa-caret-down fa-rotate-180"></i></div>
                        </button>
                    </div>
                    <div id="collapse-status" class="collapse">
                        <form id="frm" name="frm" method="post" enctype="multipart/form-data" action="movein-save.php">
                            <div class="card-body">
                                <div class="forms">
                                    <div>
                                        <label class="info-form"><i class="fa-solid fa-circle-info"></i><a href="#">Move in Checklist</a></label>
                                        <div class="form-group">
                                            <input type="text" required id="request-form" onblur="(this.type='text')" onfocus="(this.type='time')" name="date" placeholder="text">
                                            <label for="" id="request-form" class="text-required">Date of Move in<span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group">
                                            <input id="request-form" name="name" type="text" required placeholder="text">
                                            <label id="request-form">Requestor Name <span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-group select">
                                            <select class="select-text" required>
                                                <option value="" selected></option>
                                                <option value="1">Owner</option>
                                                <option value="2">Tenant</option>
                                            </select>
                                            <label class="select-label">Residential Type <span class="text-danger">*</span></label>
                                            <i class="fa-solid fa-sort-down"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <input id="request-form" name="unit" type="text" required placeholder="text">
                                            <label id="request-form">Unit # <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <input id="request-form" name="contact" type="text" required placeholder="text">
                                            <label id="request-form">Contact Number <span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <div class="terms-condition-text d-flex align-items-center gap-2">
                                        <input type="checkbox"> Gate pass for moving in Items <span class="text-danger">*</span>
                                    </div>

                                    <label style="font-weight: 400; font-size: 24px;  margin:27px 0;">List of Workers/Personnel</label>

                                    <div class="table-data" id="add-ons">

                                    </div>

                                    <div class="input-items">
                                        <div>
                                            <div class="form-group">
                                                <input id="request-form" type="text" name="workers_name[]" placeholder="text">
                                                <label id="request-form">Name<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-group">
                                                <input id="request-form" type="text" name="workers_desc[]" placeholder="text">
                                                <label id="request-form">Contact #<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="btn-add-item" class="btn-add-item"> + Add Personnel</button>
                                        </div>
                                    </div>

                                    <label style="font-weight: 400; font-size: 24px;  margin:27px 0;">List of Materials</label>

                                    <div class="table-data2" id="add-ons">
                                    </div>


                                    <div class="input-items">
                                        <div>
                                            <div class="form-group">
                                                <input id="request-form" type="text" name="material_qty[]" placeholder="text">
                                                <label id="request-form">Quantity</label>
                                            </div>
                                            <div class="form-group">
                                                <input id="request-form" type="text" name="material_desc[]" placeholder="text">
                                                <label id="request-form">Description</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="btn-add-item2" class="btn-add-item"> + Add Materials</button>
                                        </div>
                                    </div>

                                    <label style="font-weight: 400; font-size: 24px;  margin:27px 0;">List of Tools</label>


                                    <div class="table-data3" id="add-ons">
                                    </div>

                                    <div class="input-items">
                                        <div>
                                            <div class="form-group">
                                                <input id="request-form" type="text" name="tools_qty[]" placeholder="text">
                                                <label id="request-form">Quantity</label>
                                            </div>
                                            <div class="form-group">
                                                <input id="request-form" type="text" name="tools_desc[]" placeholder="text">
                                                <label id="request-form">Description</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="btn-add-item3" class="btn-add-item"> + Add Tools</button>
                                        </div>
                                    </div>

                                    <div class="terms-condition-text d-flex  gap-2 pt-3">
                                        <input type="checkbox"> I agree to the <a href="#">Terms and Condition</a>
                                    </div>

                                    <div class=" w-100" style="margin-bottom: 34px;">
                                        <div class="grp-btn">
                                            <div class="btn-settings">
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
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                    <label id="btnSubmit" class="btn first-tab btn-tab-service btn-outline-primary" for="btnradio1">Submitted <span>3</span></label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                    <label id="btnAcknowledged" class="btn btn-tab-service btn-outline-primary" for="btnradio2">Acknowledged </label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
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


    $('#btn-add-item').on('click', function(e) {
        e.preventDefault();
        const workersName = $('input[name="workers_name[]"]').val()
        const workersDesc = $('input[name="workers_desc[]"]').val()
        $('.table-data').append(`
            <div class="description-form">
                    <div class="description-label">
                        <p>Name</p>
                        <p>Contact #</p>
                    </div>
                    <div class="description-value">
                        <p>${workersName}</p>
                        <p>${workersDesc}</p>
                     </div>
            </div>
            `);
    });

    $('#btn-add-item2').on('click', function(e) {
        e.preventDefault();
        const materialQty = $('input[name="material_qty[]"]').val()
        const materialDesc = $('input[name="material_desc[]"]').val()
        $('.table-data2').append(`
            <div class="description-form">
                    <div class="description-label">
                        <p>Quantity</p>
                        <p>Description</p>
                    </div>
                    <div class="description-value">
                        <p>${materialQty}</p>
                        <p>${materialDesc}</p>
                     </div>
            </div>
            `);
    });

    $('#btn-add-item3').on('click', function(e) {
        e.preventDefault();
        const toolsQty = $('input[name="tools_qty[]"]').val()
        const toolsDesc = $('input[name="tools_desc[]"]').val()

        $('.table-data3').append(`
            <div class="description-form">
                    <div class="description-label">
                        <p>Quantity</p>
                        <p>Description</p>
                    </div>
                    <div class="description-value">
                        <p>${toolsQty}</p>
                        <p>${toolsDesc}</p>
                     </div>
            </div>
            `);
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