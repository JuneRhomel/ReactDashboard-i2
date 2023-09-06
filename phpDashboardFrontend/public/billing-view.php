<?php
include("footerheader.php");
fHeader();

$id = initObj('id');
$api = apiSend('billing','get-billing',[ 'billingid'=>$id ]);
$val = json_decode($api,true);
//vdump($val);
?>
<div class="col-12 my-4 d-flex align-items-center justify-content-start">
    <div class="">
        <a href="billing.php"><i class="fas fa-arrow-left circle"></i></a>
    </div>
    <div class="font-18 ml-2"> Back to Billing Statement / SOA </div>
</div>
<!-- <div class="m-3 px-2 bg-white rounded">
    <div class="d-flex align-items-center justify-content-between py-2">
        <div class="d-flex align-items-center">
            <i class="fas fa-arrow-circle-left fa-2xl"></i> 
            <input type="text" class="form-control col-2 mx-2 text-center" value="1" width="2"> 
            <i class="fas fa-arrow-circle-right fa-2xl"></i> 
            <div class="font-14 ml-2">Page 1 of 1</div>
        </div>
        <div class="d-flex">
            <i class="fas fa-search-minus fa-2xl"></i> 
            <i class="fas fa-search-plus fa-2xl ml-2"></i> 
        </div>
    </div>
</div> -->
<div class="container py-2 bg-darkgray">
    <div class="d-flex align-items-center justify-content-center">
        <img src="resources/images/imgSOA.png">
    </div>
</div>
<div class="container d-inline-block mt-3" style="height:100px;">
    <div class="row">
        <!-- <div class="col-6">
            <button type="button" class="btn btn-outline btn-lg btn-block" onclick="window.open('https://portal.ots-sandbox.intuition.ph/billing-soa.php?id=<?=$id?>')">
                <p class="mb-0 font-16">View</p>
            </button>
        </div> -->
        <div class="col-6">
            <button type="button" class="btn btn-primary btn-lg btn-block" onclick="window.open('https://portal.ots-sandbox.intuition.ph/billing-pay.php?id=<?=$id?>')">
                <p class="mb-0 font-16">Pay</p>
            </button>
        </div>
    </div>
</div>
<?=fFooter();?>