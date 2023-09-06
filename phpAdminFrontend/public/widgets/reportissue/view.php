<?php
$module = "reportissue";
$table = "report_issue";
$view = "vw_report_issue";

$id = $args[0];
$result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
$record = json_decode($result);

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'list_residenttype', 'field' => 'residenttype']);
$resident_types = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'vw_reportissue_status', 'condition' => 'reportissue_id="' . $record->id . '"']);
$status_list = json_decode($result);
// var_dump($status_list);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'list_workpermitstatus',  'orderby' => 'status']);
$status_item = json_decode($result);
// var_dump($status_item);
?>
<style>
    .swal-wide {
        width: 850px !important;
    }

    table th,
    td {
        font-size: 15px;
        padding: 2px;
    }
</style>
<div class="row">
    <div class="col-9">
        <div class="py-4 ps-4 bg-gray">
            <div class="d-flex justify-content-between mb-3">
                <a onclick="location='<?= WEB_ROOT . "/$module/" ?>'"><label class="data-title" style="cursor:pointer;"><i class="fa-solid fa-arrow-left fa-sm"></i> Back</label></a>
                <div class="d-flex gap-3">
                    <?php if ($role_access->update == true) : ?>
                        <?php if ($record->status != 'Closed') { ?>

                            <a href='<?= WEB_ROOT . "/$module/form/$id" ?>'>
                                <button class="main-btn"> Edit </button>
                            </a>
                        <?php } ?>
                    <?php endif ?>
                </div>
            </div>

            <!-- DETAIL -->
            <table class="table table-bordered bg-white p-5" width="100%">
                <tr>
                    <td class="p-3 bold" width="30%">Status</td>
                    <td class="p-3" width="70%">
                        <?php
                        if ($record->status === "Open") {
                            echo '<div class="data-box-y">' . $record->status . '</div>';
                        } else if ($record->status === "Closed") {
                            echo '<div class="data-box-n">' . $record->status . '</div>';
                        } else {
                            echo '<div class="data-box-o">' . $record->status . '</div>';
                        }
                        ?>
                    </td>

                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Name</td>
                    <td class="p-3" width="70%"><?= $record->firstname . ' ' . $record->lastname  ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Unit</td>
                    <td class="p-3"><?= $record->location_name ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Issue</td>
                    <td class="p-3"><?= $record->issue_name ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Contact No.</td>
                    <td class="p-3"><?= $record->contact_no ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Description</td>
                    <td class="p-3"><?= $record->description ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Attachments</td>
                    <td class="p-3"><a target="_blank" class="view-text" href="<?= $record->attachments ?>">View</a> </td>
                </tr>
            </table>


            <div>
                <div class="d-flex justify-content-between my-4 mt-5">
                    <label class="data-title">Status</label>
                    <?php if ($role_access->update == true) : ?>
                        <?php if ($record->status != 'Closed') { ?>
                            <button class="main-btn w-auto px-3 update-status"> Add Update </button>
                        <?php } ?>
                    <?php endif ?>
                </div>
                <table class="table table-bordered  border-table bg-white">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <th>Updated By</th>
                            <th>Status</th>
                        </tr>
                        <?php foreach ($status_list as $status => $item) { ?>
                            <tr>
                                <td><?= $item->date_upload ?></td>
                                <?php if ($item->full_name) { ?>
                                    <td><?= $item->full_name ?></td>
                                <?php } else { ?>
                                    <td class="p-3"><?= $record->fullname ?></td>
                                <?php } ?>
                                <td><?= $item->status ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="bg-white border-2 rounded-lg p-3 me-3 comphofilecontainer"></div>
    </div>

    <div class="status-box">
        <div class="d-flex justify-content-end mt-1">
            <button class="text-end close border-0 bg-transparent">
                <span class="material-icons">
                    close
                </span>
            </button>

        </div>
        <form method="post" action="<?= WEB_ROOT; ?>/servicerequest/save?display=plain" id="form-main">
            <h1 class="text-center bold mb-5">Select Status</h1>
            <input name="reportissue_id" type="hidden" value="<?= decryptData($id) ?>">
            <input name="module" type="hidden" value="<?= $module ?>">
            <input name="table" type="hidden" value="reportissue_status">
            <div class=" ">
                <div class="input-box">
                    <select name="status_id" class="form-control form-select" required>
                        <option selected disabled>Choose</option>
                        <?php foreach ($status_item as $key => $val) {; ?>
                            <option value="<?= $val->id ?>" <?= ($record && $record->status_id == $val->id) ? 'selected' : '' ?>><?= $val->status ?></option>
                        <?php } ?>
                    </select>
                    <label> Status <b class="text-danger">*</b></label>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button class="main-btn">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('.status-box').hide();
    $(document).ready(function() {

        $(".btn-add-contract").click(function() {
            location = '<?= WEB_ROOT . "/contract/form/?resident_id={$record->id}&unit_id={$record->unit_id}" ?>';
        });

        $('.close').click(function() {
            $('.status-box').hide();
        });
        $('.update-status').click(function() {
            $('.status-box').show();
        });


        $("#form-main").off('submit').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(data) {
                    console.log(data)
                    formstatus(data.id)
                    popup({
                        data: data,
                        reload_time: 2000,
                        redirect: location.href
                    })

                },
            });
        });

        const formstatus = (id) => {
            const data = {
                id: <?= decryptData($id) ?>,
                status_id: id,
                table: 'report_issue',
                module: 'reportissue',
            }
            $.ajax({
                url: "<?= WEB_ROOT; ?>/servicerequest/save?display=plain",
                method: 'POST',
                data: data,
                success: function(data) {
                    console.log(data)
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        $.ajax({
            url: '<?= WEB_ROOT; ?>/comphofile/widget?reference=<?= $id ?>&source=<?= $table ?>&display=plain',
            type: 'GET',
            data: $(this).serialize(),
            dataType: 'html',
            beforeSend: function() {},
            success: function(data) {
                $(".comphofilecontainer").html(data);
            },
            complete: function() {},
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    });
</script>