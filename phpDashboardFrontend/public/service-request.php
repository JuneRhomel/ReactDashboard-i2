<?php
require_once('header.php');
include("footerheader.php");
// include("navigation.php");
$location_menu = "my-request";
?>

<div class="d-flex">
    <div class="main">
    <?php include("navigation.php") ?>
        <div style="background-color: #F0F2F5;padding: 0 25px;margin-top: 24px;padding-bottom: 18px;">
            <div>
                <div class="service-container ">

                    <div class="service-card ">
                        <div class="position-relative w-100 h-100">
                            <a href="http://portali2.sandbox.inventiproptech.com/gatepass.php">
                                <img class="position-relative img-fluid" src="assets/images/gatepass.png" alt="" style="border-radius: 5px;">
                                <label class="position-absolute px-1" style="bottom: 0; left: 0; color:white; font-weight: 600">Gate Pass</label>
                            </a>
                        </div>
                    </div>

                    <div class="service-card ">
                        <div class="position-relative w-100 h-100">
                            <a href="http://portali2.sandbox.inventiproptech.com/visitor.php">
                                <img class="position-relative img-fluid" src="assets/images/visitorspass.png" alt="" style="border-radius: 5px;">
                                <label class="position-absolute px-1" style="bottom: 0; left: 0; color:white; font-weight: 600">Visitor's Pass</label>
                            </a>
                        </div>
                    </div>


                    <div class="service-card ">
                        <div class="position-relative w-100 h-100">
                            <a href="http://portali2.sandbox.inventiproptech.com/work-permit-form_new.php">
                                <img class="position-relative img-fluid" src="assets/images/workpermit.png" alt="" style="border-radius: 5px;">
                                <label class="position-absolute px-1" style="bottom: 0; left: 0; color:white; font-weight: 600">Work Permit</label>
                            </a>
                        </div>
                    </div>
                    <div class="service-card ">
                        <div class="position-relative w-100 h-100">
                            <a href="http://portali2.sandbox.inventiproptech.com/report-issue.php">
                                <img class="position-relative img-fluid" src="assets/images/unitrepair.png" alt="" style="border-radius: 5px;">
                                <label class="position-absolute px-1" style="bottom: 0; left: 0; color:white; font-weight: 600">Report Issue</label>
                            </a>
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