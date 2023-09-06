<?php
include("footerheader.php");
fHeader();

$api = apiSend('tenant','get-notifications',[]);
$notifs = json_decode($api,true);
//vdump($notifs);
?>
<div class="col-12 my-4 d-flex align-items-center justify-content-between">
	<div class="title"> Notifications </div>
</div>
<?php 
if ($notifs) {
	foreach($notifs as $key=>$val):
?>
<div class="container mb-3" style="margin-bottom:0px">
	<div class="card">
		<div class="card-body">
			<div class="d-inline-block mt-0">

				<small> <?=formatDateUnix($val['created_on']);?></small><br>
				<b><?=$val['title'];?></b></u></a></label> <?php if ($val['notif_read']=="No") { ?><div class="badge badge-success text-white font-12">New</div><?php } ?><br>
				<div class="truncate my-2"><?=strip_tags($val['content'])?> </div>
				<?php if (strlen(strip_tags($val['content']))>60) { ?><a href="notifs-view.php?id=<?=$val['id']?>"><u>Read More</u></a><?php } ?>
			</div>
		</div>
	</div>
</div>
<?php 
	endforeach;
} else {
	echo '
	<div class="container mb-3" style="margin-bottom:0px">
		<div class="card">
			<div class="card-body">
				<div class="d-inline-block mt-0">
					No record found.
				</div>
			</div>
		</div>
	</div>';
}
?>
<?=fFooter();?>