<?php
include("footerheader.php");
fHeader();
?>
<div class="col-12 my-4 d-flex align-items-center justify-content-start">
    <div class="mt-5">
        <a href="reservation.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="box-shadow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="transform: scaleX(-1)">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
    <div class="font-18 ml-0 mt-5 ml-2"> Back to Reservations </div>
</div>
<div class="py-3 bg-white">
    <div class="container">
        <div class="mb-2 row">
            <div class="col-6">
                <div class="mb-2">Start Time</div>
                <div class="input-group">
                    <div class="form-group">
                        <input type="text" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-2">End Time</div>
                <div class="input-group">
                    <div class="form-group">
                        <input type="text" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mt-3 font-14">
    <div class="container"><img src="resources/images/onepix.gif" width="22" height="22" class="bg-blue" style="border-radius:30px;"> Available</div>
    <div class="container m-3 p-2 bg-white rounded">
        <img src="resources/images/onepix.gif" width="35" height="35" class="bg-darkgray" style="border-radius:30px; margin-right:10px;"> Swimming Pool
        <div style="float:right; margin:5px 10px 0 0;">
            <img src="resources/images/onepix.gif" width="25" height="25" class="bg-blue float-right" style="border-radius:30px;">
            <span style="float:right; font-size:13px; color:white; margin-right:-20px; margin-top:3px;">(1)</span>
        </div>
    </div>
    <div class="container m-3 p-2 bg-white rounded">
        <img src="resources/images/onepix.gif" width="35" height="35" class="bg-darkgray" style="border-radius:30px; margin-right:0px;"> Massage Room
        <div style="float:right; margin:5px 10px 0 0;">
            
            <img src="resources/images/onepix.gif" width="25" height="25" class="bg-darkgray float-right" style="border-radius:30px;">
            <span style="float:right; font-size:13px; color:black; margin-right:-20px; margin-top:3px;">(0)</span>
        </div>
    </div>
    <div class="container m-3 p-2 bg-white rounded">
        <img src="resources/images/onepix.gif" width="35" height="35" class="bg-darkgray" style="border-radius:30px; margin-right:10px;"> Function Room
        <div style="float:right; margin:5px 10px 0 0;">
            
            <img src="resources/images/onepix.gif" width="25" height="25" class="bg-darkgray float-right" style="border-radius:30px;">
            <span style="float:right; font-size:13px; color:black; margin-right:-20px; margin-top:3px;">(0)</span>
        </div>
    </div>
</div>
<?php
fFooter();
?>
