<?php
require_once("header.php");

?>
<div class="d-flex"> 

    
    
    <div class="main" >
    <?php include("navigation.php") ?>
    <div style="background-color: #F0F2F5 ;">
        <div class="d-flex flex-wrap justify-content-end align-items-center gradient-blueblack px-2 py-5" style="border-radius: 0px 0px 10px 10px; background-image: url('assets/images/background-gradient-blue.png'); background-size: cover; background-repeat: no-repeat;">
            <div class="col-12">
                <label class="mb-0" style="font-weight: 700;font-size: 24px; color: #FFFFFF">How can we help you?</label>
            </div>
            <div class="col-12">
                <label style="font-size: 16px; color: #FFFFFF">Lorem ipsum dolor isit amet</label>
            </div>
        </div>
        <div class="container contact-container my-2 " style="padding: 24px 24px;">

            <div class="contact-card">
                <div class="text">
                    <label class="title ">Admin office</label>
                    <label class="num mb-0">999-000</label>
                    <label class="email mb-0">adminoffice@gmail.com</label>
                </div>
                <div class="contact-icon">
                    <div style="border-radius: 50%; background-color: #1C5196; color: #FFFFFF;">
                        <i class="px-2 py-2 fa-solid fa-envelope" style="font-size: 25px;"></i>
                    </div>
                    <div style="border-radius: 50%; background-color: #1C5196; color: #FFFFFF;">
                        <i class="px-2 py-2 fa-solid fa-phone" style="font-size: 25px;"></i>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <div class="text">
                    <label class="title ">Lobby Reception</label>
                    <label class="num mb-0">999-000</label>
                </div>
                <div class="contact-icon">
                    <div style="border-radius: 50%; background-color: #1C5196; color: #FFFFFF;">
                        <i class="px-2 py-2 fa-solid fa-phone" style="font-size: 25px;"></i>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <div class="text">
                    <label class="title ">Security</label>
                    <label class="num mb-0">999-000</label>
                </div>
                <div class="contact-icon">
                    <div style="border-radius: 50%; background-color: #1C5196; color: #FFFFFF;">
                        <i class="px-2 py-2 fa-solid fa-phone" style="font-size: 25px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 py-4">
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
</div>


<?php include('menu.php') ?>
</div>
</body>

</html>
<script>
    $('.back-button-sr').on('click', function() {
        history.back();
    });
</script>