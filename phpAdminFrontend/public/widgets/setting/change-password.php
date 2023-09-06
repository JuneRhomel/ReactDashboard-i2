<form action="<?= WEB_ROOT ?>/setting/save?display=plain" method='post' id="tr-add" class="">
    <div class="main-container">
        <input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/setting/edit-profile'>
        <input type="hidden" name='process' value='change_pass'>
        <input type="hidden" name='id' value="<?= $user->id; ?>">
        <div class="pt-4 position-relative w-50">
            <div id="password_error" class=" position-absolute top-0" style=" z-index: 2;display: none; color: red;"> <b>Passwords do not match.</b></div>
            <form action="">
                <div class="row  gap-xl-0">
                    <div class="col-6 mb-3">
                        <div class="form-group input-box">
                            <input type="password" class="form-control" name="new_password" id="new_password">
                            <label for="new_password">New Password</label>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="form-group input-box">
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                            <label for="confirm_password">Confirm New Password</label>
                        </div>
                    </div>

                    <div class="col-12  mb-3">
                        <div class="form-group input-box">
                            <input type="password" class="form-control" name="old_password">
                            <label for="">Old Password</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-start gap-3 mt-4">
                    <button class="main-btn">Save</button>
                    <!-- <button class="main-cancel">Cancel</button> -->
                </div>
            </form>
        </div>
    </div>
</form>
<template id="complete-signup-modal">
    <swal-html>
        <div class="p-5">
            <div class="text-center ">
                <span class="material-icons icon-sign" style="color:#FF6B6B;font-size:30px">
                    error
                </span>
            </div>
            <h4 class="error-description">New Password and Confirm Password Not Match</h4>
            <p style="font-size:15px " class="description">
                Please Try Again
            </p>
            <div class="d-flex justify-content-center">
                <button class="main-btn w-50 close-swal " onclick="closeSwal();">Ok</button>

            </div>
        </div>
        <swal-param name="allowEscapeKey" value="false" />
</template>

<?php
?>

<script>
    $(document).ready(function() {

        // confirmPassInput.on('input', validatePasswords);
        function showSignupModal(data) {
            const template = $('#complete-signup-modal');
            const templateContent = template.html();
            console.log(data.description);
            Swal.fire({
                html: templateContent,
                showConfirmButton: false,
                allowEscapeKey: false,
                timer: 5000, // Redirect after 5 seconds
                willClose: () => {
                    // Perform any necessary actions upon modal closing
                    // e.g., redirect to login page if data.success is 1
                    if (data.success === 1) {
                        window.location.href = '/auth/logout';
                    }
                }
            });
        }


        function closeSwal() {
            Swal.close();
        }

        $("#tr-add").off('submit').on('submit', function(e) {
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
                    showSignupModal(data);
                    console.log(data)
                    if (data.success === 0) {
                        $('.error-description').text(data.description);
                    } else {
                        $('.error-description').text('Change Password Successfully');
                        $('.description').text('You will be automatically log out');
                        $('.icon-sign').css('color', '#28A745')
                        $('.icon-sign').text('check_circle')
                    }
                },
                complete: function() {

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });

    });
</script>