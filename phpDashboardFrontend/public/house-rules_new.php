<?php
require_once('header.php');
?>
<?php include("navigation.php") ?>




    <div class="main">
        <div class="d-flex flex-wrap justify-content-end align-items-center gradient-blueblack px-2 py-5" style="border-radius: 0px 0px 10px 10px; background-image: url('assets/images/background-gradient-blue.png'); background-size: cover; background-repeat: no-repeat;">
            <div class="col-12">
                <label class=" mb-0" style="font-weight: 700; font-size: 26px; color: #FFFFFF">How can we help you?</label>
            </div>
            <div class="col-12">
                <label style="font-size: 16px; color: #FFFFFF">Lorem ipsum dolor isit amet</label>
            </div>
        </div>
        <div style="padding: 24px 20px 0px 25px">
            <label style="font-size: 20px;">Emergency Hotlines</label>
            <div class="hotlines-container ">

                <div class="card-hotlines ">
                    <div class="w-100">
                        <image class="imgae-hotlines" src="assets/images/hospital-hotline-image.png"></image>
                    </div>

                    <div class="text">
                        <div class="d-flex flex-column">
                            <label class=" department-label">Hospital</label>
                            <label style="opacity: 0.7;">8888-0000</label>
                        </div>
                        <div class="btn-container">
                            <button class="contact-house-rules "><img src="assets/icon/call.svg" alt=""> Contact</button>
                        </div>
                    </div>


                </div>

                <div class="card-hotlines ">
                    <div class="w-100">
                        <image class="imgae-hotlines" src="assets/images/police-hotline-image.png"></image>
                    </div>

                    <div class="text">
                        <div class="d-flex flex-column">
                            <label class=" department-label">Police Department</label>
                            <label style="opacity: 0.7;">8888-0000</label>
                        </div>
                        <div class="btn-container">
                            <button class="contact-house-rules "><img src="assets/icon/call.svg" alt=""> Contact</button>
                        </div>
                    </div>

                </div>

                <div class="card-hotlines ">
                    <div class="w-100">
                        <image class="imgae-hotlines" src="assets/images/police-hotline-image.png"></image>
                    </div>

                    <div class="text">
                        <div class="d-flex flex-column">
                            <label class=" department-label">Barangay</label>
                            <label style="opacity: 0.7;">8888-0000</label>
                        </div>
                        <div class="btn-container">
                            <button class="contact-house-rules "><img src="assets/icon/call.svg" alt=""> Contact</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('menu.php') ?>

    </body>

    </html>
    <script>
        $('.back-button-sr').on('click', function() {
            history.back();
        });
    </script>