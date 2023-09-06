<?php
    require_once('header.php');
    $location_menu = "billing";
?>
<div class="d-flex">
    
    
    <div class="main ">
        <?php include("navigation.php") ?>
        <div class="d-flex align-items-center px-3 mt-3">
            <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
            <label class="heading-page px-2 m-0"style="font-weight: 600; font-size: 22px; color: #1C5196;" >Payment</label>
        </div>
            <div style="padding: 24px 25px 24px 25px; background-color: #F0F2F5;">
                <div  style="background-color: #FFFFFF; border-radius: 5px; padding: 24px 22px;">
                    <div class="pb-2">
                        <image src="assets/images/master-card-icon.png"></image>
                    </div>
                    <div>
                        <label style="font-size: 12px;">Please enter your mastercard Security Authorization code in the field below to confirm your identity for this payment.</label>
                    </div>
                    <div class="pt-5">
                        <label style="font-size: 12px;">OTP has been sent via SMS to your registered mobile number.</label>
                    </div>
                    <div class="d-flex justify-content-between pt-5">
                        <input class="form-control otp-numbers text-center" type="tel" maxlength="1" data-index="0" placeholder="-">
                        <input class="form-control otp-numbers text-center" type="tel" maxlength="1" data-index="1"placeholder="-">
                        <input class="form-control otp-numbers text-center" type="tel" maxlength="1" data-index="2"placeholder="-">
                        <input class="form-control otp-numbers text-center" type="tel" maxlength="1" data-index="3"placeholder="-">
                        <input class="form-control otp-numbers text-center" type="tel" maxlength="1" data-index="4"placeholder="-">
                        <input class="form-control otp-numbers text-center" type="tel" maxlength="1" data-index="5"placeholder="-">
                    </div>
                    <div class="otp-div pt-5 text-center">
                    <label class="otp-not-received" style="font-size: 12px;">OTP not received? <a href="#" style="color:#1c5196; font-weight: 600;"><u>Resend</u></a></label>
                </div>
                <div class="button-submit" style="padding-top: 40%;">
                    <button class="submit  w-100" id="registration-buttons">Submit</button>
                    <button class="submit  w-100" style="border: 1px solid #1C5196; background-color: #FFFFFF; border-radius: 5px; color: #1C5196;">Cancel</button>
                </div>
            </div>
        </div>
    </div> 
    
    <div class="modal" tabindex="-1" role="dialog" id='payment-successfully'>
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content px-1 pt-2" style="border-radius: 10px;">
                <div class="modal-header justify-content-end pb-0" style="border-bottom: 0px;">
                    <div style="display: flex;align-items: center;justify-content: center;width: 100%;"><img src="assets/icon/success.png" alt=""></div>
                    <button style="position: absolute;" type="button" class="btn-close btn-close-payment-successfully" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body pt-0" style="padding-bottom: 20px;">
                    <h3 class="modal-title align-center text-center mb-3" style="font-weight: 600">Payment Success</h3>
                    <div class="text-center">
                        <p style="color: black">Your payment has been processed! Details of transaction are included below.</p>
                        <p class="pt-2" style="color: black">Transaction Number: <label style="font-weight: 600;">#234234</label></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p style="color: black;">Total amount paid</p>
                        <label style="font-weight: 600;">2,457.61</label>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p style="color: black;">Paid</p>
                        <label style="font-weight: 600;">Bea Alonzo</label>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p style="color: black;">Transaction Date</p>
                        <label style="font-weight: 600;">January 12, 2023 17:54:01</label>
                    </div>
                    
                    <div class="col-12 py-3">
                        <a href="http://portali2.sandbox.inventiproptech.com/"> <button class="submit px-5 py-2 w-100" id="registration-buttons">GO TO HOMEPAGE</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('menu.php') ?>
</body>
</html>
<script>
    
    $('.back-button-sr').on('click', function(){
        history.back();
    });
    $('.btn-close-payment-successfully').on('click', function(){
        $('#payment-successfully').modal('hide');
    });
    
    $('.submit').on('click', function(){
        $('#payment-successfully').modal('show');
});

const $inp = $(".form-control");

$inp.on({
  paste(ev) { // Handle Pasting
  
    const clip = ev.originalEvent.clipboardData.getData('text').trim();
    // Allow numbers only
    if (!/\d{6}/.test(clip)) return ev.preventDefault(); // Invalid. Exit here
    // Split string to Array or characters
    const s = [...clip];
    // Populate inputs. Focus last input.
    $inp.val(i => s[i]).eq(5).focus(); 
  },
  input(ev) { // Handle typing
    
    const i = $inp.index(this);
    if (this.value) $inp.eq(i + 1).focus();
  },
  keydown(ev) { // Handle Deleting
    
    const i = $inp.index(this);
    if (!this.value && ev.key === "Backspace" && i) $inp.eq(i - 1).focus();
  }
  
});
</script>
