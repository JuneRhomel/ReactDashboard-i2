<?php
include("footerheader.php");
fHeader();

$billings_result = apiSend('billing','getlist',[]);
$billings = json_decode($billings_result,true);
//vdump($billings);

// $test_backend = apiSend('billing','backend_connect',[]);
// $test = json_decode($test_backend,true);
// vdump($test);
?>
<div class="header">
	<div class="bg-white pt-2 rounded-sm" >
		<div class="d-flex align-items-baseline px-3">
			<button class="back-button-sr" style="background-color: transparent; border-radius: 10px 10px 10px 10px; border-color: rgb(180,180,177,0.2);"><i class="bi bi-arrow-left text-primary"></i></button>
			<label class="px-2">Billing</label>
		</div>
	</div>
</div>
<?php 
if ($billings) {
	$outstanding_total=0;
	foreach($billings as $billing):
		if($billing['remaining_balance'] > 0){
			$outstanding_total+=$billing['remaining_balance'];
		}
	endforeach;
?>
	<div class="main pt-3">
        <div class="px-2 pt-2" style="background-color: #F0F2F5;">
            <div class="px-4 py-3" style="background-color:    #6DACFF0F;">
               <label class="title-section">Outstanding</label>
               <div class="d-flex justify-content-between align-items-center py-4 px-1" style="background-color: #FFFFFF; border-radius: 10px 10px 10px 10px;">
                    <div class="d-flex gap-3 px-2">
                        <div>
                            image
                        </div>

                        <div>
                            <p style="font-weight: 700;"><?= number_format((float)$outstanding_total, 2, '.', ''); ?></p>
                        </div>
                    </div>
                    <div class="px-2">
                        <button class="btn-danger px-3 py-2" style="border-radius: 10px 10px 10px 10px; border: none">
                            Pay Now
                       </button>
                    </div>
               </div>
            </div>
            <div class="px-4 py-3">
                <div class="d-flex gap-1" style="border: 1px solid; width: 241px; border-radius: 4px;">
                   <button class="px-3 py-2 unpaid active">
                        Unpaid
                   </button>
                   <button class="px-3 py-2 billing">
                        Billing History
                   </button>
                </div>
				<?php 
				if ($billings) {
					foreach($billings as $billing):
				?>
				<?php if($billing['remaining_balance'] > 0){ ?>
                <div class="unpaid-section py-4">
                    <div class="d-flex justify-content-between align-items-center my-2 py-2 px-1" style="background-color: #FFFFFF; border-radius: 10px 10px 10px 10px;">
                        <div class="d-flex gap-3 px-2">
                            <div>
                                image
                            </div>

                            <div class="d-flex">
                                <p class="mb-0" style="font-weight: 700;"><?= date("M", mktime(0, 0, 0, $billing['month'], 10))." ".$billing['year']; ?></p>
                            </div>
                        </div>
                        <div class="px-2">
                            <p class="billing-price"><?= number_format((float)$billing['amount_due'], 2, '.', ''); ?></p>
                        </div>
                    </div>
                </div>
				<?php } ?>

                <div class="billing-section py-4">
                    <div class="d-flex justify-content-between align-items-center my-2 py-2 px-1" style="background-color: #FFFFFF; border-radius: 10px 10px 10px 10px;">
                        <div class="d-flex gap-3 px-2">
                            <div>
                                image
                            </div>
                            <div class="d-flex">
								<p class="mb-0" style="font-weight: 700;"><?= date("M", mktime(0, 0, 0, $billing['month'], 10))." ".$billing['year']; ?></p>
                            </div>
                        </div>
                        <div class="px-2">
							<p class="billing-price"><?= number_format((float)$billing['amount_due'], 2, '.', ''); ?></p>
                        </div>
                    </div>
                </div>
			<?php 
					endforeach;
				}
			?>
			<!-- payment -->
            <div>
                <div class="py-3">
                    <div>
                        <label class="title-section">Payment Transactions</label>
                    </div>
                    <div>
                        <a href="#">Show all ></a>
                    </div>
                </div>
                <div class="" style="background-color: #FFFFFF; border-radius: 10px 10px 10px 10px;">
                    <div class="d-flex justify-content-between align-items-center py-3 px-1" style="background-color: #FFFFFF; border-radius: 10px 10px 10px 10px;">
                        <div class="d-flex flex-wrap px-2" style="width: 70%;">
                            <div>
                                <p class="history-date-billing mb-0">March 2022</p>
                            </div>

                            <div class="col-12 px-0">
                                <p class="paid-via-billing mb-0">Paid Using Mastercard 0000</p>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <p class="billing-price" style="color: #2ECC71">₱ 2,300.00</p>
                        </div>
                    </div>
                    <hr style="margin: 0px">
                    <div class="d-flex justify-content-between align-items-center py-3 px-1" style="background-color: #FFFFFF; border-radius: 10px 10px 10px 10px;">
                        <div class="d-flex flex-wrap" style="width: 70%;">
                            <div>
                                <p class="history-date-billing mb-0">March 2022</p>
                            </div>

                            <div class="col-12 px-0">
                                <p class="paid-via-billing mb-0">Paid Using Gcash 5165</p>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <p class="billing-price" style="color: #2ECC71">₱ 2,461.52</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
	echo '<div class="bg-white"><div class="col-12 mb-3 py-3">No record found.</div></div>';
}
?>
<?php
fFooter();
?>
<script>
$('.billing-section').hide();

$('.unpaid').on('click', function(){
  $('.unpaid').addClass('active').removeAttr("style");;
  $('.unpaid').removeClass('inactive');
  $('.billing').removeClass('active');
  $('.billing').addClass('inactive').css("color", "gray");
  $('.unpaid-section').show();
  $('.billing-section').hide();
});

$('.billing').addClass('inactive').css("color", "gray");;

$('.billing').on('click', function(){
  $('.billing').addClass('active').removeAttr("style");
  $('.billing').removeClass('inactive');
  $('.unpaid').removeClass('active');
  $('.unpaid').addClass('inactive').css("color", "gray");
  $('.unpaid-section').hide();
  $('.billing-section').show();
})
</script>