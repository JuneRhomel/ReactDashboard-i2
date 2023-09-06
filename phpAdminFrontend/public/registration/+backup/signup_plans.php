<?php include 'layout/header.php' ?>
<div class="row  main-div">
    <div class="col-lg-5 col-md-12 col-sm-12 status-timeline">
        <div>
            <a href="<?=WEB_ROOT;?>/registration/signup_account.php" style="color: #FFFFFF">< Back </a>
        </div>
        <div class="inventi-logo mt-5">
            <img src="assets/inventiLogoWhite.png" alt="">
        </div>
        <div class="my-4 px-2 flex-wrap d-block">
            <div>
            <label class="text-required" style="color: #FFFFFF; font-size: 25px">Sign up for your OTS</label>
            </div>
            <label class="text-required" style="color: #FFFFFF; font-size: 25px">90-day free trial</label>
        </div>
        <img src="<?php echo MAIN_URL ?>/assets/step-3.png" alt="" class='map-image'>
    </div>
    <div class="col-lg-7 col-md-12 col-sm-12 signup-forms">
        <h2 class="text-center">Payment Details</h2>
        <h4 class="text-center">90 days free trial then 5000/month</h4>
        <p class="text-center">We'll remind you 7 days before your trial ends</p>
        <p class="text-center">Recurring billing * Cancel anytime</p>

        <form class="justify-left" action="signup_company_info.php?title=Company Info" id='sign_up'>
            <input type="hidden" name="step" value='3'>
            <input type="hidden" name="account_id" value='<?php echo $_GET['account'] ?>'>
            <input type="hidden" name="user_id" value='<?php echo $_GET['user'] ?>'>
            <div class="form-group required align-center">
                <label for="exampleInputEmail1" class="control">Firstname</label>
                <input type="text" class="form-control" id="first_name" placeholder="firstname">
            </div>
            <div class="form-group required">
                <label for="surname">Surname</label>
                <input type="text" class="form-control" id="surname" placeholder="surname">
            </div>
            <div class="form-group required">
                <label for="card_num">Card Number</label>
                <input type="text" class="form-control" id="card_num" placeholder="card number" value=''>
            </div>
            <div class="form-group required">
                <label for="exampleInputPassword1">Expiration Date</label>
                <div class="d-flex form-group align-items">
                    <div class="mt-6">
                        <input type="text" class="form-control" id="expi_mos">
                    </div>
                    <div class="mt-6">
                        <input type="text" class="form-control" id="expi_year">
                    </div>  
                </div>          
            </div>
            <div class="form-group required">
                <label for="card_num">Card CVN</label>
                <input type="text" class="form-control" id="card_cvn" placeholder="card cvn">
            </div>
            <div class="form-group">
                <div class="d-flex form-check align-items">
                    <div class="mt-3">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                    </div>
                    <div class="mt-1">
                        <label class="form-check-label" for="gridCheck">
                            By checking the checkbox below, you agree that inventi will automatically charge your plan to your payment method until you cancel.
                        </label>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary continue" onclick="">Continue</button>
        </form>
        <iframe name="sample-inline-frame"></iframe>

        <div class='fill-div text-center'>
            <span class='fill-blue '></span>
            <span class='fill-blue '> &nbsp;</span>
            <span class='fill-blue '> &nbsp;</span>
        </div>
    </div>
    <div class="modal confirm-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.confirm-modal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p>You're almost there! We sent an email If you don't see it, you may need to check your spam folder.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href = '<?=WEB_ROOT;?>/registration/login.php'" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#sign_up').submit(function(e){
            e.preventDefault();

            createToken($('#card_num').val(),$('#expi_mos').val(),$('#expi_year').val(),$('#card_cvn').val());
           
            // $.post({
            //     url : '<?= WEB_ROOT?>/account/register?display=plain',
            //     data :$(this).serialize(),
            //     success:function(data){
            //         console.log(data);
            //         data = JSON.parse(data);
            //         console.log(data.success);
            //         if(data.success == 1)
			// 		{
            //             // alert('Success');
            //             $('.confirm-modal').modal({
            //                 backdrop:'static'
            //             });
			// 		    $('.confirm-modal').modal('show');
                        
            //             var time = 5;

            //             setInterval(() => {
            //                 $('span.sec').html(time);
            //                 $('span.sec').html(time= time-1);
            //                 if(time == 0){
            //                     window.location.href = '<?=WEB_ROOT;?>/registration/login.php';
            //                 }
            //             }, 1000);

			// 		}
            //     }
            // });
        });
    });
    window.addEventListener('message', message => {
		var datas = JSON.parse(message.data);
		if(datas.status == 'VERIFIED')
		{
            $.ajax({
				url: '<?= WEB_ROOT?>/account/card-payment?display=plain',
				type: 'POST',
				data: datas,
				dataType: 'JSON',
				success: function(data){
					if(data.success == 1)
					{
						$(".notification-success-message").html(data.description);
						$(".notification-success").fadeIn('slow');
						<?php if(!$equipment):?>	
						$("#form-equipment")[0].reset();
						<?php endif;?>
					}	
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		}
	});


    function createToken(card_num,expi_mos,expi_yr,cvn)
	{
		Xendit.card.createToken({
                amount: 5000,
                card_number: card_num,
                card_exp_month: expi_mos,
                card_exp_year: expi_yr,
                card_cvn: cvn,    
                is_multiple_use: false,
                should_authenticate: true
            }, xenditResponseHandler);
	};

    function xenditResponseHandler(err, creditCardToken) {
        console.log(creditCardToken);
        if (err) {
            // Show the errors on the form
            alert(err.message);
            return;
        }

        if (creditCardToken.status === 'VERIFIED') {
            // Xendit.card.createAuthentication({ amount: 5000, token_id: creditCardToken.id }, function (err, data) {
            //     console.log(data);
            //     if (err) {
            //         alert(err.message);
            //         return;
            //     }

            //     if (data.status === 'VERIFIED') {
            //         // Handle success
            //     } else if (data.status === 'IN_REVIEW') {
            //         window.open(data.payer_authentication_url, 'sample-inline-frame');
            //         $('#three-ds-container').show();
            //     } else if (data.status === 'FAILED') {
            //         alert(data.failure_reason);
            //     }
            // });

        } else if (creditCardToken.status === 'IN_REVIEW') {
            window.open(creditCardToken.payer_authentication_url, 'sample-inline-frame');
            $('#three-ds-container').show();
			
        } else if (creditCardToken.status === 'FAILED') {
            alert(creditCardToken.failure_reason);
        }
    }

   
</script>
<?php include 'layout/footer.php' ?>