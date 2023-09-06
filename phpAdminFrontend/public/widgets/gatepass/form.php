<?php
$module = "gatepass";
$table = "gatepass";
$view = "vw_gatepass";


$id = $args[0];
if ($id != "") {
    $result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
    $record = json_decode($result);
}

// var_dump($record);
$gatepass_id = initObj('gatepass_id');
if ($gatepass_id) {
    $parent_condition = "id=" . decryptData($gatepass_id);
    $type_condition = "locationtype!='Building' and locationtype!='Floor'";
    $record->parent_location_id = decryptData($gatepass_id);
} else {
    $parent_condition = "location_type!='Building'";
    $type_condition = "locationtype!='Building'";
}
$result =  $ots->execute('module', 'get-listnew', ['table' => 'location', 'condition' => $parent_condition, 'orderby' => 'location_name']);
$unit_locs = json_decode($result);

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_residenttype', 'field' => 'residenttype']);
$list_residenttype = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'list_gatepasscategory',  'orderby' => 'category_name']);
$category_name = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'vw_resident']);
$name = json_decode($result);

// $result = $ots->execute('module', 'get-listnew', ['table' => 'gatepass_personnel']);
// $personel = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'gatepass_personnel', 'condition' => 'gatepass_id="' . $record->id . '"']);
$gatepass_personnel = json_decode($result);
// var_dump($gatepass_personnel);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'gatepass_items', 'condition' => 'gatepass_id="' . $record->id . '"']);
$gatepass_items = json_decode($result);
// var_dump($gatepass_items);
// var_dump(encryptData($gatepass_items[1]->id));
?>
<div class="main-container">
    <a href="<?= WEB_ROOT . '/' . $module . '/' ?>" class="back">
        <span class="material-icons">
            arrow_back
        </span>
        Back
    </a>
    <div class="mt-2 mb-4">
        <h1 class="text-black mt-3 fw-bold"><?= ($id == '') ? 'Add' : 'Edit'; ?> <?= $page_title ?></h1>
        <h1 class="text-black fw-bold mt-2">*Please fill in the required field </h1>
    </div>
    <div class="">
        <!-- <h1 class="text-black fw-bold">*Please fill in the required field </h1> -->
        <form method="post" action="<?= WEB_ROOT; ?>/servicerequest/save?display=plain" id="form-main">
            <b class="err"></b>
            <div class="row forms">
                <div class="col-12 col-sm-4 mb-3">
                    <div class="form-group input-box">
                        <select name="gp_type" class="form-control form-select" required>
                            <option value="" selected disabled>Choose</option>
                            <?php foreach ($category_name as $key => $val) {; ?>
                                <option value="<?= $val->id ?>" <?= ($record && $record->gp_type == $val->id) ? 'selected' : '' ?>><?= $val->category_name ?></option>
                            <?php } ?>
                        </select>
                        <label>Category <b class="text-danger">*</b></label>
                    </div>
                </div>
                <div class="col-12 col-sm-4 mb-3">
                    <div class="form-group input-box">
                        <input name="gp_date" placeholder="Enter here" type="date" class="form-control" value="<?= ($record) ? $record->gp_date : '' ?>" required>
                        <label>Date<b class="text-danger">*</b></label>
                    </div>
                </div>

                <div class="col-12 col-sm-4 mb-3">
                    <div class="form-group input-box">
                        <input name="gp_time" placeholder="Enter here" type="time" class="form-control" value="<?= ($record) ? date("H:i:s", strtotime($record->gp_time))  : '' ?>" required>
                        <label>Time<b class="text-danger">*</b></label>
                    </div>
                </div>
                <div class="col-12 col-sm-4 mb-3">
                    <div class="form-group input-box">
                        <select name="unit_id" class="form-control form-select" required>
                            <option value="" selected disabled>Choose</option>
                            <?php foreach ($unit_locs as $key => $val) {; ?>
                                <option value="<?= $val->id ?>" <?= ($record && $record->unit_id == $val->id) ? 'selected' : '' ?>><?= $val->location_name ?></option>
                            <?php } ?>
                        </select>
                        <label>Unit<b class="text-danger lbl-non-building">*</b></label>
                    </div>
                </div>
                <div class="col-12 col-sm-4 mb-3">
                    <div class="form-group input-box">
                        <select name="name_id" class="form-control form-select" required>
                            <option value="" selected disabled>Choose</option>
                            <?php foreach ($name  as $key => $val) {; ?>
                                <option value="<?= $val->id ?>" <?= ($record && $record->name_id == $val->id) ? 'selected' : '' ?>><?= $val->fullname ?></option>
                            <?php } ?>
                        </select>
                        <label>Name <b class="text-danger">*</b></label>
                    </div>
                </div>



                <div class="col-12 col-sm-4 mb-3">
                    <div class="form-group input-box">
                        <input name="contact_no" id="contact_no" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->contact_no : '' ?>" required>
                        <label>Contact # <b class="text-danger">*</b></label>
                    </div>
                </div>


            </div>

            <input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>">
            <input name="date" type="hidden" value="<?= ($record) ? date('Y-m-d H:i:s', strtotime($record->date_upload))  :  date('Y-m-d H:i:s') ?> ">
            <input name="module" type="hidden" value="<?= $module ?>">
            <input name="table" type="hidden" value="<?= $table ?>">
        </form>
    </div>


    <div class="mt-4">
        <div class="d-flex justify-content-between">
            <h1 class="text-black fw-bold">Item Details</h1>
            <button class="main-btn w-auto px-3 add-btn-items" type="button"> <span class="material-icons">
                    add
                </span>
                Add item</button>
        </div>
        <table class="table table-bordered add-items border-table ">
            <tbody>
                <tr>
                    <th>Item name</th>
                    <th>Quantity</th>
                    <th>Description</th>
                    <!-- <?php if ($record) { ?> <th>Action</th> <?php } ?> -->
                </tr>
                <?php
                if ($gatepass_items) {
                    foreach ($gatepass_items as $item) {
                ?>
                        <tr>
                            <td><?php echo $item->item_name ?></td>
                            <td><?php echo $item->item_qty ?></td>
                            <td><?php echo $item->description ?></td>
                            <!-- <?php if ($record) { ?>
                                        <td><a del_url="<?= WEB_ROOT . "/gatepass/delete/$module/gatepass_items/$item->id" ?>"role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" rec_id="<?= $item->item_name ?>"><i class="fa-solid fa-trash fa-lg text-danger"></i></a></td>
                                    <?php } ?>
                        </tr> -->
                    <?php
                    }
                }
                    ?>

            </tbody>
        </table>

        <div class="row">
            <div class="col-12 col-sm-4 mb-3">
                <input class="gatepass_id" type="hidden" class="form-control">
                <div class="form-group input-box">

                    <input id="item_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                    <label>Item name<b class="text-danger">*</b></label>
                </div>
            </div>
            <div class="col-12 col-sm-4 mb-3">
                <div class="form-group input-box">
                    <input id="item_qty" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                    <label>Quantity<b class="text-danger">*</b></label>
                </div>
            </div>
            <div class="col-12 col-sm-4 mb-3">
                <div class="form-group input-box">
                    <input id="description" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                    <label>Description</label>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <form method="post" action="<?= WEB_ROOT; ?>/servicerequest/save?display=plain" id="form-personnel">
                <h1 class="text-black fw-bold">Personnel Details</h1>
                <div class="row">

                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="company_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($gatepass_personnel) ? $gatepass_personnel[0]->company_name : '' ?>" required>
                            <label>Courier/Company<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="personnel_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($gatepass_personnel) ? $gatepass_personnel[0]->personnel_name : '' ?>">
                            <label>Name</label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="personnel_no" placeholder="Enter here" type="number" class="form-control" value="<?= ($gatepass_personnel) ? $gatepass_personnel[0]->personnel_no : '' ?>">
                            <label>Contact Details</label>
                        </div>
                    </div>

                </div>
                <input class="id" name="id" type="hidden" class="form-control" value="<?= ($gatepass_personnel) ? $gatepass_personnel[0]->id : '' ?>">
                <input class="gatepass_id" name="gatepass_id" type="hidden" class="form-control" value="<?= ($gatepass_personnel) ? $gatepass_personnel[0]->gatepass_id : '' ?>">
                <input name="module" type="hidden" value="<?= $module ?>">
                <input name="table" type="hidden" value="gatepass_personnel">

            </form>
            <div class="d-flex gap-3 justify-content-end">
                <button type="submit" class="main-btn main-submit btn">Submit</button>
                <button type="button" class="btn-cancel main-cancel btn">Cancel</button>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
        <?php if ($gatepass_id == "") { ?>
            $("select[name=unit_id]").on('change', function() {
                let cond = `unit_id=${$(this).val()}`;
                $.ajax({
                    url: '<?= WEB_ROOT . "/module/get-listnew?display=plain" ?>',
                    type: 'POST',
                    data: {
                        table: 'resident',
                        condition: cond,
                        orderby: 'first_name'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        var obj = $("select[name=name_id]");
                        var contact_no = $("input[name=contact_no]");
                        obj.empty();
                        contact_no.empty();
                        $.each(data, function(key, val) {
                            obj.append("<option value='" + val.id + "'>" + val.first_name + " " + val.last_name + "</option");
                            contact_no.val(data[key].contact_no)
                        });
                        if (data.length == 0) {
                            contact_no.val('');
                        }

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown)
                    }
                });
            });
        <?php } ?>


        $('.main-submit').click(function() {
            // Check if inputs and selects have values
            var isFormValid = true;
            $('.main-container input[required], .main-container select[required]').each(function() {
                if (!$(this).val()) {
                    isFormValid = false;
                    // $(this).addClass('error');

                }
            });

            if (isFormValid) {
                $("#form-main").submit();
            } else {
                // Trigger HTML built-in validation pop-up for all elements
                $('.main-container input[required], .main-container select[required]').each(function() {
                    this.reportValidity();
                });
            }
        });


        let items = []
        $('.add-btn-items').click(function() {
            let item_name = $('#item_name').val()
            let item_qty = $('#item_qty').val()
            let description = $('#description').val()
            if (item_name && item_qty) {

                $('.add-items tbody').append(
                    `
        <tr>
            <td><input class="border-0 bg-transparent tabel-input" name="item_name"  type="text" value="${item_name}" readonly required></td>
            <td><input class="border-0 bg-transparent tabel-input" name="item_qty" type="text" value="${item_qty}" readonly required></td>
            <td><input class="border-0 bg-transparent tabel-input" name="description" type="text" value="${description}" readonly required></td>
        </tr>
        `
                );

                var item = {
                    item_name: item_name,
                    item_qty: item_qty,
                    description: description,
                };

                // Push the item to the array
                items.push(item);
            }
            item_name = $('#item_name').val('')
            item_qty = $('#item_qty').val('')
            description = $('#description').val('')

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
                    url: '<?= WEB_ROOT; ?>/servicerequest/save?display=plain',
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


        $("#form-main").off('submit').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    $('.btn').attr('disabled', 'disabled');
                },
                success: function(data) {
                    $('.gatepass_id').val(data.id)
                    $("#form-personnel").submit();
                    send_item(items)
                    popup({
                        data: data,
                        reload_time: 2000,
                        redirect: "<?= WEB_ROOT . "/$module/" ?>"
                    })
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });


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

        $(".btn-cancel").click(function() {
            location = '<?= WEB_ROOT . "/$module/" ?>';
        });
    });
</script>