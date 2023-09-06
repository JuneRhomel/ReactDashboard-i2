<?php
$module = "gatepass";
$table = "gatepass";
$view = "vw_gatepass";
require_once "header.php";
include "footerheader.php";
$api = apiSend('module', 'get-listnew', ['table' => 'vw_resident']);
$list = json_decode($api, true);



$result =  apiSend('module', 'get-listnew', ['table' => 'list_gatepasscategory',  'orderby' => 'category_name']);
$category_name = json_decode($result, true);

$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);
// var_dump($user);
$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_gatepass', 'condition' => 'created_by="' . $user->id . '" AND status = "Pending"']);
$gatepass_pendding = json_decode($result);
// var_dump($gatepass_pendding);
$pendingtotal = count($gatepass_pendding);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_gatepass', 'condition' => 'created_by="' . $user->id . '" AND status = "Approved"']);
$gatepass_approved = json_decode($result);
$approvedtotal = count($gatepass_approved);


$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_gatepass', 'condition' => 'created_by="' . $user->id . '" AND status = "Denied"']);
$gatepass_denied = json_decode($result);
$deniedtotal = count($gatepass_denied);
?>



<div class="d-flex">
    <div class="main">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Gate pass</label>
        </div>
        <div style="background-color: #F0F2F5; padding: 20px 24px 106px 24px;">

            <div class="d-flex justify-content-center pt-3" style="background-color: #F0F2F5;">
                <div class="card mb-3" style="width: 100%">
                    <div class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-status w-100" style="padding: 12px;">
                            <div><label class="m-0" style="font-weight: 400; color:#1C5196;">Request form</label></div>
                            <div><i id="down1" style="color:#1C5196" class="fa-solid fa-caret-down"></i><i id="up1" style="color:#1C5196" class="fa-solid fa-caret-down fa-rotate-180"></i></div>
                        </button>
                    </div>
                    <div id="collapse-status" class="collapse">

                        <div class="card-body " style="padding:24px 12px;">
                            <div class="forms">
                                <form action="http://portali2.sandbox.inventiproptech.com/gatepass-save.php" method="post" id="form-main">
                                    <input name="date" type="hidden" readonly value="<?= date('Y-m-d H:i:s') ?>">
                                    <input name="module" type="hidden" readonly value="<?= $module ?>">
                                    <input name="table" readonly type="hidden" value="<?= $table ?>">
                                    <input type="hidden" readonly name="name_id" value="<?= $user->id ?>">
                                    <input type="hidden" readonly name="unit_id" value="<?= $user->def_unit_id ?>">

                                    <!-- <input type="hidden" name="type" readonly value="tenant" > -->
                                    <div class="w-100">
                                        <div class="w-100 form-group">
                                            <input id="request-form" name="name" value="<?= $user->fullname ?>" disabled required placeholder="text">
                                            <label id="request-form">Requestor Name <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="w-100 form-group select">
                                            <select name="gp_type" class="select-text" required>
                                                <option value="" disabled selected></option>
                                                <?php foreach ($category_name as $key => $val) {; ?>
                                                    <option value="<?= $val['id'] ?>"><?= $val["category_name"] ?></option>
                                                <?php } ?>
                                            </select>
                                            <label class="select-label">Gatepass Type <span class="text-danger">*</span></label>
                                            <i class="fa-solid fa-sort-down"></i>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="w-100 form-group">
                                            <input type="date" id="request-form" name="gp_date" required placeholder="text">
                                            <label for="gp_date" id="request-form" class="text-required">Date <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="w-100 form-group">
                                            <input type="time" id="request-form" name="gp_time" required placeholder="text">
                                            <label for="" id="request-form" class="text-required">Time <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="w-100 form-group">
                                            <input id="request-form" name="unit" type="text" disabled value="<?= $user->default_unit ?>" required placeholder="text">
                                            <label id="request-form">Unit # <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="w-100 form-group">
                                            <input id="request-form" name="contact_no" type="number" value="<?= $user->contact_no ?>" required placeholder="text">
                                            <label id="request-form">Contact Number <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </form>


                                <label style="font-weight: 400;font-size: 24px; margin:24px 0">Item Details </label>

                                <div class="table-data add-ons" id="add-ons">
                                    <!--Add -->
                                </div>


                                <div>
                                    <div id="gatePass-item" class="gatePass-item">
                                        <div class="w-100 form-group">
                                            <input type="text" id="request-form" name="item_name[]" placeholder="text">
                                            <label id="request-form">Item Name </label>
                                        </div>

                                        <div class="w-100 form-group">
                                            <input type="text" id="request-form" name="item_qty[]" placeholder="text">
                                            <label id="request-form">Item Quantity </label>
                                        </div>


                                        <div class="w-100 form-group">
                                            <textarea id="request-form" name="description[]" placeholder="text"></textarea>
                                            <label class="label-text-area" id="request-form">Description </label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" id="btn-add-item" class="btn-add-item"> + Add Item</button>
                                    </div>

                                </div>
                                <form method="post" action="http://portali2.sandbox.inventiproptech.com/gatepass-save.php" id="form-personnel">


                                    <input class="gatepass_id" name="gatepass_id" readonly type="hidden" class="form-control">
                                    <input name="module" type="hidden" readonly value="gatepass">
                                    <input name="table" type="hidden" readonly value="gatepass_personnel">

                                    <div class="col-12 col-sm-4 pt-3" style="padding-left: 0px;">
                                        <label style="font-weight: 400;font-size: 24px; margin:24px 0">Personnel Details</label>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <input type="text" id="request-form" name='company_name' placeholder="text">
                                            <label for="" id="request-form">Courier / Company <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <input type="text" id="request-form" name='personnel_name' placeholder="text">
                                            <label for="" id="request-form">Name <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <input type="text" id="request-form" name='personnel_no' placeholder="text">
                                            <label for="" id="request-form">Contact Details <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </form>
                                <div class="grp-btn" style="margin-bottom: 34px;">
                                    <div class="btn-settings ">
                                        <button type="submit" class="btn main-submit btn-dark btn-primary settings-save d-block px-5 w-100">Submit</button>
                                    </div>
                                    <div class="btn-settings">
                                        <button type="button" class="close-btn btn btn-light btn-cancel settings-cancel d-block px-5 w-100">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="tab-service">
                <label for="">History</label>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                    <label id="btnSubmit" class="btn first-tab btn-tab-service btn-outline-primary" for="btnradio1">Pending <span><?= $pendingtotal ?></span></label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                    <label id="btnAcknowledged" class="btn btn-tab-service btn-outline-primary" for="btnradio2">Approved <span><?= $approvedtotal ?></span> </label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                    <label id="btnFinish" class="btn btn-tab-service btn-outline-primary" for="btnradio3">Denied<span><?= $deniedtotal ?></span> </label>
                </div>
            </div>

            <div>
                <div class="history-container submitted">
                    <?php
                    $limit = 4; // Set the initial limit here
                    $totalItems = count($gatepass_pendding);
                    $showItems = min($limit, $totalItems);

                    for ($i = 0; $i < $showItems; $i++) {
                        $item = $gatepass_pendding[$i];
                        $result = apiSend('module', 'get-listnew', ['table' => 'gatepass_personnel', 'condition' => 'gatepass_id="' . $item->id . '"']);
                        $personel = json_decode($result);
                        // var_dump($item->id);
                        foreach ($personel  as $personel) {
                    ?>
                            <div class="card-history">
                                <div class="w-100">
                                    <div class="head w-100">
                                        <div class="d-flex gap-2">
                                            <span>#<?= $item->id ?></span>
                                            <div><?= $item->status ?></div>
                                        </div>
                                        <label><?= $item->date_upload ?></label>
                                    </div>
                                    <div>
                                        <p>Type: <?= $item->type   ?></label><br>
                                        <p>Personel:<?= $personel->personnel_name  ?></label><br>
                                        <p>Unit: <?= $item->unit ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php }  ?>
                    <?php
                    }
                    ?>
                </div>


                <div class="history-container acknowledged">
                    <?php
                    $limit = 4; // Set the initial limit here
                    $totalItems = count($gatepass_approved);
                    $showItems = min($limit, $totalItems);

                    for ($i = 0; $i < $showItems; $i++) {
                        $item = $gatepass_approved[$i];
                        $result = apiSend('module', 'get-listnew', ['table' => 'gatepass_personnel', 'condition' => 'gatepass_id="' . $item->id . '"']);
                        $personel = json_decode($result);

                        foreach ($personel  as $personel) {
                    ?>
                            <div class="card-history">
                                <div class="w-100">
                                    <div class="head w-100">
                                        <div class="d-flex gap-2">
                                            <span>#<?= $item->id ?></span>
                                            <div><?= $item->status ?></div>
                                        </div>
                                        <label><?= $item->date_upload ?></label>
                                    </div>
                                    <div>
                                        <p>Type: <?= $item->type   ?></label><br>
                                        <p>Personel:<?= $personel->personnel_name  ?></label><br>
                                        <p>Unit: <?= $item->unit ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php }  ?>
                    <?php
                    }
                    ?>
                </div>
                <div class="history-container finishedwork">
                    <?php
                    $limit = 4; // Set the initial limit here
                    $totalItems = count($gatepass_denied);
                    $showItems = min($limit, $totalItems);

                    for ($i = 0; $i < $showItems; $i++) {
                        $item = $gatepass_denied[$i];
                        $result = apiSend('module', 'get-listnew', ['table' => 'gatepass_personnel', 'condition' => 'gatepass_id="' . $item->id . '"']);
                        $personel = json_decode($result);

                        foreach ($personel  as $personel) {
                    ?>
                            <div class="card-history">
                                <div class="w-100">
                                    <div class="head w-100">
                                        <div class="d-flex gap-2">
                                            <span>#<?= $item->id ?></span>
                                            <div><?= $item->status ?></div>
                                        </div>
                                        <label><?= $item->date_upload ?></label>
                                    </div>
                                    <div>
                                        <p>Type: <?= $item->type   ?></label><br>
                                        <p>Personel:<?= $personel->personnel_name  ?></label><br>
                                        <p>Unit: <?= $item->unit ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php }  ?>
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
    $('.main-submit').click(function() {
        // Check if inputs and selects have values
        var isFormValid = true;
        $('.main input[required], .main select[required]').each(function() {
            if (!$(this).val()) {
                isFormValid = false;
                // $(this).addClass('error');

            }
        });

        if (isFormValid) {
            $("#form-main").submit();
        } else {
            // Trigger HTML built-in validation pop-up for all elements
            $('.main input[required], .main select[required]').each(function() {
                this.reportValidity();
            });
        }
    });


    let items = []
    $('#btn-add-item').on('click', function() {
        let name = $('input[name="item_name[]"]').val()
        let qty = $('input[name="item_qty[]"]').val()
        let description = $('textarea[name="description[]"]').val()

        if (name && qty) {

            $('.add-ons').append(`
    <div class="description-form">
       <div class="description-label">
            <p>Item Name</p>
          
            <p>Quantity</p>
            <p>Description</p>
        </div>
        <div class="description-value">
            <p>${name}</p>
           
            <p>${qty}</p>
            <p>${description}</p>
        </div>
    </div>
    `);

            var item = {
                item_name: name,
                item_qty: qty,
                description: description,
            };

            // Push the item to the array
            items.push(item);
        }
        $('input[name="item_name[]"]').val('')
        $('input[name="item_qty[]"]').val('')
        $('textarea[name="description[]"]').val('')

        console.log(item)
    });

    $("#form-main").off('submit').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                const res = JSON.parse(data)
                console.log(res)
                $('.gatepass_id').val(res.id)
                $("#form-personnel").submit();
                send_item(items)
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


    const send_item = (items) => {
        items = items.map(obj => ({
            ...obj,
            gatepass_id: Number($('.gatepass_id').val()),
            table: 'gatepass_items'
        }));

        items.forEach(i => {
            console.log(i)
            $.ajax({
                url: 'http://portali2.sandbox.inventiproptech.com/gatepass-save.php',
                method: 'POST',
                data: i,
                success: function(response) {
                    console.log(response)
                },
                error: function(xhr, status, error) {

                    console.error(error);
                }
            });
        })
    }


    $("#form-personnel").off('submit').on('submit', function(e) {

        e.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                console.log(data)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
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
        items = []

        $('.description-form').remove();

    });
    $('#collapse-status').on('show.bs.collapse', function() {
        $('#up1').show();
        $('#down1').hide();


    });
</script>