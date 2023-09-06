<?php
    require_once('header.php');
?>

<div class="header ">
        <div class="bg-white  " >
            <div class="d-flex align-items-center px-3">
                <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
                <label class="heading-page px-2 m-0"style="font-weight: 600; font-size: 22px; color: #1C5196;" >Billing</label>
            </div>
        </div>
    </div>

    <div class="main">
        <div style="padding: 24px 25px 24px 25px; background-color: #F0F2F5;">
            <label style="margin: 24px 0"  class="title-section">Summary</label>
        <div>
            <div class="billing-summary-container" >
                    <div class="d-flex justify-content-between">
                        <label style="font-size: 12px;">December 2022</label>
                        <label class="text-danger" style="font-size: 12px;"><i class="fa-solid fa-circle text-danger px-1"></i>Past due Jan 31, 2023</label>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between">
                            <label class="mb-0 font-weight-bold" style="font-size: 16px;text-transform: capitalize;">Bea Alonzo</label>
                            <label class="mb-0" style="font-size: 12px; text-transform: uppercase;">AMOUNT DUE</label>
                        </div>
                        <div class="d-flex justify-content-between">
                            <label class="mb-0"style="font-size: 12px;" >Paid via</label>
                            <label class="text-danger mb-0 font-weight-bold"style="font-size: 12px;">2,457.61</label>
                        </div>
                        <div class="">
                            <label style="font-size: 12px;">---</label>
                        </div>
                        <button class="">Pay Now</button>
                    </div>
               </div>
            </div>

            <label style="margin: 24px 0"  class="title-section">State of Account</label> 
            <div  >

                    <div class="soa">
                        <img src="assets/images/soa.png" alt="">
                    </div>

                <div class="d-flex justify-content-start py-2">
                    <button class="download-soa px-3 py-3">
                        Download SOA
                    </button>
                 </div>
            </div>

            <label style="margin: 24px 0"  class="title-section">Updates</label>
            <div >
                
                <div class="soa-update-container">
                    <div class="soa-updates">
                        <label >JANUARY 31, 2023</label>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                    <div class="soa-updates">
                        <label >JANUARY 31, 2023</label>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                    <div class="soa-updates">
                        <label >JANUARY 31, 2023</label>
                        <p>Cracked floor tile outside my unit </p>
                    </div>
                </div>
        </div>
    </div>

</body>
</html>
<script>
$('.back-button-sr').on('click', function(){
        history.back();
    });



</script>