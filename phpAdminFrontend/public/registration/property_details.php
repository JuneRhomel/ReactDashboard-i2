<?php
include('../../library/shared.php');
include('layout/header.php');

$property_name = $property_size = $property_type = $property_address = "";
//$property_name="Rising Phoenix Building"; $property_size=55000; $property_address="555 Makati Ave., Makati City, Metro Manila"; $selected="selected";
?>
<div class="d-flex ">
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
            <a href="<?= MAIN_URL ?>" class="d-flex gap-2 text-black fw-bold back ">
                <span class="material-icons">arrow_back</span> Back
            </a>
            <div class="d-flex aligin-item-center align-items-center mt-4 justify-content-center w-100">
                <img src="./assets/s-2.png" alt="">
            </div>
            <div class="d-flex gap-3 flex-column  mt-5">
                <b>*Please fill in all the fields.</b>
                <form action="<?= MAIN_URL ?>subscriptions.php" id="subscriptions" method="post" class="row">
                    <input name="email" type="hidden" value="<?= initObj('email') ?>">
                    <input name="password" type="hidden" value="<?= initObj('password') ?>">
                    <input name="firstname" type="hidden" value="<?= initObj('firstname') ?>">
                    <input name="lastname" type="hidden" value="<?= initObj('lastname') ?>">
                    <div class="col-12 mb-4">
                        <div class="input-box input-h">
                            <input name="property_name" type="text" placeholder="text" value="<?= $property_name ?>" required>
                            <label for="">Property Name*</label>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="input-box input-h">
                            <input name="property_address" type="text" placeholder="text" value="<?= $property_address ?>" required>
                            <label for="">Address</label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h">
                            <input name="property_size" type="number" placeholder="text" value="<?= $property_size ?>" required>
                            <label for="">Property Size*</label>
                        </div>

                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h">
                            <select name="property_type" required>
                                <option value="" disabled selected></option>
                                <option value="Residential" <?= $selected ?>>Residential</option>
                                <option value="Office">Office</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Mixed Used">Mixed Used</option>
                                <option value="Other">Other</option>
                            </select>
                            <label for="">Property Type*</label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h">
                            <select name="ownership" required>
                                <option value="" disabled selected></option>
                                <option value="SO" <?= $selected ?>>Single Owner or Entity</option>
                                <option value="HOA">Homeowners Association (HOA)</option>
                            </select>
                            <label for="">Ownership*</label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h">
                            <select name="user_role" required>
                                <option value="" disabled selected></option>
                                <option value="1" <?= $selected ?>>Owner</option>
                                <option value="2">Property Manager</option>
                            </select>
                            <label for="">User Role*</label>
                        </div>
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
    $('select[name="ownership"]').on("change", function(e) {
        if ($(this).val() === 'HOA') {
            $('option[value="1"]').hide()
            $('option[value="2"]').show()
            $('option[value="2"]').attr("selected", "selected")
            $('option[value="1"]').removeAttr("selected", "selected")
        } else{
            $('option[value="2"]').hide()
            $('option[value="1"]').show()
            $('option[value="1"]').attr("selected", "selected")
            $('option[value="2"]').removeAttr("selected", "selected")
        }
    })
    if ($('select[name="ownership"]').val() === 'HOA') {
            $('option[value="1"]').hide()
            $('option[value="2"]').show()
            $('option[value="2"]').attr("selected", "selected")
            $('option[value="1"]').removeAttr("selected", "selected")
        } else{
            $('option[value="2"]').hide()
            $('option[value="1"]').show()
            $('option[value="1"]').attr("selected", "selected")
            $('option[value="2"]').removeAttr("selected", "selected")
        }
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
            $("#subscriptions").submit();
        } else {
            // Trigger HTML built-in validation pop-up for all elements
            $('.form-signup input[required], .form-signup select[required]').each(function() {
                this.reportValidity();
            });
        }
    });
</script>