$providers = get_providers($ots);
<?php

if ($providers == null) {
    $missing = 1;
    $title = 'Data are mising';
    $next_url = WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders";
    $html = "Service Provider are missing<br><a href=\'" . WEB_ROOT . "/property-management/serviceprovider?submenuid=serviceproviders\' class=\'button\'>Add Service Provider</a>";
}

if ($missing) {
?>
    <script>
        Swal.fire({
            title: "<?= $title ?>",
            isDismissed: false,
            confirmButtonText: 'Yes',
            html: '<?= $html ?>',
            allowOutsideClick: false
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = "<?= $next_url ?>";
            }
        })
    </script>
<?php
}
//PERMISSIONS
//get user role
$data = [
    'view' => 'users'
];
$user = $ots->execute('property-management', 'get-record', $data);
$user = json_decode($user);

//check if has access
$data = [
    'role_id' => $user->role_type,
    'table' => 'import_equipment',
    'view' => 'role_rights'

];
$role_access = $ots->execute('form', 'get-role-access', $data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>
<div class="main-container">

    <?php if ($role_access->read != true) : ?>
        <div class="card mx-auto" style="max-width: 30rem;">
            <div class="card-header bg-danger">
                Unauthorized access
            </div>
            <div class="card-body text-center">
                You are not allowed to access this resource. Please check with system administrator.
            </div>
        </div>
    <?php else : ?>
        <div id="error-container">

        </div>
        <h3 class='h3 p-4 h3-title'>Import Equipment</h3>
        <hr>

        <a href='<?php echo WEB_ROOT ?>/sample_excel/EquipmentTemplate.xlsx' class='btn btn-link'><i class='bi bi-download text-primary' style='font-size:20px'></i> Download Template</a>
        <?php
        // print_r($_SESSION);
        if ($_GET['error']) {
        ?>
            <div class="alert alert-warning" role="alert">
                <h5><?php echo $_GET['error'] ?></h5>
                <ul>
                    <?php
                    foreach ($_SESSION['excel_errors'] as $excel_errors) {
                        echo "<li>" . $excel_errors .  "</li>";
                    }
                    ?>
                </ul>
            </div>
        <?php
        }
        ?>
        <ol>
            <li>
                Download Template File
            </li>
            <li>
                Open Template In Excel
            </li>
            <li>
                Add Records
                <ul>
                    <li>Do Not Change The Headers (Row 1)</li>
                    <li> New Record Starts At Row 2 </li>
                </ul>
            </li>
            <li>Save File As Csv 5. Upload The File</li>
        </ol>
        <hr>

        <form action="<?php echo WEB_ROOT ?>/admin/read-excel?display=plain" class='ml-3' method="post" id="import-equipment" enctype="multipart/form-data">
            <!-- default table  -->
            <input type="hidden" name="table" value='equipments'>
            <!-- table for views -->
            <input type="hidden" name="view_table" value='view_equipments'>
            <!-- table for updates -->


            <input type="hidden" name="redirect" value='<?php echo WEB_ROOT ?>/property-management/equipment?submenuid=equipment&menuid=propman'>
            <input type="hidden" name="error_redirect" value='<?php echo WEB_ROOT ?>/admin/import-equipments?submenuid=equipment'>
            <input type="hidden" name="sample">
            <div class="form-group">
                <p class="attachment-admin"> Attachment: </p>
                <input type="file" class="form-control-file inputfile" id="file-input" name="upload_file" required>
                <label class="inputfile-label" for="file-input">Choose a file</label>
            </div>
            <?php if ($role_access->upload == true) : ?>
                <button class='btn btn-primary mt-2 upload-admin-btn' type="submit">Upload Now</button>
            <?php endif; ?>
        </form>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function() {
        $("#import-equipment").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                dataType: 'JSON',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                beforeSend: function() {},
                success: function(data) {
                    if (data.success == 1) {
                        show_success_modal_upload($('input[name=redirect]').val());
                    } else {
                        $.each(data.excel_errors, function() {
                            errors = this;
                            // alert(errors);
                            $("#error-container").append("<li class='error-list'>" + errors + "</li>");
                        });

                    }
                },
                complete: function() {

                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        });
    });
</script>