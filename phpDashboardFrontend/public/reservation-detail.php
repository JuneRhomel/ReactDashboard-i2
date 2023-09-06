<?php
include("footerheader.php");
fHeader();

$id = initObj('id');

$api = apiSend('amenity','getlist',ARR_BLANK);
$list = json_decode($api,true);
foreach ($list as $key0=>$val0) {
    if ($val0['id']==$id)
        $val = $val0;
}
?>
<div class="col-12 my-4">
    <div class="title"> Reservation </div>
</div>
<div class="py-1">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <img src="<?=$val['picture_url']?>" class="w-100">
            </div>
            <?php for ($i=1; $i<=4; $i++) { ?> 
            <div class="col-3 px-3 py-0">
                <img src="<?=$val['picture_url']?>" class="img-fluid rounded">
            </div>
            <?php } ?>
        </div>
      </div>
    </div>
    <div class="container bg-white mt-3">
        <div class="row">
            <div class="col-12 p-3">
                <div class="mb-3"><h5><b><?=$val['amenity_name']?></b></h5></div>
                <div class="font-14">
                    <p><b>Capacity</b></p>
                    <p><?=$val['capacity']?></p>
                    <p><b>Health and Safety Measure</b></p>
                    <p><?=$val['amenity_info']?></p>
                    <p><b>Opening Hours</b></p>
                    <p><?=$val['operating_hours']?></p>
                </div>
            </div>
        </div>
        <div class="row mb-5" style="padding: 0 15px">
            <div class="col-6">
                <button type="button" class="btn btn-outline font-16 w-100" onclick="location='home.php'">Cancel</button>
            </div>
            <div class="col-6 d-block mb-5">
                <button type="button" class="btn btn-primary px-3 w-100" onclick="location='reservation-form.php?id=<?=$id?>'">Reserve Now</button>
            </div>
            <input name="accountcode" type="hidden" value="<?=ACCOUNT_CODE?>">
        </div>        
    </div>
</div>
<?php
fFooter();
?>