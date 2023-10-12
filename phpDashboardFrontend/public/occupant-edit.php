<?php
require_once('header.php');
include("footerheader.php");
$module = "resident";
$table = "resident";
$view = "vw_resident";

$location_menu = 'occupant';

$data = [
    'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);

// var_dump($user->unit_id);


$id = decryptData($_GET['id']);
// echo $id;
$result = apiSend('module', 'get-listnew', ['table' => 'vw_resident', 'condition' => 'id="' . $id . '"']);
$resident = json_decode($result);

$result = apiSend('module', 'get-listnew', ['table' => 'list_residentstatus', 'field' => 'residentstatus']);
$list_residentstatus = json_decode($result);


$result = apiSend('module', 'get-listnew', ['table' => 'vw_location','condition' => 'id="' .$user->unit_id . '"']);
$unit = json_decode($result);

$result = apiSend('module', 'get-listnew', ['table' => 'vw_resident','condition' => 'type="Tenant"']);
$occupied = json_decode($result);
// var_dump($occupied);



// var_dump($resident);
?>
<div class="d-flex">


    <div class="main">
        <?php include("navigation.php") ?>

        <div class="d-flex align-items-center px-3">
            <button class="back-button-sr cancel" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Back</label>
        </div>
        <div style="padding: 24px 25px 100px 25px;">
            <div class="px-3 py-3 " style="background-color: #FFFFFF; border-radius: 5px;">

                <form action="<?= WEB_ROOT; ?>/save.php" id="form-main" method="post" class="d-flex py-2 gap-4 flex-wrap">
                    <input name="id" type="hidden" value="<?= $resident[0]->id ?>">
                    <input name="module" type="hidden" value="<?= $module ?>">
                    <input name="table" type="hidden" value="<?= $table ?>">
             

                    <div class="col-12 px-0">
                        <input id="my-profile" name="first_name" type="text" value="<?= ($resident) ? $resident[0]->first_name : '' ?>" required>
                        <label id="my-profile">First Name</label>
                    </div>
                    <div class="col-12 px-0">
                        <input id="my-profile" name="last_name" type="text" value="<?= ($resident) ? $resident[0]->last_name : '' ?>" required>
                        <label id="my-profile">Last Name</label>
                    </div>
                    <div class="col-12 px-0">
                        <input id="my-profile" name="contact_no" type="text" value="<?= ($resident) ? $resident[0]->contact_no : '' ?>" required>
                        <label id="my-profile">Mobile Number</label>
                    </div>
                    <div class="col-12 px-0">
                        <input id="my-profile" disabled name="email" type="text" value="<?= ($resident) ? $resident[0]->email : '' ?>" required>
                        <label id="my-profile">Email</label>
                    </div>
                    <div class="col-12 px-0">
                        <input id="my-profile" disabled name="unit" aria-disabled="" type="text" value="<?= ($resident) ? $resident[0]->unit_name : '' ?>" required>
                        <label id="my-profile">Unit</label>
                    </div>
                    <div class="col-12 px-0">
                        <div class="w-100 form-group select">
                            <select name="status" class="select-text" required="">
                                <option value="" disabled="" selected=""></option>
                                <?php
                                foreach($list_residentstatus as $key=>$val) {
                                ?>
                               	<option 
                                <?=($resident && $resident[0]->status==$val) ? 'selected':''?>
                                ><?=$val?></option>
                                <?php } ?>
                               
                            </select>
                            <label class="select-label">Status</label>
                        
                        </div>
                    </div>
                    <!-- <div class="col-12 px-0">
						<input class="password" id="my-profile" name="password" type="password" required>
						<label id="my-profile">Old Password</label>
						<i class="bi bi-eye-slash" id="eye-icon"></i>
					</div> -->
                    <div class="btn-container-profile">
                        <button class="btn-profile-edit submit px-5 py-2 w-100" type="submit" id="registration-buttons">Submit</button>
                        <button class="btn-profile-edit cancel px-5 py-2 w-100" type="button" id="registration-buttons-cancel">Cancel</button>
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

    // Function to handle form submission
    $("#form-main").submit(function(e) {
            e.preventDefault();
            console.log(e)
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(res) {
                    const data = JSON.parse(res)
                    console.log(data)
                    if (data.success == 1) {
                        Swal.fire({
                            title: 'Success',
                            text: data.description, // Add your description here
                            icon: 'success', // Change to 'error', 'warning', 'info', etc. for different icons
                            showCancelButton: false,
                            confirmButtonClass: 'main-btn', // Apply Bootstrap button class
                            confirmButtonText: 'OK',
                            allowOutsideClick: false, // Prevent closing on clicking outside the dialog
                            allowEscapeKey: false, // Prevent closing on pressing Esc key
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?=WEB_ROOT ?>/occupant.php';
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.description, // Add your description here
                            icon: 'error', // Change to 'error', 'warning', 'info', etc. for different icons
                            showCancelButton: false,
                            confirmButtonClass: 'main-btn', // Apply Bootstrap button class
                            confirmButtonText: 'OK',
                            allowOutsideClick: false, // Prevent closing on clicking outside the dialog
                            allowEscapeKey: false, // Prevent closing on pressing Esc key
                        });
                    }
                },
            });
        
    })

    $('.cancel').on('click', function() {
        window.location.href = '<?=WEB_ROOT ?>/occupant.php';
    });
</script>