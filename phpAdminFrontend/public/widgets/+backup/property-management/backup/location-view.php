<?php
$menu = "property-management";
$module = "location";
$table = "locations";
$view = "vw_locations";
$id = $args[0];

$data = [ 'id'=>$id, 'view'=>$view ];
$record_result = $ots->execute('property-management', 'get-record', $data);
$record = json_decode($record_result);

$data = [ 'reference_id'=>$id, 'reference_table'=>$table ];
$attachments = $ots->execute('files', 'get-attachments', $data);
$attachments = json_decode($attachments);

$data = [ 'rec_id'=>$id, 'table'=>$module.'_updates' ];
$comments = $ots->execute('property-management', 'get-updates', $data);
$comments = json_decode($comments);

$role_access = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($role_access);
?>
<style>
    .swal-wide { width: 850px !important; }
</style>
<div class="row">
    <div class="col-9">
        <div class="py-4 ps-4 bg-gray">
            <div class="d-flex justify-content-between mb-3">
                <a onclick="location='<?=WEB_ROOT."/$menu/$module"?>'"><label class="data-title" style="cursor:pointer;"><i class="fa-solid fa-arrow-left fa-sm"></i> <?=$record->location_name?></label></a>
                <?php if ($role_access->update==true): ?>
                    <a href='<?=WEB_ROOT."/$menu/{$module}-form/$id/Edit"?>'>
                        <button class="main-btn"> Edit </button>
                    </a>
                <?php endif ?>
            </div>

            <!-- DETAIL -->
            <table class="table table-data table-bordered property-management border-table bg-white">
                <tr>
                    <th>Location Type</th>
                    <td><?=$record->location_type?></td>
                </tr>
                <tr>
                    <th>Location Use</th>
                    <td><?=$record->location_use?></td>
                </tr>
                <tr>
                    <th>Parent Location</th>
                    <td><?=$record->parent_location_name?></td>
                </tr>
                <tr>
                    <th>Floor Area</th>
                    <td><?=$record->floor_area?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?=$record->location_status?></td>
                </tr>
            </table>

            <!-- ATTACHMENT -->
            <div>
                <div class="d-flex justify-content-between my-4 mt-5">
                    <label class="data-title">Attachments</label>
                    <?php if ($role_access->upload==true) :?>
                        <button class='main-btn' onclick="show_modal_upload(this)" update-table='<?=$module?>_updates' reference-table='<?=$table?>' reference-id='<?=$id?>' id='<?=$id?>'>Upload</button>
                    <?php endif?>
                </div>
                <?php 
                if (!$attachments) {
                    echo "<div class='p-3 bg-white'>No record found.</div>";
                } else {
                ?>
                <table class="table table-data table-bordered property-management border-table bg-white">
                    <tr>
                        <th>Created By</th>
                        <th>Document</th>
                        <th>Description</th>
                        <th>Date Created</th>
                    </tr>
                    <?php foreach ($attachments as $attachment) { ?>
                        <tr>
                            <td><?=$attachment->created_by_fullname?></td>
                            <td><a href='<?=$attachment->attachment_url?>'><?=$attachment->filename?></a></td>
                            <td><?=$attachment->description?></td>
                            <td><?=formatDateTimeUnix($attachment->created_on)?></td>
                        </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>

            <!-- COMMENTS AND UPDATES -->
            <div>
                <div class="d-flex justify-content-between my-4 mt-5">
                    <label class="data-title">Comments And Updates</label>
                    <?php if ($role_access->comment==true) :?>
                        <button class='main-btn' onclick="show_modal_update(this)" update-table='<?=$module?>_updates' reference-table='<?=$table?>' reference-id='<?=$id?>' id='<?=$id?>'>Add</button>
                    <?php endif?>
                </div>
                <?php 
                if (!$comments) {
                    echo "<div class='p-3 bg-white'>No record found.</div>";
                } else {
                ?>
                <table class="table table-data table-bordered property-management border-table">
                    <table class="table table-data table-bordered property-management border-table">
                        <tr>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Date and Time Created</th>
                        </tr>
                        <?php foreach ($comments as $comment) { ?>
                            <tr>
                                <td><?=$comment->created_by_fullname?></td>
                                <td><?=$comment->comment?></td>
                                <td><?=formatDateTimeUnix($comment->created_on)?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </table>
                <?php } ?>
            </div>

            <!-- <span class="heading-text" style='font-size:20px'>History</span>
            <table class="table table-data table-bordered property-management border-table">
                <table class="table table-data table-bordered property-management border-table">
                    <tr>
                        <th>Edited By</th>
                        <th>Stage</th>
                        <th>Description</th>
                        <th>Date and Time Created</th>
                    </tr>
                    <?php

                    foreach ($stages as $stage) {
                   ?>
                        <tr>
                            <td><?=$stage->created_by_full_name?></td>
                            <td><?=$stage->stage?></td>
                            <td><?=$stage->comment?></td>
                            <td><?=date('Y-m-d h:i:s', $stage->created_on)?></td>
                        </tr>
                    <?php
                    }
                   ?>
                </table>
            </table> -->

            <div class="btn-group-buttons pull-right mt-5">
                <div class="d-flex flex-row-reverse">
                    <button type="button" class="main-btn" onclick="location='<?=WEB_ROOT.'/'.$menu.'/'.$module?>'">Back</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="bg-white border-2 rounded-lg p-3 me-3 comphofilecontainer"></div>
    </div>
</div>
<!-- COMMENT MODAL -->
<div class="modal" tabindex="-1" role="dialog" id='update'>
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content px-1 pb-4 pt-2">
            <div class="modal-header flex-row-reverse pb-0" style="border-bottom: 0px;">
                <!-- <h5 class="modal-title">Update Stage</h5> -->
                <button type="button" class="btn-close" data-dismiss="modal" onclick='$("#update").modal("hide")' aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <h3 class="modal-title text-primary align-center text-center mb-3">Comments and Updates</h3>
                <form action="<?=WEB_ROOT?>/property-management/update-comment?display=plain" method="post" id="form-comment" enctype="multipart/form-data">
                    <input name="table" type="hidden" value="<?=$table?>_updates">
                    <input name="rec_id" type="hidden" value="<?=$id?>">
                    <div class="col-12 my-4">
                        <label for="" class="text-required">Name <span class="text-danger">*</span></label>
                        <input  name="created_by_name" type="text" class="form-control" value="<?=$user->full_name?>" readonly>
                    </div>
                    <div class="col-12 my-4">
                        <label for="comments" class="text-required">Comments <span class="text-danger">*</span></label>
                        <textarea name="comment" id="" class="form-control" style="heigth: 100%" required>test</textarea>
                    </div>
                    <div class="d-flex justify-content-center gap-4 w-100">
                        <button type="submiit" class="btn btn-primary px-5">Submit</button>
                        <button class="btn btn-light btn-cancel px-5" onclick="$("#update").modal("hide")">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SUCCESS UPLOAD MODAL -->
<template id="upload-modal-success">
    <swal-html>
        <div class="p-5">
            <h4 class="text-primary">Upload Complete</h4>
            <p class="text-primary" style="font-size:12px">Congrats! Your upload successfully done.</p>
            <button class="btn btn-sm btn-primary w-50 close-swal" onclick="closeSwal();">View</button>
        </div>
    </swal-html>
    <swal-param name="allowEscapeKey" value="false" />
</template>

<!-- ERROR UPLOAD MODAL -->
<template id="upload-modal-error">
    <swal-html>
        <div class="p-5">
            <h4 class="text-primary">Upload Error</h4>
            <p class="text-primary" style="font-size:12px">Sorry! Something went wrong.</p>
            <button class="btn btn-sm btn-danger w-50 close-swal" onclick="closeSwal();">Try Again</button>
        </div>
    </swal-html>
    <swal-param name="allowEscapeKey" value="false" />
</template>

<script>
    function show_modal_update(button_data) {
        $('#update').modal('show');
        reference_table = $(button_data).attr('reference-table');
        reference_id = $(button_data).attr('reference-id');
        update_table = $(button_data).attr('update-table');

        $("#upload #reference_table").val(reference_table);
        $("#upload #update_table").val(update_table);
        $("#upload #reference_id").val(reference_id);
    }

    function show_modal_upload_message_success() {
        Swal.fire({
            title: "INFORMATION",
            text: "File uploaded",
            icon: "success",
            timer: 3000
        }).then((result) => {
            location = "<?=WEB_ROOT."/$menu/$module-view/$id"?>";
        });

        /*Swal.fire({
            template: '#upload-modal-success',
            showCloseButton: true,
            showConfirmButton: false,
            width: '580px'
        })*/
    }

    function show_modal_upload_message_err() {
        Swal.fire({
            template: '#upload-modal-error',
            showCloseButton: true,
            showConfirmButton: false,
            width: '580px'
        })
    }
</script>

<script>
$(document).ready(function() {
    $('#datepicker').datepicker({
        format: 'yy-mm-d',
        timepicker: false,
        minDate: '+1D',
    });

    $('#datepicker1').datepicker({
        format: 'yy-mm-d',
        timepicker: false,
        minDate: '+1D',
    });

    $("input[id=parent_location]").autocomplete({
        autoSelect: true,
        autoFocus: true,
        search: function(event, ui) {
            $('.spinner').show();
        },
        response: function(event, ui) {
            $('.spinner').hide();
        },
        source: function(request, response) {
            $.ajax({
                url: '<?=WEB_ROOT?>/location/search?display=plain',
                dataType: "json",
                type: 'post',
                data: {
                    term: request.term,
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {

            $(event.target).prev().val(ui.item.value);
            $(event.target).val(ui.item.label);

            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
                $(event.target).prev('input').val(0);
            }
        }
    });

    $("select[name=location_type]").on('change', function() {
        if ($(this).val().toLowerCase() == 'property') {
            $(".location-container").addClass('d-none');
            $("input[name=parent_location]").val('');
            $("#parent_location_id").val(0);
        } else {
            $(".location-container").removeClass('d-none');
        }
    });

    $('#file').change(function() {
        var file = $('#file')[0].files[0].name;
        $('#upload_label').text(file);
    });

    $("#form-comment").off('submit').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data){                    
                if(data.success == 1) {
                    Swal.fire({
                        title: "INFORMATION",
                        text: data.description,
                        icon: "success",
                        timer: 3000
                    }).then((result) => {
                        location.reload();
                    });
                }   
            },
        });
    });

    $.ajax({
        url: '<?=WEB_ROOT;?>/comphofile/widget?reference=<?=$id;?>&source=locations&display=plain',
        type: 'GET',
        data: $(this).serialize(),
        dataType: 'html',
        beforeSend: function(){},
        success: function(data){
            $(".comphofilecontainer").html(data);
        },
        complete: function(){},
        error: function(jqXHR, textStatus, errorThrown){}
    });
});
</script>