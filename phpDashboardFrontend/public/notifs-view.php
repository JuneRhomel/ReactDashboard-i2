<?php
include("footerheader.php");
fHeader();

$id = initObj('id');

// SET NOTIF AS READ
$api = apiSend('tenant','set-notification-read',[ 'id'=>$id ]);

// GET NOTIF
$api = apiSend('tenant','get-notification',[ 'id'=>$id ]);
$val = json_decode($api,true);
//vdump($val);
?>
<div class="col-12 d-flex align-items-center justify-content-start my-4">
    <div class="">
        <a href="notifs.php"><i class="fas fa-arrow-left circle"></i></a>
    </div>
    <div class="font-18 ml-2"><a href="news.php">Back to Notifications</a></div>
</div>
<div class="container bg-white">
    <div class="p-2">
      <div class="mt-2">
        <div>
          <label class="card-title font-18"><b><?=$val['title']?></b></label><br>
          <label><i class="fa fa-calendar" aria-hidden="true"></i> <?=formatDateUnix($val['created_on'])?></label>
        </div>
        <p class="mt-2 font-14">
          <?=$val['content']?>
        </p>
      </div>
    </div>
</div>
<?=fFooter();?>