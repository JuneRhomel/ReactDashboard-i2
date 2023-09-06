<?php
include("footerheader.php");
fHeader();

$id = initObj('id');

$tenant = initSession('tenant');
$locinfo = getLocInfo();

$api = apiSend('billing','get-billing',[ 'billingid'=>$id ]);
$val = json_decode($api,true);
//vdumpx($val);
?>
<div class="col-12 d-flex align-items-center justify-content-start mt-4">
    <div class="">
        <a href="billing.php"><i class="fas fa-arrow-left circle"></i></a>
    </div>
    <div class="font-18 ml-2"><a href="billing.php">Back to Billing Statement / SOA</a></div>
</div>
<div class="mt-4 py-4" style="background-color: #fff">
    <div class="col-12">
        <div class="text-uppercase mb-2 subtitle font-18">Payment</div>
    </div>
    <div class="d-flex">
        <div class="col-2 subtitle font-16">Month:</div>
        <div class="col-10 font-16"><?=date("F",strtotime($val['billing_date']))?></div>
    </div>
    <div class="d-flex">
        <div class="col-2 subtitle font-16">Year:</div>
        <div class="col-10 font-16"><?=date("Y",strtotime($val['billing_date']))?></div>
    </div>
    <div class="d-flex">
        <div class="col-2 subtitle font-16">Type:</div>
        <div class="col-10 font-16">SOA</div>
    </div>
    <div class="d-flex">
        <div class="col-2 subtitle font-16">Total:</div>
        <div class="col-10 font-16"><?=formatPrice($val['amount'])?></div>
    </div>
    <div class="d-flex">
        <div class="col-2 subtitle font-16">Status:</div>
        <div class="col-10 text-danger font-16">Unpaid</div>
    </div>
</div>
<div class="mt-4 py-4 bg-white">
    <div class="col-12">
        <div class="font-16 subtitle">Select Payment Gateway</div>
    </div>
    <div class="d-flex mt-4">
        <div class="col-4">
            <button type="button" class="btn btn-primary btn-lg py-4 px-3 w-100" style="height:90px">
                <p class="mb-0 font-14">Credit/Debit Card</p>
            </button>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-outline btn-lg py-4 px-3 w-100" style="height:90px" disabled>
                <p class="mb-0 font-14">Gcash (Unavailable)</p>
            </button>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-outline btn-lg py-2 px-3 w-100" style="height:90px" disabled>
                <p class="mb-0 font-14">Bank Transfer (Unavailable)</p>
            </button>
        </div>
    </div>
    <hr />
    <div class="col-12 mb-2">
        <div class="mb-2 font-16 subtitle">Unit Number</div>
        <input type="text" class="form-control" value="<?=$locinfo['location_name']?>" readonly />
    </div>
    <div class="col-12 mb-2">
        <div class="mb-2 font-16 subtitle">Account Number</div>
        <input type="text" class="form-control" value="32256545455" readonly />
    </div>
    <div class="col-12 mb-2">
        <div class="mb-2 font-16 subtitle">SOA Total</div>
        <input type="text" class="form-control" value="<?=number_format($val['amount'],2,".",",")?>" readonly />
    </div>
    <div class="col-12 mb-2">
        <div class="mb-2 font-16 subtitle">Mobile Number</div>
        <input type="text" class="form-control" value="<?=$tenant['mobile']?>" readonly />
    </div>
    <!-- <div class="col-12 mt-4">
        <div class="d-flex justify-content-between">
            <div class="font-16 subtitle">Sent Receipt to Email</div>
            <div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" />
                    <label class="custom-control-label" for="customSwitch1"></label>
                </div>
            </div>
        </div>
    </div> -->
    <div class="col-6 mt-4">
        <button type="button" class="btn btn-primary btn-lg btn-block mb-5" onclick="window.open('https://portal.ots-sandbox.intuition.ph/billing-pay.php?id=<?=$id?>')">
            <p class="mb-0">Pay Now</p>
        </button>
    </div>
</div>
<?=fFooter();?>