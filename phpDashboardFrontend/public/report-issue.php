<?php
require_once('header.php');
include("footerheader.php");

$module = "reportissue";
$table = "report_issue";
$view = "vw_report_issue";

$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);


$result =   apiSend('tenant', 'get-list-sr', ['table' => 'list_issuecategory',  'orderby' => 'issue_name']);
$issue_name = json_decode($result);


// vdump($user);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_report_issue', 'condition' => 'created_by="' . $user->id . '" AND status = "Open"']);
$open = json_decode($result);
$opentotal = count($open);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_report_issue', 'condition' => 'created_by="' . $user->id . '" AND status = "Ongoing"']);
$ongoing = json_decode($result);
$ongoingdtotal = count($ongoing);


$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_report_issue', 'condition' => 'created_by="' . $user->id . '" AND status = "Closed"']);
$closed = json_decode($result);
$closedtotal = count($closed);
?>

<div class="d-flex">

    <div class="main">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Report Issue</label>
        </div>
        <div style="background-color: #F0F2F5; padding: 20px 24px 106px 24px;">

            <div style="background-color: #F0F2F5;">
                <div class="card mb-3" style="width: 100%; ">
                    <div class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-status w-100" style="padding: 12px;">
                            <div><label class="m-0" style="font-weight: 400; color:#1C5196;">Request form</label></div>
                            <div><i id="down1" style="color:#1C5196" class="fa-solid fa-caret-down"></i><i id="up1" style="color:#1C5196" class="fa-solid fa-caret-down fa-rotate-180"></i></div>
                        </button>
                    </div>
                    <div id="collapse-status" class="collapse">
                        <form id='form-main' method="post" action="<?=WEB_ROOT?>/report-issue-save.php" style="margin-top: 24px;">
                            <div class="card-body">
                                <div class="row forms">                                    
                                    <input name="module" type="hidden" value="<?=$module ?>">
                                    <input name="table" type="hidden" value="<?=$table ?>">
                                    <input name="name_id" type="hidden" value="<?=$user->id ?>">
                                    <input name="unit_id" type="hidden" value="<?=$user->def_unit_id ?>">
                                    <input name="date" type="hidden" value="<?=date('Y-m-d H:i:s') ?> ">
                                    <input name="status_id" type="hidden" value="1">
                                    <input name="created_by" type="hidden" value="<?=$user->unit_id ?>">                                    

                                    <div class="w-100">
                                        <div class="w-100 form-group">
                                            <select name="issue_id" class="w-100" id="request-form" required>
                                                <option selected disabled></option>
                                                <?php foreach ($issue_name as $key => $val) {; ?>
                                                    <option value="<?=$val->id ?>"><?=$val->issue_name ?></option>
                                                <?php } ?>
                                            </select>
                                            <label id="request-form">Issue Category<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="w-100 form-group">
                                            <input id="request-form" name="name" value="<?=$user->fullname ?>" disabled required placeholder="text">
                                            <label id="request-form">Requestor Name <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="w-100 form-group">
                                            <input id="request-form" name="contact_no" type="number" value="<?=$user->contact_no ?>" required placeholder="text">
                                            <label id="request-form">Contact Number <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="w-100 form-group">
                                            <input id="request-form" name="unit" type="text" disabled value="<?=$user->default_unit ?>" required placeholder="text">
                                            <label id="request-form">Unit # <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="input-repare-status">
                                        <div class="form-group">
                                            <textarea id="request-form" name="description" required placeholder="text"></textarea>
                                            <label id="request-form" class="label-text-area">Description <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="input-repare-status input-box">
                                        <input type="file" id="file" name="attachments" class="request-upload" multiple>
                                        <label for="file" class="file file-name"><span class="material-icons">upload_file</span>Attachment File/Photo</label>
                                        <!-- Attachment/Photo <span class="text-danger">*</span>
                                    <div class="d-flex align-items-center">
                                        <label class="input-group-btn">
                                            <i class="fa-solid fa-paperclip px-2 py-2" style="border: 1px solid #1C5196; color: #FFFFFF; border-radius: 10px 0px 0px 10px; background-color: #1C5196;"></i>
                                                <input type="file" name="upload_file" style="display: none;" multiple>
                                         </label>
                                        <input type="text" class="form-control-file" placeholder="Choose File">
                                    </div> -->
                                    </div>

                                    <div class="w-100" style=" margin-bottom: 34px;">
                                        <div class="grp-btn">
                                            <button type="submit" class="btn btn-dark btn-primary settings-save d-block px-5 w-100">Submit</button>
                                            <button type="button" class="close-btn btn btn-light btn-cancel settings-cancel d-block px-5 w-100">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- <hr class="dashed"> -->


        <div class="tab-service">
            <label for="">History</label>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                <label id="btnSubmit" class="btn first-tab btn-tab-service btn-outline-primary" for="btnradio1">Open <span><?=$opentotal ?></span></label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                <label id="btnAcknowledged" class="btn btn-tab-service btn-outline-primary" for="btnradio2">Ongoing <span><?=$ongoingdtotal ?></span> </label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                <label id="btnFinish" class="btn btn-tab-service btn-outline-primary" for="btnradio3">Closed<span><?=$closedtotal ?></span> </label>
            </div>
        </div>

        <div>
            <div class="history-container submitted">
                <?php
                $limit = 4; // Set the initial limit here
                $totalItems = count($open);
                $showItems = min($limit, $totalItems);

                for ($i = 0; $i < $showItems; $i++) {
                    $item = $open[$i];
                ?>
                    <div class="card-history">
                        <div class="w-100">
                            <div class="head w-100">
                                <div class="d-flex gap-2">
                                    <span>#<?=$item->id ?></span>
                                    <div><?=$item->status ?></div>
                                </div>
                                <label><?=$item->date_upload ?></label>
                            </div>
                            <div>
                                <p>Category: <?=$item->issue_name ?></p>
                                <p>Name: <?=$item->fullname ?></p>
                                <p>Unit: <?=$item->location_name ?></p>
                                <p>Contact Number: <?=$item->contact_no ?></p>
                                <p>Issue Description: <?=$item->description ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="history-container acknowledged">
                <?php
                $limit = 4; // Set the initial limit here
                $totalItems = count($ongoing);
                $showItems = min($limit, $totalItems);

                for ($i = 0; $i < $showItems; $i++) {
                    $item = $ongoing[$i];
                ?>
                    <div class="card-history">
                        <div class="w-100">


                            <div class="head w-100">
                                <div class="d-flex gap-2">
                                    <span>#<?=$item->id ?></span>
                                    <div><?=$item->status ?></div>
                                </div>

                                <label><?=$item->date_upload ?></label>
                            </div>
                            <div>
                                <p>Category: <?=$item->issue_name ?></p>
                                <p>Name: <?=$item->fullname ?></p>
                                <p>Unit: <?=$item->location_name ?></p>
                                <p>Contact Number: <?=$item->contact_no ?></p>
                                <p>Issue Description: <?=$item->description ?></p>

                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="history-container finishedwork">
                <?php
                $limit = 4; // Set the initial limit here
                $totalItems = count($closed);
                $showItems = min($limit, $totalItems);

                for ($i = 0; $i < $showItems; $i++) {
                    $item = $closed[$i];
                ?>
                    <div class="card-history">
                        <div class="w-100">


                            <div class="head w-100">
                                <div class="d-flex gap-2">
                                    <span>#<?=$item->id ?></span>
                                    <div><?=$item->status ?></div>
                                </div>

                                <label><?=$item->date_upload ?></label>
                            </div>
                            <div>
                                <p>Category: <?=$item->issue_name ?></p>
                                <p>Name: <?=$item->fullname ?></p>
                                <p>Unit: <?=$item->location_name ?></p>
                                <p>Contact Number: <?=$item->contact_no ?></p>
                                <p>Issue Description: <?=$item->description ?></p>

                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>
<?php include('menu.php') ?>
</div>
</body>

</html>
<script>
    $("#form-main").off('submit').on('submit', function(e) {
        e.preventDefault();
        // Function to handle image compression
        var formData = new FormData(this);
        const fileInput = $('#file').prop('files')[0];

        // Add the file input to the form data
        if (fileInput) {
            formData.append('attachments', fileInput);
        }
        console.log(formData)
        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function(data) {
                const res = JSON.parse(data)
                popup({
                    data: res,
                    reload_time: 2000,
                    redirect: location.href
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });


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

    $(function() {

        // This code will attach `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });


        $(document).ready(function() {
            //below code executes on file input change and append name in text control
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.d-flex').find('.form-control-file'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) $('.file-name').text(log);
                }

            });
        });

    });
    $(".close-btn").on('click', function() {
        $('#collapse-status').collapse('toggle');
    });

    $('.btn-status').off('click').on('click', function() {
        $('#collapse-status').collapse('toggle');
    });

    $('#up1').hide();

    $('#collapse-status').on('hidden.bs.collapse', function() {
        $('#up1').hide();
        $('#down1').show();
        $('.main input:not([readonly]):not([disabled]):not([name="contact_no"]), .main select:not([readonly]):not([disabled]), .main textarea').each(function() {
            $(this).val('');
        });


    });

    $('#collapse-status').on('show.bs.collapse', function() {
        $('#up1').show();
        $('#down1').hide();

    });

    $('.back-button-sr').on('click', function() {
        history.back();
    });
</script>