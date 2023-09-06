<?php
include('../../library/shared.php');
include('layout/header.php');
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
            <a href="<?= MAIN_URL ?>property_details.php" class="d-flex gap-2 text-black fw-bold back ">
                <span class="material-icons">arrow_back</span> Back
            </a>
            <div class="d-flex aligin-item-center align-items-center mt-4 justify-content-center w-100">
                <img src="./assets/s-3.png" alt="">
            </div>
            <div class="d-flex gap-5 flex-column  mt-5">
                <form id="frm" method="post" action="<?= MAIN_URL; ?>save.php">
                    <input name="email" type="hidden" value="<?= initObj('email') ?>">
                    <input name="password" type="hidden" value="<?= initObj('password') ?>">
                    <input name="firstname" type="hidden" value="<?= initObj('firstname') ?>">
                    <input name="lastname" type="hidden" value="<?= initObj('lastname') ?>">
                    <input name="property_name" type="hidden" value="<?= initObj('property_name') ?>">
                    <input name="property_address" type="hidden" value="<?= initObj('property_address') ?>">
                    <input name="property_size" type="hidden" value="<?= initObj('property_size') ?>">
                    <input name="property_type" type="hidden" value="<?= initObj('property_type') ?>">
                    <input name="ownership" type="hidden" value="<?= initObj('ownership') ?>">
                    <input name="user_role" type="hidden" value="<?= initObj('user_role') ?>">
                    <input name="subscription" type="hidden" value="Free Trial">
                    <input name="table" type="hidden" value="system_info">
                    <h1 class="heading-signup mb-2">Select a subscription plan</h1>
                    <div class="d-flex justify-content-center gap-5">
                        <div class="card-sub">
                            <h2 class="heading-signup">FREE TRIAL</h2>
                            <p class="text-center mb-3">Lorem ipsum dolor sit amet consectetur. Fermentum sed non consectetur faucibus ultrices amet dolor enim id. Massa aenean aenean turpis felis iaculis velit vitae feugiat. Feugiat justo tincidunt sit malesuada enim a. Cursus leo lacus lobortis turpis ac dui.</p>
                            <h2 class="heading-2-signup mb-3">2 MONTHS FREE</h2>
                        </div>
                        <div class="card-sub disable-card">
                            <h2 class="heading-signup">Basic</h2>
                            <p class="text-center mb-3">Lorem ipsum dolor sit amet consectetur. Fermentum sed non consectetur faucibus ultrices amet dolor enim id. Massa aenean aenean turpis felis iaculis velit vitae feugiat. Feugiat justo tincidunt sit malesuada enim a. Cursus leo lacus lobortis turpis ac dui.</p>
                            <h2 class="heading-2-signup mb-3">1,500/Month</h2>
                            <div class="d-flex  justify-content-center">
                                <button class="main-btn ">Subscribe</button>
                            </div>
                        </div>
                        <div class="card-sub disable-card">
                            <h2 class="heading-signup">Standard</h2>
                            <p class="text-center mb-3">Lorem ipsum dolor sit amet consectetur. Fermentum sed non consectetur faucibus ultrices amet dolor enim id. Massa aenean aenean turpis felis iaculis velit vitae feugiat. Feugiat justo tincidunt sit malesuada enim a. Cursus leo lacus lobortis turpis ac dui.</p>
                            <h2 class="heading-2-signup mb-3">2,500/Month</h2>
                            <div class="d-flex  justify-content-center">
                                <button class="main-btn ">Subscribe</button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="main-btn mt-5">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="complete-signup-modal">
        <swal-html>
            <div class="p-5">
                <div class="text-center ">
                    <span class="material-icons" style="color: #1C5196;">
                        mail
                    </span>
                </div>
                <h4 class="error-description">Thank for you registering.</h4>
                <p style="font-size:15px " class="description">
                    You will receive an email to verify your account.
                </p>
                <div class="d-flex justify-content-center">
                    <button class="main-btn w-50 close-swal " onclick="closeSwal();">Ok</button>

                </div>
            </div>
            <swal-param name="allowEscapeKey" value="false" />
    </template>
</div>
<script>
    $(document).ready(function() {
        $("#frm").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    const template = $('#complete-signup-modal');
                    const templateContent = template.html();
                    Swal.fire({
                        html: templateContent,
                        showConfirmButton: false,
                        allowEscapeKey: false,
                        timer: 9000, // Redirect after 5 seconds
                        willClose: () => {
                            // Perform any necessary actions upon modal closing
                            // e.g., redirect to login page if data.success is 1                 
                            window.location.href = '<?= WEB_ROOT ?>';
                        }
                    });
                },
            });
        });
    });
</script>