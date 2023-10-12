<?php
require_once("header.php");
$location_menu = "news&announcement";
include("footerheader.php");

$id = initObj('id');

$api = apiSend('news', 'get-details', ['newsid' => $id]);
//vdump($api);
$val = json_decode($api, true);
//vdump($val);
?>
<div class="d-flex">
  <div class="main">
    <?php include("navigation.php") ?>
    <div style="background-color: #F0F2F5;padding: 10px 20px 100px 25px">
      <div class="d-flex align-items-center px-3 mt-3">
        <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
        <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Back</label>
      </div>
      <div class=" mt-4">
        <div class="p-2 bg-white">
          <?php if ($val['thumbnail']) { ?>
            <img class="card-img-top news-img rounded" src="<?= $val['thumbnail'] ?>" alt="News">
          <?php } ?>
          <div class="mt-2">
            <div>
              <label class="card-title font-18"><b><?= $val['title'] ?></b></label><br>
              <label><?= formatDateUnix($val['created_on']) ?></label>
            </div>
            <p class="mt-2 font-14">
              <?= $val['content'] ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('menu.php') ?>
</div>


<script>
  $('.back-button-sr').click(function() {
    window.location = 'news-announcement.php'
  })
</script>