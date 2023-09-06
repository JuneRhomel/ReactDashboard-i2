<?php
include('../../library/shared.php');
include('layout/header.php');

$email = $password = $firstname = $lastname = "";
//$email="alfrigor@mailinator.com"; $password="123"; $firstname="alf"; $lastname="rigor";
?>
<div class="d-flex">
    <div class="signup-image ">
        <div class="logo">
            <!-- <img src="./assets/logo.png" alt=""> -->
        </div>
        <div class="img-container">
            <img src="./assets/Frame.png" alt="">

        </div>
    </div>
    <div class="form-signup">
        <div class="h-100">
            <a href="<?= WEB_ROOT ?>" class="d-flex gap-2 text-black fw-bold back ">
                <span class="material-icons">arrow_back</span> Back
            </a>
            <div class="d-flex aligin-item-center align-items-center mt-4 justify-content-center w-100">
                <img src="./assets/s-1.png" alt="">
            </div>
            <div class="d-flex gap-3 flex-column  mt-5">
                <b>*Please fill in all the fields.</b>
                <form action="<?= MAIN_URL ?>property_details.php" id="property_details" method="post" class="row">
                    <div class="col-6 mb-4">
                        <div class="input-box input-h">
                            <input name="email" type="email" placeholder="text" value="<?= $email ?>" required>
                            <label>Email*</label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h ">
                            <input name="password" type="password" placeholder="text" value="<?= $password ?>" required>
                            <label>Password*</label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h ">
                            <input name="firstname" type="firstname" placeholder="text" value="<?= $firstname ?>" required>
                            <label>First Name*</label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h ">
                            <input name="lastname" type="lastname" placeholder="text" value="<?= $lastname ?>" required>
                            <label>Last Name*</label>
                        </div>
                    </div>
                    <div>
                        <input type="checkbox" name="" required id="check" class="c1">
                        <label for="check" class="fw-bold">I agree to the <a href="">terms and conditions.</a> </label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="main-btn main-submit">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('.main-submit').click(function() {
        // Check if inputs and selects have values
        var isFormValid = true;
        $('.form-signup input[required], .form-signup select[required]').each(function() {
            if (!$(this).val()) {
                isFormValid = false;
                $(this).addClass('error');
                $(this).siblings('label').addClass('error-text')

            }
        });

        if (isFormValid) {
            $("#property_details").submit();
        } else {
            // Trigger HTML built-in validation pop-up for all elements
            $('.form-signup input[required], .form-signup select[required]').each(function() {
                this.reportValidity();
            });
        }
    });
</script>