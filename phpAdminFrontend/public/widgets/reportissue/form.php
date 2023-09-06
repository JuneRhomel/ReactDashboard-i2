<?php
$module = "reportissue";
$table = "report_issue";
$view = "vw_report_issue";


$id = $args[0];
if ($id != "") {
    $result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
    $record = json_decode($result);
}
// var_dump($record);
$reportissue_id = initObj('reportissue_id');
if ($reportissue_id) {
    $parent_condition = "id=" . decryptData($reportissue_id);
    $type_condition = "locationtype!='Building' and locationtype!='Floor'";
    $record->parent_location_id = decryptData($reportissue_id);
} else {
    $parent_condition = "location_type!='Building'";
    $type_condition = "locationtype!='Building'";
}
$result =  $ots->execute('module', 'get-listnew', ['table' => 'location', 'condition' => $parent_condition, 'orderby' => 'location_name']);
$unit_locs = json_decode($result);
$result =  $ots->execute('module', 'get-listnew', ['table' => 'list_issuecategory',  'orderby' => 'issue_name']);
$issue_name = json_decode($result);
// var_dump($issue_name);
$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_residenttype', 'field' => 'residenttype']);
$list_residenttype = json_decode($result);


$result = $ots->execute('module', 'get-listnew', ['table' => 'vw_resident']);
$name = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'list_workpermitstatus',  'orderby' => 'status']);
$status = json_decode($result);
?>

<div class="main-container">
    <div class="">
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
        <form method="post" action="<?= WEB_ROOT; ?>/reportissue/save?display=plain" id="form-main">
            <input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>">
            <input name="module" type="hidden" value="<?= $module ?>">
            <input name="table" type="hidden" value="<?= $table ?>">
            <?php if ($id) { ?>
                <input name="status_id" type="hidden" value="<?= $record->status_id ?>">
            <?php } ?>
            <div class="grid lg:grid-cols-1 grid-cols-1 title">
                <!-- <h1 class="text-black fw-bold">*Please fill in the required field </h1> -->
                <div class="row forms">
                    <div class="col-12 mb-3">
                        <div class="form-group input-box">
                            <select name="issue_id" class="form-control form-select" required>
                                <option selected disabled>Choose</option>
                                <?php foreach ($issue_name as $key => $val) {; ?>
                                    <option value="<?= $val->id ?>" <?= ($record && $record->issue_id == $val->id) ? 'selected' : '' ?>><?= $val->issue_name ?></option>
                                <?php } ?>
                            </select>
                            <label>Issue Category <b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <select name="unit_id" class="form-control form-select">
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
                            <input name="contact_no" placeholder="Enter here" type="text" maxlength="11" class="form-control" value="<?= ($record) ? $record->contact_no : '' ?>" required>
                            <label>Contact #<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="form-group input-box">
                            <textarea name="description" id="" cols="30" rows="10" class="w-100" value="<?= ($record) ? $record->description : '' ?>"><?= ($record) ? $record->description : '' ?></textarea>
                            <label for="">Description</label>
                        </div>
                    </div>
                </div>
                <div>
                    <h1 class="text-black fw-bold">Attachments</h1>
                    <div class="form-group file-box">

                        <input type="file" class="form-control" name="attachments" id="file">
                        <label for="file"><span class="material-icons">download</span> Upload</label>
                        <span id="file-name">No file chosen</span>
                    </div>
                </div>
                <div class="d-flex gap-3 justify-content-end pt-5">
                    <button class="main-btn btn">Submit</button>
                    <button class="main-cancel btn-cancel btn" type="button">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {
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

    $('#file').on('change', function() {
        // Get the file name
        var fileName = this.files[0].name;
        // Set the file name element text to the file name
        $('#file-name').text(fileName);
    });

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
            beforeSend: function(){
                $('.btn').attr('disabled','disabled');
            },
            success: function(data) {
                console.log(data)

                // Handle the response data
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


    $(".btn-cancel").click(function() {
        location = '<?= WEB_ROOT . "/$module/" ?>';
    });
});
</script>