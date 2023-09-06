<?php
require_once('header.php');
include("footerheader.php");
$location_menu = "billing";
$module = "soa";
$table = "soa";
$view = "vw_soa";


$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);


$id = decryptData($_GET['id']);

?>
<div class="d-flex">


    <div class="main">
        <?php include("navigation.php") ?>

        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr cancel" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Back</label>
        </div>
        <div style="padding: 24px 25px 100px 25px;">
            <div class="px-3 py-3 " style="background-color: #FFFFFF; border-radius: 5px;">
                <label class="title-section">Proof of Payment </label>
                <form action="<?= WEB_ROOT; ?>/save.php" id="form-main" method="post" class="d-flex py-2 gap-4 flex-wrap">
                    <input name="reference_id" type="hidden" value="<?= $id ?>">
                    <input name="module" type="hidden" value="<?= $module ?>">
                    <input name="table" type="hidden" value="photos">
                    <input name="reference_table" type="hidden" value="soa">


                    <div class="col-12 px-0">
                        <input id="my-profile" name="description" type="text" required>
                        <label id="my-profile">Payment Method</label>
                    </div>
                    <div class="input-repare-status input-box w-100">
                        <input type="file" id="file" name="attachments" class="request-upload" multiple>
                        <label for="file" class="file file-name"><span class="material-icons">upload_file</span>Attachment File/Photo</label>

                    </div>
                    <div class="col-12 px-0">
                        <div class="btn-container-profile">
                            <button class="btn-profile-edit submit px-5 py-2 w-100" type="submit" id="registration-buttons">Submit</button>
                            <button class="btn-profile-edit cancel px-5 py-2 w-100" type="button" id="registration-buttons-cancel">Cancel</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <?php include('menu.php') ?>
</div>
</body>

</html>
<script>
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

    // Function to handle form submission
    $("#form-main").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        const fileInput = $('#file').prop('files')[0];

        // Add the file input to the form data
        if (fileInput) {
            formData.append('attachments', fileInput);
        }

        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            data: formData,
            dataType: 'json', // 'JSON' should be 'json'
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            success: function(res) {
                popup({
                    data: res,
                    reload_time: 2000,
                    redirect: '<?=WEB_ROOT ?>/billing.php'
                })
            },
        });
    });


    $('.cancel').on('click', function() {
        window.location.href = 'http://portali2.sandbox.inventiproptech.com/billing.php';
    });
</script>