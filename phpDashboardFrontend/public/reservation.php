<?php
include("footerheader.php");
fHeader();

$api = apiSend('amenity','getlist',[]);
$list = json_decode($api,true);
?>
<div class="col-12 my-4">
    <div class="title"> Reservation </div>
</div>
<div class="py-1">
    <div class="container">
        <div class="row">
            <?php foreach ($list as $key=>$val) { ?>             
            <div class="col-6 mb-3">
                <a href="reservation-detail.php?id=<?=$val['id']?>">
                    <div class="mb-1"><img src="<?=$val['picture_url']?>" class="rounded img-fluid" style="min-height: 150px;"></div>
                    <div class="font-14"><?=$val['amenity_name']?></div>
                    <div class="font-10">Opening Hours <b><?=$val['operating_hours']?></b></div>
                </a>
            </div>            
            <?php } ?>
        </div>
    </div>
</div>
<?php
fFooter();
?>