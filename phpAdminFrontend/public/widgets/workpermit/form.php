<?php
$module = "workpermit";
$table = "workpermit";
$view = "vw_workpermit";

$id = $args[0];
if ($id != "") {
    $result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
    $record = json_decode($result);
}
$decrypt_id = decryptData($id);

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);


$result =  $ots->execute('module', 'get-listnew', ['table' => 'location', 'condition' => $parent_condition, 'orderby' => 'location_name']);
$unit_locs = json_decode($result);
$result = $ots->execute('module', 'get-listnew', ['table' => 'vw_resident']);
$name = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'work_details', 'condition' => 'id="' . $record->work_details_id . '"']);
$work_detail = json_decode($result);
// var_dump($work_detail);


$result =  $ots->execute('module', 'get-listnew', ['table' => 'list_workpermitcategory',  'orderby' => 'category']);
$category = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'list_workpermitstatus',  'orderby' => 'status']);
$status = json_decode($result);
// var_dump($status);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'workers', 'condition' => 'workpermit_id="' . $record->id . '"']);
$workers = json_decode($result);


$result =  $ots->execute('module', 'get-listnew', ['table' => 'work_materials', 'condition' => 'workpermit_id="' . $record->id . '"']);
$work_materials = json_decode($result);
// var_dump($workers);


$result =  $ots->execute('module', 'get-listnew', ['table' => 'work_tools', 'condition' => 'workpermit_id="' . $record->id . '"']);
$work_tools = json_decode($result);
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




    <div class="grid lg:grid-cols-1 grid-cols-1 title">
        <form method="post" action="<?= WEB_ROOT; ?>/servicerequest/save?display=plain" id="form-main">
            <div class="">
                <input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>">
                <input name="module" type="hidden" value="<?= $module ?>">
                <input name="table" type="hidden" value="<?= $table ?>">
                <input name="work_details_id" type="hidden" id="work_details_id">
                <input name="date" type="hidden" value="<?= ($record) ? date('Y-m-d H:i:s', strtotime($record->date_upload))  :  date('Y-m-d H:i:s') ?> ">
                <!-- <h1 class="text-black fw-bold">*Please fill in the required field </h1> -->

                <div class="row forms">


                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <select name="workpermitcategory_id" class="form-control form-select" required>
                                <option selected disabled>Choose</option>
                                <?php foreach ($category as $key => $val) {; ?>
                                    <option value="<?= $val->id ?>" <?= ($record && $record->workpermitcategory_id == $val->id) ? 'selected' : '' ?>><?= $val->category ?></option>
                                <?php } ?>
                            </select>
                            <label> Nature of Work <b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="start_date" id="start_date" placeholder="Enter here" type="date" class="form-control" value="<?= ($record) ? $record->start_date : '' ?>" required>
                            <label>Start Date<b class="text-danger">*</b></label>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="end_date" placeholder="Enter here" type="date" class="form-control" value="<?= ($record) ? $record->end_date : '' ?>" required>
                            <label>End Date<b class="text-danger">*</b></label>
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
                                <option selected disabled>Choose</option>
                                <?php foreach ($name  as $key => $val) {; ?>
                                    <option value="<?= $val->id ?>" <?= ($record && $record->name_id == $val->id) ? 'selected' : '' ?>><?= $val->fullname ?></option>
                                <?php } ?>
                            </select>
                            <label>Name <b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="contact_no" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->contact_no : '' ?>" required>
                            <label>Contact Number <b class="text-danger">*</b></label>
                        </div>
                    </div>

                </div>

            </div>

        </form>

        <div class="mt-4">
            <form method="post" action="<?= WEB_ROOT; ?>/servicerequest/save?display=plain" id="work-details">
                <!-- <input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>"> -->
                <input name="module" type="hidden" value="<?= $module ?>">
                <input name="table" type="hidden" value="work_details">
                <h1 class="text-black fw-bold">Work Details</h1>

                <div class="row">
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="name_contractor" placeholder="Enter here" type="text" class="form-control" value="<?= ($work_detail) ? $work_detail[0]->name_contractor : '' ?>" required>
                            <label>Name of Contractor<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="scope_work" placeholder="Enter here" type="text" class="form-control" value="<?= ($work_detail) ? $work_detail[0]->scope_work : '' ?>" required>
                            <label>Scope of Work<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="person_charge" placeholder="Enter here" type="text" class="form-control" value="<?= ($work_detail) ? $work_detail[0]->person_charge : '' ?>" required>
                            <label>Name of Person-In-Charge<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="contact_number" placeholder="Enter here" type="number" class="form-control" value="<?= ($work_detail) ? $work_detail[0]->contact_number : '' ?>" required>
                            <label>Contact Number<b class="text-danger">*</b></label>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <!-- personel -->
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h1 class="text-black fw-bold">List of Workers/Personnel</h1>
                <button class="main-btn w-auto px-3 add-personel" type="button"> <span class="material-icons">
                        add
                    </span>
                    Add Personnel</button>
            </div>
            <table class="table table-bordered add-personel-tabel  border-table ">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <!-- <?php if ($record) { ?>
                            <th>Action</th>
                        <?php } ?> -->
                    </tr>
                    <?php
                    if ($workers) {
                        foreach ($workers as $item) {
                    ?>
                            <tr>
                                <td><?php echo $item->personnel_name ?></td>
                                <td><?php echo $item->personnel_description ?></td>
                                <!-- <?php if ($record) { ?>
                                    <td><a del_url="<?= WEB_ROOT . "/gatepass/delete/$module/workers/$item->id" ?>" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" rec_id="<?= $item->personnel_name ?>"><i class="fa-solid fa-trash fa-lg text-danger"></i></a></td>
                                <?php } ?> -->
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="row">

                <div class="col-6 mb-3">

                    <div class="form-group input-box">
                        <input id="personnel_name" placeholder="Enter here" type="text" class="form-control">
                        <label>Name<b class="text-danger">*</b></label>
                    </div>
                </div>
                <div class="col-6 mb-3">
                    <div class="form-group input-box">
                        <input id="personnel_description" placeholder="Enter here" type="text" class="form-control">
                        <label>Description</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- Materials -->
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h1 class="text-black  fw-bold">List of Materials</h1>
                <button class="main-btn add-materials w-auto px-3" type="button"> <span class="material-icons">
                        add
                    </span>
                    Add Materials</button>
            </div>
            <table class="table table-bordered add-materials-table  border-table ">
                <tbody>
                    <tr>
                        <th>Materials Name</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <!-- <?php if ($record) { ?>
                            <th>Action</th>
                        <?php } ?> -->
                    </tr>
                    <?php
                    if ($work_materials) {
                        foreach ($work_materials as $item) {
                    ?>
                            <tr>
                                <td><?php echo $item->materials_name ?></td>
                                <td><?php echo $item->quantity_materials ?></td>
                                <td><?php echo $item->description_materials ?></td>
                                <!-- <?php if ($record) { ?>
                                    <td><a del_url="<?= WEB_ROOT . "/gatepass/delete/$module/work_materials/$item->id" ?>" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" rec_id="<?= $item->materials_name ?>"><i class="fa-solid fa-trash fa-lg text-danger"></i></a></td>
                                <?php } ?> -->
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-4 mb-3">
                    <div class="form-group input-box">
                        <input id="materials_name" class="materials_name" name="materials_name" placeholder="Enter here" type="text" value="<?= ($record) ? $record->last_name : '' ?>">
                        <label>Material Name<b class="text-danger">*</b></label>
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="form-group input-box">
                        <input id="quantity_materials" class="quantity_materials" name="quantity_materials" placeholder="Enter here" type="number" value="<?= ($record) ? $record->last_name : '' ?>">
                        <label>Quantity<b class="text-danger">*</b></label>
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="form-group input-box">
                        <input id="description_materials" class="description_materials" name="description_materials" placeholder="Enter here" type="text" value="<?= ($record) ? $record->last_name : '' ?>">
                        <label>Description</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- tools -->
        <div class="mt-4">
            <div class="d-flex justify-content-between">
                <h1 class="text-black fw-bold">List of Tools</h1>
                <button class="main-btn add-tools w-auto px-3" type="button"> <span class="material-icons">
                        add
                    </span>
                    Add Tools</button>
            </div>
            <table class="table table-bordered  add-tools-table border-table ">
                <tbody>
                    <tr>
                        <th>Tools Name</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <!-- <?php if ($record) { ?>
                            <th>Action</th>
                        <?php } ?> -->
                    </tr>
                    <?php
                    if ($work_tools) {
                        foreach ($work_tools as $item) {
                    ?>
                            <tr>
                                <td><?php echo $item->tools_name ?></td>
                                <td><?php echo $item->quantity_tools ?></td>
                                <td><?php echo $item->description_tools ?></td>
                                <!-- <?php if ($record) { ?>
                                    <td><a del_url="<?= WEB_ROOT . "/gatepass/delete/$module/work_tools/$item->id" ?>" role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" rec_id="<?= $item->tools_name ?>"><i class="fa-solid fa-trash fa-lg text-danger"></i></a></td>
                                <?php } ?> -->
                            </tr>
                    <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
            <div class="row">
                <div class="col-4 mb-3">
                    <div class="form-group input-box">
                        <input id="tools_name" name="tools_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                        <label>Tool Name<b class="text-danger">*</b></label>
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="form-group input-box">
                        <input id="quantity_tools" name="quantity_tools" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                        <label>Quantity<b class="text-danger">*</b></label>
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="form-group input-box">
                        <input id="description_tools" name="description_tools" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                        <label>Description</label>
                    </div>
                </div>
            </div>
            <?php if (!$id) : ?>
                <div class="d-flex flex-column gap-4 mt-4">
                    <div class="d-flex align-items-center">
                        <div class="switch">
                            <input type="checkbox" id="switch1">
                            <label for="switch1">Toggle</label>
                        </div>
                        <label for="" class="label-switch mx-3">Create Gate Pass</label>
                    </div>

                    <div class="gatepass">

                        <div class="d-flex gap-3">
                            <div>
                                <input type="radio" name="gp_type" id="delivery" value="1">
                                <label for="delivery" class="label-switch">Delivery</label>
                            </div>
                            <div>
                                <input type="radio" name="gp_type" id="pullout" value="2">
                                <label for="pullout" class="label-switch">Pull Out</label>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-group input-box">
                                        <input name="gp_date" id="delivery_date" placeholder="Enter here" type="date" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                                        <label for="delivery_date">Delivery Date<b class="text-danger">*</b></label>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group input-box">
                                        <input name="gp_time" id="delivery_time" placeholder="Enter here" type="time" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                                        <label for="delivery_time">Delivery Time<b class="text-danger">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <!-- <div class="d-flex gap-3 justify-content-end mb-4">
            <input type="checkbox" name="" id="terms" required>
            <label for="terms" class="label-switch">I agree to the Terms and Condition</label>
        </div> -->
        <input id="workpermit_id" type="hidden" class="form-control">
        <div class="d-flex gap-3 justify-content-end">
            <button class="main-btn btn main-submit">Submit</button>
            <button class="main-cancel btn-cancel btn" type="button">Cancel</button>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
		$("input[name=end_date]").change(function() {
			if ($("input[name=start_date]").val() === "") {
				popup({
					title: "Please enter start date first.",
					data: {
						success: 0
					},
					reload_time: 3000,
					
				});
				$("input[name=start_date]").focus();
				$(this).val('');
			} else if ($("input[name=end_date]").val() < $("input[name=start_date]").val()) {
				popup({
					title: "End date cannot be before start date. Please change.",
					data: {
						success: 0
					},
					reload_time: 3000,
					
				});
				$("input[name=end_date]").val(''); // Clear the invalid end date
				$("input[name=end_date]").focus();
			}
		});



        $('#start_date').on('change', function() {
            $('#delivery_date').val($(this).val());
        });

        const workpermit_id = $('#workpermit_id')
        <?php if ($reportissue_id == "") { ?>
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
                        var contact_no = $("input[name=contact_no]");
                        var obj = $("select[name=name_id]");
                        obj.empty();
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
                $("#work-details").submit();
                if ($('#switch1').is(':checked')) {
                    send_gatepass();
                }
            } else {
                // Trigger HTML built-in validation pop-up for all elements
                $('.main-container input[required], .main-container select[required]').each(function() {
                    this.reportValidity();
                });
            }
        });



        $("#work-details").off('submit').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(data) {
                    $('#work_details_id').val(data.id);
                    $('#form-main').submit();

                },
            });
        });
        let personel = []
        $('.add-personel').click(function() {
            // console.log(workpermit_id.val())
            let personnel_name = $('#personnel_name').val()
            let personnel_description = $('#personnel_description').val()
            if (personnel_name) {

                $('.add-personel-tabel tbody').append(
                    `
        <tr>
            <td><input class="border-0 bg-transparent tabel-input" name="personnel_name"  type="text" value="${personnel_name}" readonly></td>
            <td><input class="border-0 bg-transparent tabel-input" name="personnel_description" type="text" value="${personnel_description}" readonly></td>
        </tr>
        `
                );

                var item = {
                    personnel_name: personnel_name,
                    personnel_description: personnel_description,
                };

                // Push the item to the array
                personel.push(item);
            }
            // console.log(personel)
            personel = personel.map(obj => ({
                ...obj,
                workpermit_id: Number(workpermit_id.val()),
                table: 'workers'
            }));
            // console.log(personel)
        });

        let materials = []
        $('.add-materials').click(function() {
            let materials_name = $('#materials_name').val()
            let quantity_materials = $('#quantity_materials').val()
            let description_materials = $('#description_materials').val()
            if (materials_name && quantity_materials) {

                $('.add-materials-table tbody').append(
                    `
        <tr>
            <td><input class="border-0 bg-transparent tabel-input" name="materials_name"  type="text" value="${materials_name}" readonly></td>
            <td><input class="border-0 bg-transparent tabel-input" name="quantity_materials"  type="text" value="${quantity_materials}" readonly></td>
            <td><input class="border-0 bg-transparent tabel-input" name="description_materials" type="text" value="${description_materials}" readonly></td>
        </tr>
        `
                );

                var item = {
                    materials_name: materials_name,
                    quantity_materials: quantity_materials,
                    description_materials: description_materials,
                };

                // Push the item to the array
                materials.push(item);
            }

            materials = materials.map(obj => ({
                ...obj,
                workpermit_id: Number(workpermit_id.val()),
                table: 'work_materials'
            }));
            console.log(materials)

        });

        let tools = []
        $('.add-tools').click(function() {
            let tools_name = $('#tools_name').val()
            let quantity_tools = $('#quantity_tools').val()
            let description_tools = $('#description_tools').val()
            if (tools_name && quantity_tools) {

                $('.add-tools-table tbody').append(
                    `
        <tr>
            <td><input class="border-0 bg-transparent tabel-input" name="tools_name"  type="text" value="${tools_name}" readonly></td>
            <td><input class="border-0 bg-transparent tabel-input" name="quantity_tools"  type="text" value="${quantity_tools}" readonly></td>
            <td><input class="border-0 bg-transparent tabel-input" name="description_tools" type="text" value="${description_tools}" readonly></td>
        </tr>
        `
                );

                var item = {
                    tools_name: tools_name,
                    quantity_tools: quantity_tools,
                    description_tools: description_tools,
                };

                // Push the item to the array
                tools.push(item);
            }

            tools = tools.map(obj => ({
                ...obj,
                workpermit_id: Number(workpermit_id.val()),
                table: 'work_tools'
            }));

        });
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
                    // console.log(data)
                    workpermit_id.val(data.id)
                    item_send(materials, data.id)
                    // console.log(personel)
                    item_send(personel, data.id)
                    item_send(tools, data.id)



                    popup({
                        data: data,
                        reload_time: 2000,
                        redirect: "<?= WEB_ROOT . "/$module/" ?>"
                    })


                },
            });
        });

        const item_send = (items, id) => {
            items.forEach(i => {
                <?php if ($decrypt_id) { ?>
                    i.workpermit_id = <?php echo $decrypt_id ?>
                <?php } else { ?>
                    i.workpermit_id = id
                <?php } ?>

                // console.log(items)
                $.ajax({
                    url: '<?= WEB_ROOT; ?>/servicerequest/save?display=plain',
                    method: 'POST',
                    data: i,
                    success: function(response) {
                        const data = JSON.parse(response)
                        console.log(data)

                    },
                    error: function(xhr, status, error) {

                        console.error(error);
                    }
                });
            })
        }


        $('.gatepass').hide()
        $('#switch1').change(function() {
            const gate = $('.gatepass');
            // alert("test")
            if ($(this).is(':checked')) {
                $("input[name=gp_type]").prop('required', true);
                $("input[name=delivery_date]").prop('required', true);
                $("input[name=delivery_time]").prop('required', true);
                gate.show();

            } else {
                $("input[name=gp_type]").prop('required', false);
                $("input[name=delivery_date]").prop('required', false);
                $("input[name=delivery_time]").prop('required', false);
                gate.hide();
            }
        });

        let materials_gatepass = [];
        $('.add-materials').click(function() {
            let materials_name = $('.materials_name').val();
            let quantity_materials = $('.quantity_materials').val();
            let description_materials = $('.description_materials').val();

            var item = {
                item_name: materials_name,
                item_qty: quantity_materials,
                description: description_materials,
            };
            materials_gatepass.push(item);

            $('.materials_name').val('');
            $('.quantity_materials').val('');
            $('.description_materials').val('');

            materials_gatepass = materials_gatepass.map(obj => ({
                ...obj,
                workpermit_id: Number(workpermit_id.val()),
                table: 'work_materials'
            }));
            console.log(materials_gatepass);
        });


        let tools_gatepass = []
        $('.add-tools').click(function() {
            let tools_name = $('#tools_name').val()
            let quantity_tools = $('#quantity_tools').val()
            let description_tools = $('#description_tools').val()
            if (tools_name && quantity_tools) {

                var item = {
                    item_name: tools_name,
                    item_qty: quantity_tools,
                    description: description_tools,
                };

                // Push the item to the array
                tools_gatepass.push(item);
            }
            tools_name = $('#tools_name').val('')
            quantity_tools = $('#quantity_tools').val('')
            description_tools = $('#description_tools').val('')
            tools_gatepass = tools_gatepass.map(obj => ({
                ...obj,
                workpermit_id: Number(workpermit_id.val()),
                table: 'work_tools'
            }));
            console.log(tools_gatepass)
        });

        let personnel_gatepass = []
        $('.add-personel').click(function() {
            // console.log(workpermit_id.val())
            let personnel_name = $('#personnel_name').val()
            let personnel_description = $('#personnel_description').val()
            if (personnel_name) {

                var item = {
                    personnel_name: personnel_name,
                    personnel_description: personnel_description,
                };

                // Push the item to the array
                personnel_gatepass.push(item);
            }
            personnel_name = $('#personnel_name').val('')
            personnel_description = $('#personnel_description').val('')
            // console.log(personel)
            personnel_gatepass = personnel_gatepass.map(obj => ({
                ...obj,
                workpermit_id: Number(workpermit_id.val()),
                table: 'workers'
            }));
            // console.log(personnel_gatepass)
        });

        const send_gatepass = () => {
            const gp_date = $('input[name="gp_date"]').val();
            const gp_time = $('input[name="gp_time"]').val();
            const unit_id = $('select[name="unit_id"]').val();
            const name_id = $('select[name="name_id"]').val();
            const contact_no = $('input[name="contact_no"]').val();
            const gp_type = $('input[name="gp_type"]:checked').attr('value');

            const formData = new FormData();
            formData.append('gp_date', gp_date);
            formData.append('gp_time', gp_time);
            formData.append('unit_id', unit_id);
            formData.append('name_id', name_id);
            formData.append('contact_no', contact_no);
            formData.append('gp_type', gp_type);
            formData.append('module', "gatepass");
            formData.append('table', "gatepass");

            // console.log(gp_type)
            $.ajax({
                url: '<?= WEB_ROOT; ?>/servicerequest/save?display=plain',
                dataType: 'JSON',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data)
                    item_send_gatepass(tools_gatepass, data.id, "gatepass_items")
                    item_send_gatepass(materials_gatepass, data.id, "gatepass_items")
                    item_send_gatepass(personnel_gatepass, data.id, "gatepass_personnel")
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        };



        const item_send_gatepass = (items, id, table) => {
            items.forEach(i => {
                // Remove the workpermit_id property
                delete i.workpermit_id;

                i.gatepass_id = id;
                i.table = table;

                $.ajax({
                    url: '<?= WEB_ROOT; ?>/servicerequest/save?display=plain',
                    method: 'POST',
                    data: i,
                    success: function(response) {
                        const data = JSON.parse(response);
                        console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        };





        $(".btn-cancel").click(function() {
            location = '<?= WEB_ROOT . "/$module/" ?>';
        });
    });
</script>