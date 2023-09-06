<?php
$module = "visitorpass";
$table = "visitorpass";
$view = "vw_visitor_pass";


$id = $args[0];
if ($id != "") {
    $result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
    $record = json_decode($result);
}
// var_dump($record);
$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$guest_id = initObj('visitorpass_id');
if ($visitorpass_id) {
    $parent_condition = "id=" . decryptData($visitorpass_id);
    $type_condition = "locationtype!='Building' and locationtype!='Floor'";
    $record->parent_location_id = decryptData($visitorpass_id);
} else {
    $parent_condition = "location_type!='Building'";
    $type_condition = "locationtype!='Building'";
}
$result =  $ots->execute('module', 'get-listnew', ['table' => 'location', 'condition' => $parent_condition, 'orderby' => 'location_name']);
$unit_locs = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'vw_resident']);
$name = json_decode($result);


$result =  $ots->execute('module', 'get-listnew', ['table' => 'vp_guest', 'condition' => 'guest_id="' . $record->id . '"']);
$vp_guest = json_decode($result);
// var_dump($vp_guest);
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
        <div class="">
            <form method="post" action="<?= WEB_ROOT; ?>/servicerequest/save?display=plain" id="form-main">
                <!-- <h1 class="text-black fw-bold">*Please fill in the required field </h1> -->
                <input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>">
                <input name="module" type="hidden" value="<?= $module ?>">
                <input name="table" type="hidden" value="<?= $table ?>">
                <input name="date" type="hidden" value="<?= ($record) ? date('Y-m-d H:i:s', strtotime($record->date_upload))  :  date('Y-m-d H:i:s') ?> ">
                <div class="row forms">
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
                            <input name="contact_no" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->contact_no : '' ?>" required>
                            <label>Contact #<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="arrival_date" placeholder="Enter here" type="date" class="form-control" value="<?= ($record) ? $record->arrival_date : '' ?>" required>
                            <label>Arrival Date<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="arrival_time" placeholder="Enter here" type="time" class="form-control" value="<?= ($record) ? date("H:i:s", strtotime($record->arrival_time))  : '' ?>" required>
                            <label>Arrival Time<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3"> </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="departure_date" placeholder="Enter here" type="date" class="form-control" value="<?= ($record) ? $record->departure_date : '' ?>" required>
                            <label>Departure Date<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="departure_time" placeholder="Enter here" type="time" class="form-control" value="<?= ($record) ? date("H:i:s", strtotime($record->departure_time))  : '' ?>" required>
                            <label>Departure Time<b class="text-danger">*</b></label>
                        </div>
                    </div>

                </div>

            </form>
        </div>
        <form method="post" action="<?= WEB_ROOT; ?>/servicerequest/save?display=plain" id="item-send">
            <div class="mt-4">
                <div class="d-flex justify-content-between">
                    <h1 class="text-black fw-bold">Guest Details </h1>
                    <button class="main-btn w-auto px-3 add-btn-items" type="button"> <span class="material-icons">
                            add
                        </span>
                        Add Guest</button>
                </div>
                <table class="table table-bordered  add-items  border-table ">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Purpose of Visit</th>
                            <!-- <?php if ($record) { ?> <th>Action</th> <?php } ?> -->
                        </tr>
                        <?php
                        if ($vp_guest) {
                            foreach ($vp_guest as $item) {
                        ?>
                                <tr>
                                    <td><?php echo $item->guest_name ?></td>
                                    <td><?php echo $item->guest_no ?></td>
                                    <td><?php echo $item->guest_purpose ?></td>
                                    <!-- <?php if ($record) { ?>
                                        <td><a del_url="<?= WEB_ROOT . "/gatepass/delete/$module/vp_guest/$item->id" ?>"role_access="<?= $role_access->delete ?>" onclick="show_delete_modal(this)" rec_id="<?= $item->guest_name ?>"><i class="fa-solid fa-trash fa-lg text-danger"></i></a></td>
                                    <?php } ?> -->
                                </tr>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
        </form>
        <div class="row">

            <input id="guest_id" type="hidden" class="form-control">
            <div class="col-4 mb-3">
                <div class="form-group input-box">
                    <input id="guest_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                    <label>Name<b class="text-danger">*</b></label>
                </div>
            </div>
            <div class="col-4 mb-3">
                <div class="form-group input-box">
                    <input id="guest_no" placeholder="Enter here" type="number" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                    <label>Contact Number<b class="text-danger">*</b></label>
                </div>
            </div>
            <div class="col-4 mb-3">
                <div class="form-group input-box">
                    <input id="guest_purpose" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->last_name : '' ?>">
                    <label>Purpose of Visit<b class="text-danger">*</b></label>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="d-flex gap-3 justify-content-end">
    <button class="main-btn main-submit btn">Submit</button>
    <button type="button" class="btn-cancel main-cancel btn">Cancel</button>
</div>
</div>

</div>
<script>
    $(document).ready(function() {

		$("input[name=departure_date]").change(function() {
			if ($("input[name=arrival_date]").val() === "") {
				popup({
					title: "Please enter arrival date first.",
					data: {
						success: 0
					},
					reload_time: 3000,
					
				});
				$("input[name=arrival_date]").focus();
				$(this).val('');
			} else if ($("input[name=departure_date]").val() < $("input[name=arrival_date]").val()) {
				popup({
					title: "Departure date cannot be before arrival date. Please change.",
					data: {
						success: 0
					},
					reload_time: 3000,
					
				});
				$("input[name=departure_date]").val(''); // Clear the invalid end date
				$("input[name=departure_date]").focus();
			}
		});



        <?php if ($guest_id == "") { ?>
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



        let items = []
        $('.add-btn-items').click(function() {
            let guest_name = $('#guest_name').val()
            let guest_no = $('#guest_no').val()
            let guest_purpose = $('#guest_purpose').val()
            if (guest_name && guest_no && guest_purpose) {

                $('.add-items tbody').append(
                    `
        <tr>
            <td><input class="border-0 bg-transparent tabel-input" name="guest_name"  type="text" value="${guest_name}" readonly></td>
            <td><input class="border-0 bg-transparent tabel-input" name="guest_no" type="text" value="${guest_no}" readonly></td>
            <td><input class="border-0 bg-transparent tabel-input" name="guest_purpose" type="text" value="${guest_purpose}" readonly></td>
        </tr>
        `
                );

                var item = {
                    guest_name: guest_name,
                    guest_no: guest_no,
                    guest_purpose: guest_purpose,
                };

                // Push the item to the array
                items.push(item);
            }
            guest_name = $('#guest_name').val('')
            guest_no = $('#guest_no').val('')
            guest_purpose = $('#guest_purpose').val('')

        });
        $('.main-submit').click(function() {
            // Check if inputs and selects have values
            var isFormValid = true;
            $('.main-container input[required], .main-container select[required]').each(function() {
                if (!$(this).val()) {
                    isFormValid = false;
                    // $(this).addClass('error');
                    console.log($(this));
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


        $("#form-main").off('submit').on('submit', function(e) {
            // Check if any required fields are empty
            $(this).find('[required]').css('border', ''); // Reset border color
            var isFormValid = true;
            $(this).find('[required]').each(function() {
                if ($(this).val() === '') {
                    isFormValid = false;
                    $(this).css('border', '1px solid red');
                    return false; // Exit the loop early
                }
            });

            if (!isFormValid) {
                // Display an error message or perform any other desired action

                e.preventDefault();
                return;
            }
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
                    $('#guest_id').val(data.id)
                    $('#item-send').submit();
                    popup({
                        data: data,
                        reload_time: 2000,
                        redirect: "<?= WEB_ROOT . "/$module/" ?>"
                    })
                },
            });
        });

        $('#item-send').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally
            items = items.map(obj => ({
                ...obj,
                <?php if ($id) { ?>
                    guest_id: "<?php echo decryptData($id); ?>"
                <?php } else { ?> guest_id: $('#guest_id').val()
                <?php } ?>,
                table: 'vp_guest'
            }));

            items.forEach(i => {
                $.ajax({
                    url: $(this).prop('action'),
                    method: 'POST',
                    data: i,
                    success: function(data) {

                    },
                    error: function(xhr, status, error) {

                        console.error(error);
                    }
                });
            })



        });


        $(".btn-cancel").click(function() {
            location = '<?= WEB_ROOT . "/$module/" ?>';
        });
    });
</script>