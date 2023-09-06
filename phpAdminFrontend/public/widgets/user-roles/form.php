<?php
$module = "user-roles";
$table = "_roles";
$view = "_roles";

$id = $args[0];
if ($id != "") {
    $result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
    $record = json_decode($result);
}
$result = $ots->execute('module', 'get-ownership', []);
$ownership = json_decode($result);

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);


// foreach ($name as $key => $val) { 
// 	var_dump($val->id);
// 	var_dump($val->fullname);
// }
?>
<div class="main-container">
<a href="<?= WEB_ROOT . '/' . $module . '/' ?>" class="back">
            <span class="material-icons">
                arrow_back
            </span>
            Back
        </a>
    <div class="mt-2 mb-4"><h1 class="text-black mt-3 fw-bold"><?= ($id == '') ? 'Add' : 'Edit'; ?> <?= $page_title ?></h1>   
    <div class="grid lg:grid-cols-1 grid-cols-1 title">
        <div class="rounded-sm">
            <form method="post" action="<?= WEB_ROOT; ?>/module/save?display=plain" id="form-main">
            <input type="hidden" name="ownership" value="<?= $ownership ?>">
                <div class="row forms">
                    <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                            <input name="role_name" type="text" class="form-control" value="<?= ($record) ? $record->role_name : '' ?>" required>
                            <label for="" class="text-required">Role Name <span class="text-danger">*</span></label>
                        </div>
                    </div>

                    <!-- <div class="col-12 col-sm-4 my-4">
                        <div class="form-group input-box">
                            <label for="" class="text-required">Role Description</label>
                            <input name="description" type="text" value="<?= ($record) ? $record->description : '' ?>" class="form-control">
                        </div>
                    </div> -->
                    <div class="d-flex gap-3 justify-content-start">
                        <button class="main-btn">Submit</button>
                        <button type="button" class="main-cancel btn-cancel">Cancel</button>
                    </div>
                    <input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>">
                    <input name="module" type="hidden" value="<?= $module ?>">
                    <input name="table" type="hidden" value="<?= $table ?>">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#form-main").off('submit').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
					$('.main-btn').attr('disabled', 'disabled');
				},
                success: function(data) {
                    console.log(data)
					popup({
                        data: data,
                        reload_time: 2000,
                        redirect: "<?= WEB_ROOT . "/$module/" ?>"
                    })
                   
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown)
                }
            });
        });

        $(".btn-cancel").click(function() {
            location = '<?= WEB_ROOT . "/$module/" ?>';
        });
    });
</script>