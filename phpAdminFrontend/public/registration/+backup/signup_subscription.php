<?php include 'layout/header.php' ?>

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
            <a href="http://i2-sandbox.inventiproptech.com/registration/signup_property_details.php" class="d-flex gap-2 text-black fw-bold back ">
                <span class="material-icons">
                    arrow_back
                </span>
                Back
            </a>
            <div class="d-flex aligin-item-center align-items-center mt-4 justify-content-center w-100">
                <img src="./assets/s-3.png" alt="">
            </div>
            <div class="d-flex gap-5 flex-column  mt-5">
                <h1 class="heading-signup mb-2">Select a subscription plan</h1>
                <div class="d-flex justify-content-center gap-5">
                    <div class="card-sub">
                        <h2 class="heading-signup">FREE TRIAL</h2>
                        <p class="text-center mb-3">Lorem ipsum dolor sit amet consectetur. Fermentum sed non consectetur faucibus ultrices amet dolor enim id. Massa aenean aenean turpis felis iaculis velit vitae feugiat. Feugiat justo tincidunt sit malesuada enim a. Cursus leo lacus lobortis turpis ac dui.</p>
                        <h2 class="heading-2-signup mb-3">2 MONTHS FREE</h2>
                        <div class="d-flex  justify-content-center">
                            <button class="main-btn ">Subscribe</button>
                        </div>
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
                    <button class="main-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Email Modal -->
<template id="confirm-email-modal">
    <swal-html>
        <div class="p-5">
            <h4 class="">Please verify your email</h4>
            <p style="font-size:12px">
                You're almost there! We sent an email to <u class="text-primary2">angeli@inventi.ph</u>
                <br>If you don't see it, you may need to check your spam folder.
            </p>
            <button class="btn btn-sm btn-primary2 w-50 close-swal mt-3" onclick="popup_modal('completesignup');">Ok</button>
        </div>
    </swal-html>
    <swal-param name="allowEscapeKey" value="false" />
</template>

<!-- Sign-Up Complete Modal -->
<template id="complete-signup-modal">
    <swal-html>
        <div class="p-5">
            <div class="text-center ">
                <span class="material-icons" style="color:#3BBB7F">
                    check_circle
                </span>
            </div>
            <h4 class="">Congratulations! You are now registered</h4>
            <p style="font-size:12px">
                You will be automatically redirected to a login page in 5 second, or you can click log in below.
            </p>
            <button class="btn btn-sm btn-primary2 w-50 close-swal mt-3" onclick="closeSwal();">Login</button>
        </div>
        <swal-param name="allowEscapeKey" value="false" />
</template>