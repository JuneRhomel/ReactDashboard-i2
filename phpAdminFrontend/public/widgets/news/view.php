<?php
$news = null;
if(count($args))
{
	$news_result = $ots->execute('news','get-details',['newsid'=>$args[0]]);
	$news = json_decode($news_result,true);
}
?>
<div class="page-title"><?php echo $news ? $news['title'] : '';?></div>
<div class="bg-white p-2 rounded">
	<?php if($news['image_url']):?>
	<div class="mt-3 mb-3">
		<img src="<?php echo $news['image_url'];?>" style="max-width:100%">
	</div>
	<?php endif;?>
	<div class="row">
		<div class="col">
			<div><?php echo nl2br($news['content']);?></div>
		</div>
	</div>
</div>
<div class="my-3">
	<button class="btn btn-secondary btn-sm" onclick="history.back()">Back</button>
</div>