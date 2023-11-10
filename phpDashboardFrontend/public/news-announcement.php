<?php
require_once("header.php");

include("footerheader.php");
$location_menu = "news&announcement";


$result = apiSend('news', 'getlist', ['table' => 'news','condition' => 'status="Published"']);
$news = json_decode($result);
?>
<div class="d-flex">
    <div class="main">
        <?php include("navigation.php") ?>
        <div style="background-color: #F0F2F5;padding: 10px 20px 0px 25px">
            <?php if ($news) { ?>
                <div class="news-announcements ">
                    <!-- News Cards -->
                    <?php foreach ($news as $item) { ?>
                        <div class="news-card col-8 col-md-3 ">
                            <a href="<?= WEB_ROOT?>/news-view.php?id=<?= $item->enc_id?>" class="text-black">
                                <div>
                                    <img src="<?= $item->thumbnail ?>" alt="">
                                </div>
                                <div class="text">
                                    <label class="title-news"><?= $item->title ?></label>
                                    <label class="m-0"><?= $item->subtitle ?></label>
                                    <label class="date"><?= date("F j, Y", strtotime($item->date)) ?></label>
                                </div>
                            </a>
                        </div>
                    <?php } ?>

                    <!-- End Cards -->
                </div>

            <?php } else { ?>
                <div class="d-flex justify-content-center align-items-center" style="height: 104px">No News Announcement</div>
            <?php }    ?>

            <!-- <div class="more-news">
                <h3 class="news-heading">More News</h3>
                <div class="news-container">
            
                    <div class="card-news">
                        <div >
                            <div>
                                <p class="description">Donec pretium nisi nec mi commodo, nec fringilla ex pharetra</p>
                            </div>
                            <div>
                                <p class="date">February 1, 2023</p>
                            </div>
                        </div>

                        <div>
                            <img src="assets/images/news-image-2.png">
                        </div>
                    </div>

                    <div class="card-news">
                        <div >
                            <div>
                                <p class="description">Donec pretium nisi nec mi commodo, nec fringilla ex pharetra</p>
                            </div>
                            <div>
                                <p class="date">February 1, 2023</p>
                            </div>
                        </div>

                        <div>
                            <img src="assets/images/news-image-2.png">
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <?php include('menu.php') ?>
</div>
<script>
    $('.back-button-sr').on('click', function() {
        history.back();
    });
</script>