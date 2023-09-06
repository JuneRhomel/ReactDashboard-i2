<?php
$module = "visitorpass";
$table = "visitorpass";
$view = "vw_visitor_pass";

$id = $args[0];
$result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
$record = json_decode($result);
// var_dump($record->id);


$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);
// var_dump($role_access);
$result =  $ots->execute('module', 'get-listnew', ['table' => 'list_residenttype', 'field' => 'residenttype']);
$resident_types = json_decode($result);

$result =  $ots->execute('module', 'get-listnew', ['table' => 'vp_guest', 'condition' => 'guest_id="' . $record->id . '"',]);
$guest_list = json_decode($result);
// var_dump($guest_list);
$result =  $ots->execute('module', 'get-listnew', ['table' => 'gatepass_personnel', 'condition' => 'id="' . $record->gp_personnel_id . '"']);
$personel = json_decode($result);
// var_dump($personel)
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
                <a onclick="location='<?= WEB_ROOT . "/$module/" ?>'"><label class="data-title" style="cursor:pointer;"><i class="fa-solid fa-arrow-left fa-sm"></i> <?= $record->fullname ?></label></a>
                <?php if ($role_access->update == true) : ?>
                    <?php if ($record->status === 'Pending') { ?>

                        <a href='<?= WEB_ROOT . "/$module/form/$id" ?>'>
                            <button class="main-btn"> Edit </button>
                        </a>
                    <?php } ?>
                <?php endif ?>
            </div>

            <!-- DETAIL -->
            <table class="table table-bordered bg-white p-5" width="100%">
            <tr>
                    <td class="p-3 bold" width="30%">Status</td>
                    <td class="p-3" width="70%"> <?php
                        if ($record->status === "Approved") {
                            echo '<div class="data-box-y">' . $record->status . '</div>';
                        } else if ($record->status === "Denied") {
                            echo '<div class="data-box-n">' . $record->status . '</div>';
                        } else {
                            echo '<div class="data-box-o">' . $record->status . '</div>';
                        }
                        ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Fullname</td>
                    <td class="p-3"><?= $record->fullname ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold" width="30%">Unit</td>
                    <td class="p-3" width="70%"><?= $record->location_name ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Contact Number</td>
                    <td class="p-3"><?= $record->contact_no ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Arrival Date </td>
                    <td class="p-3"><?= $record->arrival_date ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Arrival Time</td>
                    <td class="p-3"><?= $record->arrival_time ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Departure Date</td>
                    <td class="p-3"><?= $record->departure_date ?></td>
                </tr>
                <tr>
                    <td class="p-3 bold">Departure Time</td>
                    <td class="p-3"><?= $record->departure_time ?></td>
                </tr>
            </table>

            <div>
                <div class="d-flex justify-content-between my-4 mt-5">
                    <label class="data-title">Guest</label>
                    <!-- <button class="main-btn btn-add-contract">Add</button> -->
                </div>
                <?php
                if (!$guest_list) {
                    echo "<div class='p-3 bg-white'>No record found.</div>";
                } else {
                ?>
                    <table class="table table-bordered  border-table bg-white">
                        <tr>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Vist Purpose</th>
                        </tr>
                        <?php foreach ($guest_list as $val) { ?>
                            <tr>
                                <td><?= $val->guest_name ?></td>
                                <td><?= $val->guest_no ?></td>
                                <td><?= $val->guest_purpose ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </div>

            <div class="btn-group-buttons pull-right mt-5">
                <div class="d-flex flex-row-start">
                    <button type="button" class="main-btn" onclick="location='<?= WEB_ROOT . "/$module/" ?>'">Back</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="bg-white border-2 rounded-lg p-3 me-3 comphofilecontainer"></div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".btn-add-contract").click(function() {
            location = '<?= WEB_ROOT . "/contract/form/?resident_id={$record->id}&unit_id={$record->unit_id}" ?>';
        });

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