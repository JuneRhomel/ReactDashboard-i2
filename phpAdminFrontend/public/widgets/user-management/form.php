<?php
$module = "user-management";
$table = "_users";
$view = "_user";
$role_view = "_roles";

$id = $args[0];
if ($id != "") {
    $title = "User Management";
    $module = "user-management";
    $table = "_users";
    $view = "vw_users";
    $role_view = "_roles";

    $result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
    $record = json_decode($result);
}
// var_dump($record);

$user = $ots->execute('property-management', 'get-record',['view' => 'users']);
$user = json_decode($user);
$email = $user->email;


$account_code = $ots->execute('user-management', 'get-account',['view' => 'accounts', 'username' => $email] );
$account_code = json_decode($account_code);
// var_dump($account_code[0]->account);


$result = $ots->execute('admin', 'get-role', ['view' => $role_view]);
$roles = json_decode($result)->data;
// var_dump($roles);
$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

?>
<div class="main-container">
<a href="<?= WEB_ROOT . '/' . $module . '/' ?>" class="back">
            <span class="material-icons">
                arrow_back
            </span>
            Back
        </a>
    <div class="mt-2 mb-4"><h1 class="text-black mt-3 fw-bold"><?= ($id == '') ? 'Add' : 'Edit'; ?> <?= $page_title ?></h1>   
    <h1 class="text-black fw-bold mt-2">*Please fill in the required field </h1></div>
    <div class="grid lg:grid-cols-1 grid-cols-1 title">
        <div class="rounded-sm">
            <form method="post" action="<?= WEB_ROOT; ?>/user-management/account-save?display=plain" id="form-main">
                <div class="row forms">
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="email" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->email : '' ?>" <?= ($record) ? 'readonly' : '' ?> required>
                            <label>Email<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="first_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->firstname : '' ?>" required>
                            <label>First Name<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="last_name" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->lastname : '' ?>" required>
                            <label>Last Name<b class="text-danger">*</b></label>
                        </div>
                    </div>
                    <?php if (!($record)) : ?>
                        <div class="col-12 col-sm-4 mb-3">
                            <div class="form-group input-box">
                                <input name="password" placeholder="Enter here" type="password" class="form-control" value="<?= ($record) ? $record->check_no : '' ?>" required>
                                <label>Password<b class="text-danger">*</b></label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="input-box">
                            <select name="role_type" id="role_id">
                                <option value="" selected disabled>Select</option>
                                <?php foreach ($roles  as $key => $val) {; ?>
                                    <option value="<?= $val->id ?>" <?= ($record && $record->role_type == $val->id) ? 'selected' : '' ?>><?= $val->role_name ?></option>
                                    <!-- <option value="<?= $role->id ?>"><?= $role->role_name ?></option> -->
                                <?php } ?>
                            </select>
                            <label class="capitalize bold " style="text-transform: capitalize" for="role">Role</label>
                        </div>
                    </div>
                    <?php if ($record) : ?>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="input-box">
                            <select name="is_active" id="status">
                                <option value="" selected disabled>Select</option>
                                <option value="1" <?= $record->is_active === '1' ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= $record->is_active === '0' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                            <label class="capitalize bold " style="text-transform: capitalize" for="">Status</label>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="col-12 col-sm-4 mb-6"></div>
                    <div class="d-flex gap-3 justify-content-end">
                        <button class=" main-btn">Save</button>
                        <?php if (!$record) : ?>
                        <button type="button" class="main-cancel btn-cancel">Cancel</button>
                        <?php endif; ?>
                    </div>
                    <input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>">
                    <input name="account_code" type="hidden" value="<?= $account_code[0]->account ?>">
                    <input name="module" type="hidden" value="<?= $module ?>">
                    <input name="table" type="hidden" value="<?= $table ?>">
                </div>
            </form>
        </div>
    </div>

    <?php if ($record) : ?>
        <div class="mt-5">
            <h1>Change Password</h1>

            <form method="post" action="<?= WEB_ROOT; ?>/user-management/change-pass?display=plain" id="change_pass">
                <div class="row forms">
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="new_password" placeholder="Enter here" type="password" class="form-control" required>
                            <label>New Password<b class="text-danger">*</b></label>
                            <div class="invalid-feedback">Please enter a new password.</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-3">
                        <div class="form-group input-box">
                            <input name="retype_password" placeholder="Enter here" type="password" class="form-control" required >
                            <label>Retype Password<b class="text-danger">*</b></label>
                            <div class="invalid-feedback">Please retype the password.</div>
                        </div>
                    </div>


                    <div class="col-12 col-sm-4 mb-6"></div>
                    <div class="d-flex gap-3 justify-content-between">
                        <button class=" main-btn w-auto px-3">Change Password</button>
                        <button type="button" class="main-cancel btn-cancel">Cancel</button>
                    </div>
                    <input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>">
                    
                    <input name="table" type="hidden" value="<?= $table ?>">
                </div>
            </form>
        </div>
    <?php endif; ?>
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
        $("#change_pass").off('submit').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
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