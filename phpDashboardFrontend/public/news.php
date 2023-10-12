<?php
include("footerheader.php");

$news_result = apiSend('news','getlist',[]);
$news = json_decode($news_result,true);
// var_dump($news);
fHeader();
?>
<div class="col-12 my-4 d-flex align-items-center justify-content-between">
	<div class="title"> News and Announcement </div>
</div>
<div class="container">
	<?php 
	foreach($news as $key=>$val):
		if ($key==0) {
	?>
	<div class="card">
		<?php if ($val['thumbnail']) { ?>
	    <img class="card-img-top rounded" src="<?=$val['thumbnail']?>" alt="News">
	     <?php } ?>
		<div class="card-body">
		  <div style="padding-left:10px; border-left:solid 5px #234E95">
			<label class="card-title font-18"><b><?=$val['title']?></b></label><br>
			<label><i class="fa fa-calendar" aria-hidden="true"></i><?=formatDateUnix($val['created_on'])?></label>
		  </div>
		  <p class="mt-2 font-14">
			  <?=$val['content']?>
			  <br>
			  <a href="news-view.php?id=<?=$val['id']?>"><u>Read More</u></a>
		  </p>
		</div>
	</div>
	<?php
		}
	endforeach;
	?>
</div>
<div class="col-12 my-4 d-flex align-items-center">
	<div class="title font-18"> MORE NEWS </div>
</div>

<?php 
foreach($news as $key=>$n):
	if ($key>0) {
?>
<div class="container mb-3" style="margin-bottom:0px">
	<div class="card">
		<div class="card-body">
		<div class="d-inline-block mt-0">
			<small> <?php echo date('d M Y',$n['created_on']);?></small><br>
			<b><?php echo $n['title'];?></b></u></a></label><br>
			<p><?php echo nl2br($n['content']);?></p>
			<a href="news-view.php?id=<?=$n['id']?>"><u>Read More</u></a>
		</div>

		</div>
	</div>
</div>
<?php 
	}
endforeach;
?>
<?=fFooter();?>